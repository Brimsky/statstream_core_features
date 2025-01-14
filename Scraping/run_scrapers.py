import schedule
import time
import sys
import logging
from datetime import datetime
import importlib.util
import os
from db import db  
import traceback
import requests

logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler('timber_scraper.log'),
        logging.StreamHandler()
    ]
)

DISCORD_WEBHOOK = os.getenv('DISCORD_WEBHOOK', '')  

def send_notification(message, is_error=False):
    """Send notification to Discord webhook."""
    if DISCORD_WEBHOOK:
        try:
            color = 16711680 if is_error else 65280 
            payload = {
                "embeds": [{
                    "title": "Timber Scraper Alert",
                    "description": message,
                    "color": color,
                    "timestamp": datetime.utcnow().isoformat()
                }]
            }
            requests.post(DISCORD_WEBHOOK, json=payload)
        except Exception as e:
            logging.error(f"Failed to send notification: {e}")

def import_scraper(file_path):
    """Import a Python file as a module."""
    try:
        spec = importlib.util.spec_from_file_location("module", file_path)
        module = importlib.util.module_from_spec(spec)
        spec.loader.exec_module(module)
        return module
    except Exception as e:
        logging.error(f"Failed to import scraper {file_path}: {e}")
        send_notification(f"Failed to import scraper {os.path.basename(file_path)}: {e}", True)
        return None

def run_all_scrapers():
    """Run all scraper scripts in the scrapers directory."""
    start_time = datetime.now()
    logging.info(f"Starting scraper run at {start_time}")
    send_notification("Starting daily scraper run")
    
    scrapers_dir = os.path.join(os.path.dirname(__file__), "scrapers")
    success_count = 0
    error_count = 0
    
    for filename in os.listdir(scrapers_dir):
        if filename.endswith(".py") and filename != "__init__.py":
            scraper_path = os.path.join(scrapers_dir, filename)
            try:
                logging.info(f"Running {filename}...")
                module = import_scraper(scraper_path)
                if not module:
                    error_count += 1
                    continue
                
                main_functions = {
                    'siardn.py': 'scrape_timber_data',
                    'bono.py': 'main',
                    'stiga.py': 'extract_data',
                    'amberbirch.py': 'scrape_amberbirch',
                    'finieris.py': 'scrape_finieris'
                }
                
                main_function_name = main_functions.get(filename)
                if main_function_name and hasattr(module, main_function_name):
                    main_function = getattr(module, main_function_name)
                    
                    if filename == 'siardn.py':
                        url = "https://siardn.lv/berza-iepirksana-koklaukumos/"
                        data = main_function(url)
                        db.insert_timber_data(data)
                    elif filename == 'stiga.py':
                        url = "https://stigarm.lv/lv/finierklucu-iepirksana/"
                        html_content = module.fetch_html_content(url)
                        if html_content:
                            data = main_function(html_content)
                            db.insert_timber_data(data)
                    else:
                        data = main_function()
                        if data:
                            db.insert_timber_data(data)
                    
                    success_count += 1
                    logging.info(f"Successfully completed {filename}")
                else:
                    error_msg = f"Main function not found in {filename}"
                    logging.error(error_msg)
                    send_notification(error_msg, True)
                    error_count += 1
                
            except Exception as e:
                error_msg = f"Error in {filename}: {str(e)}\n{traceback.format_exc()}"
                logging.error(error_msg)
                send_notification(f"Error in {filename}: {str(e)}", True)
                error_count += 1
    
    end_time = datetime.now()
    duration = end_time - start_time
    summary = f"Scraper run completed in {duration}. Success: {success_count}, Errors: {error_count}"
    logging.info(summary)
    send_notification(summary, error_count > 0)

def schedule_scrapers():
    """Schedule scrapers to run at 6 AM daily."""
    schedule.every().day.at("06:00").do(run_all_scrapers)
    logging.info("Scrapers scheduled to run daily at 06:00")
    
    while True:
        try:
            schedule.run_pending()
            time.sleep(60)
        except Exception as e:
            error_msg = f"Scheduler error: {str(e)}\n{traceback.format_exc()}"
            logging.error(error_msg)
            send_notification(error_msg, True)
            time.sleep(60)

if __name__ == "__main__":
    if len(sys.argv) > 1:
        if sys.argv[1] == "run":
            run_all_scrapers()
        elif sys.argv[1] == "scheduler":
            logging.info("Starting scheduler mode...")
            schedule_scrapers()
    else:
        logging.info("Starting scheduler mode (default)...")
        schedule_scrapers()

import re
from bs4 import BeautifulSoup
import requests
from datetime import datetime

def fetch_html_content(url):
    try:
        response = requests.get(url)
        response.raise_for_status()
        return response.text
    except requests.RequestException as e:
        print(f"An error occurred while fetching the web page: {e}")
        return None

def extract_data(html_content):
    soup = BeautifulSoup(html_content, 'html.parser')
    data = []
    
    notice = soup.find(string=re.compile(r'finierkluču iepirkšana ir pārtraukta', re.IGNORECASE))
    if notice:
        data.append({
            'Date': datetime.now().strftime('%Y-%m-%d'),
            'Seller': 'Stiga',
            'Species': 'Bērzs',
            'Type': 'Finierkluči',
            'Class': 'N/A',
            'Length': 2.70,
            'Diameter': 'N/A',
            'Location': 'Kuldīga',
            'Price': 0.0,
            'URL': 'https://stigarm.lv/lv/finierklucu-iepirksana/'
        })
        return data

    rows = soup.find_all('tr')
    current_quality = None
    for row in rows:
        cells = row.find_all('td')
        if len(cells) == 1:
            current_quality = cells[0].text.strip()
        elif len(cells) == 3:
            quality = cells[0].text.strip()
            diameter = cells[1].text.strip()
            price = cells[2].text.strip()
            if not quality and current_quality:
                quality = current_quality
            brakis_pattern = r"(Brāķēts papīrmalkā|Brāķis|Brāķēts dēļ metāla ieslēgumiem)"
            is_brakis = bool(re.search(brakis_pattern, diameter, flags=re.IGNORECASE))
            if is_brakis:
                class_value = "Brāķis"
                diameter_value = "N/A"
            else:
                if '<' in diameter:
                    number, sign = diameter.split('<')
                    rounded_number = int(number) // 10
                    diameter_value = f">{rounded_number}"
                else:
                    diameter_parts = diameter.split('–')
                    rounded_diameter_parts = [int(part) // 10 for part in diameter_parts]
                    diameter_value = f"{rounded_diameter_parts[0]}-{rounded_diameter_parts[1]}"
                class_value = quality.split()[0] if quality else 'N/A'
            
            try:
                if price.strip() == '–' or price.strip() == '-':
                    continue
                
                price_clean = price.replace('€', '').strip()
                price_clean = price_clean.replace(',', '.').replace(' ', '')
                price_parts = re.findall(r'\d+(?:\.\d+)?', price_clean)
                if price_parts:
                    price_value = float(price_parts[0])
                else:
                    continue
            except (ValueError, AttributeError):
                continue
            
            data.append({
                'Date': datetime.now().strftime('%Y-%m-%d'),
                'Seller': 'Stiga',
                'Species': 'Bērzs',
                'Type': 'Finierkluči',
                'Class': class_value,
                'Length': 2.70,
                'Diameter': diameter_value,
                'Location': 'Kuldīga',
                'Price': price_value,
                'URL': 'https://stigarm.lv/lv/finierklucu-iepirksana/'
            })
    return data

if __name__ == "__main__":
    url = "https://stigarm.lv/lv/finierklucu-iepirksana/"
    html_content = fetch_html_content(url)
    if html_content:
        scraped_data = extract_data(html_content)
        for item in scraped_data:
            print(f"Date: {item['Date']} | "
                  f"Seller: {item['Seller']} | "
                  f"Species: {item['Species']} | "
                  f"Type: {item['Type']} | "
                  f"Class: {item['Class']} | "
                  f"Length: {item['Length']} | "
                  f"Diameter: {item['Diameter']} | "
                  f"Location: {item['Location']} | "
                  f"Price: {item['Price']} | "
                  f"URL: {item['URL']}")
    else:
        print("Failed to retrieve the web page. Please check the URL and your internet connection.")
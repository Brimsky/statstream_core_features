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

def extract_date(soup):
    return datetime.now().strftime('%Y-%m-%d')

def extract_wood_class(header):
    class_match = re.search(r'([ABCDE]) šķiras', header.text)
    if class_match:
        wood_class = class_match.group(1)
        return 'A' if wood_class == 'E' else wood_class
    return None

def format_diameter(diameter):
    diameter = re.sub(r'\s*([-–])\s*', r'-', diameter)
    diameter = diameter.replace('> ', '>')
    return diameter

def process_lengths(length):
    if length == 'N/A':
        return ['N/A']
    lengths = length.rstrip('m').split('/')
    return [f"{float(l.strip()):.2f}" for l in lengths]

def extract_price(price_str):
    # Extract the first number from a price string like "200 (190)"
    price_match = re.search(r'(\d+(?:\.\d+)?)', price_str)
    if price_match:
        return float(price_match.group(1))
    return 0.0

def extract_data(html_content):
    soup = BeautifulSoup(html_content, 'html.parser')
    data = []

    container = soup.select_one('.log-purchasing-list')
    if not container:
        return data

    items = container.select('.log-purchasing-item')[:-1]
    for item in items:
        header = item.select_one('.log-purchasing-item-header h4')
        if not header:
            continue

        wood_type = "Finierkluči"
        wood_class = extract_wood_class(header)

        date = extract_date(item)
        content = item.select_one('.log-purchasing-item-content')

        if not content:
            continue

        for row in content.select('.table-row'):
            if 'table-header' in row.get('class', []):
                continue

            cells = row.select('.table-row-item')
            if len(cells) != 2:
                continue

            if "Brāķēts" in header.text:
                price_str = cells[1].text.strip()
                price = extract_price(price_str)
                base_data = {
                    'Species': 'Bērzs',
                    'Type': 'Finierkluči',
                    'Class': 'Brāķis',
                    'Diameter': 'N/A',
                    'Length': '2.70',
                    'Seller': 'Finieris',
                    'Location': 'Bolderāja',
                    'Date': date,
                    'Price': f"{price:.2f}",
                    'URL': 'https://www.finieris.com/lv/meza-ipasniekiem/finierklucu-iepirksana/'
                }
                data.append(base_data)
            else:
                diameter = format_diameter(cells[0].text.strip())
                price_str = cells[1].text.strip()
                price = extract_price(price_str)

                base_data = {
                    'Species': 'Bērzs',
                    'Type': wood_type,
                    'Class': wood_class,
                    'Diameter': diameter,
                    'Seller': 'Finieris',
                    'Location': 'Rīga',
                    'Date': date,
                    'Price': f"{price:.2f}",
                    'URL': 'https://www.finieris.com/lv/meza-ipasniekiem/finierklucu-iepirksana/'
                }

                lengths = process_lengths('2.70')
                for length in lengths:
                    entry = base_data.copy()
                    entry['Length'] = length
                    data.append(entry)

    return data

def scrape_finieris():
    url = "https://www.finieris.com/lv/meza-ipasniekiem/finierklucu-iepirksana/"
    html_content = fetch_html_content(url)
    if html_content:
        return extract_data(html_content)
    return []

if __name__ == "__main__":
    data = scrape_finieris()
    for item in data:
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
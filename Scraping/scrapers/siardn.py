import re
from bs4 import BeautifulSoup
import requests
from datetime import datetime
from db import TimberDatabase

def scrape_timber_data(url):
    response = requests.get(url)
    soup = BeautifulSoup(response.content, 'html.parser')
    textboxes = soup.find_all('div', class_='gem-textbox-content')
    data_list = []
    current_date = datetime.now().strftime("%Y-%m-%d")

    for textbox in textboxes:
        location_elem = textbox.find('span', style=lambda value: value and 'color: #ed1c24' in value)
        location = location_elem.text.strip() if location_elem else "Unknown"

        table = textbox.find('table', class_='tablepress')
        if table:
            rows = table.find_all('tr')
            lengths = [th.text.strip().replace('Garums ', '').replace('m', '').replace(',', '.') for th in rows[0].find_all('th')[2:]]

            for row in rows[1:]:
                columns = row.find_all('td')
                if len(columns) >= 4:
                    class_type = columns[0].text.strip().split()[0]  # "A", "B", "C", "Tara"
                    diameter_match = re.search(r'(\d+)-(\d+)', columns[1].text)
                    diameter = f"{diameter_match.group(1)}-{diameter_match.group(2)}" if diameter_match else "N/A"

                    prices = [col.text.strip().replace('€', '').strip() for col in columns[2:]]
                    for length, price in zip(lengths, prices):
                        if price and price != '-':
                            data = {
                                'Date': current_date,
                                'Seller': "Siardn",
                                'Species': 'Bērzs',
                                'Type': 'Finierkluči',
                                'Class': class_type,
                                'Length': float(length),
                                'Diameter': diameter,
                                'Location': location,
                                'Price': float(price),
                                'URL': 'https://siardn.lv/berza-iepirksana-koklaukumos/'
                            }
                            data_list.append(data)
    return data_list

def main():
    """Main function to scrape Siardn timber prices."""
    url = "https://siardn.lv/berza-iepirksana-koklaukumos/"
    data = scrape_timber_data(url)
    
    if data:
        db = TimberDatabase()
        db.insert_timber_data(data)
        print(f"Successfully inserted {len(data)} records into the database")
        return True
    else:
        print("No data found to insert")
        return False

if __name__ == "__main__":
    main()
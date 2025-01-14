import requests
from bs4 import BeautifulSoup
import datetime
import re

def fetch_webpage(url):
    try:
        response = requests.get(url)
        response.raise_for_status()
        return BeautifulSoup(response.content, "html.parser")
    except requests.RequestException as e:
        print(f"Error fetching webpage: {e}")
        return None

def extract_cell_data(element):
    return element.text.strip() if element else 'N/A'

def format_diameter(diameter):
    diameter = re.sub(r'\s*([-–])\s*', r'-', diameter)
    diameter = re.sub(r'(\d+)\.0', r'\1', diameter)
    if diameter.endswith('<'):
        diameter = '>' + diameter[:-1]
    return diameter

def standardize_species(species):
    species_mapping = {
        'Bērza': 'Bērzs',
        'Skuju koku': 'Skuju koku',
        'Skujkoku': 'Skuju koku',
        'Egles': 'Egle',
        'Apses': 'Apse',
        'Alkšņa': 'Alksnis',
        'Malka': 'Jaukta',
        'Sauskaltušais': 'Sauskaltušais',
        'Priedes': 'Priede',
        'Ozola': 'Ozols',
        'Melnalkšņa': 'Melnalksnis'
    }
    return species_mapping.get(species, species)

def standardize_type(type_):
    type_mapping = {
        'finieris': 'Finierkluči',
        'papīrmalka': 'Papīrmalka',
        'malka': 'Malka',
        'gulsnis': 'Gulsnis',
        'zāģbaļķi': 'Zāģbaļķi'
    }
    return type_mapping.get(type_, type_.capitalize() if type_ else 'N/A')

class TimberProcessor:
    def __init__(self):
        self.previous_species = None
        self.previous_class = None

    def process_timber_table(self, table):
        rows = table.find_all('div', class_='table__row')
        table_data = []

        for row in rows:
            if 'table__row--header' in row.get('class', []) or 'table__row--seperator' in row.get('class', []):
                continue

            cells = row.find_all('div', class_='table__cell')
            if len(cells) >= 3:
                sortiment = extract_cell_data(cells[0])
                length = extract_cell_data(cells[1])
                diameter = format_diameter(extract_cell_data(cells[2]))

                species, type_, class_ = self.extract_species_type_class(sortiment)
                prices = extract_prices(cells[3:])

                lengths = length.split('/')

                for single_length in lengths:
                    data_dict = {
                        'Date': datetime.datetime.now().strftime('%Y-%m-%d'),
                        'Seller': 'Bono',
                        'Species': standardize_species(species),
                        'Type': standardize_type(type_),
                        'Class': class_ if class_ else 'N/A',
                        'Length': f"{float(single_length.strip()):.2f}",
                        'Diameter': diameter,
                        'Prices': prices,
                        'URL': 'https://www.bonotimber.com/pakalpojumi/apalkoka-tirdznieciba'
                    }
                    table_data.append(data_dict)

        return table_data

    def extract_species_type_class(self, sortiment):
        sortiment = sortiment.replace('(', '').replace(')', '')
        parts = sortiment.split()

        if 'brāķis' in sortiment.lower():
            species = self.previous_species if self.previous_species else ''
            return species, 'Finierkluči', 'Brāķis'

        species = ''
        if 'Skuju koku' in sortiment:
            species = 'Skuju koku'
        elif 'Bērza' in sortiment:
            species = 'Bērzs'
        elif parts:
            species = parts[0]

        class_ = ''
        class_pattern = r'\b([ABCD])\b'
        if 'tara' in sortiment.lower():
            class_ = 'Tara'
        else:
            class_match = re.search(class_pattern, sortiment)
            if class_match:
                class_ = class_match.group(1)

        allowed_types = {
            'finieris': 'Finierkluči',
            'papīrmalka': 'Papīrmalka',
            'malka': 'Malka',
            'gulsnis': 'Gulsnis',
            'zāģbaļķi': 'Zāģbaļķi'
        }

        type_ = 'N/A'
        sortiment_lower = sortiment.lower()

        for allowed_type, standardized_type in allowed_types.items():
            if allowed_type in sortiment_lower:
                type_ = standardized_type
                break

        self.previous_species = species
        if class_:
            self.previous_class = class_

        return species, type_, class_

def standardize_location(location):
    if location.startswith("Rīga"):
        return "Rīga"
    return location

def extract_prices(price_cells):
    prices = {}
    for cell in price_cells:
        location, price = extract_location_and_price(cell)
        if location and location != 'Sortiments' and price != 'N/A' and price != '-':
            standardized_location = standardize_location(location)
            prices[standardized_location] = f"{float(price):.2f}"
    return prices

def extract_location_and_price(cell):
    location = cell.get('data-label', '')
    price = extract_cell_data(cell)
    return location, price

def main():
    """Main function to scrape Bono timber prices."""
    url = "https://www.bonotimber.com/pakalpojumi/apalkoka-tirdznieciba"
    soup = fetch_webpage(url)
    if soup is None:
        return []

    timber_tables = soup.find_all(class_="table table--roundwood")
    processor = TimberProcessor()

    all_data = []
    for table in timber_tables:
        table_data = processor.process_timber_table(table)
        for item in table_data:
            for location, price in item['Prices'].items():
                standardized_location = standardize_location(location)
                all_data.append({
                    'Date': item['Date'],
                    'Seller': item['Seller'],
                    'Species': item['Species'],
                    'Type': item['Type'],
                    'Class': item['Class'],
                    'Length': float(item['Length']),
                    'Diameter': item['Diameter'],
                    'Location': standardized_location,
                    'Price': float(price),
                    'URL': item['URL']
                })
    
    return all_data

if __name__ == "__main__":
    data = main()
    for item in data:
        print(f"Date: {item['Date']} | "
              f"Seller: {item['Seller']} | "
              f"Species: {item['Species']} | "
              f"Type: {item['Type']} | "
              f"Class: {item['Class']} | "
              f"Length: {item['Length']:.2f} | "
              f"Diameter: {item['Diameter']} | "
              f"Location: {item['Location']} | "
              f"Price: {item['Price']:.2f} | "
              f"URL: {item['URL']}")
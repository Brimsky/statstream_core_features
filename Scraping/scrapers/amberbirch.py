import requests
from bs4 import BeautifulSoup
from datetime import datetime

def scrape_amberbirch():
    url = "https://amberbirch.lv/apalkoku-iepirksana/"
    data = []
    try:
        response = requests.get(url)
        response.raise_for_status()
        soup = BeautifulSoup(response.content, "html.parser")
        table = soup.find("tbody")
        if not table:
            return data
        rows = table.find_all("tr")
        scrape_date = datetime.now().strftime("%Y-%m-%d")
        for row in rows:
            try:
                if "avia-heading-row" not in row.get("class", []):
                    cells = row.find_all("td")
                    if len(cells) < 5:
                        continue
                    quality_text = cells[0].text.strip()
                    if not quality_text:
                        continue
                    quality = quality_text[0]
                    diameter_range = cells[1].text.strip()
                    try:
                        diameter_min, diameter_max = map(int, diameter_range.split("-"))
                        diameter = f"{(diameter_min // 10)}-{(diameter_max // 10)}"
                    except ValueError:
                        continue
                    prices = []
                    for i in range(2, 5):
                        try:
                            prices.append(float(cells[i].text.strip()))
                        except ValueError:
                            prices.append(None)
                    lengths = [2.7, 3.2, 3.3]
                    for length, price in zip(lengths, prices):
                        if price is not None:
                            data.append({
                                'Date': scrape_date,
                                'Seller': 'AmberBirch',
                                'Species': 'Bērzs',
                                'Type': 'Finierkluči',
                                'Class': quality,
                                'Length': length,
                                'Diameter': diameter,
                                'Location': 'Rīga',
                                'Price': price,
                                'URL': 'https://amberbirch.lv/apalkoku-iepirksana/'
                            })
            except Exception:
                continue
    except requests.RequestException as e:
        print(f"Error fetching AmberBirch data: {e}")
    return data

if __name__ == "__main__":
    data = scrape_amberbirch()
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

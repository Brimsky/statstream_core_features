from db import TimberDatabase

def view_latest_prices(limit=10000):  
    db = TimberDatabase()
    conn = db.db_path
    
    results = db.get_latest_prices(limit)
    
    if not results:
        print("No data found in the database.")
        return
    
    print("\nLatest Timber Prices:")
    print("-" * 120)
    print(f"{'Date':<12} {'Seller':<10} {'Species':<15} {'Type':<15} {'Class':<10} {'Length':<8} {'Diameter':<10} {'Location':<15} {'Price':<8}")
    print("-" * 120)
    
    for row in results:
        date, seller, species, type_, class_, length, diameter, location, price = row
        date = date or ''
        seller = seller or ''
        species = species or ''
        type_ = type_ or ''
        class_ = class_ or ''
        length = length or 0.0
        diameter = diameter or ''
        location = location or ''
        price = price or 0.0
        
        print(f"{date:<12} {seller:<10} {species:<15} {type_:<15} {class_:<10} {length:<8.2f} {diameter:<10} {location:<15} {price:<8.2f}")
    
    print("-" * 120)
    print(f"\nTotal records shown: {len(results)}")

if __name__ == "__main__":
    view_latest_prices() 

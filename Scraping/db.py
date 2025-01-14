import os
from datetime import datetime
from sqlalchemy import create_engine, Column, Integer, String, Float, DateTime, Table, MetaData
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker
from sqlalchemy.exc import IntegrityError
from dotenv import load_dotenv

load_dotenv()

DB_CONNECTION = os.getenv('DB_CONNECTION', 'mysql')
DB_HOST = os.getenv('DB_HOST', 'mysql')
DB_PORT = os.getenv('DB_PORT', '3306')
DB_DATABASE = os.getenv('DB_DATABASE', 'stat')
DB_USERNAME = os.getenv('DB_USERNAME', 'sail')
DB_PASSWORD = os.getenv('DB_PASSWORD', 'password')

DATABASE_URL = f"mysql+mysqldb://{DB_USERNAME}:{DB_PASSWORD}@{DB_HOST}:{DB_PORT}/{DB_DATABASE}"

Base = declarative_base()

class TimberPrice(Base):
    __tablename__ = 'timber_prices'

    id = Column(Integer, primary_key=True)
    date = Column(String(255))
    seller = Column(String(255))
    species = Column(String(255))
    type = Column(String(255))
    class_ = Column('class', String(255))
    length = Column(Float)
    diameter = Column(String(255))
    location = Column(String(255))
    price = Column(Float)
    created_at = Column(DateTime, default=datetime.utcnow)

class TimberDatabase:
    def __init__(self):
        self.engine = create_engine(DATABASE_URL)
        Base.metadata.create_all(self.engine)
        Session = sessionmaker(bind=self.engine)
        self.session = Session()

    def insert_timber_data(self, data_list):
        """Insert timber price data into the database."""
        for data in data_list:
            try:
                timber_price = TimberPrice(
                    date=data.get('Date', datetime.now().strftime('%Y-%m-%d')),
                    seller=data.get('Seller', ''),
                    species=data.get('Species', ''),
                    type=data.get('Type', ''),
                    class_=data.get('Class', ''),
                    length=data.get('Length', 0.0),
                    diameter=data.get('Diameter', ''),
                    location=data.get('Location', ''),
                    price=data.get('Price', 0.0)
                )
                self.session.add(timber_price)
                self.session.commit()
            except IntegrityError:
                self.session.rollback()
            except Exception as e:
                print(f"Error inserting data: {e}")
                self.session.rollback()

    def get_latest_prices(self, limit=None):
        """Retrieve the latest timber prices from the database."""
        query = self.session.query(TimberPrice).order_by(TimberPrice.date.desc(), TimberPrice.created_at.desc())
        if limit is not None:
            query = query.limit(limit)
        results = query.all()
        return results

db = TimberDatabase()

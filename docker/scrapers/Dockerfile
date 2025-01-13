FROM python:3.9-slim

WORKDIR /app

# Install system dependencies including MySQL development files
RUN apt-get update && apt-get install -y \
    pkg-config \
    default-libmysqlclient-dev \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

COPY Scraping/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt
RUN pip install mysqlclient SQLAlchemy python-dotenv

COPY Scraping/ .
COPY .env .

CMD ["python", "run_scrapers.py"]

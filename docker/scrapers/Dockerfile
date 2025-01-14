FROM python:3.9-slim

WORKDIR /app

# Install system dependencies including MySQL development files
RUN apt-get update && apt-get install -y \
    pkg-config \
    apt-utils \
    libmysqlclient-dev \
    default-libmysqlclient-dev \
    build-essential \
    && rm -rf /var/lib/apt/lists/*


COPY Scraping/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt
RUN pip install mysqlclient SQLAlchemy python-dotenv
RUN python -m venv /opt/venv
ENV PATH="/opt/venv/bin:$PATH"
RUN pip install --upgrade pip
RUN apt-get update && apt-get install -y apt-utils
ENV DEBIAN_FRONTEND=noninteractive

COPY Scraping/ .
COPY .env .

# Run in scheduler mode by default (no "run" argument)
CMD ["python", "run_scrapers.py", "scheduler"]

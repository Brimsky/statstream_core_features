FROM python:3.9-slim

WORKDIR /app

# Install system dependencies including MySQL development files
RUN apt-get update && apt-get install -y \
    pkg-config \
    apt-utils \
    default-libmysqlclient-dev \
    libmariadb-dev \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

# Create and activate virtual environment
RUN python -m venv /opt/venv
ENV PATH="/opt/venv/bin:$PATH"

# Upgrade pip in the virtual environment
RUN pip install --upgrade pip

# Copy and install requirements
COPY Scraping/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copy application code
COPY Scraping/ .
COPY .env .

# Set the entrypoint to use scheduler mode
CMD ["python", "run_scrapers.py", "scheduler"]

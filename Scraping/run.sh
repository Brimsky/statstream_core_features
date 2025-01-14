#!/bin/bash

# Get the directory where the script is located
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Set MySQL environment variables
export LDFLAGS="-L/opt/homebrew/opt/mysql-client/lib"
export CPPFLAGS="-I/opt/homebrew/opt/mysql-client/include"
export PKG_CONFIG_PATH="/opt/homebrew/opt/mysql-client/lib/pkgconfig"

# Activate virtual environment
source "$DIR/venv/bin/activate"

# Install required packages if they're not already installed
pip install schedule requests sqlalchemy beautifulsoup4 selenium webdriver_manager mysqlclient

# Run the scrapers
python "$DIR/run_scrapers.py" run

# Deactivate virtual environment
deactivate

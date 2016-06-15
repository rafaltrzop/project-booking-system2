#!/bin/bash

DB_USER="root"
DB_PASSWORD="root"
DB_NAME="srtp2" # do not forget to update 01_create_database.sql

echo "* Creating database"
mysql -u$DB_USER -p$DB_PASSWORD < data/01_create_database.sql

echo "* Creating tables"
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/02_create_tables.sql

echo "* Configuring app"
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/03_configure_app.sql

read -p "Import sample data? [Y/n] " -n 1 -r
echo # move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]; then
  echo "* Inserting sample data"
  mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/04_insert_sample_data.sql
fi

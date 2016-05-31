#!/bin/bash

DB_USER="root"
DB_PASSWORD="root"
DB_NAME="srtp2"

echo "* Creating database"
mysql -u$DB_USER -p$DB_PASSWORD < data/01_create_database.sql

echo "* Creating tables"
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/02_create_tables.sql

echo "* Configuring app"
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/03_configure_app.sql

echo "* Inserting sample data"
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/04_insert_sample_data.sql

echo "* Adding user submissions"
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/05_add_submissions.sql

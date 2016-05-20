#!/bin/bash

DB_USER="root"
DB_PASSWORD="root"
DB_NAME="srtp2"

mysql -u$DB_USER -p$DB_PASSWORD < data/01_create_database.sql
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/02_create_tables.sql
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/03_configure_app.sql
mysql -u$DB_USER -p$DB_PASSWORD $DB_NAME < data/04_insert_sample_data.sql

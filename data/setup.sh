mysql -uroot -proot < data/01_create_database.sql
mysql -uroot -proot srtp2 < data/02_create_tables.sql
mysql -uroot -proot srtp2 < data/03_configure_app.sql
mysql -uroot -proot srtp2 < data/04_insert_sample_data.sql

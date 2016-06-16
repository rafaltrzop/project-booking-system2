# Project booking system 2

## Set up

1. Clone repository and install dependencies:

  ```
  $ cd project-booking-system2
  $ composer install
  $ npm install
  ```

2. Change your database credentials:

  ```
  $ vim data/setup.sh
  ```

3. Set up database and optionally import sample data:

  ```
  $ bash data/setup.sh
  ```

4. Generate assets:

  ```
  $ gulp compile:sass copy:fonts copy:js
  ```

## Usage

Just log in as an administrator and manage your app:

```
email: admin@example.com
password: password
```

If you decided to import sample data you can also use the following accounts to test things out:

```
email: mod@example.com
password: password
```

```
email: user@example.com
password: password
```

## Development

Run gulp to copy and compile all the assets. It will re-run every time you make some changes.

```
$ gulp
```

## Documentation

Download phpDoc:

```
$ curl -OL http://www.phpdoc.org/phpDocumentor.phar
```

Generate docs:
```
$ php phpDocumentor.phar -d src/ -t docs/
```

# Heroku

1. [Set up PHP project](https://devcenter.heroku.com/articles/getting-started-with-php) and add [JawsDB MySQL](https://elements.heroku.com/addons/jawsdb) add-on.

2. Use multiple buildpacks for an app:

  ```
  $ heroku buildpacks:add --index 2 heroku/nodejs
  ```

3. Deploy your app.
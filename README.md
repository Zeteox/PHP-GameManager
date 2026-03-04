# PHP GameViewer

A lightweight **vanilla PHP** web application that allows users to track the games they play, unlock achievements, and manage their gaming activity.

This project uses:
- Pure PHP (no framework)
- Docker for MySQL
- PDO for secure database access
- Dynamic frontend powered by database content

---

## Features

- User registration & authentication
- Add and manage games
- Achievement system
- Dynamic game listing (data-driven frontend)
- Admin account for moderation & issue management
- Dockerized MySQL database
- Lightweight & framework-free

---

## Tech Stack

- **PHP 8+**
- **MySQL 8 (Docker)**
- **PDO (PHP Data Objects)**
- **HTML5 / CSS3 / JavaScript**
- **Docker & Docker Compose**

---

## Prérequise

You need to activate you mysqli and pdo_mysql extension to mak the projet work. <br>
You'll also need to have docker desktop for Windows and Mac, for linux just install the package.

you will also nee to create a **.env** file at the root of the project like this one, make sure to change te values:
```
DB_HOST=localhost
DB_ROOT_PASS=secret_root
DB_PASS=secret_user
DB_NAME=app_db
DB_USER=user
```

---

## Launching

To launch the server do these commands:
```
PHP-GameManager:~$ docker compose up -d
PHP-GameManager:~$ php -S localhost:8080 -t public/
```

---

## Reset the database

To reset the database, you'll need to down your docker container with the following command:

```
PHP-GameManager:~$ docker compose down
```

After that, you will delete de database/db_data folder<br>
Then relaunch the database with this command
```
PHP-GameManager:~$ docker compose up -d
```

After that the database will be reseted and have the default data put in the database/init/init.sql file.

### /!\ An admin user is put by default with the following indentifier make sure to replace delete it with a safer one: /!\
```
$email = admin@exemple.com<br>
$password = admindefault
```

---

## License

This project is licensed under the **MIT License**.

---

## Contact

For any questions or issues, feel free to reach out:

### Loïc DELPRAT
- **Email** : [loic.delprat@ynov.com](mailto:loic.delprat@ynov.com)
- **LinkedIn** : [Loïc DELPRAT](https://linkedin.com/in/loïc-delprat)
- **GitHub** : [Zeteox](https://github.com/Zeteox)

### Ylan DESSENE
- **Email** : [ylan.dessenne@ynov.com](mailto:ylan.dessenne@ynov.com)
- **LinkedIn** : [ylan DESSENNE](https://linkedin.com/in/dessenne-ylan)
- **GitHub** : [Torolgo](https://github.com/Torolgo)


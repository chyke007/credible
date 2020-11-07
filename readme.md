# Nafc Portal

A full blown SPA built with Vue.js and Laravel for the Nigerian Army Finance Corps


# create a new droplet on digital ocean, 
# login to root, change root password
# add a new user
- sudo adduser username
# grant user elevated priviledges 
 - visudo
 -  username ALL=(ALL:ALL) ALL 

# sudo apt-get install mysql-server

 - sudo mysql_secure_installation utility

/# you can start the database service by running the following command. 
 - sudo systemctl start mysql
 - To ensure that the database server launches after a reboot, run the following command:
 - sudo systemctl enable mysql
# install php my admin
 - sudo apt-get install phpmyadmin php-mbstring php-gettext
 - edit the phpmyadmin config File
 - sudo nano /etc/apache2/conf-available/phpmyadmin.conf

# add the config file to apache config file 
 - sudo nano /etc/apche2/apache2.conf
  'Include /etc/phpmyadmin/apache.conf'

# changing phpmyadmin access url 
 - sudo nano /etc/phpmyadmin/apache.conf
 - Alias /yournewalias /usr/share/phpmyadmin
 - sudo service apache2 restart

## Getting Started
* Clone or download this repo
* Run composer install
* Edit .env to you database credentials
* Run migration (N:b This should only be crried out once n the live server to avoid loss of data)
* Run seed
* Run compile for JS
* Serve the application

### Setting up production server
Do the following

```
Install Mysql on server
Install phpmyadmin (this would install apache with it) 
Created ssh key in repo and added it to server(Digital ocean)
```

### Prerequisites

Install the following 


```
Composer
 Node

```


### Installing

```
# Install Dependencies
composer install

# Run Migrations
php artisan migrate

# Import Articles
php artisan db:seed

# If you get an error about an encryption key
php artisan key:generate

# Passport
php artisan passport:install

# Clear cache
php artisan cache:clear

# Clear config
php artisan config:cache

# Install JS Dependencies
npm install 

# Watch Files
npm run watch -- in development
npm run prod -- in production

```

## Endpoints

### Register user
```
POST api/register
{"reg_service_number":"staf",
"full_name":"dd",
"email":"de@zercomsystems.com",
"rank":"ddd",
"unit":"ddd",
"salary_step":"dd43",
"date_promotion": "2019-12-10:0"
}
```

### Login user
```
POST api/login
{ "service_number":"","password":""}

```
### Adds article
```
POST api/{role}/community
title/body/image

{role} - either admin or officer ~ secured route
```
### Gets all community news
```
GET api/communitynews

```

## Built With

* [Laravel](https://laravel.com/) - The web framework used
* [VueJs](https://vuejs.org/) - Used for front end functionality
* [Bootstrap](https://getbootstrap.com/) - Used for the UI



## Versioning

We use [SemVer](http://semver.org/) for versioning. Current version is 1.0.0

## Authors

* **Nwachukwu Chibuike** - *Initial work* - [NodeRest](https://github.com/chyke007/hackvotes)
* **Olubayo Samuel**
* **Joseph Ayobami** 
## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details

## Acknowledgments

* Olowogbayi Gbenga
* Ekeh Wisdom


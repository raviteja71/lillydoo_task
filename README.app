Technologies:
	Symfony 3.4
	Doctrine with SQLite
	Twig
	PHP 7.0

Installation Steps:

```composer create-project symfony/framework-standard-edition addresbook "3.4"```

```cd addressbook/app/config```


in config.yml 
	->change pdo_mysql to pdo_sqlite 
	->uncomment "path"
in parameters.yml.dist uncomment sqlite driver

start application : 
	```php bin/console server:run```

create database: 
	```php bin/console doctrine:database:create```

cerate table schema:  
	```php bin/console doctrine:generate:entity```

use yml for file type as it is the default
	
check for mapping and schema are ready or not
	```php bin/console doctrine:schema:validate``` (you have to see a green mesage with all ok.)

if not please update databse
	```php bin/console doctrine:schema:update --force```
	
To work with forms please use below command
	```composer require symfony/form```
	



Technologies:
	Symfony 3.4
	Doctrine with SQLite
	Twig
	PHP 7.0

Installation Steps:

```composer create-project symfony/framework-standard-edition addresbook "3.4"```

```cd addressbook/app/config```


in config.yml 
	->change pdo_mysql to pdo_sqlite 
	->uncomment "path"
in parameters.yml.dist uncomment sqlite driver

start application : 
	```php bin/console server:run```

create database: 
	```php bin/console doctrine:database:create```

cerate table schema:  
	```php bin/console doctrine:generate:entity```

use yml for file type as it is the default
	
check for mapping and schema are ready or not
	```php bin/console doctrine:schema:validate``` (you have to see a green mesage with all ok.)

if not please update databse
	```php bin/console doctrine:schema:update --force```
	
To work with forms please use below command
	```composer require symfony/form```
	




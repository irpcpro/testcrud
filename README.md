<h1>Test CRUD</h1>

**Version:**
<span>1.0.0</span>

A project for managing `Products` & `Orders` with `JWT` authentication

[![Latest Stable Version](http://poser.pugx.org/irpcpro/testcrud/v)](https://packagist.org/packages/irpcpro/testcrud) [![Total Downloads](http://poser.pugx.org/irpcpro/testcrud/downloads)](https://packagist.org/packages/irpcpro/testcrud) [![Latest Unstable Version](http://poser.pugx.org/irpcpro/testcrud/v/unstable)](https://packagist.org/packages/irpcpro/testcrud) [![License](http://poser.pugx.org/irpcpro/testcrud/license)](https://packagist.org/packages/irpcpro/testcrud) [![PHP Version Require](http://poser.pugx.org/irpcpro/testcrud/require/php)](https://packagist.org/packages/irpcpro/testcrud)

<h2>+ Installation</h2>

Install this project via Composer:

```
composer create-project irpcpro/testcrud
```

<h2>+ Requirements</h2>

- PHP: `^8.1`
- mongodb/laravel-mongodb: `^4.3`
- tymon/jwt-auth: `^2.1`
- Redis Driver (windows): `v4.2.1`
- MongoDB (windows): `7.2.5`

<h2>+ MongoDB Installation & Configuration</h2>

<h3>installing MongoDB</h3>

- first you need to install the `MongoDB 7.2.5` for windows.
- after installing, you have to insert your DB connection to the `.env` file. to connect the project to the database.

<h3>Download MongoDB Extension .dll file</h3>

- next step, you have to install the Ext of the MongoDB for PHP and enable it through the `php.ini` file.
- for downloading, go to the packages PHP official website, and base on your windows, download the version of the `.dll` which is compatible with your windows and the PHP version which is installed on your PC.
- [MongoDB PHP Package (https://pecl.php.net/package/mongodb)](https://pecl.php.net/package/mongodb)

<h3>Install the extension</h3>

- 1- go to your PHP folders where you've installed. (for finding the path of the PHP file, execute this command on CommandPrompt: `where php`)
- go to this path and copy the `php_mongodb.dll`

```
{drive}:\php\php-{version}\ext
```

- next step, you have to add the extension name to `php.ini` file. go to this path and open the `php.ini` file with `notepad`:

```
{drive}:\php\php-{version}\
```

- in the part of the `Dynamic Extensions` (you can search it) add this command and save the file and restart your PHP server

```
..
..
extension=mongodb
```

- you can check in the terminal to see if it is installed. open your CommandPrompt and run this command :

```
> php -m | find "mongo"
```

- the output should be `mongodb`
- or just execute this code via PHP :

```phpt
<?php echo phpinfo(); ?>
```


<h3>config Replica Set and run the database</h3>

- first open the `CommandPrompt` as administrator and run this command to start the Replica Set

```
mongod --dbpath "C:\data\db" --logpath "C:\data\log\mongod.log" --replSet "rs0"
```

- now, open another `CommandPrompt` as administrator and run this command to enter to the MongoDB environment

```
mongo
```

- now you can initiate the Replica and see the status of this with these two commands:

```
> rs.initiate()

> rs.status()
```

<h3>Debugging</h3>

- if you have a problem for running Replica Set and you face a problem like this :

```composer log
> rs.initiate()
{
        "ok" : 0,
        "errmsg" : "This node was not started with the replSet option",
        "code" : 76,
        "codeName" : "NoReplicationEnabled"
}
```

- it's because you're port of the MongoDB is reserved. and you have to stop the process which is run on the port of `27017`

<h3>Killing the port</h3>

- 1- Open the `CommandPrompt` as administrator.
- 2- run this command: `> netstat -aon | find "27017"`.
- 3- then you see something like this :

```
TCP   127.0.0.1:27017   0.0.0.0:0   LISTENING   13936
```

- 4- the `13936` is the `PID` that you have to kill it.
- 5- next step, run this command to abort this process:

```
taskkill /pid {PID} /f
```

like :

```
taskkill /pid 13936 /f
```

<h2>+ Redis Installation & Configuration</h2>

<h3>Installing Redis</h3>

- installing Redis v4.2.1 for windows. you can download the release version from the Redis Github
- [Redis GitHub (https://github.com/redis-windows/redis-windows)](https://github.com/redis-windows/redis-windows)
- after downloading, you have to run 2 service. first run the `redis-server.exe` and next run the `redis-cli.exe`
- your redis driver is running

<h3>Install Redis PHP Extension</h3>

- for downloading, go to the packages PHP official website, and base on your windows, download the version of the `.dll` which is compatible with your windows and the PHP version which is installed on your PC.
- [Redis PHP Package (https://pecl.php.net/package/redis)](https://pecl.php.net/package/redis)

<h3>Install the extension</h3>

- 1- go to your PHP folders where you've intsalled. (for finding the path of the PHP file, execute this command on CommandPrompt: `where php`)
- go to this path and copy the `php_redis.dll`

```
{drive}:\php\php-{version}\ext
```

- next step, you have to add the extension name to `php.ini` file. go to this path and open the `php.ini` file with `notepad`:

```
{drive}:\php\php-{version}\
```

- in the part of the `Dynamic Extensions` (you can search it) add this command and save the file and restart your PHP server`

```
..
..
extension=redis
```
- you can check in the terminal to see if it is installed. open your CommandPrompt and run this command :
- `php -m | find "redis"`
- the output should be `redis` 
- or just execute this code via PHP :
- `<?php echo phpinfo(); ?>`


<h3>changing the cache driver</h3>

- for chaning the `Cache Driver` of the project, if you don't have Redis Driver on your system, open the `.env` file and change the `CACHE_DRIVER` to `file` like this :
- `CACHE_DRIVER=file`
- also you can set it with Redis
- `CACHE_DRIVER=redis`


<h2>+ Postman Collection & Environment</h2>

- there are the Postman Collection and Environment for importing.
- collections are available on `DEVELOPMENT` folder
- `Collection => DEVELOPMENT/CRUD.postman_collection.json`
- `Environment => DEVELOPMENT/CRUD.postman_environment.json`



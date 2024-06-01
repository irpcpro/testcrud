<h1>Test CRUD</h1>
**Version:**
<span>1.0.0</span>

<p>A project for managing `Products` & `Orders` with `JWT` authentication</p>

<h2>Installation</h2>
Install this project via Composer:
```
composer create-project irpcpro/testcrud
```

<h2>Requirements</h2>
<ul>
    <li>PHP: `^8.1`</li>
    <li>mongodb/laravel-mongodb: `^4.3`</li>
    <li>tymon/jwt-auth: `^2.1`</li>
    <li>Redis Driver (windows): `v4.2.1`</li>
    <li>MongoDB (windows): `7.2.5`</li>
</ul>

<h2>MongoDB Installation & Configuration</h2>
<h3>installing MongoDB</h3>
<ul>
    <li>first you need to install the `MongoDB 7.2.5` for windows.</li>
    <li>after installing, you have to insert your DB connection to the `.env` file. to connect the project to the database.</li>
</ul>

<h3>Download MongoDB Extension `.dll` file</h3>
<ul>
    <li>next step, you have to install the Ext of the MongoDB for PHP and enable it through the `php.ini` file.</li>
    <li>for downloading, go to the packages PHP official website, and base on your windows, download the version of the `.dll` which is compatible with your windows and the PHP version which is installed on your PC.</li>
    <li>[MongoDB PHP Package (https://pecl.php.net/package/mongodb)](https://pecl.php.net/package/mongodb)</li>
</ul>

<h3>Install the extension</h3>
<ul>
    <li>1- go to your PHP folders where you've installed. (for finding the path of the PHP file, execute this command on CommandPrompt: `where php`)</li>
    <li>go to this path and copy the `php_mongodb.dll`</li>
</ul>

```
{drive}:\php\php-{version}\ext
```
<ul>
    <li>next step, you have to add the extension name to `php.ini` file. go to this path and open the `php.ini` file with `notepad`:</li>
</ul>

```
{drive}:\php\php-{version}\
```
<ul>
    <li>in the part of the `Dynamic Extensions` (you can search it) add this command and save the file and restart your PHP server</li>
</ul>

```
..
..
extension=mongodb
```

<ul>
    <ii>you can check in the terminal to see if it is installed. open your CommandPrompt and run this command :</ii>
</ul>

`php -m | find "mongo"`
<ul>
    <li>the output should be `mongodb`</li>
    <li>or just execute this code via PHP :</li>
</ul>
`<?php echo phpinfo(); ?>`


<h3>config Replica Set and run the database</h3>
- <p>first open the `CommandPrompt` as administrator and run this command to start the Replica Set</p>

```
mongod --dbpath "C:\data\db" --logpath "C:\data\log\mongod.log" --replSet "rs0"
```
- <p>now, open another `CommandPrompt` as administrator and run this command to enter to the MongoDB environment</p>
```
mongo
```
- <p>now you can initiate the Replica and see the status of this with these two commands:</p>
```
> rs.initiate()

> rs.status()
```

<h3>Debugging</h3>
- <p>if you have a problem for running Replica Set and you face a problem like this :</p>
```
> rs.initiate()
{
        "ok" : 0,
        "errmsg" : "This node was not started with the replSet option",
        "code" : 76,
        "codeName" : "NoReplicationEnabled"
}
```
- <p>it's because you're port of the MongoDB is reserved. and you have to stop the process which is run on the port of `27017`</p>

<h3>Killing the port</h3>
<p>
1- Open the `CommandPrompt` as administrator<br/>
2- run this command: `> netstat -aon | find "27017"`<br/>
3- then you see something like this :
</p>

```
TCP   127.0.0.1:27017   0.0.0.0:0   LISTENING   13936
```
<p>
4- the `13936` is the `PID` that you have to kill it.
5- next step, run this command to abort this process:
</p>

```
taskkill /pid {PID} /f
```

like :
```
taskkill /pid 13936 /f
```


<h2>Redis Installation & Configuration</h2>
<h3>Installing Redis</h3>
- <p>installing Redis v4.2.1 for windows. you can download the release version from the Redis Github</p>
- [Redis GitHub (https://github.com/redis-windows/redis-windows)](https://github.com/redis-windows/redis-windows)
- <p>after downloading, you have to run 2 service. first run the `redis-server.exe` and next run the `redis-cli.exe`</p>
- <p>your redis driver is running</p>

<h3>Install Redis PHP Extension</h3>
- <p>for downloading, go to the packages PHP official website, and base on your windows, download the version of the `.dll` which is compatible with your windows and the PHP version which is installed on your PC.</p>
- [Redis PHP Package (https://pecl.php.net/package/redis)](https://pecl.php.net/package/redis)

<h3>Install the extension</h3>
- <p>1- go to your PHP folders where you've intsalled. (for finding the path of the PHP file, execute this command on CommandPrompt: `where php`)</p>
- <p>go to this path and copy the `php_redis.dll`</p>
```{drive}:\php\php-{version}\ext```
- <p>next step, you have to add the extension name to `php.ini` file. go to this path and open the `php.ini` file with `notepad`:</p>
```{drive}:\php\php-{version}\```
- <p>in the part of the `Dynamic Extensions` (you can search it) add this command and save the file and restart your PHP server</p>
```
..
..
extension=redis
```
- <p>you can check in the terminal to see if it is installed. open your CommandPrompt and run this command :</p>
- `php -m | find "redis"`
- <p>the output should be `redis`</p> 
- <p>or just execute this code via PHP :</p>
- `<?php echo phpinfo(); ?>`


<h3>changing the cache driver</h3>
- <p>for chaning the `Cache Driver` of the project, if you don't have Redis Driver on your system, open the `.env` file and change the `CACHE_DRIVER` to `file` like this :</p>
- `CACHE_DRIVER=file`
- <p>also you can set it with Redis</p>
- `CACHE_DRIVER=redis`


<h3>Postman Collection & Environment</h3>
- <p>there are the Postman Collection and Environment for importing.</p>
- <p>collections are available on `DEVELOPMENT` folder</p>
- [Collection](./DEVELOPMENT/CRUD.postman_collection.json)
- [Environment](./DEVELOPMENT/CRUD.postman_environment.json)



+ test

-----------------------------------
replica =


    config Replica Set
    $ find the 27017 & kill it
    $ mongod --dbpath "C:\data\db" --logpath "C:\data\log\mongod.log" --replSet "rs0"
    $ mongo
    $ rs.initiate()


    install mongodb =
    php.ini
    add ext file (https://pecl.php.net/package/mongodb)
    add ext line


    install redis = php.ini
    redis windows (https://github.com/redis-windows/redis-windows)
    redis php ext (https://pecl.php.net/package/redis)

    redis =
    copy file "redis"



    cache =
    change cache driver
    env => CACHE_DRIVER

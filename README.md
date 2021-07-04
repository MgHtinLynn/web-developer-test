# Web-Developer-Test
Web Test System with PHP 8 + Vanilla JS + API
# Setup
## Docker Desktop
-  First download dockerhub desktop from https://docs.docker.com/get-docker/ depend on your laptop or pc. Window, Mac, Linux.
-  Create Account at dockerhub
-  After install docker desktop and login with your account (https://docs.docker.com/docker-for-windows/install/)
-  If interest , keep digging more. There was a lot of knowledge for infrastructure (kubernetes) (docker-swarm)

## Host Setup with https certificate
https://laravel.com/docs/8.x/valet
   ```console
   composer global require laravel/valet
   valet install
   ```

## Local Dev Setup
- clone repo from Github

```console
git clone https://github.com/MgHtinLynn/web-developer-test.git
cd web-developer-test
```

Link valet certificate with nginx proxy
```console
ln -s /Users/htinlynn/.config/valet/Certificates {dir of repo clone}/data/
ln -s /Users/htinlynn/.config/valet/Certificates data/
```

Link Valet With Https URL
```console
valet secure {host-name}
```

For Example
```console
valet secure web-test
```

That will generate https certificate for your repo

We have to disable nginx port 80 in PC or Laptop


```console
valet stop
```


For Server Up
```console
docker-compose up -d
```

For Sever Down
```console
docker-compose down
```

!!BOOM!!

You can call your host name to web-browser

In my mac
https://web-test.test/

if different dir, need to update docker-compose file.


For Migration
```console
docker exec -i mariadb mysql -uroot -proot --database=web_test < web_test.sql
```

For API Earthquakes API Link

The First Task -
- https://web-test.test/

The Second Task
For API Testing, There is a file . You can import in your postman.
- web_test.postman_collection.json
- Get Products
- Store Product

Enjoy your setup.

If any problem , open the issue.

Htin Lynn,
htinlin01@gmail.com,
09785360975 



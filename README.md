# dacxi_api

#### Requirements
- docker >= 20.10.9
- docker-compose >= 1.27.4
- git >= 2.25.1
- composer >= 1.10.1

### Add virtual hosts
```sh
127.0.0.1       mysql
```
### Clone project
```sh
git clone https://github.com/anderson-matheus/dacxi_api.git
```

### Configure nginx
```sh
cd dacxi_api/docker/nginx
sudo cp dacxi_api.nginx.conf.example dacxi_api.nginx.conf
```

#### Config .env
```sh
cd dacxi_api/
sudo cp .env.example .env
```

### Update env vars
```sh
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=dacxi_api
DB_USERNAME=dacxi
DB_PASSWORD=123456

API_COINGECKO="https://api.coingecko.com/api/v3"
```

#### Install project
```sh
docker-compose up -d
docker exec -it php sh
composer install
php artisan key:generate
php artisan migrate
```


#### Application url
- DEV: [http://localhost/](localhost)
- PROD: [http://159.223.186.38//](http://159.223.186.38/)

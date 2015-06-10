# Posaderos

### Docker
Para usar Docker (requiere docker-compose)

```sh
git clone https://github.com/CrimsonGlory/posaderos.git
mv env-sample .env
composer update
composer install
docker-compose up
docker exec -i -t posaderos_web_1 php artisan migrate
docker exec -i -t posaderos_web_1 php artisan db:seed
```
En caso de utilizar en producción cambiar la APP_KEY en .env

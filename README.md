# Posaderos

### Docker
Para usar [Docker](http://www.docker.com) (requiere [docker-compose](https://docs.docker.com/compose/))
```sh
#bajar la imagen de posaderos_web 
wget "https://www.dropbox.com/s/wk2h7smvteptupv/posaderos_web_latest_image.tar?dl=0" -O posaderos_web_latest_image.tar
docker load < posaderos_web_latest_image.tar 
git clone https://github.com/CrimsonGlory/posaderos.git
cd posaderos
mv env-docker .env
docker-compose up
```
Ir a localhost:8888 y debería estar el sitio online.

docker-compose up lo usamos solo la primera vez. Después se puede levantar y bajar el servicio con 
```sh
docker-compose <start|stop>
```
En caso de utilizar en producción cambiar la APP_KEY en .env

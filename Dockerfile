FROM debian:jessie
RUN apt-get update -y && \
    apt-get install -y  php5-cli \
			curl \
			git  \
			php5-mcrypt \
			php5-gd \
			php5 \
			php5-mysql  && \
			curl -sS https://getcomposer.org/installer | php && \
			mv composer.phar /usr/local/bin/composer 
RUN mkdir /myapp
WORKDIR /myapp
ADD .env /myapp/.env
#RUN git clone https://github.com/CrimsonGlory/posaderos.git myapp
ADD . /myapp

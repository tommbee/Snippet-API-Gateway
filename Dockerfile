FROM dusterio/ubuntu-php7:latest

RUN apt-get -y update
RUN apt-get -y install php-xdebug

ENV CHOWN_TO_USER=www-data

RUN mkdir -p /app
ADD app /app/app
ADD public /app/public
ADD vendor /app/vendor
ADD tests/ /app/tests
ADD phpunit.xml /app/
ADD setup.sh /

EXPOSE 80

RUN rm /etc/nginx/sites-enabled/default
ADD site.conf /etc/nginx/sites-enabled/site.conf

ENTRYPOINT ["/bin/sh", "/setup.sh"]

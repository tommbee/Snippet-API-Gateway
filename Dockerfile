FROM webdevops/php-nginx:7.1

env WEB_DOCUMENT_ROOT=/var/www/public

RUN mkdir -p /var/www/public
ADD app /var/www/app
ADD public /var/www/public
ADD vendor /var/www/vendor
ADD tests/ /var/www/tests
ADD phpunit.xml /var/www/
ADD bootstrap.php /var/www/

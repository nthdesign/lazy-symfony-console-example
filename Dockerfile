FROM php:latest
COPY ./app /usr/src/app
WORKDIR /usr/src/app
CMD [ "php", "./app.php" ]
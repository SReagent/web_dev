FROM php:7.2.6-apache

RUN docker-php-ext-install mysqli

RUN a2enmod rewrite

RUN echo '<Directory /var/www/html>' >> /etc/apache2/conf-available/my-apache-config.conf
RUN echo '    AllowOverride All' >> /etc/apache2/conf-available/my-apache-config.conf
RUN echo '</Directory>' >> /etc/apache2/conf-available/my-apache-config.conf

RUN a2enconf my-apache-config
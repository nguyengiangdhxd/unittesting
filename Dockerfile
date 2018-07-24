# Set base image
FROM ubuntu:latest

# Add Maintainer name and email address
MAINTAINER Ramesh B <ramesh90.crescent@gmail.com>

# Set frontend
ENV DEBIAN_FRONTEND noninteractive

# Install basics
RUN apt-get update && apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php && apt-get update
RUN apt-get install -y curl

# Install PHP 7.2
#RUN apt-get install -y — allow-unauthenticated php7.2 php7.2-mysql php7.2-mcrypt php7.2-cli php7.2-gd php7.2-curl
RUN apt-get install -y php7.2 php7.2-mysql php7.2-curl php7.2-gd php7.2-json php7.*-mbstring php7.*-mcrypt


# Enable apache mods.
RUN a2enmod php7.2
RUN a2enmod rewrite

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.2/apache2/php.ini
RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.2/apache2/php.ini

# Manually set up the apache environment variables
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

# Expose apache.
EXPOSE 80
EXPOSE 8080
EXPOSE 443
EXPOSE 3306

# Update the default apache site with the config we created.
ADD apache-config.conf /etc/apache2/sites-enabled/000-default.conf

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND

#move the updated files to target location
COPY code/ /var/www/html


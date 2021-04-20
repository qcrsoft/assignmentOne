FROM jenkins/jenkins:lts

USER root
COPY plugins.txt /usr/share/jenkins/plugins.txt
#RUN /usr/local/bin/plugins.sh /usr/share/jenkins/plugins.txt

#
# nodejs
#
RUN    curl -sL https://deb.nodesource.com/setup_12.x | DEBIAN_FRONTEND=noninteractive bash - \
    && DEBIAN_FRONTEND=noninteractive apt-get install -yq \
         build-essential \
         nodejs

#
# PHP
#
RUN    DEBIAN_FRONTEND=noninteractive apt install -y lsb-release ca-certificates apt-transport-https software-properties-common \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list \
    && wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add - \
    && DEBIAN_FRONTEND=noninteractive apt update

RUN    DEBIAN_FRONTEND=noninteractive apt-get install -yq --no-install-recommends \
         php8.0-cli \
         php8.0-curl \
         php8.0-fpm \
         php8.0-gd \
         php8.0-mbstring \
         php8.0-pdo\
         php8.0-mysql \
         php8.0-xml \
         php8.0-zip \
         php8.0-intl \
         php8.0-xdebug

RUN wget https://getcomposer.org/installer -O - | php -- --install-dir=/usr/local/bin/ --filename=composer
#RUN wget https://get.symfony.com/cli/installer -O - | bash && mv $HOME/.symfony/bin/symfony /usr/local/bin/.

#
# mariadb
#
RUN    DEBIAN_FRONTEND=noninteractive apt-get install -yq --no-install-recommends \
         mariadb-server

RUN    mkdir -p /var/lib/mysql /var/log/mysql /var/run/mysqld \
    && chown -R jenkins:jenkins /var/lib/mysql /var/log/mysql /var/run/mysqld

USER jenkins


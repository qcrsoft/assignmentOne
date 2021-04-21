FROM debian:10

RUN    DEBIAN_FRONTEND=noninteractive apt-get update \
    && DEBIAN_FRONTEND=noninteractiv apt-get install -y locales \
    && rm -rf /var/lib/apt/lists/* \
    && localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US.UTF-8
ENV LANG en_US.utf8

RUN    DEBIAN_FRONTEND=noninteractive apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -yq --no-install-recommends \
         ca-certificates \
         curl \
         git \
         wget

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

#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /docroot
WORKDIR /docroot
CMD php -S 0.0.0.0:80 -t /docroot

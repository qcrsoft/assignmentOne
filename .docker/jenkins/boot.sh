#!/bin/sh -x

MYSQL_DATA_DIR=/var/lib/mysql

if [ ! -d "${MYSQL_DATA_DIR}/mysql" ]; then
    /usr/bin/mysql_install_db --user=
fi

#/usr/bin/mysqld_safe --datadir=${MYSQL_DATA_DIR} --user &
/usr/bin/mysqld_safe --user &

exec /usr/local/bin/jenkins.sh

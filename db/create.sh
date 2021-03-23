#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE orientat_test;"
    psql -U postgres -c "CREATE USER orientat PASSWORD 'orientat' SUPERUSER;"
else
    [ "$1" = "test" ] || sudo -u postgres dropdb --if-exists orientat
    sudo -u postgres dropdb --if-exists orientat_test
    [ "$1" = "test" ] || sudo -u postgres dropuser --if-exists orientat
    [ "$1" = "test" ] || sudo -u postgres psql -c "CREATE USER orientat PASSWORD 'orientat' SUPERUSER;"
    [ "$1" = "test" ] || sudo -u postgres createdb -O orientat orientat
    [ "$1" = "test" ] || sudo -u postgres psql -d orientat -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O orientat orientat_test
    sudo -u postgres psql -d orientat_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    [ "$1" = "test" ] && exit
    LINE="localhost:5432:*:orientat:orientat"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi

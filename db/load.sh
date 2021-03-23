#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U orientat -d orientat < $BASE_DIR/orientat.sql
    if [ -f "$BASE_DIR/orientat_test.sql" ]; then
        psql -h localhost -U orientat -d orientat < $BASE_DIR/orientat_test.sql
    fi
    echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U orientat -d orientat
fi
psql -h localhost -U orientat -d orientat_test < $BASE_DIR/orientat.sql
echo "DROP TABLE IF EXISTS migration CASCADE;" | psql -h localhost -U orientat -d orientat_test

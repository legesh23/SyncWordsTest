#!/bin/bash

set -e
set -u

function create_user_and_db() {
  local database=$1

    echo "  Creating user and database '$database'"
    psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<-EOSQL
        CREATE USER root;
        CREATE DATABASE syncwords_api;
        GRANT ALL PRIVILEGES ON DATABASE syncwords_api TO syncwords_api;
EOSQL
}

if [ -n "$POSTGRES_MULTIPLE_DATABASES" ]; then
    echo "Multiple database creation requested: $POSTGRES_MULTIPLE_DATABASES"
    for db in $(echo $POSTGRES_MULTIPLE_DATABASES | tr ',' ' '); do
        create_user_and_db $db
    done
    echo "Multiple databases created"
fi

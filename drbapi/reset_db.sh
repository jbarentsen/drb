#!/bin/bash
php public/index.php dbal:run-sql "DROP DATABASE ta_ncp; CREATE DATABASE ta_ncp;"
php public/index.php orm:schema-tool:update --force
php public/index.php migration apply


./vendor/bin/propel sql:build --overwrite
./vendor/bin/propel model:build
composer dump-autoload
./vendor/bin/propel config:convert

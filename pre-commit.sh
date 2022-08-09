#!/bin/bash

npm run check-format
ESLINT_EXIT_CODE=$?

if [ $ESLINT_EXIT_CODE -ne 0 ]
then
	npm run format
fi


composer check-format
CS_FIXER_EXIT_CODE=$?

if [ $CS_FIXER_EXIT_CODE -ne 0 ]
then
	composer format
fi


#composer analyse
#PHP_STAN_EXIT_CODE=$?


if [ $ESLINT_EXIT_CODE -ne 0 ] || [ $CS_FIXER_EXIT_CODE -ne 0 ]
then
	exit -1
fi


php artisan test
PHP_ARTISAN_EXIT_CODE=$?

if [ $PHP_ARTISAN_EXIT_CODE -ne 0 ]
then
	exit -1
fi

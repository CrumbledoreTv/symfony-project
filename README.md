simplon_project
===============

A Symfony project created on April 20, 2017, 10:24 am.

$ git clone https://github.com/MaksJS/simplon_symfony.git && composer install && bower install

$ php bin/console doctrine:schema:validate

$ php bin/console doctrine:schema:create

$ php bin/console doctrine:schema:update --force

$ php bin/console generate:doctrine:crud --entity=AppBundle:Foo --format=annotation --with-write --no-interaction

$ php bin/console generate:doctrine:entity

$ php bin/console generate:doctrine:entities AppBundle

$ php bin/console generate:doctrine:form AppBundle:Product

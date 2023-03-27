https://symfony.com/doc/current/the-fast-track/en/19-workflow.html

https://symfony.com/doc/current/components/workflow.html

```
Pour démarrer en local :

[SHELL #1]
cd app && symfony server:start

[SHELL #2]
composer update
php bin/console cache:clear
php bin/console cache:clear
php bin/console doctrine:schema:update --dump-sql --force --complete -v
php bin/console doctrine:fixtures:load -v

NB: En parallèle, il y a un fichier à modifier .env.dev qui contient la connexion à la base de données, ainsi que le domaine local à utiliser
```

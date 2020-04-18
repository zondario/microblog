# Welcome to the microblog
To setup the project
1. Change database settings in config/doctrine.php
2. ./vendor/doctrine/orm/bin/doctrine orm:schema-tool:create
3. php ./config/misc/users/generate.php
4. cd public/
5. php -S localhost:8080
6. open localhost:8080 in browser
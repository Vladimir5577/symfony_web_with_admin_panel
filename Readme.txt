composer create-project symfony/skeleton new_project
mv new_project/* .
mv new_project/.* .
rm -R new_project
composer require webapp


cp .env .env.local
put credentials inside .env.local

// =====================================
composer require easycorp/easyadmin-bundle
php bin/console make:user
    Name: User
    Security identifier: email
    Store in database: yes
php bin/console make:entity User
    Добавь поле:
        password → string → length 255


// =====================================
php bin/console make:migration
php bin/console doctrine:migrations:migrate

// =======================================

php bin/console make:auth
    Выбираем:
        Login form authenticator
        Controller name: SecurityController
        Login route: /login
        Symfony сам создаст:
        форму логина
        security конфиг


composer require --dev doctrine/doctrine-fixtures-bundle
php bin/console make:fixtures UserFixtures
php bin/console doctrine:fixtures:load


composer require easycorp/easyadmin-bundle
php bin/console make:admin:dashboard
    Controller: AdminDashboardController
    URL: /admin


php bin/console make:migration
php bin/console doctrine:migrations:migrate


// CRUD for admin

php bin/console make:controller ProductController
php bin/console make:entity Product
Поля, например:
    name (string)
    price (float)
    createdAt (datetime)

php bin/console make:migration
php bin/console doctrine:migrations:migrate


php bin/console make:admin:crud
    Выбираешь:
        Entity: Product
        Controller: ProductCrudController



php bin/console make:admin:dashboard

for soft delete
composer require stof/doctrine-extensions-bundle



// ============================
Resize image
composer require liip/imagine-bundle


Step 2 — Upload original images

Store uploaded images in public/uploads/images/:

public/uploads/images/photo.jpg


This is the original — you only back up this folder.

Step 3 — Display images in Twig

Original image:

<img src="{{ asset('uploads/images/photo.jpg') }}" alt="Original">


Thumbnail (150×150):

<img src="{{ asset('uploads/images/photo.jpg') | imagine_filter('thumbnail') }}" alt="Thumbnail">


Medium (800×600):

<img src="{{ asset('uploads/images/photo.jpg') | imagine_filter('medium') }}" alt="Medium">


Large (1200×900):

<img src="{{ asset('uploads/images/photo.jpg') | imagine_filter('large') }}" alt="Large">

# Intro
This project uses Laravel + Vue 3 + Jetstream (Inertia) + Tailwind + Primevue.

# Requirements
- MySQL
- PHP 
- Nodejs

# Setup
1. Clone project
2. Create database
3. Clone .env.example to .env
4. Set .env
5. copy /database/seeders/storage to /storage folder with the command ``cp -r database/seeders/storage ./``
7. run the following in console:
   1. (optionally) ``composer update``
   2. ``composer install``
   3. ``npm install``
   4. ``php artisan key:generate``
   5. ``php artisan storage:link``
   6. ``php artisan migrate:fresh --seed``
8. From seeding you should see in console email and password for superadmin user. It is randomly generated.

# Notes
1. May need to copy primevue icons folder to public...
2. Inertia.reload in store.js - add all essential reloads (which has entity id)
3. There are custom artisan commands: `php artisan make:crud [CrudName]`, e.g., `php artisan make:crud Account`

# Run project
1. compile js to public folder ``npm run dev``, ``npm run prod`` or ``npm run watch``
2. ``php artisan serve`` (or run on your server)

# Tests
The project has some tests.
- PHPUnit tests ``php artisan test``
- Dusk tests ``php artisan dusk``

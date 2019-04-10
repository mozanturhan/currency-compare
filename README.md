## Installation

```
git clone https://github.com/mozanturhan/currency-compare.git
```

Backend
```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console app:install
```

Front End
```
npm install
npm run-script build
```

Run Server
```
php bin/console server:run
```

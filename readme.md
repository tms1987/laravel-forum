[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Riari/laravel-forum/badges/quality-score.png?b=5.0)](https://scrutinizer-ci.com/g/Riari/laravel-forum/?branch=5.0)

**Complete documentation is available on [teamteatime.net](https://teamteatime.net/docs/laravel-forum/5.x/).**

## Installation

Requires Laravel 6+ and PHP 7.2+.

### Step 1: Install the package

Install the package via composer:

```
composer require teamteatime/laravel-forum:~5.0
```

Then add the service provider to your `config/app.php`:

```php
TeamTeaTime\Forum\ForumServiceProvider::class,
```

### Step 2: Publish the package files

Run the vendor:publish command to publish the package config, translations and migrations to your app's directories:

`php artisan vendor:publish`

### Step 3: Update your database

Run your migrations:

`php artisan migrate`

### Additional steps

#### Configuration

Several configuration files are published to your application's config directory, each prefixed with `forum.`. Refer to these for a variety of options for changing the behaviour of the forum and how it integrates with key parts of your application code.

> You may need to modify the `forum.integration.user_name` config option according to your user model. This specifies which attribute on the user model should be used as a display name in the forum views.

#### Translations

Laravel Forum currently supports 13 languages: German, English, Spanish, French, Italian, Dutch, Romanian, Russian, Thai, Turkish, Serbian, Portuguese (Brazil) and Swedish. The translation files are published to `resources/lang/vendor/forum/{locale}`. **Some new language strings have been introduced in 5.0 but not yet translated; PRs to translate these would be greatly appreciated.**

## Development

If you wish to contribute, an easy way to set up the package for local development is [Team-Tea-Time/laravel-studio](https://github.com/Team-Tea-Time/laravel-studio), which is set up to load a local working copy of this repository (see the [readme](https://github.com/Team-Tea-Time/laravel-studio/blob/6.x/readme.md#usage) for usage details).

### Running tests

Bring up the MySQL service:

```bash
docker-compose up -d mysql
```

Install Composer dependencies:

```bash
docker-compose run --rm composer install
```

Run the phpunit container to execute tests:

```bash
docker-compose run --rm phpunit
```

### Seeding

The DB can be seeded with sample categories, threads, posts, and a user via `ForumSeeder`:

```bash
docker-compose exec php-fpm php artisan db:seed --class=TeamTeaTime\Forum\Database\Seeds\ForumSeeder
```

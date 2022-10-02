<p align="center"><a href="http://localhost" target="_blank"><img src="https://github.com/nsankov/laravel-blog-RESTful/blob/main/_documentation/logo.png?raw=true" width="150" alt="BlogAPI Logo"></a></p>

<p align="center">
    <img src="https://github.com/nsankov/laravel-blog-RESTful/actions/workflows/laravel.yml/badge.svg" alt="Status building">

[comment]: <> (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>)

[comment]: <> (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>)

[comment]: <> (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>)
</p>

## About BlogAPI

BlogApi is a simple example of using the best practices of development on the Laravel framework. It also uses the tools accepted in the Laravel community.

```
get api/v1/categories (limit 5 for guest)
get api/v1/posts
post api/v1/posts (with ThrottleRequestsTest )
post api/v1/posts/{id}
put api/v1/posts/{id}
get api/v1/coments/{id}
get api/v1/coments/threaded?post_id={id}
post api/v1/coments (with ThrottleRequestsTest )
```

Laravel is accessible, powerful, and provides tools required for large, robust applications.

### Database structure
![alt text](https://github.com/nsankov/laravel-blog-RESTful/blob/main/_documentation/db_diagram.png?raw=true)

### Getting Started
Installing Composer Dependencies For Existing Applications
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
Create default environment
```
cp .env.example .env
```
Pulling and start containers
```
./vendor/bin/sail up -d
```
```
./vendor/bin/sail artisan key:generate
```


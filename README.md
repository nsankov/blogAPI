<p align="center"><a href="http://localhost" target="_blank"><img src="https://github.com/nsankov/blogAPI/blob/main/_documentation/logo.png?raw=true" width="150" alt="BlogAPI Logo"></a></p>

<p align="center">
    <a href="https://github.com/nsankov/blogAPI/actions"><img src="https://github.com/nsankov/blogAPI/actions/workflows/BlogAPI.yml/badge.svg" alt="Status building"></a>
</p>

## About BlogAPI

BlogApi is a simple example of using the best practices of development on the Laravel framework. It also uses the tools accepted in the Laravel community.

```
 GET|HEAD        api/v1/articles .......................................................................................................................... articles.index › APIv1\ArticleController@index
  POST            api/v1/articles .......................................................................................................................... articles.store › APIv1\ArticleController@store
  GET|HEAD        api/v1/articles/{article_id}/comments ........................................................................................... articles.comments.index › APIv1\CommentController@index
  POST            api/v1/articles/{article_id}/comments ........................................................................................... articles.comments.store › APIv1\CommentController@store
  GET|HEAD        api/v1/articles/{article_id}/comments/{comment_id}/vote ................................................................ articles.comments.vote.index › APIv1\CommentVoteController@index
  POST            api/v1/articles/{article_id}/comments/{comment_id}/vote ................................................................ articles.comments.vote.store › APIv1\CommentVoteController@store
  GET|HEAD        api/v1/articles/{article_id}/comments/{comment_id}/vote/{vote} ........................................................... articles.comments.vote.show › APIv1\CommentVoteController@show
  GET|HEAD        api/v1/articles/{article_id}/comments/{comment} ................................................................................... articles.comments.show › APIv1\CommentController@show
  PUT|PATCH       api/v1/articles/{article_id}/comments/{comment} ............................................................................... articles.comments.update › APIv1\CommentController@update
  DELETE          api/v1/articles/{article_id}/comments/{comment} ............................................................................. articles.comments.destroy › APIv1\CommentController@destroy
  GET|HEAD        api/v1/articles/{article_id}/vote ............................................................................................... articles.vote.index › APIv1\ArticleVoteController@index
  POST            api/v1/articles/{article_id}/vote ............................................................................................... articles.vote.store › APIv1\ArticleVoteController@store
  GET|HEAD        api/v1/articles/{article_id}/vote/{vote} .......................................................................................... articles.vote.show › APIv1\ArticleVoteController@show
  GET|HEAD        api/v1/articles/{article} .................................................................................................................. articles.show › APIv1\ArticleController@show
  PUT|PATCH       api/v1/articles/{article} .............................................................................................................. articles.update › APIv1\ArticleController@update
  DELETE          api/v1/articles/{article} ............................................................................................................ articles.destroy › APIv1\ArticleController@destroy
  POST            api/v1/auth/login ............................................................................................................................................ APIv1\AuthController@login
  POST            api/v1/auth/logout .......................................................................................................................................... APIv1\AuthController@logout
  POST            api/v1/avatar ............................................................................................................................... avatar.store › APIv1\AvatarController@store
  GET|HEAD        api/v1/avatar/{avatar} ........................................................................................................................ avatar.show › APIv1\AvatarController@show
  DELETE          api/v1/avatar/{avatar} .................................................................................................................. avatar.destroy › APIv1\AvatarController@destroy
  GET|HEAD        api/v1/categories ..................................................................................................................... categories.index › APIv1\CategoryController@index
  POST            api/v1/categories ..................................................................................................................... categories.store › APIv1\CategoryController@store
  GET|HEAD        api/v1/categories/top ..................................................................................................................... categories.top › APIv1\CategoryController@top
  GET|HEAD        api/v1/categories/{category} ............................................................................................................ categories.show › APIv1\CategoryController@show
  PUT|PATCH       api/v1/categories/{category} ........................................................................................................ categories.update › APIv1\CategoryController@update
  DELETE          api/v1/categories/{category} ...................................................................................................... categories.destroy › APIv1\CategoryController@destroy
  POST            api/v1/user/register ......................
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


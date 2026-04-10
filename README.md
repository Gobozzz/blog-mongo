# Проект-пример использования MongoDB с Laravel + StateMachine

## О проекте

Простой блог со статьями. Каждая статья принаждежит конкретному пользователю.
К статьям можно цеплять теги. Любую статью можно комментировать как автору так и другим пользователям.

## Фильтрация

![img.png](readme-images/filters-1.png)

Рабочая папка фильтров находится в App/Filters.

Работа фильтров централизована. Все фильтры реализуют один интерфейс. И наследуются от BaseFilter.

Фильтры сделаны в стиле паттерна "Билдер", что позволяет гибко их настраивать.

Благодаря этому можно создавать различные фильтры, под разные нужды.

Фильтры можно объеденять в коллекции, или передавать в виде массива в скоуп `filters()` модели Eloquent.

### Пример использования

Используем trait в модели

```php
class Post extends Model
{
    use HasFilters;
}
```

Используем фильтры

```php
Post::query()
    ->filters(PostCollectionFilters::class)
    ->latest()
    ->paginate(8);

// или

Post::query()
    ->filters([
        BaseFilter::make('count_views', 'f_min_views')->setOperator('>='),
        ContainFilter::make('slug', 'f_tag')->setRelation('tags'),
        // остальные фильтры
    ])
    ->latest()
    ->paginate(8);

```

### Пару слов про SearchFilter

Он необходим для поиска в текстовых полях. В Монго есть возможность искать через регулярные выражения с помощью `Regex`,
а также
есть [текстовый индекс и более мощный поиск поддерживающий релевантную выборку](https://www.mongodb.com/docs/drivers/php/laravel-mongodb/current/fundamentals/read-operations/#std-label-laravel-fundamentals-read-ops),
однако в проекте используется `Regex` поиск, с ростом нагрузки лучше перебраться на текстовые индексы

## Деплой

### Для первого раза

- `git clone https://github.com/Gobozzz/laravel-mongo.git laravel-mongo`
- `cd laravel-mongo`
- `docker compose up -d --build`
- `docker compose exec php bash`
- `composer setup`

### В следующие разы:

`docker compose up -d`

### env.example -> .env

`cp .env.example .env`

### Laravel App

- URL: http://localhost

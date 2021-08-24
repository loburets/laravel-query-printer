# Laravel Query Printer

An easy way to print queries in Laravel 🖨️

Example:

```PHP
// Enable query log
\DB::enableQueryLog();

// Use whatever queries you want to debug:
User::where('email', 'test@test.com')->where('verified', true)->first();
User::where('id', '<', '5')->get();

// See what the queries were executed
\QueryPrinter::printQueryLog();
```

Output without this package:
![1](https://user-images.githubusercontent.com/5417461/130602821-0d93551d-71e7-44c7-b4ad-4f8af1c071f2.png)

Output WITH this package:
![2](https://user-images.githubusercontent.com/5417461/130602831-85a47a6c-fa2f-4115-ad1a-066efd03cbf1.png)

So you can easily run this query manually and not spend your time to struggle with the bindings 🙌

## How to install

```Bash
composer require loburets/laravel-query-printer
```

If you use Laravel < 5.5 also add the alias to your `config/app.php`:

```PHP
'QueryPrinter' => Loburets\LaravelQueryPrinter\Facade::class,
```

## Usage

Use it with query builder before you run the query:

```PHP
    // Build your query, but don't call ->first(), ->get() etc. So it is an instance of the Query Builder here:
    $query = \Model::where()->join()->etc();

    // Then just print and see what laravel is going to execute:
    \QueryPrinter::print($query);
```

Or use it with query logs when you have already run the query:

```PHP
    // Enable the Query log:
    \DB::enableQueryLog();

    // Do any actions which you want to log:
    $results = \Model::where()->join()->etc()->get();

    // Then just print the query you built:
    \QueryPrinter::printQueryLog();
```

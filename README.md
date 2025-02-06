# 🖨️ Laravel Query Printer

An easy way to print Laravel queries

## 📌 Example

```PHP
// Enable query log
\DB::enableQueryLog();

// Use whatever queries you want to debug:
User::where('email', 'test@test.com')->where('verified', true)->first();
User::where('id', '<', '5')->get();

// See what the queries were executed
\QueryPrinter::printQueryLog();
```

### 🔹 Output **without** this package:
![Without Package](https://user-images.githubusercontent.com/5417461/130602821-0d93551d-71e7-44c7-b4ad-4f8af1c071f2.png)

### 🔹 Output **with** this package:
![With Package](https://user-images.githubusercontent.com/5417461/130602831-85a47a6c-fa2f-4115-ad1a-066efd03cbf1.png)

Now you can simply copy and execute the query without struggling with bindings 🙌

## 🚀 Installation

```Bash
composer require loburets/laravel-query-printer
```

For Laravel **< 5.5**, add the alias in `config/app.php`:

```PHP
'QueryPrinter' => Loburets\LaravelQueryPrinter\Facade::class,
```

## 🛠️ Usage

### ✅ Printing a Query Builder instance

You can print a query before execution:

```PHP
    // Build your query, but don't call ->first(), ->get() etc. So it is an instance of the Query Builder here:
    $query = \Model::where()->join()->etc();

    // Print the generated SQL
    \QueryPrinter::print($query);
```

### ✅ Printing executed queries from query logs

You can also print queries after they have been executed:

```PHP
    // Enable the Query log:
    \DB::enableQueryLog();

    // Do any actions which you want to be logged:
    $results = \Model::where()->join()->etc()->get();

    // Print all the executed queries
    \QueryPrinter::printQueryLog();
```

---

Now debugging Laravel queries is easier than ever! 🎯


<?php

namespace Loburets\LaravelQueryPrinter;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;

class QueryPrinter
{
    /**
     * Print query as a string with the bindings inside
     * So you can copy and run it without manual replacement of the "?" signs
     *
     * How to use:
     * $query = \Model::where()->join();
     * \QueryPrinter::print($query);
     *
     * @param Builder|Model|Relation $query
     * @param bool $returnAsString Set as true to return result as string instead of immediate print
     * @return string|null
     */
    public static function print($query, bool $returnAsString = false): ?string
    {
        $sql = $query->toSql();
        $sql = self::insertBindingsToQueryString($sql, $query->getBindings());

        if ($returnAsString) {
            return $sql;
        }

        dump($sql);
        return null;
    }

    /**
     * Print query logs a string with the bindings inside
     * So you can copy and run it without manual replacement of the "?" signs
     *
     * How to use:
     *
     * \DB::enableQueryLog();
     * // some code here to be logged
     * \QueryPrinter::printQueryLog();
     *
     * @param bool $returnAsString Set as true to return result as array instead of immediate print
     * @return array|null
     */
    public static function printQueryLog($returnAsString = false): ?array
    {
        $queryLogOutput = [];
        $logs = DB::getQueryLog();
        foreach ($logs as $log) {
            $singleQueryLogOutput = $log['time'] . 'ms: ' . self::insertBindingsToQueryString($log['query'], $log['bindings']);
            $queryLogOutput[] = $singleQueryLogOutput;
            if (!$returnAsString) {
                dump($singleQueryLogOutput);
            }
        }

        return $returnAsString ? $queryLogOutput : null;
    }

    /**
     * @param string $sql
     * @param array $bindings
     * @return string
     */
    public static function insertBindingsToQueryString(string $sql, array $bindings):string
    {
        $sql = str_replace('"', '`', $sql);
        // just for the raw queries to look like normal one line query in the console:
        $sql = str_replace("\n", ' ', $sql);
        $sql = str_replace("\t", ' ', $sql);

        foreach ($bindings as $binding) {
            if (!is_numeric($binding)) {
                $binding = '"' . $binding . '"';
            }
            $sql = preg_replace('/' . preg_quote('?') . '/', $binding, $sql, 1);
        }
        return $sql;
    }
}

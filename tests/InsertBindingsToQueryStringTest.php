<?php

use Loburets\LaravelQueryPrinter\QueryPrinter;
use PHPUnit\Framework\TestCase;

class InsertBindingsToQueryStringTest extends TestCase
{
	public function testItShouldReplaceBindingOfDifferentTypes() {
		$query = 'select * from "users" where "email" = ? and "verified" = ? and "users"."deleted_at" is null limit 1';
		$bindings = ['test@test.com', true];
		$result = QueryPrinter::insertBindingsToQueryString($query, $bindings);
		$this->assertEquals('select * from `users` where `email` = "test@test.com" and `verified` = "1" and `users`.`deleted_at` is null limit 1', $result);
	}
}

<?php

namespace Nix\QueryBuilder\Tests\Integration;

use Nix\QueryBuilder\Builder;
use Nix\QueryBuilder\Tests\TestCase;

class ComplexSelectQueryTest extends TestCase
{
    public function testComplexSelect()
    {
        $sql = 'SELECT `id`, `name` AS `first_name` FROM `users` WHERE `id` = ?';

        $builder = new Builder();

        $builder->select(['id', 'name as first_name'])->from('users')->where('id', '=', 1);

        $this->assertEquals($sql, (string) $builder);
    }
}

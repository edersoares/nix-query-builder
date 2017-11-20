<?php

namespace Nix\QueryBuilder\Tests\Statements;

use Nix\QueryBuilder\Statements\Select;
use Nix\QueryBuilder\Tests\TestCase;

class SelectTest extends TestCase
{
    public function testSelectAll()
    {
        $sql = 'SELECT *';

        $stm = new Select();

        $this->assertEquals($sql, $stm->getStatement());
    }

    public function testImplicitCast()
    {
        $sql = 'SELECT *';

        $stm = new Select();

        $this->assertEquals($sql, (string) $stm);
    }

    public function testSelectOneColumn()
    {
        $sql = 'SELECT `id`';

        $stm = new Select(['id']);

        $this->assertEquals($sql, $stm->getStatement());
    }

    public function testSelectTwoColumn()
    {
        $sql = 'SELECT `id`, `name`';

        $stm = new Select(['id', 'name']);

        $this->assertEquals($sql, $stm->getStatement());
    }

    public function testSelectWithAlias()
    {
        $sql = 'SELECT `id`, `name` as `other_name`';

        $stm = new Select(['id', 'name as other_name']);

        $this->assertEquals($sql, $stm->getStatement());
    }
}

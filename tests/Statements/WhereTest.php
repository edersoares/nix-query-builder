<?php

namespace Nix\QueryBuilder\Tests\Statements;

use Nix\QueryBuilder\Statements\Raw;
use Nix\QueryBuilder\Statements\Where;
use Nix\QueryBuilder\Tests\TestCase;

class WhereTest extends TestCase
{
    public function testConstructor()
    {
        $where = new Where('column', '=', 'value', 'and');

        $this->assertAttributeEquals('`column`', 'leftExpression', $where);
        $this->assertAttributeEquals('=', 'comparisionOperator', $where);
        $this->assertAttributeEquals('?', 'rightExpression', $where);
        $this->assertAttributeEquals('AND', 'concatOperator', $where);
        $this->assertAttributeEquals(['value'], 'parameters', $where);
    }

    public function testGetStatement()
    {
        $statement = 'AND `column` = ?';

        $where = new Where('column', '=', 'value', 'and');

        $this->assertEquals($statement, $where->getStatement());
        $this->assertEquals(['value'], $where->getParameters());
    }

    public function testGetParameters()
    {
        $where = new Where('column', '=', 'value', 'and');

        $this->assertEquals(['value'], $where->getParameters());
    }

    public function testWhereUsingRaw()
    {
        $column = $this->faker->word;
        $comparison = $this->faker->randomElement(['=', '>=', '<=']);
        $value = $this->faker->name;
        $concat = $this->faker->randomElement(['AND', 'OR']);

        $statement = "{$concat} DATE({$column}) {$comparison} ?";

        // FIXME remove from here
        $where = new Where(new Raw("DATE({$column})"), $comparison, $value, $concat);

        $this->assertEquals($statement, $where->getStatement());
        $this->assertEquals([$value], $where->getParameters());
    }
}

<?php

namespace Nix\QueryBuilder\Tests\Statements;

use Nix\QueryBuilder\Statements\Raw;
use Nix\QueryBuilder\Tests\TestCase;

class RawTest extends TestCase
{
    public function testSimpleConstructor()
    {
        $sql = 'NOW()';

        $raw = new Raw($sql);

        $this->assertAttributeEquals($sql, 'raw', $raw);
    }

    public function testManyParametersInConstructor()
    {
        $sql = 'INSERT INTO table (email, password) VALUES (?, ?)';

        $email = $this->faker->email;
        $password = $this->faker->password;

        $raw = new Raw($sql, $email, $password);

        $this->assertAttributeEquals($sql, 'raw', $raw);
        $this->assertAttributeEquals([$email, $password], 'parameters', $raw);
    }

    public function testImplicitCast()
    {
        $sql = 'DATE(column) = NOW()';

        $raw = new Raw($sql);

        $this->assertEquals($sql, (string) $raw);
    }

    public function testGetStatement()
    {
        $sql = 'INSERT INTO table (email, password) VALUES (?, ?)';

        $email = $this->faker->email;
        $password = $this->faker->password;

        $raw = new Raw($sql, $email, $password);

        $this->assertEquals($sql, $raw->getStatement());
    }

    public function testGetParameters()
    {
        $sql = 'INSERT INTO table (email, password) VALUES (?, ?)';

        $email = $this->faker->email;
        $password = $this->faker->password;

        $raw = new Raw($sql, $email, $password);

        $this->assertEquals([$email, $password], $raw->getParameters());
    }
}

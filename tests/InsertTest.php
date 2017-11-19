<?php

namespace Nix\QueryBuilder\Tests;

use Nix\QueryBuilder\Builder;

class InsertTest extends TestCase
{
    public function testInsertBasic()
    {
        $sql = 'INSERT INTO `table` (`column`) VALUES (?)';

        $builder = new Builder();

        $insert = $builder->insert('table', [
            'column' => 'value'
        ]);

        $this->assertEquals($builder, $insert);
        $this->assertAttributeEquals($sql, 'base', $builder);
    }

    public function testInsertMultiple()
    {
        $sql = 'INSERT INTO `table` (`c1`, `c2`, `c3`) VALUES (?, ?, ?)';

        $builder = new Builder();

        $insert = $builder->insert('table', [
            'c1' => 'value',
            'c2' => 'value',
            'c3' => 'value'
        ]);

        $this->assertEquals($builder, $insert);
        $this->assertAttributeEquals($sql, 'base', $builder);
    }

    public function testUpdateBasic()
    {
        $sql = 'UPDATE `table` SET `column` = ?';

        $builder = new Builder();

        $update = $builder->update('table', [
            'column' => 'value'
        ]);

        $this->assertEquals($builder, $update);
        $this->assertAttributeEquals($sql, 'base', $builder);
    }

    public function testUpdateMultiple()
    {
        $sql = 'UPDATE `table` SET `c1` = ?, `c2` = ?, `c3` = ?';

        $builder = new Builder();

        $update = $builder->update('table', [
            'c1' => 'value',
            'c2' => 'value',
            'c3' => 'value'
        ]);

        $this->assertEquals($builder, $update);
        $this->assertAttributeEquals($sql, 'base', $builder);
    }

    public function testDeleteBasic()
    {
        $sql = 'DELETE FROM `table`';

        $builder = new Builder();

        $delete = $builder->delete('table');

        $this->assertEquals($builder, $delete);
        $this->assertAttributeEquals($sql, 'base', $builder);
    }

    public function testWhereBasic()
    {
        $wheres = [
            [
                'column'   => 'c1',
                'value'    => 'v1',
                'operator' => '='
            ]
        ];

        $builder = new Builder();

        $instance = $builder->where('c1', 'v1');

        $this->assertEquals($builder, $instance);
        $this->assertAttributeEquals($wheres, 'wheres', $instance);
    }

    public function testWhereMultiple()
    {
        $wheres = [
            [
                'column'   => 'c1',
                'value'    => 'v1',
                'operator' => '='
            ],
            [
                'column'   => 'c2',
                'value'    => 'v2',
                'operator' => '='
            ],
            [
                'column'   => 'c3',
                'value'    => 'v3',
                'operator' => '='
            ]
        ];

        $builder = new Builder();

        $instance = $builder->where('c1', 'v1')
            ->where('c2', 'v2')
            ->where('c3', 'v3');

        $this->assertEquals($builder, $instance);
        $this->assertAttributeEquals($wheres, 'wheres', $instance);
    }
}

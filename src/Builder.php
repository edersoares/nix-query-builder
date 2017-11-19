<?php

namespace Nix\QueryBuilder;

class Builder
{
    protected $base;
    protected $separator = ', ';

    protected $wheres = [];

    public function getSeparator()
    {
        return $this->separator;
    }

    protected function escape($string)
    {
        return "`{$string}`";
    }

    protected function escapeTable($table)
    {
        return $this->escape($table);
    }

    protected function escapeColumns(array $columns)
    {
        return array_map(function ($column) {
            return $this->escape($column);
        }, $columns);
    }

    protected function escapeValues(array $values)
    {
        return array_map(function () {
            return $this;
        }, $values);
    }

    protected function escapeColumnsInsert(array $columns)
    {
        return implode($this->escapeColumns($columns), $this->getSeparator());
    }

    protected function escapeUpdate(array $values)
    {
        $columns = [];

        foreach ($values as $key => $value) {
            $columns[] = "`{$key}` = ?";
        }

        return implode($columns, $this->getSeparator());
    }

    protected function replaceToToken(array $values)
    {
        $count = count($values);
        $token = [];

        for ($i = 0; $i < $count; $i++) {
            $token[] = '?';
        }

        return implode($token, $this->getSeparator());
    }

    protected function getInsertBase()
    {
        return 'INSERT INTO %s (%s) VALUES (%s)';
    }

    protected function getUpdateBase()
    {
        return 'UPDATE %s SET %s';
    }

    protected function getDeleteBase()
    {
        return 'DELETE FROM %s';
    }

    public function insert($table, array $values)
    {
        $this->base = sprintf(
            $this->getInsertBase(),
            $this->escapeTable($table),
            $this->escapeColumnsInsert(array_keys($values)),
            $this->replaceToToken($values)
        );

        return $this;
    }

    public function update($table, array $values)
    {
        $this->base = sprintf(
            $this->getUpdateBase(),
            $this->escapeTable($table),
            $this->escapeUpdate($values)
        );

        return $this;
    }

    public function delete($table)
    {
        $this->base = sprintf(
            $this->getDeleteBase(),
            $this->escapeTable($table)
        );

        return $this;
    }

    public function where($key, $value)
    {
        $this->wheres[] = [
            'left'      => $key,
            'right'    => $value,
            'operator' => 'AND',
            'concat'   => 'AND'
        ];

        return $this;
    }
}

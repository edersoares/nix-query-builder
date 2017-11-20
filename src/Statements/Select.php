<?php

namespace Nix\QueryBuilder\Statements;

use RuntimeException;
use Nix\QueryBuilder\Contracts\Statement;

class Select implements Statement
{
    /**
     * Columns.
     *
     * @var array
     */
    protected $columns;

    /**
     * Select constructor.
     *
     * @param array $columns
     */
    public function __construct($columns = ['*'])
    {
        $this->setColumns($columns);
    }

    /**
     * To string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getStatement();
    }

    /**
     * Escape the columns.
     *
     * @param \Nix\QueryBuilder\Contracts\Statement|string $column
     * @throws \RuntimeException
     * @return string
     */
    protected function escapeColumn($column)
    {
        if ($column === '*') {
            return $column;
        }

        if (strpos(strtolower($column), ' as ')) {

            $parts = explode(' as ', $column);

            return "`{$parts[0]}` as `{$parts[1]}`";
        }

        if (is_string($column)) {
            return "`{$column}`";
        }

        if ($column instanceof Statement) {
            return $column->getStatement();
        }

        throw new RuntimeException('Column not allowed.');
    }

    /**
     * Return the columns.
     *
     * @return string
     */
    protected function getColumns()
    {
        return implode(', ', $this->columns);
    }

    /**
     * Set the columns.
     *
     * @param array $columns
     * @return array
     */
    protected function setColumns(array $columns)
    {
        return $this->columns = array_map(function ($column) {
            return $this->escapeColumn($column);
        }, $columns);
    }

    /**
     * Return the statement.
     *
     * @return string
     */
    public function getStatement()
    {
        return sprintf(
            'SELECT %s',
            $this->getColumns()
        );
    }

    /**
     * Return the parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return [];
    }
}

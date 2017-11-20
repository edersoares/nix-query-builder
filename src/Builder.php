<?php

namespace Nix\QueryBuilder;

use Nix\QueryBuilder\Contracts\Statement;
use Nix\QueryBuilder\Statements\Select;
use Nix\QueryBuilder\Statements\Where;

class Builder implements Statement
{
    /**
     * Select.
     *
     * @var \Nix\QueryBuilder\Statements\Select
     */
    protected $select;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table;

    /**
     * Wheres.
     *
     * @var \Nix\QueryBuilder\Statements\Where[]
     */
    protected $wheres;

    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->getStatement();
    }

    public function getStatement()
    {
        $stm = $this->select->getStatement();

        if ($this->table) {
            $stm .= " FROM `{$this->table}` ";
        }

        if (count($this->wheres)) {

            $stm .= 'WHERE 1 = 1';

            foreach ($this->wheres as $where) {
                $stm .= ' ' . $where->getStatement();
            }
        }

        return $stm;
    }

    public function getParameters()
    {
        // TODO: Implement getParameters() method.
    }

    public function select($columns = ['*'])
    {
        $this->select = new Select($columns);

        return $this;
    }

    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    public function where(
        $leftExpression,
        $comparisionOperator,
        $rightExpression,
        $concatOperator = 'AND'
    ) {
        $this->wheres[] = new Where(
            $leftExpression,
            $comparisionOperator,
            $rightExpression,
            $concatOperator
        );

        return $this;
    }
}

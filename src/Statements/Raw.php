<?php

namespace Nix\QueryBuilder\Statements;

use Nix\QueryBuilder\Contracts\Statement;

class Raw implements Statement
{
    /**
     * SQL raw.
     *
     * @var string
     */
    protected $raw;

    /**
     * Parameters to be used in bindings.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Raw constructor.
     *
     * @param string raw
     * @param array ...$parameters
     */
    public function __construct($raw, ...$parameters)
    {
        $this->raw = $raw;
        $this->parameters = $parameters;
    }

    /**
     * Return the statement.
     *
     * @see \Nix\QueryBuilder\Statements\Raw::getStatement()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getStatement();
    }

    /**
     * Return the statement.
     *
     * @return string
     */
    public function getStatement()
    {
        return $this->raw;
    }

    /**
     * Return the parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}

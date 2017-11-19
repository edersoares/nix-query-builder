<?php

namespace Nix\QueryBuilder\Contracts;

interface Statement
{
    /**
     * Return the statement.
     *
     * @return string
     */
    public function getStatement();

    /**
     * Return the parameters.
     *
     * @return array
     */
    public function getParameters();
}

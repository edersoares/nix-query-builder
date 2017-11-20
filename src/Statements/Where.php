<?php

namespace Nix\QueryBuilder\Statements;

use RuntimeException;
use Nix\QueryBuilder\Contracts\Statement;

class Where implements Statement
{
    /**
     * Left expression.
     *
     * @var string
     */
    protected $leftExpression;

    /**
     * Right expression.
     *
     * @var string
     */
    protected $rightExpression;

    /**
     * Comparision operator.
     *
     * @var string
     */
    protected $comparisionOperator;

    /**
     * Concat operator.
     *
     * @var string
     */
    protected $concatOperator;

    /**
     * Parameters used as bindings.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Where constructor.
     *
     * @param \Nix\QueryBuilder\Contracts\Statement|string $leftExpression
     * @param string $comparisionOperator
     * @param \Nix\QueryBuilder\Contracts\Statement|string $rightExpression
     * @param string $concatOperator
     */
    public function __construct(
        $leftExpression,
        $comparisionOperator,
        $rightExpression,
        $concatOperator = 'AND'
    ) {
        $this->parameters = [];

        $this->setLeftExpression($leftExpression);
        $this->setComparisonOperator($comparisionOperator);
        $this->setRightExpression($rightExpression);
        $this->setConcatOperator($concatOperator);
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
     * Return the concat operator.
     *
     * @return string
     */
    protected function getConcatOperator()
    {
        return $this->concatOperator;
    }

    /**
     * Define the concat operator.
     *
     * @param string $operator
     * @throws \RuntimeException
     * @return $this
     */
    protected function setConcatOperator($operator)
    {
        switch ($operator) {
            case 'OR':
            case 'or':
                $operator = 'OR';
                break;

            case 'AND':
            case 'and':
            case null:
                $operator = 'AND';
                break;

            default:
                throw new RuntimeException('Concat operator not found.');
                break;
        }

        $this->concatOperator = $operator;

        return $this;
    }

    /**
     * Return the comparison operator.
     *
     * @return string
     */
    protected function getComparisonOperator()
    {
        return $this->comparisionOperator;
    }

    /**
     * Define the comparison operator.
     *
     * @param string $operator
     * @throws \RuntimeException
     * @return $this
     */
    protected function setComparisonOperator($operator)
    {
        switch ($operator) {
            case '=':
            case '>=':
            case '>':
            case '<=':
            case '<':
            case '<>':
            case '!=':
                $comparisionOperator = $operator;
                break;
            default:
                throw new RuntimeException('Comparison operator not found.');
                break;
        }

        $this->comparisionOperator = $comparisionOperator;

        return $this;
    }

    /**
     * Return the left expression.
     *
     * @return string
     */
    protected function getLeftExpression()
    {
        return $this->leftExpression;
    }

    /**
     * Define left expression.
     *
     * @param \Nix\QueryBuilder\Contracts\Statement|string $expression
     * @throws \RuntimeException
     * @return $this
     */
    protected function setLeftExpression($expression)
    {
        if (is_scalar($expression)) {
            $this->leftExpression = "`{$expression}`";
        } elseif ($expression instanceof Statement) {
            $this->leftExpression = $expression->getStatement();
            $this->parameters = array_merge($this->parameters, $expression->getParameters());
        } else {
            throw new RuntimeException('Left expression cannot be used.');
        }

        return $this;
    }

    /**
     * Return the right expression.
     *
     * @return string
     */
    protected function getRightExpression()
    {
        return $this->rightExpression;
    }

    /**
     * Define right expression.
     *
     * @param \Nix\QueryBuilder\Contracts\Statement|string $expression
     * @throws \RuntimeException
     * @return $this
     */
    protected function setRightExpression($expression)
    {
        if (is_scalar($expression)) {
            $this->rightExpression = '?';
            $this->parameters[] = $expression;
        } elseif ($expression instanceof Statement) {
            $this->rightExpression = $expression->getStatement();
            $this->parameters = array_merge($this->parameters, $expression->getParameters());
        } else {
            throw new RuntimeException('Right expression cannot be used.');
        }

        return $this;
    }

    /**
     * Return the statement.
     *
     * @return string
     */
    public function getStatement()
    {
        return sprintf('%s %s %s %s', ...[
            $this->getConcatOperator(),
            $this->getLeftExpression(),
            $this->getComparisonOperator(),
            $this->getRightExpression()
        ]);
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

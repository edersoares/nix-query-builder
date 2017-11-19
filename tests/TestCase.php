<?php

namespace Nix\QueryBuilder\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

abstract class TestCase extends PHPUnitTestCase
{
    /**
     * Faker Generator.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Configure the test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
    }
}

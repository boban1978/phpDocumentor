<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor\Filter;

use League\Pipeline\Pipeline;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * Tests the functionality for the ClassFactory class.
 */
class ClassFactoryTest extends MockeryTestCase
{
    /** @var ClassFactory $fixture */
    protected $fixture;

    /**
     * Creates a new (empty) fixture object.
     */
    protected function setUp() : void
    {
        $this->fixture = new ClassFactory();
    }

    /**
     * @covers \phpDocumentor\Descriptor\Filter\ClassFactory::getChainFor
     */
    public function testGetChainForReturnsInstanceOfFilterChain() : void
    {
        $filterChain = $this->fixture->getChainFor('foo');

        $this->assertInstanceOf(Pipeline::class, $filterChain);
    }
}

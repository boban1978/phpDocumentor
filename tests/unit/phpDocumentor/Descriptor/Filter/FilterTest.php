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
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function get_class;

/**
 * Tests the functionality for the Filter class.
 */
class FilterTest extends MockeryTestCase
{
    public const FQCN = 'SomeFilterClass';

    /** @var ClassFactory|m\Mock */
    protected $classFactoryMock;

    /** @var FilterInterface|m\Mock */
    protected $filterChainMock;

    /** @var Filter $fixture */
    protected $fixture;

    /**
     * Creates a new (empty) fixture object.
     */
    protected function setUp() : void
    {
        $this->classFactoryMock = m::mock('phpDocumentor\Descriptor\Filter\ClassFactory');
        $this->filterChainMock  = m::mock(Pipeline::class);
        $this->fixture          = new Filter($this->classFactoryMock);
    }

    /**
     * @covers \phpDocumentor\Descriptor\Filter\Filter::attach
     */
    public function testAttach() : void
    {
        $filterMock = m::mock(FilterInterface::class);

        $this->classFactoryMock->shouldReceive('attachTo')->with(self::FQCN, $filterMock);

        $this->fixture->attach(self::FQCN, $filterMock);
    }

    /**
     * @covers \phpDocumentor\Descriptor\Filter\Filter::filter
     */
    public function testFilter() : void
    {
        $filterableMock = m::mock('phpDocumentor\Descriptor\Filter\Filterable');

        $this->filterChainMock->shouldReceive('__invoke')->with($filterableMock)->andReturn($filterableMock);
        $this->classFactoryMock
            ->shouldReceive('getChainFor')->with(get_class($filterableMock))->andReturn($this->filterChainMock);

        $this->assertSame($filterableMock, $this->fixture->filter($filterableMock));
    }
}

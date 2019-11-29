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

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use phpDocumentor\Descriptor\MethodDescriptor;
use phpDocumentor\Descriptor\ProjectDescriptorBuilder;

/**
 * Tests the functionality for the StripOnVisibility class.
 */
class StripOnVisibilityTest extends MockeryTestCase
{
    /** @var ProjectDescriptorBuilder|m\Mock */
    protected $builderMock;

    /** @var StripOnVisibility $fixture */
    protected $fixture;

    /**
     * Creates a new (empty) fixture object.
     */
    protected function setUp() : void
    {
        $this->builderMock = m::mock('phpDocumentor\Descriptor\ProjectDescriptorBuilder');
        $this->fixture     = new StripOnVisibility($this->builderMock);
    }

    /**
     * @covers \phpDocumentor\Descriptor\Filter\StripOnVisibility::__invoke
     */
    public function testStripsTagFromDescriptionIfVisibilityIsNotAllowed() : void
    {
        $this->builderMock->shouldReceive('getProjectDescriptor->isVisibilityAllowed')->andReturn(false);

        $descriptor = m::mock(MethodDescriptor::class);
        $descriptor->shouldReceive('getVisibility')->andReturn('public');

        $this->assertNull($this->fixture->__invoke($descriptor));
    }

    /**
     * @covers \phpDocumentor\Descriptor\Filter\StripOnVisibility::__invoke
     */
    public function testKeepsDescriptorIfVisibilityIsAllowed() : void
    {
        $this->builderMock->shouldReceive('getProjectDescriptor->isVisibilityAllowed')->andReturn(true);

        $descriptor = m::mock(MethodDescriptor::class);
        $descriptor->shouldReceive('getVisibility')->andReturn('public');

        $this->assertSame($descriptor, $this->fixture->__invoke($descriptor));
    }

    /**
     * @covers \phpDocumentor\Descriptor\Filter\StripOnVisibility::__invoke
     */
    public function testKeepsDescriptorIfDescriptorNotInstanceOfVisibilityInterface() : void
    {
        $this->builderMock->shouldReceive('getProjectDescriptor->isVisibilityAllowed')->andReturn(false);

        $descriptor = m::mock('\phpDocumentor\Descriptor\DescriptorAbstract');

        $this->assertSame($descriptor, $this->fixture->__invoke($descriptor));
    }
}

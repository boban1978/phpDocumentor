<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor\Tag;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use phpDocumentor\Reflection\Types\Array_;

/**
 * Tests the functionality for the ReturnDescriptor class.
 */
class ReturnDescriptorTest extends MockeryTestCase
{
    /** @var ReturnDescriptor $fixture */
    protected $fixture;

    /**
     * Creates a new fixture object.
     */
    protected function setUp() : void
    {
        $this->fixture = new ReturnDescriptor('name');
    }

    /**
     * @covers \phpDocumentor\Descriptor\Tag\BaseTypes\TypedAbstract::setTypes
     * @covers \phpDocumentor\Descriptor\Tag\BaseTypes\TypedAbstract::getTypes
     */
    public function testSetAndGetTypes() : void
    {
        $expected = new Array_();
        $this->assertNull($this->fixture->getType());

        $this->fixture->setType($expected);
        $result = $this->fixture->getType();

        $this->assertEquals($expected, $result);
    }
}

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

/**
 * Tests the functionality for the UsesDescriptor class.
 */
class UsesDescriptorTest extends MockeryTestCase
{
    public const EXAMPLE_REFERENCE = 'reference';

    /** @var UsesDescriptor $fixture */
    protected $fixture;

    /**
     * Creates a new fixture object.
     */
    protected function setUp() : void
    {
        $this->fixture = new UsesDescriptor('name');
    }

    /**
     * @covers \phpDocumentor\Descriptor\Tag\UsesDescriptor::setReference
     * @covers \phpDocumentor\Descriptor\Tag\UsesDescriptor::getReference
     */
    public function testSetAndGetReference() : void
    {
        $this->assertEmpty($this->fixture->getReference());

        $this->fixture->setReference(self::EXAMPLE_REFERENCE);
        $result = $this->fixture->getReference();

        $this->assertEquals(self::EXAMPLE_REFERENCE, $result);
    }
}

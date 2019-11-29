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
 * Tests the functionality for the LinkDescriptor class.
 */
class LinkDescriptorTest extends MockeryTestCase
{
    public const EXAMPLE_LINK = 'http://phpdoc.org';

    /** @var LinkDescriptor $fixture */
    protected $fixture;

    /**
     * Creates a new fixture object.
     */
    protected function setUp() : void
    {
        $this->fixture = new LinkDescriptor('name');
    }

    /**
     * @covers \phpDocumentor\Descriptor\Tag\LinkDescriptor::setLink
     * @covers \phpDocumentor\Descriptor\Tag\LinkDescriptor::getLink
     */
    public function testSetAndGetLink() : void
    {
        $this->assertEmpty($this->fixture->getLink());

        $this->fixture->setLink(self::EXAMPLE_LINK);
        $result = $this->fixture->getLink();

        $this->assertSame(self::EXAMPLE_LINK, $result);
    }
}

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
 * Tests the functionality for the SinceDescriptor class.
 */
class SinceDescriptorTest extends MockeryTestCase
{
    public const EXAMPLE_VERSION = 'version';

    /** @var SinceDescriptor $fixture */
    protected $fixture;

    /**
     * Creates a new fixture object.
     */
    protected function setUp() : void
    {
        $this->fixture = new SinceDescriptor('name');
    }

    /**
     * @covers \phpDocumentor\Descriptor\Tag\SinceDescriptor::setVersion
     * @covers \phpDocumentor\Descriptor\Tag\SinceDescriptor::getVersion
     */
    public function testSetAndGetVersion() : void
    {
        $this->assertEmpty($this->fixture->getVersion());

        $this->fixture->setVersion(self::EXAMPLE_VERSION);
        $result = $this->fixture->getVersion();

        $this->assertEquals(self::EXAMPLE_VERSION, $result);
    }
}

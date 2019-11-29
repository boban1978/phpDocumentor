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
 * Tests the functionality for the DeprecatedDescriptor class.
 */
final class DeprecatedDescriptorTest extends MockeryTestCase
{
    public const EXAMPLE_VERSION = '2.0';

    /** @var DeprecatedDescriptor $fixture */
    protected $fixture;

    /**
     * Creates a new fixture object.
     */
    protected function setUp() : void
    {
        $this->markTestIncomplete('Review this whole testcase; it is too complicated to change');
        $this->fixture = new DeprecatedDescriptor('name');
    }

    /**
     * @covers \phpDocumentor\Descriptor\Tag\DeprecatedDescriptor::setVersion
     * @covers \phpDocumentor\Descriptor\Tag\DeprecatedDescriptor::getVersion
     */
    public function testSetAndGetVersion() : void
    {
        $this->assertEmpty($this->fixture->getVersion());

        $this->fixture->setVersion(self::EXAMPLE_VERSION);
        $result = $this->fixture->getVersion();

        $this->assertSame(self::EXAMPLE_VERSION, $result);
    }
}

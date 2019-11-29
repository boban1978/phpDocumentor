<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor\Type;

use Mockery\Adapter\Phpunit\MockeryTestCase;

class UnknownTypeDescriptorTest extends MockeryTestCase
{
    /**
     * @covers \phpDocumentor\Descriptor\Type\UnknownTypeDescriptor::getName
     * @covers \phpDocumentor\Descriptor\Type\UnknownTypeDescriptor::__toString
     */
    public function testIfNameCanBeReturned() : void
    {
        $fixture = new UnknownTypeDescriptor('unknowntype');

        $this->assertSame('unknowntype', $fixture->getName());
        $this->assertSame('unknowntype', (string) $fixture);
    }
}

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

class FloatDescriptorTest extends MockeryTestCase
{
    /**
     * @covers \phpDocumentor\Descriptor\Type\FloatDescriptor::getName
     * @covers \phpDocumentor\Descriptor\Type\FloatDescriptor::__toString
     */
    public function testIfNameCanBeReturned() : void
    {
        $fixture = new FloatDescriptor();

        $this->assertSame('float', $fixture->getName());
        $this->assertSame('float', (string) $fixture);
    }
}

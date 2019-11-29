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

class IntegerDescriptorTest extends MockeryTestCase
{
    /**
     * @covers \phpDocumentor\Descriptor\Type\IntegerDescriptor::getName
     * @covers \phpDocumentor\Descriptor\Type\IntegerDescriptor::__toString
     */
    public function testIfNameCanBeReturned() : void
    {
        $fixture = new IntegerDescriptor();

        $this->assertSame('integer', $fixture->getName());
        $this->assertSame('integer', (string) $fixture);
    }
}

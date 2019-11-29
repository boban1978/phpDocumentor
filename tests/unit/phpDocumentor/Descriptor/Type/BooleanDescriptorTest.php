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

class BooleanDescriptorTest extends MockeryTestCase
{
    /**
     * @covers \phpDocumentor\Descriptor\Type\BooleanDescriptor::getName
     * @covers \phpDocumentor\Descriptor\Type\BooleanDescriptor::__toString
     */
    public function testIfNameCanBeReturned() : void
    {
        $fixture = new BooleanDescriptor();

        $this->assertSame('boolean', $fixture->getName());
        $this->assertSame('boolean', (string) $fixture);
    }
}

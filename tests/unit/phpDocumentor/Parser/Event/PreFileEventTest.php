<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Parser\Event;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use stdClass;

/**
 * Test for the PreFileEvent class.
 */
class PreFileEventTest extends MockeryTestCase
{
    /** @var PreFileEvent $fixture */
    protected $fixture;

    /**
     * Sets up a fixture.
     */
    protected function setUp() : void
    {
        $this->fixture = new PreFileEvent(new stdClass());
    }

    /**
     * @covers \phpDocumentor\Parser\Event\PreFileEvent::getFile
     * @covers \phpDocumentor\Parser\Event\PreFileEvent::setFile
     */
    public function testRemembersFileThatTriggersIt() : void
    {
        $filename = 'myfile.txt';

        $this->assertNull($this->fixture->getFile());

        $this->fixture->setFile($filename);

        $this->assertSame($filename, $this->fixture->getFile());
    }
}

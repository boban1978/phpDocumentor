<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Transformer\Event;

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use stdClass;

/**
 * Tests the functionality for the PreTransformEvent class.
 */
class PreTransformEventTest extends MockeryTestCase
{
    /** @var PreTransformEvent $fixture */
    protected $fixture;

    /**
     * Creates a new (empty) fixture object.
     * Creates a new DOMDocument object.
     */
    protected function setUp() : void
    {
        $this->fixture = new PreTransformEvent(new stdClass());
    }

    /**
     * @covers \phpDocumentor\Transformer\Event\PreTransformEvent::getProject
     * @covers \phpDocumentor\Transformer\Event\PreTransformEvent::setProject
     */
    public function testSetAndGetProject() : void
    {
        $project = m::mock('phpDocumentor\Descriptor\ProjectDescriptor');
        $this->assertNull($this->fixture->getProject());

        $this->fixture->setProject($project);

        $this->assertSame($project, $this->fixture->getProject());
    }
}

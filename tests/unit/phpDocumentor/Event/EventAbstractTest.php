<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Event;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use phpDocumentor\Event\Mock\EventAbstract as EventAbstractMock;
use stdClass;

/**
 * Test for the EventAbstract class.
 */
class EventAbstractTest extends MockeryTestCase
{
    /**
     * @covers \phpDocumentor\Event\EventAbstract::__construct
     * @covers \phpDocumentor\Event\EventAbstract::getSubject
     */
    public function testSubjectMustBeProvidedAndCanBeRead() : void
    {
        $subject = new stdClass();

        $fixture = new EventAbstractMock($subject);

        $this->assertSame($subject, $fixture->getSubject());
    }

    /**
     * @covers \phpDocumentor\Event\EventAbstract::createInstance
     */
    public function testCanBeConstructedUsingAStaticFactoryMethod() : void
    {
        $subject = new stdClass();

        $fixture = EventAbstractMock::createInstance($subject);

        $this->assertSame($subject, $fixture->getSubject());
    }
}

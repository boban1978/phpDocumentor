<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Event\Mock;

use phpDocumentor\Event\EventAbstract as BaseClass;

/**
 * EventAbstract Mocking Class.
 *
 * We need a real mock because events may be constructed using a static factory method. But we cannot invoke
 * those on a mock constructed with Mockery, phpUnit or directly on the abstract class.
 */
class EventAbstract extends BaseClass
{
}

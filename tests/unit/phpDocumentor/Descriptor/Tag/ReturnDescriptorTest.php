<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @copyright 2010-2018 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor\Tag;

use phpDocumentor\Reflection\Types\Array_;

/**
 * Tests the functionality for the ReturnDescriptor class.
 */
class ReturnDescriptorTest extends \Mockery\Adapter\Phpunit\MockeryTestCase
{
    /** @var ReturnDescriptor $fixture */
    protected $fixture;

    /**
     * Creates a new fixture object.
     */
    protected function setUp(): void
    {
        $this->fixture = new ReturnDescriptor('name');
    }

    /**
     * @covers \phpDocumentor\Descriptor\Tag\BaseTypes\TypedAbstract::setTypes
     * @covers \phpDocumentor\Descriptor\Tag\BaseTypes\TypedAbstract::getTypes
     */
    public function testSetAndGetTypes() : void
    {
        $expected = new Array_();
        $this->assertNull($this->fixture->getType());

        $this->fixture->setType($expected);
        $result = $this->fixture->getType();

        $this->assertEquals($expected, $result);
    }
}

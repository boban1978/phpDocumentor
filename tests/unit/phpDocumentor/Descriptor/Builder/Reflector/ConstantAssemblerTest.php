<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor\Builder\Reflector;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Php\Constant;

/**
 * Test class for \phpDocumentor\Descriptor\Builder
 *
 * @coversDefaultClass  \phpDocumentor\Descriptor\Builder\Reflector\ConstantAssembler
 */
class ConstantAssemblerTest extends MockeryTestCase
{
    /** @var ConstantAssembler $fixture */
    protected $fixture;

    /**
     * Creates a new fixture to test with.
     */
    protected function setUp() : void
    {
        $this->fixture = new ConstantAssembler();
    }

    /**
     * Creates a Descriptor from a provided class.
     *
     * @covers ::create
     */
    public function testCreateConstantDescriptorFromReflector() : void
    {
        $pi        = '3.14159265359';
        $name      = 'constPI';
        $namespace = 'Namespace';

        $docBlockDescription = new DocBlock\Description(
            <<<DOCBLOCK
            /**
             * This is a example description
             */
DOCBLOCK
        );

        $docBlockMock          = new DocBlock('This is a example description', $docBlockDescription);
        $constantReflectorMock = new Constant(new Fqsen('\\' . $namespace . '::' . $name), $docBlockMock, $pi);

        $descriptor = $this->fixture->create($constantReflectorMock);

        $this->assertSame($name, $descriptor->getName());
        $this->assertSame(
            '\\' . $namespace . '::' . $name,
            (string) $descriptor->getFullyQualifiedStructuralElementName()
        );
        $this->assertSame('\\' . $namespace, $descriptor->getNamespace());
        $this->assertSame($pi, $descriptor->getValue());
    }
}

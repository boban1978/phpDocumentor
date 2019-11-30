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

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Php\Class_;
use phpDocumentor\Reflection\Php\Constant;
use phpDocumentor\Reflection\Php\Method;
use phpDocumentor\Reflection\Php\Property;

/**
 * Test class for \phpDocumentor\Descriptor\Builder
 *
 * @covers \phpDocumentor\Descriptor\Builder\Reflector\ClassAssembler
 */
class ClassAssemblerTest extends MockeryTestCase
{
    /** @var ClassAssembler $fixture */
    protected $fixture;

    /**
     * Creates a new fixture to test with.
     */
    protected function setUp() : void
    {
        $this->fixture = new ClassAssembler();
        $this->fixture->setBuilder($this->getProjectDescriptorBuilderMock());
    }

    /**
     * Creates a Descriptor from a provided class.
     *
     * @covers \phpDocumentor\Descriptor\Builder\Reflector\ClassAssembler::create
     */
    public function testCreateClassDescriptorFromReflector() : void
    {
        $name                       = 'ClassName';
        $namespace                  = 'Namespace';
        $docBlockDescriptionContent = <<<DOCBLOCK
/**
 * This is a example description
 */
DOCBLOCK;

        $classReflectorMock = $this->getClassReflectorDescriptor();

        $descriptor = $this->fixture->create($classReflectorMock);

        $this->assertSame(
            '\\' . $namespace . '\\' . $name,
            (string) $descriptor->getFullyQualifiedStructuralElementName()
        );
        $this->assertSame($name, $descriptor->getName());
        $this->assertSame((string) $descriptor->getDescription(), $docBlockDescriptionContent);
    }

    /**
     * Create a ClassReflector mock
     */
    protected function getClassReflectorDescriptor() : Class_
    {
        $name                       = 'ClassName';
        $namespace                  = 'Namespace';
        $docBlockDescriptionContent = <<<DOCBLOCK
/**
 * This is a example description
 */
DOCBLOCK;
        $docBlockMock               = new DocBlock(
            'This is a example description',
            new DocBlock\Description($docBlockDescriptionContent),
            []
        );

        $classFqsen         = new Fqsen('\\' . $namespace . '\\' . $name);
        $classReflectorMock = new Class_(
            $classFqsen,
            $docBlockMock
        );

        $classReflectorMock->addConstant(new Constant(new Fqsen($classFqsen . '::Constant')));
        $classReflectorMock->addInterface(new Fqsen('\\TestInterface'));
        $classReflectorMock->addProperty(new Property(new Fqsen($classFqsen . '::$property')));
        $classReflectorMock->addMethod(new Method(new Fqsen($classFqsen . '::method()')));

        return $classReflectorMock;
    }

    /**
     * Create a descriptor builder mock
     */
    protected function getProjectDescriptorBuilderMock() : MockInterface
    {
        $projectDescriptorBuilderMock = m::mock('phpDocumentor\Descriptor\ProjectDescriptorBuilder');
        $projectDescriptorBuilderMock->shouldReceive('getDefaultPackage')->andReturn('\\');
        $projectDescriptorBuilderMock->shouldReceive('buildDescriptor')->andReturnUsing(static function ($param) {
            $mock = null;

            switch ($param) {
                case 'Properties':
                    $mock = m::mock('phpDocumentor\Descriptor\PropertiesDescriptor');
                    $mock->shouldReceive('getName')->once()->andReturn('Mock');
                    $mock->shouldReceive('setParent')->once()->andReturn();
                    break;

                case 'Method':
                    $mock = m::mock('phpDocumentor\Descriptor\MethodDescriptor');
                    $mock->shouldReceive('getName')->once()->andReturn('Mock');
                    $mock->shouldReceive('setParent')->once()->andReturn();
                    break;

                case 'Constant':
                    $mock = m::mock('phpDocumentor\Descriptor\ConstantDescriptor');
                    $mock->shouldReceive('getName')->once()->andReturn('Mock');
                    $mock->shouldReceive('setParent')->once()->andReturn();
                    break;
            }

            return $mock;
        });

        return $projectDescriptorBuilderMock;
    }
}

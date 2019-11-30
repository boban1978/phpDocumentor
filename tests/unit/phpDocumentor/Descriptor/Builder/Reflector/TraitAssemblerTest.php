<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Descriptor\Builder\Reflector;

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use phpDocumentor\Descriptor\MethodDescriptor;
use phpDocumentor\Descriptor\ProjectDescriptorBuilder;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Php\Method;
use phpDocumentor\Reflection\Php\Trait_;

/**
 * @coversDefaultClass \phpDocumentor\Descriptor\Builder\Reflector\TraitAssembler
 * @covers ::<private>
 */
class TraitAssemblerTest extends MockeryTestCase
{
    /**
     * @covers ::create
     */
    public function testAssembleTraitWithMethod() : void
    {
        $method = new MethodDescriptor();
        $method->setName('method');
        $builder = m::mock(ProjectDescriptorBuilder::class);
        $builder->shouldReceive('buildDescriptor')->andReturn($method);

        $traitFqsen = new Fqsen('\My\Space\MyTrait');
        $trait      = new Trait_($traitFqsen);
        $trait->addMethod(new Method(new Fqsen('\My\Space\MyTrait::method()')));
        $assembler = new TraitAssembler();
        $assembler->setBuilder($builder);

        $result = $assembler->create($trait);

        static::assertEquals('\My\Space', $result->getNamespace());
        static::assertSame($traitFqsen, $result->getFullyQualifiedStructuralElementName());
        static::assertEquals('MyTrait', $result->getName());
        static::assertInstanceOf(MethodDescriptor::class, $result->getMethods()->get('method', false));
    }
}

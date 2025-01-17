<?php

namespace phpDocumentor\Compiler\Pass;

use Mockery as m;
use phpDocumentor\Descriptor\Example\Finder;
use phpDocumentor\Reflection\DocBlock\ExampleFinder;

/**
 * Tests the \phpDocumentor\Compiler\Pass\ExampleTagsEnricher class.
 */
class ExampleTagsEnricherTest extends \Mockery\Adapter\Phpunit\MockeryTestCase
{
    /** @var Finder|m\MockInterface */
    private $finderMock;

    /** @var ExampleTagsEnricher */
    private $fixture;

    /**
     * Initializes the fixture and its dependencies.
     */
    protected function setUp(): void
    {
        $this->finderMock = m::mock(ExampleFinder::class);
        $this->fixture = new ExampleTagsEnricher($this->finderMock);
    }

    /**
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::getDescription
     */
    public function testDescriptionName() : void
    {
        $this->assertSame('Enriches inline example tags with their sources', $this->fixture->getDescription());
    }

    /**
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::__construct
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::execute
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::replaceInlineExamples
     */
    public function testReplaceExampleTagReturnsDescriptionIfItContainsNoExampleTags() : void
    {
        $description = 'This is a description';

        $descriptor = $this->givenAChildDescriptorWithDescription($description);
        $this->thenDescriptionOfDescriptorIsChangedInto($descriptor, $description);

        $project = $this->givenAProjectDescriptorWithChildDescriptors([$descriptor]);

        $this->fixture->execute($project);

        $this->assertTrue(true);
    }

    /**
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::__construct
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::execute
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::replaceInlineExamples
     */
    public function testReplaceExampleTagWithExampleContents() : void
    {
        $exampleText = 'Example Text';
        $description = 'This is a description with {@example example2.txt} without description.';
        $expected = "This is a description with `${exampleText}` without description.";

        $descriptor = $this->givenAChildDescriptorWithDescription($description);
        $this->whenExampleTxtFileContains($exampleText);
        $this->thenDescriptionOfDescriptorIsChangedInto($descriptor, $expected);

        $project = $this->givenAProjectDescriptorWithChildDescriptors([$descriptor]);

        $this->fixture->execute($project);

        $this->assertTrue(true);
    }

    /**
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::__construct
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::execute
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::replaceInlineExamples
     */
    public function testReplaceExampleTagWithExampleContentsAndDescription() : void
    {
        $exampleText = 'Example Text';
        $description = 'This is a description with {@example example.txt including description}.';
        $expected = "This is a description with *including description*`${exampleText}`.";

        $descriptor = $this->givenAChildDescriptorWithDescription($description);
        $this->whenExampleTxtFileContains($exampleText);
        $this->thenDescriptionOfDescriptorIsChangedInto($descriptor, $expected);

        $project = $this->givenAProjectDescriptorWithChildDescriptors([$descriptor]);

        $this->fixture->execute($project);

        $this->assertTrue(true);
    }

    /**
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::__construct
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::execute
     * @covers \phpDocumentor\Compiler\Pass\ExampleTagsEnricher::replaceInlineExamples
     */
    public function testReplacingOfDescriptionHappensOncePerExample() : void
    {
        $exampleText = 'Example Text';
        $description = 'This is a description with {@example example.txt} and {@example example.txt}.';
        $expected = "This is a description with `${exampleText}` and `${exampleText}`.";

        $descriptor = $this->givenAChildDescriptorWithDescription($description);
        $this->whenExampleTxtFileContainsAndMustBeCalledOnlyOnce($exampleText);
        $this->thenDescriptionOfDescriptorIsChangedInto($descriptor, $expected);

        $project = $this->givenAProjectDescriptorWithChildDescriptors([$descriptor]);

        $this->fixture->execute($project);

        $this->assertTrue(true);
    }

    /**
     * Returns a mocked Descriptor with its description set to the given value.
     *
     * @param string $description
     *
     * @return m\MockInterface
     */
    private function givenAChildDescriptorWithDescription($description) : \Mockery\MockInterface
    {
        $descriptor = m::mock('phpDocumentor\Descriptor\DescriptorAbstract');
        $descriptor->shouldReceive('getDescription')->andReturn($description);

        return $descriptor;
    }

    /**
     * Returns a mocked Project Descriptor.
     *
     * @param m\MockInterface[] $descriptors
     *
     * @return m\MockInterface
     */
    private function givenAProjectDescriptorWithChildDescriptors($descriptors) : \Mockery\MockInterface
    {
        $projectDescriptor = m::mock('phpDocumentor\Descriptor\ProjectDescriptor');
        $projectDescriptor->shouldReceive('getIndexes->get')->with('elements')->andReturn($descriptors);

        return $projectDescriptor;
    }

    /**
     * Verifies if the given descriptor's setDescription method is called with the given value.
     *
     * @param m\MockInterface $descriptor
     * @param string          $expected
     */
    public function thenDescriptionOfDescriptorIsChangedInto($descriptor, $expected) : void
    {
        $descriptor->shouldReceive('setDescription')->with($expected);
    }

    /**
     * Instructs the finder mock to return the given text when an example is requested.
     *
     * @param string $exampleText
     */
    private function whenExampleTxtFileContains($exampleText) : void
    {
        $this->finderMock->shouldReceive('find')->andReturn($exampleText);
    }

    /**
     * Instructs the finder mock to return the given text when an example is requested and verifies that that is only
     * done once.
     *
     * @param string $exampleText
     */
    private function whenExampleTxtFileContainsAndMustBeCalledOnlyOnce($exampleText) : void
    {
        $this->finderMock->shouldReceive('find')->once()->andReturn($exampleText);
    }
}

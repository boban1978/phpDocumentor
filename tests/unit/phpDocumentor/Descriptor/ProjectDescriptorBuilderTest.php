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

namespace phpDocumentor\Descriptor;

use \Mockery as m;
use phpDocumentor\Descriptor\ProjectDescriptor\Settings;

/**
 * Tests the functionality for the ProjectDescriptorBuilder class.
 * @coversDefaultClass \phpDocumentor\Descriptor\ProjectDescriptorBuilder
 */
class ProjectDescriptorBuilderTest extends \Mockery\Adapter\Phpunit\MockeryTestCase
{
    /** @var \phpDocumentor\Descriptor\ProjectDescriptorBuilder $fixture */
    protected $fixture;

    /**
     * Mock of the required AssemblerFactory dependency of the $fixture.
     *
     * @var \phpDocumentor\Descriptor\Builder\AssemblerFactory|m\MockInterface
     */
    protected $assemblerFactory;

    /**
     * Sets up a minimal fixture with mocked dependencies.
     */
    protected function setUp(): void
    {
        $this->assemblerFactory = $this->createAssemblerFactoryMock();
        $filterMock = m::mock('phpDocumentor\Descriptor\Filter\Filter');

        $this->fixture = new ProjectDescriptorBuilder($this->assemblerFactory, $filterMock);
    }

    /**
     * @covers ::createProjectDescriptor
     * @covers ::getProjectDescriptor
     */
    public function testCreatesAnEmptyProjectDescriptorWhenCalledFor() : void
    {
        $this->fixture->createProjectDescriptor();

        $this->assertInstanceOf('phpDocumentor\Descriptor\ProjectDescriptor', $this->fixture->getProjectDescriptor());
        $this->assertEquals(
            ProjectDescriptorBuilder::DEFAULT_PROJECT_NAME,
            $this->fixture->getProjectDescriptor()->getName()
        );
    }

    /**
     * Creates a new FileReflector mock that can be used as input for the builder.
     */
    protected function createFileReflectorMock(): m\MockInterface
    {
        return m::mock('phpDocumentor\Reflection\FileReflector');
    }

    protected function createFileDescriptorCreationMock() : void
    {
        $fileDescriptor = m::mock('phpDocumentor\Descriptor\FileDescriptor');
        $fileDescriptor->shouldReceive('setErrors');
        $fileDescriptor->shouldReceive('getPath')->andReturn('abc');

        $fileAssembler = m::mock('stdClass');
        $fileAssembler->shouldReceive('setBuilder')->withAnyArgs();
        $fileAssembler->shouldReceive('create')
            ->with('phpDocumentor\Reflection\FileReflector')
            ->andReturn($fileDescriptor);

        $this->assemblerFactory->shouldReceive('get')
            ->with('phpDocumentor\Reflection\FileReflector')
            ->andReturn($fileAssembler);
    }

    /**
     * Creates a Mock of an AssemblerFactory.
     *
     * When a FileReflector (or mock thereof) is passed to the 'get' method this mock will return an
     * empty instance of the FileDescriptor class.
     *
     * @return m\MockInterface|\phpDocumentor\Descriptor\Builder\AssemblerFactory
     */
    protected function createAssemblerFactoryMock()
    {
        return m::mock('phpDocumentor\Descriptor\Builder\AssemblerFactory');
    }
}

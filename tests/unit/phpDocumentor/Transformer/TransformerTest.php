<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Transformer;

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use org\bovigo\vfs\vfsStream;
use Psr\Log\NullLogger;
use const DIRECTORY_SEPARATOR;
use function strlen;

/**
 * Test class for \phpDocumentor\Transformer\Transformer.
 *
 * @covers \phpDocumentor\Transformer\Transformer
 */
class TransformerTest extends MockeryTestCase
{
    /** @var int Max length of description printed. */
    protected static $MAX_DESCRIPTION_LENGTH = 68;

    /** @var Transformer $fixture */
    protected $fixture = null;

    /**
     * Instantiates a new \phpDocumentor\Transformer for use as fixture.
     */
    protected function setUp() : void
    {
        $templateCollectionMock = m::mock('phpDocumentor\Transformer\Template\Collection');
        $templateCollectionMock->shouldIgnoreMissing();
        $writerCollectionMock = m::mock('phpDocumentor\Transformer\Writer\Collection');
        $writerCollectionMock->shouldIgnoreMissing();

        $this->fixture = new Transformer($templateCollectionMock, $writerCollectionMock, new NullLogger());
    }

    /**
     * @covers \phpDocumentor\Transformer\Transformer::__construct
     */
    public function testInitialization() : void
    {
        $templateCollectionMock = m::mock('phpDocumentor\Transformer\Template\Collection');
        $templateCollectionMock->shouldIgnoreMissing();
        $writerCollectionMock = m::mock('phpDocumentor\Transformer\Writer\Collection');
        $writerCollectionMock->shouldIgnoreMissing();
        $this->fixture = new Transformer($templateCollectionMock, $writerCollectionMock, new NullLogger());

        $this->assertSame($templateCollectionMock, $this->fixture->getTemplates());
    }

    /**
     * @covers \phpDocumentor\Transformer\Transformer::getTarget
     * @covers \phpDocumentor\Transformer\Transformer::setTarget
     */
    public function testSettingAndGettingATarget() : void
    {
        $this->assertEquals('', $this->fixture->getTarget());

        $this->fixture->setTarget(__DIR__);

        $this->assertEquals(__DIR__, $this->fixture->getTarget());
    }

    /**
     * @covers \phpDocumentor\Transformer\Transformer::setTarget
     */
    public function testExceptionWhenSettingFileAsTarget() : void
    {
        $this->expectException('InvalidArgumentException');
        $this->fixture->setTarget(__FILE__);
    }

    /**
     * @covers \phpDocumentor\Transformer\Transformer::setTarget
     */
    public function testExceptionWhenSettingExistingDirAsTarget() : void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Target directory (vfs://myroot) does not exist and could not be created');
        $fileSystem = vfsStream::setup('myroot');
        $this->fixture->setTarget(vfsStream::url('myroot'));
    }

    /**
     * @covers \phpDocumentor\Transformer\Transformer::getTemplates
     */
    public function testRetrieveTemplateCollection() : void
    {
        $templateCollectionMock = m::mock('phpDocumentor\Transformer\Template\Collection');
        $templateCollectionMock->shouldIgnoreMissing();
        $writerCollectionMock = m::mock('phpDocumentor\Transformer\Writer\Collection');
        $writerCollectionMock->shouldIgnoreMissing();

        $fixture = new Transformer($templateCollectionMock, $writerCollectionMock, new NullLogger());

        $this->assertEquals($templateCollectionMock, $fixture->getTemplates());
    }

    /**
     * @covers \phpDocumentor\Transformer\Transformer::execute
     */
    public function testExecute() : void
    {
        $myTestWritter = 'myTestWriter';

        $templateCollection = m::mock('phpDocumentor\Transformer\Template\Collection');

        $project = m::mock('phpDocumentor\Descriptor\ProjectDescriptor');

        $myTestWritterMock = m::mock('phpDocumentor\Transformer\Writer\WriterAbstract')
            ->shouldReceive('transform')->getMock();

        $writerCollectionMock = m::mock('phpDocumentor\Transformer\Writer\Collection')
            ->shouldReceive('offsetGet')->with($myTestWritter)->andReturn($myTestWritterMock)
            ->getMock();

        $fixture = new Transformer($templateCollection, $writerCollectionMock, new NullLogger());

        $transformation = m::mock('phpDocumentor\Transformer\Transformation')
            ->shouldReceive('execute')->with($project)
            ->shouldReceive('getQuery')->andReturn('')
            ->shouldReceive('getWriter')->andReturn($myTestWritter)
            ->shouldReceive('getArtifact')->andReturn('')
            ->shouldReceive('setTransformer')->with($fixture)
            ->getMock();

        $templateCollection->shouldReceive('getTransformations')->andReturn(
            [$transformation]
        );

        $fixture->execute($project);
    }

    /**
     * Tests whether the generateFilename method returns a file according to
     * the right format.
     *
     * @covers \phpDocumentor\Transformer\Transformer::generateFilename
     */
    public function testGenerateFilename() : void
    {
        // separate the directories with the DIRECTORY_SEPARATOR constant to prevent failing tests on windows
        $filename = 'directory' . DIRECTORY_SEPARATOR . 'directory2' . DIRECTORY_SEPARATOR . 'file.php';
        $this->assertEquals('directory.directory2.file.html', $this->fixture->generateFilename($filename));
    }

    /**
     * @covers \phpDocumentor\Transformer\Transformer::getDescription
     */
    public function testGetDescription() : void
    {
        $description = $this->fixture->getDescription();
        $this->assertNotNull($description);
        $this->assertLessThanOrEqual(static::$MAX_DESCRIPTION_LENGTH, strlen($description));
    }
}

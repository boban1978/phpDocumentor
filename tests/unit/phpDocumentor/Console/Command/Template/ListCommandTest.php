<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2010-2018 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Console\Command\Template;

use Mockery as m;
use phpDocumentor\Transformer\Template\Factory;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @coversDefaultClass \phpDocumentor\Console\Command\Template\ListCommand
 */
class ListCommandTest extends \Mockery\Adapter\Phpunit\MockeryTestCase
{
    /**
     * @covers ::__construct
     * @covers ::configure
     * @covers ::execute
     */
    public function testExecuteListsCommands() : void
    {
        // Arrange
        $command = new ListCommand($this->givenAFactoryWithTemplateNames(['default', 'second']));

        $expectedOutput = <<<TXT
Available templates:
* default
* second


TXT;
        $expectedOutput = str_replace("\n", PHP_EOL, $expectedOutput);

        // Act
        $commandTester = new CommandTester($command);
        $commandTester->execute([], ['decorated' => false]);

        // Assert
        $this->assertSame($expectedOutput, $commandTester->getDisplay());
    }

    /**
     * Returns a factory mock object with the provided template names returned using the `getAllNames()` method.
     *
     * @param string[] $templateNames
     *
     * @return m\MockInterface|Factory
     */
    private function givenAFactoryWithTemplateNames(array $templateNames)
    {
        $factoryMock = m::mock('phpDocumentor\Transformer\Template\Factory');
        $factoryMock->shouldReceive('getAllNames')->once()->andReturn($templateNames);

        return $factoryMock;
    }
}

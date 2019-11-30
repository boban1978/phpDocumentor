<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Console;

use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @coversDefaultClass \phpDocumentor\Console\Application
 * @covers ::__construct
 * @covers ::<private>
 */
class ApplicationTest extends MockeryTestCase
{
    /** @var Application */
    private $feature;

    public function setUp() : void
    {
        $kernelMock = m::mock(KernelInterface::class);
        $kernelMock->shouldIgnoreMissing();
        $kernelMock->shouldReceive('getBundles')->andReturn([]);
        $kernelMock->shouldReceive('getContainer->has')->andReturn(false);
        $kernelMock->shouldReceive('getContainer->hasParameter')->andReturn(false);
        $kernelMock->shouldReceive('getContainer->get')
            ->with('event_dispatcher')
            ->andReturn(new EventDispatcher());

        $kernelMock->shouldReceive('getContainer->get')->andReturn(false);

        $this->feature = new Application($kernelMock);
        $this->feature->setAutoExit(false);
    }

    /**
     * @covers ::getCommandName
     */
    public function testWhetherTheNameOfTheCommandCanBeRetrieved() : void
    {
        $_SERVER['argv'] = ['binary', 'my:command'];
        $this->feature->add((new Command('my:command'))->setCode(static function () {
            return 1;
        }));
        $this->feature->add((new Command('project:run'))->setCode(static function () {
            return 2;
        }));

        $this->assertSame(1, $this->feature->run(new StringInput('my:command -q')));
    }

    /**
     * @covers ::getCommandName
     */
    public function testWhetherTheRunCommandIsUsedWhenNoCommandNameIsGiven() : void
    {
        $_SERVER['argv'] = ['binary', 'something else'];
        $this->feature->add((new Command('MyCommand'))->setCode(static function () {
            return 1;
        }));
        $this->feature->add((new Command('project:run'))->setCode(static function () {
            return 2;
        }));

        $this->assertSame(2, $this->feature->run(new StringInput('-q')));
    }

    /**
     * @covers ::getDefaultInputDefinition
     */
    public function testWhetherTheConfigurationAndLogIsADefaultInput() : void
    {
        $definition = $this->feature->getDefinition();

        $this->assertTrue($definition->hasOption('config'));
        $this->assertTrue($definition->hasOption('log'));
    }

    /**
     * @covers ::getLongVersion
     */
    public function testGetLongVersion() : void
    {
        self::assertRegExp(
            '~phpDocumentor <info>v(.*)</info>~',
            $this->feature->getLongVersion()
        );
    }
}

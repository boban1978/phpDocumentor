<?php

declare(strict_types=1);

/**
 * phpDocumentor
 *
 * PHP Version 5.3
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Transformer\Router;

use Mockery\Adapter\Phpunit\MockeryTestCase;

class RuleTest extends MockeryTestCase
{
    /**
     * @covers \phpDocumentor\Transformer\Router\Rule::__construct
     * @covers \phpDocumentor\Transformer\Router\Rule::match
     */
    public function testIfRuleCanBeMatched() : void
    {
        $fixture  = new Rule(
            static function () {
                return true;
            },
            static function () : void {
            }
        );
        $fixture2 = new Rule(
            static function () {
                return false;
            },
            static function () : void {
            }
        );

        $node = 'test';
        $this->assertTrue($fixture->match($node));
        $this->assertFalse($fixture2->match($node));
    }

    /**
     * @covers \phpDocumentor\Transformer\Router\Rule::__construct
     * @covers \phpDocumentor\Transformer\Router\Rule::generate
     */
    public function testIfUrlCanBeGenerated() : void
    {
        $fixture = new Rule(
            static function () : void {
            },
            static function () {
                return 'url';
            }
        );

        $this->assertSame('url', $fixture->generate('test'));
    }

    /**
     * @covers \phpDocumentor\Transformer\Router\Rule::__construct
     * @covers \phpDocumentor\Transformer\Router\Rule::generate
     * @covers \phpDocumentor\Transformer\Router\Rule::translateToUrlEncodedPath
     */
    public function testTranslateToUrlEncodedPath() : void
    {
        $this->markTestSkipped(
            'Github Actions does not like this test; let us skip it for now and figure out what to do'
        );
        $fixture = new Rule(
            static function () {
                return true;
            },
            static function () {
                return 'httö://www.€xample.org/foo.html#bär';
            }
        );

        $this->assertSame('httö://www.EURxample.org/foo.html#bär', $fixture->generate('test'));
    }
}

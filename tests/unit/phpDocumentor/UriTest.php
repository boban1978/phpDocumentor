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

namespace phpDocumentor;

use PHPUnit\Framework\TestCase;

/**
 * Test case for Uri
 *
 * @coversDefaultClass \phpDocumentor\Uri
 */
final class UriTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::__toString
     * @covers ::<private>
     */
    public function testItShouldReturnTheUriAsAString() : void
    {
        $uri = new Uri('http://foo.bar/phpdoc.xml');

        $this->assertSame('http://foo.bar/phpdoc.xml', (string) $uri);
    }

    /**
     * @covers ::<private>
     */
    public function testItShouldDiscardAnInvalidUri() : void
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('http://foo,bar is not a valid uri');
        new Uri('http://foo,bar');
    }

    /**
     * @covers ::<private>
     */
    public function testItShouldAddAFileSchemeWhenSchemeIsAbsent() : void
    {
        $uri = new Uri('foo/phpdoc.xml');

        $this->assertSame('file://foo/phpdoc.xml', (string) $uri);
    }

    /**
     * @covers ::<private>
     */
    public function testItShouldAddAFileSchemeWhenAWindowsDriveLetterIsGiven() : void
    {
        $uri = new Uri('c:\foo\phpdoc.xml');

        $this->assertSame('file:///c:\foo\phpdoc.xml', (string) $uri);
    }

    public function testItShouldReturnTrueIfUrisAreEqual() : void
    {
        $uri1 = new Uri('foo');
        $uri2 = new Uri('foo');

        $this->assertTrue($uri1->equals($uri2));
    }

    public function testItShouldReturnTrueIfUrisAreNotEqual() : void
    {
        $uri1 = new Uri('foo');
        $uri2 = new Uri('bar');

        $this->assertFalse($uri1->equals($uri2));
    }
}

<?php
declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    Mike van Riel <mike.vanriel@naenius.com>
 * @copyright 2010-2018 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Parser\Middleware;

use phpDocumentor\Reflection\Middleware\Command;
use phpDocumentor\Reflection\Middleware\Middleware;
use phpDocumentor\Reflection\Php\Factory\File\CreateCommand;
use phpDocumentor\Reflection\Php\File;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Contracts\Cache\CacheInterface;

final class CacheMiddleware implements Middleware
{
    /** @var CacheInterface */
    private $cache;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(CacheInterface $files, LoggerInterface $logger)
    {
        $this->cache = $files;
        $this->logger = $logger;
    }

    /**
     * Executes this middle ware class.
     * A middle ware class MUST return a File object or call the $next callable.
     *
     * @param CreateCommand $command
     * @param callable $next
     *
     * @return File
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function execute(Command $command, callable $next)
    {
        $itemName = md5($command->getFile()->path());

        $cacheResponse = $this->cache->get(
            $itemName . '-' . $command->getFile()->md5(),
            function () use ($next, $command) {
                $this->logger->log(LogLevel::NOTICE, 'Parsing ' . $command->getFile()->path());
                $file = $next($command);
                return base64_encode(serialize($file));
            }
        );
        $cachedFile = unserialize(base64_decode($cacheResponse));

        return $cachedFile;
    }
}

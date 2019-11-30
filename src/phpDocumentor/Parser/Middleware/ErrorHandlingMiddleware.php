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

namespace phpDocumentor\Parser\Middleware;

use phpDocumentor\Reflection\Middleware\Command;
use phpDocumentor\Reflection\Middleware\Middleware;
use phpDocumentor\Reflection\Php\Factory\File\CreateCommand;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Throwable;
use function assert;

final class ErrorHandlingMiddleware implements Middleware
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return string|object|null
     */
    public function execute(Command $command, callable $next)
    {
        assert($command instanceof CreateCommand);

        $filename = $command->getFile()->path();
        $this->log('Starting to parse file: ' . $filename, LogLevel::INFO);

        try {
            return $next($command);
        } catch (Throwable $e) {
            $this->log(
                '  Unable to parse file "' . $filename . '", an error was detected: ' . $e->getMessage(),
                LogLevel::ALERT
            );
        }

        return null;
    }

    /**
     * Dispatches a logging request.
     */
    private function log(string $message, string $priority = LogLevel::INFO, array $parameters = []) : void
    {
        $this->logger->log($priority, $message, $parameters);
    }
}

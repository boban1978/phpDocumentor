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

namespace phpDocumentor\Application\Stage\Cache;

use phpDocumentor\Application\Stage\Payload;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

final class PurgeCachesWhenForced
{
    private $filesCache;
    private $descriptorsCache;
    private $logger;

    public function __construct(
        AdapterInterface $filesCache,
        AdapterInterface $descriptorsCache,
        LoggerInterface $logger
    ) {
        $this->filesCache       = $filesCache;
        $this->descriptorsCache = $descriptorsCache;
        $this->logger           = $logger;
    }

    public function __invoke(Payload $payload)
    {
        $this->logger->info('Checking whether to purge cache');
        if (!$payload->getConfig()['phpdocumentor']['use-cache']) {
            $this->logger->info('Purging cache');
            $this->filesCache->clear();
            $this->descriptorsCache->clear();
        }

        return $payload;
    }
}

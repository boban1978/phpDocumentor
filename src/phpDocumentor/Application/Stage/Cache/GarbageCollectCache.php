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

use phpDocumentor\Application\Stage\Parser\Payload;
use phpDocumentor\Descriptor\Cache\ProjectDescriptorMapper;

final class GarbageCollectCache
{
    /** @var ProjectDescriptorMapper */
    private $descriptorMapper;

    public function __construct(ProjectDescriptorMapper $descriptorMapper)
    {
        $this->descriptorMapper = $descriptorMapper;
    }

    public function __invoke(Payload $payload)
    {
        $this->descriptorMapper->garbageCollect($payload->getFiles());
        return $payload;
    }
}
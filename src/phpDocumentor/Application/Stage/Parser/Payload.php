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

namespace phpDocumentor\Application\Stage\Parser;

use phpDocumentor\Application\Stage\Payload as ApplicationPayload;
use phpDocumentor\Descriptor\ProjectDescriptorBuilder;
use phpDocumentor\Reflection\File;
use function array_merge;
use function current;

final class Payload extends ApplicationPayload
{
    /** @var File[] */
    private $files;

    /**
     * @param File[] $files
     */
    public function __construct(array $config, ProjectDescriptorBuilder $builder, array $files = [])
    {
        parent::__construct($config, $builder);
        $this->files = $files;
    }

    public function getApiConfigs()
    {
        //Grep only the first version for now. Multi version support will be added later
        $version = current($this->getConfig()['phpdocumentor']['versions']);

        return $version['api'];
    }

    public function withFiles(array $files) : Payload
    {
        return new self(
            $this->getConfig(),
            $this->getBuilder(),
            array_merge($this->getFiles(), $files)
        );
    }

    /**
     * @return File[]
     */
    public function getFiles() : array
    {
        return $this->files;
    }
}

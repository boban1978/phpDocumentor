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

namespace phpDocumentor\Application;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\PipelineInterface;

final class PipelineFactory
{
    public static function create(iterable $stages) : PipelineInterface
    {
        $builder = new PipelineBuilder();
        foreach ($stages as $stage) {
            $builder->add($stage);
        }

        return $builder->build();
    }
}

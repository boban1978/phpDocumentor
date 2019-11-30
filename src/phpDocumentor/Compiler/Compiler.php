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

namespace phpDocumentor\Compiler;

use SplPriorityQueue;
use Webmozart\Assert\Assert;

/**
 * Contains a series of compiler steps in a specific order; ready to be executed during transformation.
 */
class Compiler extends SplPriorityQueue
{
    /** @var integer Default priority assigned to Compiler Passes without provided priority */
    public const PRIORITY_DEFAULT = 10000;

    /**
     * @param CompilerPassInterface $value
     * @param int $priority
     */
    public function insert($value, $priority = self::PRIORITY_DEFAULT) : bool
    {
        Assert::isInstanceOf($value, CompilerPassInterface::class);

        return parent::insert($value, $priority);
    }
}

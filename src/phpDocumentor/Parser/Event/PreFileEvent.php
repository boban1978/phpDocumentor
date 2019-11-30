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

namespace phpDocumentor\Parser\Event;

use phpDocumentor\Event\EventAbstract;

/**
 * Event thrown before the parsing of an individual file.
 */
class PreFileEvent extends EventAbstract
{
    /** @var string */
    protected $file;

    /**
     * Sets the name of the file that is about to be processed.
     *
     * @return self|PreFileEvent
     */
    public function setFile(string $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Returns the name of the file that is about to be processed.
     */
    public function getFile() : string
    {
        return $this->file;
    }
}

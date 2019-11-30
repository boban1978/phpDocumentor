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

namespace phpDocumentor\Descriptor\Filter;

use phpDocumentor\Descriptor\Collection;
use phpDocumentor\Descriptor\Descriptor;

/**
 * Interface to determine which elements can be filtered and to provide a way to set errors on the descriptor.
 */
interface Filterable extends Descriptor
{
    /**
     * Sets a list of errors on the associated element.
     */
    public function setErrors(Collection $errors) : void;
}

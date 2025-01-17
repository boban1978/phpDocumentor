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

namespace phpDocumentor\Transformer\Router\UrlGenerator;

/**
 * Service class used to convert Qualified names into URL paths for the Standard Router.
 */
class QualifiedNameToUrlConverter
{
    /**
     * Converts the provided FQCN into a file name by replacing all slashes and underscores with dots.
     *
     * @param string $fqcn
     *
     * @return string
     */
    public function fromPackage($fqcn)
    {
        $name = str_replace(['\\', '_'], '-', ltrim($fqcn, '\\'));

        // convert root namespace to default; default is a keyword and no namespace CAN be named as such
        if ($name === '') {
            $name = 'default';
        }

        return $name;
    }

    /**
     * Converts the provided FQCN into a file name by replacing all slashes with dots.
     *
     * @param string $fqnn
     *
     * @return string
     */
    public function fromNamespace($fqnn)
    {
        $name = str_replace('\\', '-', ltrim((string) $fqnn, '\\'));

        // convert root namespace to default; default is a keyword and no namespace CAN be named as such
        if ($name === '') {
            $name = 'default';
        }

        return strtolower($name);
    }

    /**
     * Converts the provided FQCN into a file name by replacing all slashes with dots.
     *
     * @param string $fqcn
     *
     * @return string
     */
    public function fromClass($fqcn)
    {
        return str_replace('\\', '-', ltrim((string) $fqcn, '\\'));
    }

    /**
     * Converts the given path to a valid url.
     *
     * @param string $path
     *
     * @return string
     */
    public function fromFile($path)
    {
        $path = $this->removeFileExtensionFromPath($path);

        return str_replace(['/', '\\'], '-', ltrim($path, '/'));
    }

    /**
     * Removes the file extension from the provided path.
     *
     * @param string $path
     *
     * @return string
     */
    private function removeFileExtensionFromPath($path)
    {
        if (strrpos($path, '.') !== false) {
            $path = substr($path, 0, strrpos($path, '.'));
        }

        return $path;
    }
}

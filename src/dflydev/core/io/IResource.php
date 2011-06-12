<?php

/*
 * This file is part of the dflydev-core-php package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\core\io;

/**
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
interface IResource {
    
    /**
     * Return whether this resource actually exists in physical form.
     * @return bool
     */
    function exists();
    
    /**
     * Return whether this resource is a file.
     * @return bool
     */
    function isFile();
    
    /**
     * Return whether this resource is a directory.
     * @return bool
     */
    function isDirectory();
    
    /**
     * Return the filename.
     * @return string
     */
    function filename();
    
}

<?php

/*
 * This file is part of the dflydev-core-php package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\core\io;

/**
 * Description of FileResource
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class FileSystemResource implements IResource {
    
    /**
     * @var string Filename
     */
    protected $filename;
    
    /**
     * Constructor
     * @param string $filename
     */
    public function __construct($filename) {
        $this->filename = $filename;
    }
    
    /**
     * {@inheritdoc}
     */
    public function exists() {
        return file_exists($this->filename);
    }

    /**
     * {@inheritdoc}
     */
    public function isFile() {
        return file_exists($this->filename) and is_file($this->filename);
    }
    
    /**
     * {@inheritdoc}
     */
    public function isDirectory() {
        return file_exists($this->filename) and is_dir($this->filename);
    }

    /**
     * {@inheritdoc}
     */
    public function filename() {
        return $this->filename;
        
    }

}
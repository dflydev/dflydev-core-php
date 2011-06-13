<?php

/*
 * This file is part of the dflydev-core-php package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dflydev\tests\core\io;

use dflydev\core\io\FileSystemResourceLoader;

/**
 * Description of FileSystemResourceLoaderTest
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class FileSystemResourceLoaderTest extends \PHPUnit_Framework_TestCase {
    static protected $tmpDir;
    static protected $files;
    public function testFile() {
        $resourceLoader = new FileSystemResourceLoader(self::$tmpDir);
        $resource = $resourceLoader->load("bar/test.properties");
        $this->assertTrue($resource->exists(), '->exists() returns true for a resource representing something that exists on the filesystem');
        $this->assertTrue($resource->isFile(), '->isFile() returns true for a resource representing an existing file');
        $this->assertFalse($resource->isDirectory(), '->isDirectory() returns false for a resource representing an existing file');
    }
    public function testDirectory() {
        $resourceLoader = new FileSystemResourceLoader(self::$tmpDir);
        $resource = $resourceLoader->load("bar");
        $this->assertTrue($resource->exists(), '->exists() returns true for a resource representing something that exists on the filesystem');
        $this->assertFalse($resource->isFile(), '->isFile() returns false for a resource representing an existing directory');
        $this->assertTrue($resource->isDirectory(), '->isDirectory() returns true for a resource representing an existing directory');
    }
    public function testMissing() {
        $resourceLoader = new FileSystemResourceLoader(self::$tmpDir);
        try {
            // This file is known to be missing in our test space.
            $resource = $resourceLoader->load("--MISSING--");
            $this->fail();
        } catch (\Exception $e) {
            $this->assertInstanceOf('dflydev\core\io\exception\ResourceNotFoundException', $e, '->load() throws dflydev\core\io\exception\ResourceNotFoundException when loading a resource that does not exist');
        }
    }
    static public function setUpBeforeClass() {
        self::$tmpDir = $tmpDir = sys_get_temp_dir().'/dflydev_core_io_fsrl_tests_'.md5(time().rand());
        self::$files = array(
            $tmpDir.'/foo/',
            $tmpDir.'/bar/',
            $tmpDir.'/bar/test.properties',
            $tmpDir.'/yar.txt',
        );
        if ( is_dir($tmpDir) ) {
            self::removeAllFiles();
        } else {
            mkdir($tmpDir);
        }
        foreach (self::$files as $file) {
            if ('/' === $file[strlen($file) - 1]) {
                mkdir($file);
            } else {
                touch($file);
            }
        }
    }
    static public function tearDownAfterClass() {
        self::removeAllFiles();
        @rmdir(self::$tmpDir);
    }
    static protected function removeAllFiles() {
        foreach (array_reverse(self::$files) as $file) {
            if ('/' === $file[strlen($file) - 1]) {
                @rmdir($file);
            } else {
                @unlink($file);
            }
        }
    }
}
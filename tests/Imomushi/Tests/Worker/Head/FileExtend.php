<?php
/*
 * This file is part of Worker.
 *
 ** (c) 2016 - Fumikazu Fujiwara
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imomushi\Tests\Worker\Head;

/**
 * Class FileExtend
 *
 * @package Imomushi\Tests\Worker\Head
 */

class FileExtend extends \Imomushi\Worker\Head\File
{
    public function input()
    {
        return $this -> input;
    }
    public function log()
    {
        return $this -> log;
    }
    public function fh()
    {
        return $this -> fh;
    }
    public function body()
    {
        return $this -> body;
    }
    public function size($size = null)
    {
        return $this -> size = is_null($size) ? $this -> size : $size;
    }
    public function currentSize()
    {
        return $this -> currentSize;
    }
    public function open()
    {
        return parent::open();
    }
    public function close()
    {
        return parent::close();
    }
    public function diff()
    {
        return parent::diff();
    }
    public function stop()
    {
        $this -> stop = true;
    }
    public function onChange()
    {
        return parent::onChange();
    }
    public function logWrite()
    {
        return parent::logWrite();
    }
    public function sizeSetFromLog()
    {
        return parent::sizeSetFromLog();
    }
}
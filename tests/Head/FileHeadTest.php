<?php
/*
 * This file is part of Worker.
 *
 ** (c) 2016 - Fumikazu Fujiwara
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Imomushi\Worker\Tests\Head;

use Imomushi\Worker\Head\FileHead;

/**
 * Class FileHeadTest
 *
 * @package Imomushi\Worker\Tests
 */

class FileHeadTest extends \PHPUnit_Framework_TestCase
{
    /*
     * @vars
     */
    private $target;
    private $tmpFile;
    public function setUp()
    {
        $this -> tmpFile = tempnam(sys_get_temp_dir(), 'Imomushi.');
        $this -> target = new FileHead($this -> tmpFile);
        $this -> target -> inTest = true;

    }

    public function tearDown()
    {
        unlink($this -> tmpFile);
    }

    public function testConstruct()
    {
        $this -> assertInstanceOf(
            'Imomushi\Worker\Head\FileHead',
            $this -> target
        );
    }

    public function testOpen()
    {
        $this -> assertTrue(
            method_exists(
                $this -> target,
                'open'
            )
        );
        $this -> assertTrue(
            $this -> target -> open()
        );
    }

    public function testClose()
    {
        $this -> assertTrue(
            method_exists(
                $this -> target,
                'close'
            )
        );

        $this -> target -> open();
        $this -> assertTrue(
            $this -> target -> close()
        );
    }

    public function testChanged()
    {
        $this -> assertTrue(
            method_exists(
                $this -> target,
                'changed'
            )
        );

        $this -> target -> open();
        $this -> assertFalse(
            $this -> target -> changed()
        );

        $tmp = tempnam(sys_get_temp_dir(), 'Imomushi.');
        $tmpFileHead = new FileHead($tmp);
        $tmpFileHead -> open();
        $tmpFileHead -> changed();

        $fh = fopen($tmp, 'w');
        fwrite(
            $fh,
            '{"pipeline_id": "hogehoge", "segment_id": 1,'.
            ' function":"func1", "args": {"arg1": 1, "arg2": 2}}'."\n"
        );
        fclose($fh);

        $this -> assertTrue(
            $tmpFileHead -> changed()
        );

        $tmpFileHead -> close();
        unlink($tmp);
    }

    public function testGetInput()
    {
        $this -> assertTrue(
            method_exists(
                $this -> target,
                'getInput'
            )
        );
        $input = $this -> target -> getInput();
        $this -> assertEmpty(
            $input
        );

        $fh = fopen($this -> tmpFile, 'w');
        fwrite(
            $fh,
            '{"pipeline_id": "hogehoge", "segment_id": 1,'.
            '"function":"func1", "args": {"arg1": 1, "arg2": 2}}'.PHP_EOL
        );
        fclose($fh);

        $input = $this -> target -> getInput();
        $this -> assertNotEmpty(
            $input
        );
        $this -> assertEquals(
            1,
            count($input)
        );

        $input = $this -> target -> getInput();
        $this -> assertEmpty(
            $input
        );

        $fh = fopen($this -> tmpFile, 'a');
        fwrite(
            $fh,
            '{"pipeline_id": "hogehoge", "segment_id": 2,'.
            '"function":"func1", "args": {"arg1": 1, "arg2": 2}}'.PHP_EOL
        );
        fwrite(
            $fh,
            '{"pipeline_id": "hogehoge", "segment_id": 3,'.
            '"function":"func1", "args": {"arg1": 1, "arg2": 2}}'.PHP_EOL
        );
        fwrite(
            $fh,
            '{"pipeline_id": "hogehoge", "segment_id": 4,'.
            '"function":"func1", "args": {"arg1": 1, "arg2": 2}}'.PHP_EOL
        );
        fwrite(
            $fh,
            '{"pipeline_id": "hogehoge", "segment_id": 5,'.
            '"function":"func1", "args": {"arg1": 1, "arg2": 2}}'.PHP_EOL
        );
        fwrite(
            $fh,
            '{"pipeline_id": "hogehoge", "segment_id": 6,'.
            '"function":"func1", "args": {"arg1": 1, "arg2": 2}}'.PHP_EOL
        );
        fclose($fh);
        $input = $this -> target -> getInput();
        $this -> assertNotEmpty(
            $input
        );
        $this -> assertEquals(
            5,
            count($input)
        );
    }

    public function testRun()
    {
        $this -> assertTrue(
            method_exists(
                $this -> target,
                'run'
            )
        );

        $fh = fopen($this -> tmpFile, 'w');
        fwrite(
            $fh,
            '{"pipeline_id": "hogehoge", "segment_id": 1,'.
            '"function":"func1", "args": {"arg1": 1, "arg2": 2}}'.PHP_EOL
        );
        fclose($fh);
        $this -> target -> run();
    }
}

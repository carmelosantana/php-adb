<?php

declare(strict_types=1);

namespace carmelosantana\ADB;

class ADB
{
    // binary location
    private $bin = 'adb';

    // enable raw output
    private $raw;

    // command io
    public $run = [];

    /**
     * Method bin
     *
     * @param string $exe [explicite description]
     *
     * @return object
     */
    public function bin(string $exe): object
    {
        // TODO: Add additional OS
        switch (PHP_OS_FAMILY) {
            default:
                $this->bin = $exe;
                break;
        }

        return $this;
    }

    public function devices()
    {
        $args = [
            'devices'
        ];

        $this->run($args);

        $output = $this->run['output'];

        // remove command banner and last empty line
        array_shift($output);
        array_pop($output);

        if ( empty($output) )
            return false;

        return $output;
    }

    /*
     * The sources are: 
     *     dpad
     *     keyboard
     *     mouse
     *     touchpad
     *     gamepad
     *     touchnavigation
     *     joystick
     *     touchscreen
     *     stylus
     *     trackball
     * 
     * The commands and default sources are:
     *     text <string> (Default: touchscreen)
     *     keyevent [--longpress] <key code number or name> ... (Default: keyboard)
     *     tap <x> <y> (Default: touchscreen)
     *     swipe <x1> <y1> <x2> <y2> [duration(ms)] (Default: touchscreen)
     *     draganddrop <x1> <y1> <x2> <y2> [duration(ms)] (Default: touchscreen)
     *     press (Default: trackball)
     *     roll <dx> <dy> (Default: trackball)
     */
    public function input(string $input, $args = [])
    {
        $sources = [
            'text' => 'touchscreen',
            'keyevent' => 'keyboard',
            'tap' => 'touchscreen',
            'swipe' => 'touchscreen',
            'draganddrop' => 'touchscreen',
            'press' => 'trackball',
            'roll' => 'trackball'
        ];

        $cmd = [
            'shell',
            'input',
            $sources[strtolower($input)],
            strtolower($input),
        ];

        $this->run(array_merge($cmd, $args));

        return $this->run['output'] ? true : false;
    }

    public function screencap($path)
    {
        $args = [
            'exec-out',
            'screencap',
            '-p',
            '>',
            self::wrap($path)
        ];

        $this->run($args);

        if (is_file($path))
            return filesize($path);

        return false;
    }

    public function killServer()
    {
        $args = [
            'kill-server'
        ];

        $this->run($args);

        // if output is empty server shutdown correctly
        return $this->ifEmpty(true);
    }


    public function startServer()
    {
        $args = [
            'start-server'
        ];

        return $this->run($args);
    }

    public function version()
    {
        $args = [
            '--version'
        ];

        $this->run($args);

        return $this->run['output'][0] ?? false;
    }

    public function raw(): object
    {
        $this->raw = true;

        return $this;
    }

    public function run($args = [])
    {
        $this->run = [
            'command' => self::escapeCMD($this->bin, $args),
            'output' => [],
            'status' => null,
        ];

        exec($this->run['command'], $this->run['output'], $this->run['status']);

        return implode(PHP_EOL, $this->run['output']);
    }

    public function listPackages()
    {
        $args = [
            'shell',
            'pm',
            'list',
            'packages',
            '|',
            '-F',
            '":"',
            '\'{print $2}\'',
        ];

        return $this->run($args);
    }

    private function ifEmpty($bool)
    {
        if (empty($this->run['output'][0]))
            return true;


        return false;
    }

    static function escapeArgs(array $args): string
    {
        // return implode(' ', array_map('escapeshellarg', $args));
        return implode(' ', $args);
    }

    static function escapeCMD($bin, $args = []): string
    {
        $cmd = $bin . ' ' . self::escapeArgs($args);
        
        // return escapeshellcmd($cmd);
        return $cmd;
    }

    static function wrap($string, $char = '"')
    {
        return $char . $string . $char;
    }
}

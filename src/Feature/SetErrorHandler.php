<?php

namespace zonuexe\PhpCon2017\Feature;

use zonuexe\PhpCon2017\Features;

final class SetErrorHandler extends Feature
{
    public function execute(Features $features)
    {
        chrome_log()->info(__CLASS__, ['message' => 'set_error_handler()']);
        set_error_handler([$this, 'error_handler']);
    }

    public function error_handler($severity, $message, $file, $line)
    {
        if (!(error_reporting() & $severity)) {
            return;
        }

        throw new \ErrorException($message, 0, $severity, $file, $line);
    }
}

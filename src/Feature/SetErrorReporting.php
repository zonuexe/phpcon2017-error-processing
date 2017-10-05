<?php

namespace zonuexe\PhpCon2017\Feature;

use zonuexe\PhpCon2017\Features;

final class SetErrorReporting extends Feature
{
    public function execute(Features $features)
    {
        error_reporting($this->getErrorReportingLevel());
    }

    private function getErrorReportingLevel()
    {
        $v = 0;
        eval("\$v = {$this->value};");

        return $v;
    }
}

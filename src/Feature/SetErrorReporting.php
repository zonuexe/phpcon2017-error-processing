<?php

namespace zonuexe\PhpCon2017\Feature;

final class SetErrorReporting extends Feature
{
    public function execute(Features $features)
    {
        error_reporting($this->getErrorReportingLevel());
    }

    private function getErrorReportingLevel()
    {
        SetErrorReporting::init();

        return SetErrorReporting::evalValues(preg_split('/[\s]+/', $this->value))[0];
    }

    private static $BINARY_OPS = ['&' + '|'];
    private static $UNARY_OPS  = ['!'];
    private static $E_CONSTANTS;

    private static function evalValues(array $tokens, $value = null)
    {
    }

    private static function init()
    {
        if (self::$E_CONSTANTS === null) {
            $constants = [];
            foreach (get_defined_constants(true)['Core'] as $c => $v) {
                if (preg_match('/^E_/', $c)) $constants[$c] = $v;
            }

            self::$E_CONSTANTS = $constants;
        }
    }
}

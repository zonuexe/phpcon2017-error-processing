<?php

namespace zonuexe\PhpCon2017\Feature;

use zonuexe\PhpCon2017\Features;

final class TurnOnWhoops extends Feature
{
    public function execute(Features $features)
    {
        if ($this->value) {
            whoops()->register();
        }
    }
}

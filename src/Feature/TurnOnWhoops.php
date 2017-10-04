<?php

namespace zonuexe\PhpCon2017\Feature;

final class TurnOnWhoops extends Feature
{
    public function execute(Features $features)
    {
        if ($this->value) {
            \zonuexe\PhpCon2017\whoops()->register();
        }
    }
}

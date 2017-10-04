<?php

namespace zonuexe\PhpCon2017\Feature;

final class AddWhoopsHandler extends Feature
{
    public function execute(Features $features)
    {
        if ($this->value) {
            \zonuexe\PhpCon2017\whoops()->pushHandler($this->getHanlder());
        }
    }

    private function getHanlder()
    {
        $class = sprintf('%s\%s', \Whoops\Handler::class, $this->value);
    }
}

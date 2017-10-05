<?php

namespace zonuexe\PhpCon2017\Feature;

use zonuexe\PhpCon2017\Features;

final class AddWhoopsHandler extends Feature
{
    public function execute(Features $features)
    {
        if ($this->value) {
            whoops()->pushHandler($this->getHandler());
        }
    }

    /**
     * @return \Whoops\Handler\HandlerInterface
     */
    private function getHandler()
    {
        $class = sprintf('%s\%s', \Whoops\Handler::class, $this->value);
        new $class;
    }
}

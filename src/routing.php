<?php

namespace zonuexe\PhpCon2017;

$routing_map = [];

$routing_map['show_index'] = ['GET', '/', function () {
    return view('index');
}];

return $routing_map;

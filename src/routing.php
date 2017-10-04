<?php

namespace zonuexe\PhpCon2017;

$routing_map = [];

$routing_map['show_index'] = ['GET', '/', function () {
    return view('index');
}];

$routing_map['post_feature'] = ['GET', '/feature', function () {
    //var_dump($_POST);exit;

    return view('index');
}];

$routing_map['#404'] = function () {
    http_response_code(404);
    return view('404');
};

return $routing_map;

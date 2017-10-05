<?php

namespace zonuexe\PhpCon2017;

$routing_map = [];

$routing_map['show_index'] = ['GET', '/', function () {
    return view('index');
}];

$routing_map['error_notice'] = ['GET', '/error/notice/undefined_variable', function () {
    echo $a;
    return null;
}];

$routing_map['list_feature'] = ['GET', '/feature', function () {
    return view('list_feature', [
        'available_features' => Features::getAvailableValues(),
    ]);
}];

$routing_map['post_feature'] = ['POST', '/feature', function () {
    var_dump($_POST);exit;

    return view('index');
}];

$routing_map['#404'] = function () {
    http_response_code(404);
    return view('404');
};

return $routing_map;

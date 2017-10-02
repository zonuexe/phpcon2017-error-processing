<?php

/**
 * Helper functions for SampleApp
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 USAMI Kenta
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */

namespace zonuexe\PhpCon2017;

require __DIR__ . '/../src/bootstrap.php';

session_name(config('cookie.session_name'));
session_set_save_handler(new CookieSessionHandler(config('cookie.crypt_key_salt')));

session_start();

chrome_log()->info('$_SESSION', $_SESSION);

$_SESSION['last_update'] = $_SERVER['REQUEST_TIME_FLOAT'];


$router = router(new \Teto\Routing\Router(include __DIR__ . '/../src/routing.php'));
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
$action = $router->match($_SERVER['REQUEST_METHOD'], $request_uri);
$content = call_user_func($action->value, $action);

session_write_close();

echo $content();

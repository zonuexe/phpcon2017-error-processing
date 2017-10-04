<?php

/**
 * Helper functions for SampleApp
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 USAMI Kenta
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */

namespace zonuexe\PhpCon2017;

use Monolog\Logger;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\NullHandler;
use Teto\Routing\Router;

/**
 * @param  Router $router
 * @return Router
 */
function router(Router $router = null)
{
    /** @var Router $cache */
    static $cache;

    if ($router !== null) {
        $cache = $router;
    }

    return $cache;
}

/**
 * @return \Monolog\Logger
 */
function chrome_log()
{
    /** @var \Monolog\Logger */
    static $logger;

    if ($logger === null) {
        $logger  = new \Monolog\Logger('PHP');
        $handler = new ChromePHPHandler(Logger::INFO);
        $logger->pushHandler($handler);
    }

    return $logger;
}

/**
 * @param  string $key
 * @return mixed
 */
function config($key)
{
    /** @var array $config */
    static $config;

    if ($config === null) {
        $config = include __DIR__ . '/../config.php';
    }

    return $config[$key];
}

/**
 * @return \Twig_Environment
 */
function twig()
{
    /** @var \Twig_Environment $twig */
    static $twig;

    if ($twig === null) {
        $basedir = dirname(__DIR__);
        $loader = new \Twig_Loader_Filesystem($basedir . '/view/');
        $twig   = new \Twig_Environment($loader, [
            'cache' => $basedir . '/cache/twig',
            'debug' => true,
        ]);

        $twig->addFunction(new \Twig_SimpleFunction(
            'url_to', function ($name, array $param = []) {
                return router()->makePath($name, $param, true);
            }));

        $twig->addFunction(new \Twig_SimpleFunction(
            'feature_value', function ($value) {
                $in_array = is_array($value);
                $values = array_map(function ($v) {
                    if ($v === true)  return 'true';
                    if ($v === false) return 'false';

                    if (is_string($v)) {
                        return sprintf('"%s"', $v);
                    }

                    return (string)$v;
                }, $in_array ? $value : [$value]);

                return $in_array ? $values : $values[0];
            }));
    }

    return $twig;
}

/**
 * @param string $tpl_name
 * @param array $data
 * @return callable
 */
function view($tpl_name, array $data = [])
{
    $main_tpl = __DIR__ . "/../view/{$tpl_name}.html.tpl";

    if (!file_exists($main_tpl)) {
        throw new \RuntimeException("Template file not exists: {$tpl_name}");
    }

    return function () use ($tpl_name, $data) {
        $data = [
            'features' => Features::fromArray($_SESSION['features']),
        ] + $data;

        return twig()->render("{$tpl_name}.html.tpl", $data);
    };
}

/**
 * @return \Whoops\Run
 */
function whoops()
{
    /** @var \Whoops\Run */
    static $whoops;

    if ($whoops === null) {
        $whoops = new \Whoops\Run;
    }

    return $whoops;
}

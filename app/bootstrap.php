<?php
/**
 * Application bootstrap.
 *
 * Every entry point requires this file and receives a configured App. BASE_DIR
 * is the only path that matters: if the hosting account allows the application
 * to live outside the document root, moving app/, config/, database/, storage/
 * and resources/ together and repointing BASE_DIR is the whole change.
 */

declare(strict_types=1);

use Mktr\Core\App;
use Mktr\Core\Autoloader;
use Mktr\Core\Config;
use Mktr\Core\Lang;
use Mktr\Core\Request;
use Mktr\Core\Router;
use Mktr\Core\Session;
use Mktr\Core\View;

if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__));
}

require BASE_DIR . '/app/Core/Autoloader.php';

$autoloader = new Autoloader();
$autoloader->addNamespace('Mktr', BASE_DIR . '/app');
$autoloader->register();

require BASE_DIR . '/app/Support/helpers.php';

Config::setPath(BASE_DIR . '/config');
View::setPath(BASE_DIR . '/app/Views');
Lang::setPath(BASE_DIR . '/resources/lang');

date_default_timezone_set((string) Config::get('app.timezone', 'Asia/Jakarta'));
mb_internal_encoding('UTF-8');

// Errors are logged, never printed, unless debug is on. The legacy site ran
// with display_errors On in production.
$debug = (bool) Config::get('app.debug', false);
ini_set('display_errors', $debug ? '1' : '0');
error_reporting(E_ALL);

Session::start();

$request = Request::capture();
$router  = new Router();

$registerRoutes = require BASE_DIR . '/config/routes.php';
$registerRoutes($router);

return new App($router, $request);

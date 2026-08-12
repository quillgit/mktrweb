<?php
/**
 * Front controller for the rebuilt application.
 *
 * Served from /v2 while the legacy site continues to run at the document root.
 * At cutover this file moves to the root and config/app.php's base_path
 * becomes ''.
 */

declare(strict_types=1);

define('BASE_DIR', dirname(__DIR__));

/** @var \Mktr\Core\App $app */
$app = require BASE_DIR . '/app/bootstrap.php';

$app->handle()->send();

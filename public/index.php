<?php
/*
 * Copyright (c) 2022 Sura
 *
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 *
 */

declare(strict_types=1);

use Mozg\Mozg;

if (\version_compare(PHP_VERSION, '8.1.5') < 0) {
    throw new \RuntimeException('Please change php version');
}
if (isset($_POST['PHPSESSID'])) {
    \session_id($_POST['PHPSESSID']);
}
\session_start();
\ob_start();
\ob_implicit_flush(false);
const ROOT_DIR = __DIR__ . '/../';
const ENGINE_DIR = ROOT_DIR . '/system';
try {
    require __DIR__ . '/../vendor/autoload.php';
} catch (\Error) {
    throw new \RuntimeException('Please install composer');
}

/** Initialize */
try {
    (new Mozg())::initialize();
} catch (JsonException $e) {
} catch (\Mozg\exception\ErrorException $e) {
}



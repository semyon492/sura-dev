<?php
/*
 * Copyright (c) 2022 Tephida
 *
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 *
 */

namespace Mozg;

use Tephida\Corner\Error;
use Mozg\exception\ErrorException;
use FluffyDollop\Http\Request;
use JsonException;
use FluffyDollop\Support\{Registry, Router};
use Mozg\classes\{I18n, DB};

class Mozg
{
    /**
     * @throws ErrorException|JsonException
     */
    public static function initialize(): mixed
    {
        if (isset($_POST['PHPSESSID'])) {
            \session_id($_POST['PHPSESSID']);
        }

//        $db = require ENGINE_DIR . '/data/db_config.php';
//        Registry::set('db', $db);

//        $checkLang = I18n::getLang();
        $lang = I18n::dictionary();
        Registry::set('lang', $lang);

//        $config = settings_get();
        Registry::set('server_time', \time());
        (new classes\Auth)->login();
//        if ($config['offline'] === 'yes') {
//            include ENGINE_DIR . '/modules/offline.php';
//        }
        /** @var array $user_info */
        $user_info = Registry::get('user_info');
//        if ($user_info['user_delet'] > 0) {
//            include_once ENGINE_DIR . '/modules/profile_delet.php';
//        }
//        if ((Registry::get('logged') && $user_info['user_ban_date'] >= Registry::get('server_time')) || (Registry::get('logged') && ($user_info['user_ban_date'] === '0'))) {
//            include_once ENGINE_DIR . '/modules/profile_ban.php';
//        }

        /**
         * Если юзер авторизован,
         * то обновляем последнюю дату посещения в таблице друзей и на личной стр
         */
        if (Registry::get('logged')) {
            //Начисления 1 убм.
            if (empty($user_info['user_lastupdate'])) {
                $user_info['user_lastupdate'] = 1;
            }
            $server_time = Registry::get('server_time');
            //Определяем устройство
            $device_user = 0;
            if (empty($user_info['user_last_visit'])) {
                $user_info['user_last_visit'] = $server_time;
            }

            if (($user_info['user_last_visit'] + 60) <= $server_time) {
                if (\date('Y-m-d', $user_info['user_lastupdate']) < \date('Y-m-d', $server_time)) {
                    DB::getDB()->update('users', [
                        'user_logged_mobile' => $device_user,
                        'user_last_visit' => $server_time,
                        'user_balance' => 'user_balance + 1',
                        'user_lastupdate' => $server_time,
                    ], [
                        'user_id' => $user_info['user_id']
                    ]);
                } else {
                    DB::getDB()->update('users', [
                        'user_logged_mobile' => $device_user,
                        'user_last_visit' => $server_time,
                    ], [
                        'user_id' => $user_info['user_id']
                    ]);
                }
            }
        }

        $router = Router::fromGlobals();
        $params = [];
        $routers = [
            '/' => 'Home@main',

            '/register/send' => 'Register@send',
            '/register/rules' => 'Register@rules',
            '/register/step2' => 'Register@step2',
            '/register/step3' => 'Register@step3',
            '/register/activate' => 'Register@activate',
            '/register/finish' => 'Register@finish',
            '/login' => 'Register@login',

            '/u:num' => 'Profile@main',
            '/u:numafter' => 'Profile@main',

            '/public:num' => 'Communities@main',

            //restore
            '/restore' => 'Restore@main',
            '/restore/next' => 'Restore@next',
            '/restore/next/' => 'Restore@next',
            '/restore/send' => 'Restore@send',
            '/restore/prefinish' => 'Restore@preFinish',

            '/wall:num' => 'WallPage@main',
            '/wall:num_:num' => 'WallPage@main',

            '/security/img' => 'Captcha@captcha',
            '/security/code' => 'Captcha@code',

            '/langs/box' => 'Lang@main',
            '/langs/change' => 'Lang@change',

            '/balance' => 'Balance@main',
            '/balance/payment_2' => 'Balance@payment_2',
            '/balance/ok_payment' => 'Balance@ok_payment',

            '/balance/payment' => 'Balance@createOrderBox',//1
            '/pay/test/create/' => 'Balance@payCreateTest',//2
            '/pay/fkw/create/' => 'Balance@payCreateFkw',//2
            '/pay/test/' => 'Balance@payMain',//3
            '/pay/test/success/' => 'Balance@payTestSuccess',//4
            '/pay/fw/check/' => 'Balance@checkFWKassa',
            '/pay/fw/success/' => 'Balance@main',//4
            '/pay/fkw/success/' => 'Balance@main',//4
            '/pay/fw/bad/' => 'Balance@main',//4
            '/pay/fkw/bad/' => 'Balance@main',//4

            '/support' => 'Support@main',

            '/messages' => 'Im@main',

            '/settings' => 'Settings@main',
            '/wall/send' => 'Wall@sendRecord',

            '/updates' => 'Updates@main',
            '/search' => 'Search@main',
            '/news' => 'News@main',

            '/editprofile/delete/photo' => 'Editprofile@deletePhoto',
            '/editmypage' => 'Editprofile@main',

            '/admin/' => 'Admin@main',
        ];
        $router->add($routers);

        if ($router->isFound()) {
            $router->executeHandler($router::getRequestHandler(), $params);
        } else {
            //todo update
            $module = isset($_GET['go']) ?
                htmlspecialchars(strip_tags(stripslashes(trim(urldecode($_GET['go']))))) : 'main';
            $action = (new Request)->filter('act');
            $class = ucfirst($module);
            if (!class_exists($class) || $action === '' || $class === 'Wall') {
                $text = 'error 500';
                $params = [
                    'title' => 'error 500',
                    'text' => $text,
                ];
                view('info.info', $params);
            } else {
                $controller = new $class();
                $params['params'] = '';
                $params = [$params];
                try {
                    return call_user_func_array([$controller, $action], $params);
                } catch (Error $error) {
                    $params = [
                        'title' => 'error 500',
                        'text' => 'error 500',
                    ];
                    view('info.info', $params);
                }
            }
        }
        return '';//fixme
    }
}

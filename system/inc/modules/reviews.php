<?php

/*
 * Copyright (c) 2022 Tephida
 *
 *  For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 *
 */

echoheader();

//Отправляем на сайт
if ($_GET['act'] === 'ok') {

    $id = (int)$_GET['id'];

    $db->query("UPDATE `reviews` SET approve = '0' WHERE id = '{$id}'");

    header("Location: ?mod=reviews&approve=1");

}

//Удаление
if ($_GET['act'] === 'del') {

    $id = (int)$_GET['id'];

    $db->query("DELETE FROM `reviews` WHERE id = '{$id}'");

    header("Location: ?mod=reviews");

}

$page = (new \FluffyDollop\Http\Request)->int('page', 1);
$gcount = 20;
$limit_page = ($page - 1) * $gcount;

$approve = (int)$_GET['approve'];

if ($approve) {
    $where_sql = "AND tb1.approve = 1";
} else {
    $where_sql = null;
}

$sql_ = $db->super_query("SELECT tb1.*, tb2.user_search_pref FROM `reviews` tb1, `users` tb2 WHERE tb1.user_id = tb2.user_id {$where_sql} ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", true);

$where_sql = str_replace('AND tb1.', 'WHERE ', $where_sql);
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `reviews` {$where_sql}");

if ($approve) {

    echo '<a href="?mod=reviews">Показать все отзывы</a>';

} else {

    echo '<a href="?mod=reviews&approve=1">Показать отзывы ожидающих проверху</a>';

}

if ($sql_) {

    foreach ($sql_ as $row) {

        $row['text'] = stripslashes($row['text']);

        $row['date'] = langdate('j F Y в H:i', $row['date']);

        if ($row['approve']) $moder_lnk = '<a href="?mod=reviews&act=ok&id=' . $row['id'] . '">Отправить на сайт</a>';
        else $moder_lnk = '&nbsp;';

        echo <<<HTML
<div style="padding-bottom:10px;padding-top:10px;border-top:1px solid #f0f0f0;margin-top:5px">
<div><a href="/u{$row['user_id']}" target="_blank"><b>{$row['user_search_pref']}</b></a> <span style="color:#777;float:right">{$row['date']}</span></div>
<div>{$row['text']}</div>
<div>{$moder_lnk} <a href="?mod=reviews&act=del&id={$row['id']}" style="float:right">Удалить</a></div>
</div>
HTML;

    }

} else
    echo '<div style="font-size:13px;color:#555;text-align:center;padding:50px">Ничего не найдено.</div>';

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?' . $query_string . '&page=');

echohtmlend();
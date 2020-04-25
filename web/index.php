<?php
error_reporting(NULL);
$TAB = 'MAIL';

// Main include
include($_SERVER['DOCUMENT_ROOT'] . "/inc/main.php");

function list_mail_acc($domain) {
    global $user;
    $_GET['domain'] = $domain;

    $data = Vesta::exec("v-list-mail-accounts",$user, $_GET['domain'], 'json');
    ksort($data);

    //render_page($user, $TAB, 'list_mail_acc');
    include(__DIR__ . "/templates/list_mail_acc.php");
    unset($_GET['domain']);
}

// Data & Render page
$data = Vesta::exec("v-list-mail-domains", $user, 'json');
ksort($data);

Vesta::render("/templates/list_mail.php", ['plugin' => 'single-mail-list', 'data' => $data]);

// Back uri
$_SESSION['back'] = $_SERVER['REQUEST_URI'];

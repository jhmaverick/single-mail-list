<?php
error_reporting(NULL);
$TAB = 'MAIL';

// Main include
include($_SERVER['DOCUMENT_ROOT'] . "/inc/main.php");
include($_SERVER['DOCUMENT_ROOT'] . "/inc/plugins-helper.php");

function list_mail_acc($domain) {
    global $user;
    $_GET['domain'] = $domain;

    exec (VESTA_CMD."v-list-mail-accounts ".$user." ".escapeshellarg($_GET['domain'])." json", $output, $return_var);
    $data = json_decode(implode('', $output), true);
    $data = array_reverse($data, true);
    unset($output);

    //render_page($user, $TAB, 'list_mail_acc');
    include(__DIR__ . "/templates/list_mail_acc.php");
    unset($_GET['domain']);
}

// Data & Render page
exec(VESTA_CMD . "v-list-mail-domains $user json", $output, $return_var);
$data = json_decode(implode('', $output), true);
$data = array_reverse($data, true);
unset($output);

render_template(__DIR__ . "/templates/list_mail.php", ['data' => $data], ['tab' => $TAB]);

// Back uri
$_SESSION['back'] = $_SERVER['REQUEST_URI'];

<?php
// Init
error_reporting(NULL);
ob_start();
session_start();

include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Check token
if ((!isset($_POST['token'])) || ($_SESSION['token'] != $_POST['token'])) {
    header('location: /login/');
    exit();
}

$account = $_POST['account'];
$action = $_POST['action'];

if (!empty($account)) {
    switch ($action) {
        case 'delete': $cmd='v-delete-mail-account';
            break;
        case 'suspend': $cmd='v-suspend-mail-account';
            break;
        case 'unsuspend': $cmd='v-unsuspend-mail-account';
            break;
        default: header("Location: /plugins/vestacp-mail-list/"); exit;
    }

    foreach ($account as $domain => $accounts) {
        foreach ($accounts as $value) {
            // Mail Account
            $value = escapeshellarg($value);
            $dom = escapeshellarg($domain);
            exec (VESTA_CMD.$cmd." ".$user." ".$dom." ".$value, $output, $return_var);
            $restart = 'yes';
        }
    }
}

header("Location: /plugins/vestacp-mail-list/");
exit;


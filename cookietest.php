<?php // cookietest.php require_once from common.php

if ( $_SERVER['PHP_SELF'] == "/login/cookietest.php" )
{
    header("Location: index.php");
    die;
}



if(isset($_COOKIE['RememberMe']))
{
    checkcookietokenandupdate($_COOKIE['RememberMeCookie'], $db);
}
/*
elseif ( $_SERVER['PHP_SELF'] != "/login/index.php" )
{
    header("Location: index.php");
    die;
}    


?>

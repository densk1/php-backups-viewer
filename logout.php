<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // We remove the user's data from the session 
    unset($_SESSION['user']); 
    unset($_SESSION);
    setcookie('RememberMeCookie',"",1,"/","example.com",true,true);
     
    // We redirect them to the login page 
    header("Location: /login"); 
    die("Redirecting to: /login");

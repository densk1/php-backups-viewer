<?php //functions.php


// if URL is functions.php redirect to index

if ( $_SERVER['PHP_SELF'] == "/login/functions.php" )
{
    header ("Location: index.php");
    die;
}


function dbfetch($db,$query,$query_params=[])
    {
        //try
        //{
        $stmt = $db->prepare($query); 
        $stmt->execute($query_params);
        //}
        //catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); } 
        return $stmt->fetch();
    }

function dbfetchColumn($db,$query,$query_params=[])
    {
        //try
        //{
        $stmt = $db->prepare($query); 
        $stmt->execute($query_params);
        //}
        //catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); } 
        return $stmt->fetchColumn();
    }

function dbfetchAll($db,$query,$query_params=[])
    {
        //try
        //{
        $stmt = $db->prepare($query); 
        $stmt->execute($query_params);
        //}
        //catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); } 
        return $stmt->fetchAll();
    }

function dbinsert($db,$query,$query_params=[])
    {
        //try
        //{
        $stmt = $db->prepare($query)->execute($query_params);  
        //$stmt = $db->prepare($query); 
        //$stmt->execute($query_params);
        return $stmt;
        //}
        //catch(PDOException $ex) { die("Failed to run query: " . $ex->getMessage()); } 
        //$stmt->fetchAll();
    }

function generateToken($length = 20)
    {
        return bin2hex(random_bytes($length));
    }

function createnewloginCookie($userid, $db)
{
  
    $email = $userid; // = $_SESSION['user']['email'];
    //$currentdomain = $_SERVER['HTTP_HOST'];
    $Selector = md5(date('Ydmhis', time()).$email);
    $newToken = generateToken();
    $cookiedata = $Selector.":".$newToken;
    setcookie('RememberMeCookie',$cookiedata,time()+(3600*24*15),"/","example.com",true,true);
    $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
    $tokenhash = hash('sha256', $newToken . $salt); 
    for($round = 0; $round < 65536; $round++) 
    { 
        $tokenhash = hash('sha256', $tokenhash . $salt); 
    }    
    $query = " INSERT INTO RememberMe(email,Selector,RememberHash,RememberSalt) VALUES (:email, :Selector, :RememberHash, :RememberSalt) ";
    $query_params = array ( ':email' => $email ,':Selector' => $Selector , ':RememberHash' => $tokenhash, ':RememberSalt' => $salt );

    dbinsert($db,$query,$query_params);

}




// Working to here

function checkcookietokenandupdate($cookieraw, $db)
{
    $CookieExtracted = explode(":", $cookieraw);
    $Selector = $CookieExtracted[0];
    $Validator = $CookieExtracted[1];
    $query = " SELECT email, Selector, RememberHash, RememberSalt FROM RememberMe WHERE Selector = :Selector ";
    $query_params = array( 'Selector' => $Selector );


    $row = dbfetch($db,$query,$query_params);

    if ($row)
    {
        $check_token = hash('sha256', $Validator . $row['RememberSalt']); 
        for($round = 0; $round < 65536; $round++) 
        { 
            $check_token = hash('sha256', $check_token . $row['RememberSalt']); 
        } 
        if ($check_token === $row['RememberHash'])
        {
            $_SESSION['user']['email'] = $row['email'];
            $newToken = generateToken();
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
            $tokenhash = hash('sha256', $newToken . $salt); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $tokenhash = hash('sha256', $tokenhash . $salt); 
            }
            $query = " UPDATE RememberMe SET RememberHash = :RememberHash, RememberSalt = :RememberSalt WHERE Selector = :Selector ";
            $query_params = array ( ':RememberHash' => $tokenhash,':RememberSalt' => $salt, ':Selector' => $Selector );
            
            $UpdateToken = dbinsert($db,$query,$query_params);
            if ($UpdateToken)
            {
                
                $cookiedata =  $Selector.":".$newToken;
                setcookie('RememberMeCookie',$cookiedata,time()+(3600*24*15),"/","example.com",true,true);
            }
            if ( $_SERVER['PHP_SELF'] == "/login/index.php" )
            {
                header("Location: private");
                die;
            }
        
        }
        else // If token's don't match
        {
           if ( $_SERVER['PHP_SELF'] != "/login/index.php" )
                {
                setcookie('RememberMeCookie',"",1,"/","example.com",true,true);
                header("Location: index.php");
                die;
                }
        }
    }
    else
    {
        if ( $_SERVER['PHP_SELF'] != "/login/index.php" )
        {
            setcookie('RememberMeCookie',"",1,"/","example.com",true,true);
            header("Location: index.php");
            die;
        }
    }
    
}


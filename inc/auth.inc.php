<?php
if (isset($_GET['logout']) && $_GET['logout']=="1") {    
    log_me_out(); 
}

if (basename($_SERVER['SCRIPT_NAME'])!='login.php') {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id']=="") {
        $login_msg = "Please Login First.";

        if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name]!="") {
            $login_detail = json_decode($_COOKIE[$cookie_name]);


            $sql = "SELECT * FROM `auth` WHERE `username` = '$login_detail->username'";
            $data = mysqli_query($con, $sql);
            $result = mysqli_fetch_assoc($data);


            if (!$result && empty($result)) {
                log_me_out();
            }

            if ($result['password']!=$login_detail->password) {
                log_me_out();
            }

            $_SESSION['user_id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['password'] = $result['password'];    



        }
        else{
            log_me_out($login_msg);
        }
    } 

} 
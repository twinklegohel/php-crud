<?php

 include_once('inc/config.php');

if (isset($_POST['action'])) {

    //$url= get_site_url('add_edit_user.php?action=edit&user_id=1&success=User Insert Succesfully.');
    $action = (isset($_POST['action']) && $_POST['action']=="add") ? "add" : "edit";    
    $url= get_site_url('add_edit_user.php?action='.$action);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $age = $_POST['age'];
    $status = (isset($_POST['status']) && $_POST['status']==1) ? 1 : 0;
    $address = $_POST['address'];    
    
    if ($_POST['action']=="add") {
        
        $sql = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `phone_number`, `age`, `address`, `status`, `create_date`) VALUES ('$first_name','$last_name','$email','$phone_number','$age','$address','$status',NOW())";        
        $data = mysqli_query($con, $sql);
        $last_user_id = mysqli_insert_id($con);
        $url=str_replace("=add","=edit",$url);        
        $url.='&user_id='.$last_user_id.'&success=User Insert Succesfully.';
        header('location:'.$url);
        die();
    }
}
if (isset($_GET['action'])) {
    
    if ($_GET['action']=='edit') {
        $user_id = $_GET['user_id'];
        $sql = "SELECT * FROM `users` WHERE `id`= '$user_id'";
        $data = mysqli_query($con, $sql);
        $result = mysqli_fetch_assoc($data);        
    }
}
else {
    $sql = "SELECT * FROM `users`";
    $data = mysqli_query($con, $sql);
}
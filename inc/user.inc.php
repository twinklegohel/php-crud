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
   
    if ($_POST['action']=="edit" && isset($_POST['user_id']) && $_POST['user_id']!='') {
        $user_id = $_POST['user_id'];
        $sql = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`email`='$email',`phone_number`='$phone_number',`age`='$age',`address`='$address',`status`='$status',`update_date`=NOW() WHERE `id` = $user_id";  
        $data = mysqli_query($con, $sql);
        $url.='&user_id='.$user_id.'&success=User Update Succesfully.';
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

    if ($_GET['action']=='status' && isset($_GET['user_id']) && $_GET['user_id']!='') {
        $user_id = $_GET['user_id'];
        $user_status = (isset($_GET['user_status']) && $_GET['user_status']==1) ? 0 : 1;
        $sql = "UPDATE `users` SET `status`='$user_status',`update_date`=NOW() WHERE `id` = $user_id";
        $data = mysqli_query($con, $sql);
        $url=get_site_url('user.php?success=Status update successfully.');
        header('location:'.$url);        
    }
   
    if ($_GET['action']=='delete' && isset($_GET['user_id']) && $_GET['user_id']!='') {
        $user_id = $_GET['user_id'];        
        $sql = "DELETE FROM `users` WHERE `id` = $user_id";
        $data = mysqli_query($con, $sql);
        $url=get_site_url('user.php?success= user deleted successfully.');
        header('location:'.$url);
    }

    
}
else {
    
     $limit = 1;
    $offset = 0;
    $sql = "SELECT COUNT(*) AS total FROM `users`";
    $data = mysqli_query($con, $sql);
    $total = mysqli_fetch_assoc($data);    
    $total = $total['total'];
    $total_page = $total / $limit;
    if (is_float($total_page)) {
        $total_page = (int)$total_page+1;
    }
    $current_page = (isset ($_GET['page']) && $_GET['page']!='') ? $_GET['page'] : 1;
    $prev_page_url = $next_page_url = "#";
    if ($current_page>1) {
        $prev_page = $current_page-1;
        $prev_page_url = get_site_url('user.php?page='.$prev_page);
    }
    if ($current_page<$total_page) {
        $next_page = $current_page+1;
        $next_page_url = get_site_url('user.php?page='.$next_page);
    }
    if ($current_page>1) {
       $offset = ($current_page-1)*$limit;
    }
    
    $sql = "SELECT * FROM `users` LIMIT $limit OFFSET $offset";
    $data = mysqli_query($con, $sql);
} 
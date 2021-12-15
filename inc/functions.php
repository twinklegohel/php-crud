<?php
function get_site_url($path = ""){
    global $site_url;
    return $site_url.$path;
}

function site_url($path = ""){
    echo get_site_url($path);
}

function get_assets_url($path = ""){
    global $assets_url;
    return $assets_url.$path;
}

function assets_url($path = ""){
    echo get_assets_url($path);
}
function log_me_out($logoutmsg = "Logout Successfully."){
    global $cookie_name;
    setcookie($cookie_name, null, -1, '/');
    session_unset();
    session_destroy();
    $url = get_site_url('login.php?login='.$logoutmsg);
    header('location:'.$url);   
} 
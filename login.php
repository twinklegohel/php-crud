<?php include_once ('inc/config.php'); 

if (isset($_POST['login']) && $_POST['login']=="yes") {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $errors = array();
    if ($username == "") {
        $errors[] = "username=Username is null.";
    }

    if ($password == "") {
        $errors[] = "password=Password is null.";
    }

    if (!empty($errors)) {
        $url_arg = implode("&",$errors);
        $url = get_site_url('login.php?'.$url_arg);
        header('location:'.$url);
        die();
        
    }
    
    $sql = "SELECT * FROM `auth` WHERE `username` = '$username'";
    $data = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($data);
    
    
    if (!$result && empty($result)) {
        $url=get_site_url("login.php?username=Username is incorrect.");
        header('location:'.$url);
        die();
    }

    if ($result['password']!=md5($password)) {
        $url=get_site_url("login.php?password=Password is incorrect.");
        header('location:'.$url);
        die();
    }

    $_SESSION['user_id'] = $result['id'];
    $_SESSION['username'] = $result['username'];
    $_SESSION['password'] = $result['password'];

    if (isset($_POST['remember_me']) && $_POST['remember_me']=="yes") {
        global $cookie_name;
        $login_value = array(
            'username' => $result['username'],
            'password' => $result['password'],
        );
        setcookie($cookie_name, json_encode($login_value), time() + (86400 * 30), "/"); // 86400 = 1 day
    }
    
    $url=get_site_url("index.php");
    header('location:'.$url);

    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?php assets_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php assets_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <?php
                                        foreach ($_GET as $key => $value) {
                                    ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $value ?>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                placeholder="user">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-user" id="exampleInputPassword"
                                                placeholder="Password">
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember_me" value="yes"
                                                    class="custom-control-input" id="customCheck">

                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="login" value="yes"
                                            class="btn btn-primary btn-user btn-block">
                                            Login

                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php assets_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?php assets_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php assets_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php assets_url('js/sb-admin-2.min.js') ?>"></script>

</body>

</html>
<?php
session_start();
include "config.php";
include "./assets/components/login-arc.php";

if(isset($_COOKIE['logindata']) && $_COOKIE['logindata'] == $key['token'] && $key['expired'] == "no"){
    $_SESSION['IAm-logined'] = 'yes';
	header("location: panel.php");
}

elseif(isset($_SESSION['IAm-logined'])){
	header('location: panel.php');
	exit;
}

else{ 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #000;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            overflow: hidden;
        }

        .wrapper {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            border: 1px solid #fff;
            text-align: center;
            width: 100%;
            max-width: 400px;
            transition: all 0.3s ease;
        }

        .wrapper:hover {
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
        }

        .title h1 {
            font-size: 24px;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .form-signin {
            margin-top: 20px;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 1px solid #fff;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.3);
            border-color: #fff;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.25);
        }

        .btn-primary {
            background-color: #000;
            border-color: #fff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #fff;
            color: #000;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .error-message {
            color: red;
            margin-top: 15px;
        }
    </style>
</head>
<body>
  <div class="wrapper">
    <div class="title">
      <h1>Login</h1>
    </div>
    <form action="" class="form-signin" method="POST">
      <h2 class="form-signin-heading">Please login</h2>
      <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" /><br>
      <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
      <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

      <?php
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['username']) && isset($_POST['password'])){
          $username = $_POST['username'];
          $password = $_POST['password'];

          if(isset($CONFIG[$username]) && $CONFIG[$username]['password'] == $password){
            $_SESSION['IAm-logined'] = $username;
            echo '<script>location.href="panel.php"</script>';
          } else {
            echo '<p class="error-message">Username or password is incorrect!</p>';
          }
        }
      }
      ?>
    </form>
  </div>
</body>
</html>


<?php
}
?>

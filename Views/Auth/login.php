<?php 
require_once '../../Models/user.php';
require_once '../../Controllers/AuthController.php';
$errMsg="";
session_start();
if(isset($_GET["logout"]))
{
  session_start();
  session_unset();
  session_destroy();
  header("location: ../Auth/login.php");

}
if(isset($_POST['email']) && isset($_POST['password']))
{
    if(!empty($_POST['email']) && !empty($_POST['password']) )
    {   
        $user=new User;
        $auth=new AuthController;
        $user->email=$_POST['email'];
        $user->password=$_POST['password'];
        if(!$auth->login($user))
        {
            if(!isset($_SESSION["userId"]))
            {
               
            }
            $errMsg=$_SESSION["errMsg"];
        }
        else
        {
            if(!isset($_SESSION["userId"]))
            {
                session_start();
            }
            if($_SESSION["userRole"] =="Admin")
            {
                header("location: ../Admin/index.php");
            }
            else
            {
                header("location:../Eleve/index.php");
            }

        }
    }
    else
    {
        $errMsg="Please fill all fields";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        h4 {
            color: #333;
        }

        h2 {
            color: #007bff;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        p.text-center {
            margin-top: 20px;
            color: #555;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p.error-message {
            color: red;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h4>Welcome to e-Learning!</h4>
    <h2>Login</h2>
    <?php if(!empty($errMsg)){?>
        <p class="error-message"><?php echo $errMsg; ?></p>
    <?php } ?>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email">

        <label for="password">Password:</label>
        <input type="password" name="password">

        <button type="submit">Login</button>
    </form>
    <p class="text-center">
        <span>New on our platform?</span>
        <a href="register.php">
            <span>Create an account</span>
        </a>
    </p>
</div>

</body>
</html>


<?php
require_once '../../Models/user.php';
require_once '../../Controllers/AuthController.php';

if(!isset($_SESSION["userId"]))
{
  session_start();
}
$errMsg="";
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])) 
{
  if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['name'])) 
  {
    $user=new User;
    $auth=new AuthController;
    $user->name=$_POST['name'];
    $user->email=$_POST['email'];
    $user->password=$_POST['password'];
    if($auth->register($user))
    {
      header("location: ../Eleve/index.php");
    }
    else
    {
      $errMsg=$_SESSION["errMsg"];
    }

  }
  else
  {
    $errMsg="Please fill all fields";
  }

}

?>
<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
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

        div {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
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

        p {
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
        body.orange-theme {
    background-color: #9fd3c7;
    color: #FFFFFF; 
  }

  .navbar {
    background-color: #FF6347; 
  }
    </style>
 
</head>

<body class="orange-theme" >

<div>
    <h2>Sign up</h2>

    <form action="register.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name">

        <label for="email">Email:</label>
        <input type="email" name="email">

        <label for="password">Password:</label>
        <input type="password" name="password">

        <button type="submit">Sign up</button>
    </form>
    <p>
        <span>Already have an account?</span>
        <a href="login.php">
            <span>Sign in instead</span>
        </a>
    </p>
</div>

</body>

</html>

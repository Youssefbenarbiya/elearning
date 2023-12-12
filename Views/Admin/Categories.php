<?php
session_start();
if (!isset($_SESSION["userRole"])) {

    header("location:../Auth/login.php ");
} 

require_once '../../Controllers/CourController.php';
require_once '../../Models/category.php';
$CourController = new CourController;
$categories = $CourController->getCategories();
$errMsg = "";


if (isset($_POST['category']) ) {
    if (!empty($_POST['category']) ) {



        $Category = new category;
        $Category->name = $_POST['category'];
    

            if ($CourController->addCategory($Category)) {
                header("location: index.php");
            } else {
                $errMsg = "Something went wrong... try again";
            }
     
    } else {
        $errMsg = "Please fill all fields";
    }
}
if (isset($_POST["delete"])) {
    if (!empty($_POST["id"])) {
        if ($CourController->deleteCategory($_POST["id"])) {
            $deleteMsg = true;
            $cours = $CourController->getAllCours();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Add-Category</title>
    <meta name="description" content="" />

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .navbar {
            background-color: #007bff;
            padding: 10px 20px;
            color: #fff;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #fff;
        }

        .navbar-brand img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }

        .navbar-menu {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-search input {
            border: none;
            padding: 8px;
            border-radius: 5px;
        }

        .navbar-user {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Content */
        .content-wrapper {
            padding: 20px;
        }

        .page-title {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .category-list {
            display: flex;
            flex-wrap: wrap;
        }

        .category-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            text-align: center;
            min-width: 150px;
        }

        .add-category-form {
            margin-top: 20px;
        }

        .form-label {
            color: #333;
            margin-bottom: 10px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .back-button {
            background-color: #ffc107;
            color: #000;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }
        nav {
            background-color: #3498db;
            padding: 10px;
            text-align: center;
            color: #fff;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }

        nav a:last-child {
            margin-left: auto;
        }
    </style>
</head>

<body>
<nav>
        <a href="index.php">Home</a>
        <a href="../Auth/login.php" style="margin-left: 200px;">Logout</a>
    </nav>

    <div class="content-wrapper">
        <h4 class="page-title">Add New Category</h4>
        <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category) { ?>
            <tr>
                <td><?php echo $category["id"]; ?></td>
                <td><?php echo $category["name"]; ?></td>
                <td>
                <form action="Categories.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $category["id"] ?>">
                  <button type="submit" style="background-color: red;" name="delete" class="btn">Delete</button>
                  </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


        <div class="add-category-form">
            <form action="Categories.php" method="post">
                <label class="form-label" for="category">Add category</label>
                <input class="form-input" type="text" name="category" />

                <div>
                    <button type="submit" class="form-button">Add</button>
                    <a href="index.php" class="back-button">Back</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>

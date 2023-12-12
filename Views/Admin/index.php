<?php
session_start();
if (!isset($_SESSION["userRole"])) {
    header("location:../Auth/login.php ");
}

require_once '../../Controllers/CourController.php';
$CourController = new CourController;
$cours = $CourController->getAllCours();
$deleteMsg = false;
if (isset($_POST["delete"])) {
    if (!empty($_POST["courId"])) {
        if ($CourController->deleteCour($_POST["courId"])) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel - Cours Store</title>
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            box-sizing: border-box;
            margin: 0 auto;
            max-width: 800px;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h5 {
            margin: 0;
            font-size: 1.25rem;
        }

        .card-body {
            padding: 20px;
        }

        .btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            color: #721c24;
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5>Cours Store</h5>
                <a href="add-cour.php" class="btn" style='background-color: orange;'>Add New Cours</a>
                <a href="Categories.php" class="btn" style='background-color: orange;'>Add New Category</a>
            </div>
            <div class="card-body">
                <?php if (count($cours) == 0) { ?>
                    <div class="alert" role="alert">No Available Cours</div>
                <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Cours Name</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cours as $cour) { ?>
                                <tr>
                                    <td><strong><?php echo $cour["name"] ?></strong></td>
                                    <td><?php echo $cour["category"] ?></td>
                                    <td>
                                    <a href="edit-cour.php?id=<?php echo $cour["id"]; ?>" class="btn" style="background-color: green;">Update</a>
                                        <form action="index.php" method="POST" style="display: inline-block;">
                                            <input type="hidden" name="courId" value="<?php echo $cour["id"] ?>">
                                            <button type="submit" name="delete" style="background-color: red;" class="btn">Delete</button>
                                        </form>
                                        
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
        <?php if ($deleteMsg == true) { ?>
            <div class="toast" role="alert">
                Deleted Successfully
            </div>
        <?php } ?>
    </div>
</body>
</html>

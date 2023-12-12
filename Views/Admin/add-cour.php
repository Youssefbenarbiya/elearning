<?php
session_start();
if (!isset($_SESSION["userRole"])) {
    header("location:../Auth/login.php ");
}

require_once '../../Controllers/CourController.php';
require_once '../../Models/cour.php';
$CourController = new CourController;
$categories = $CourController->getCategories();
$errMsg = "";

if (
    isset($_POST['name']) &&
    isset($_POST['description']) &&
    isset($_POST['category']) &&
    isset($_FILES["image"]) &&
    isset($_FILES["video"])
) {
    if (
        !empty($_POST['name']) &&
        !empty($_POST['description'])
    ) {
        $Cour = new Cour;
        $Cour->name = $_POST['name'];
        $Cour->description = $_POST['description'];
        $Cour->categoryid = $_POST['category'];

        $locationImage = "../images/" . date("h-i-s") . $_FILES["image"]["name"];
        $locationVideo = "../videos/" . date("h-i-s") . $_FILES["video"]["name"];

        if (
            move_uploaded_file($_FILES["image"]["tmp_name"], $locationImage) &&
            move_uploaded_file($_FILES["video"]["tmp_name"], $locationVideo)
        ) {
            $Cour->image = $locationImage;
            $Cour->video = $locationVideo;

            if ($CourController->addCour($Cour)) {
                header("location: index.php");
            } else {
                $errMsg = "Something went wrong... try again";
            }
        } else {
            $errMsg = "Error in Upload";
        }
    } else {
        $errMsg = "Please fill all fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Add-Cour</title>

    <meta name="description" content="" />

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .layout-container {
            flex: 1;
            display: flex;
        }

        .layout-menu {
            width: 200px;
            background-color: #333;
            color: #fff;
        }

        .app-brand {
            padding: 20px;
            text-align: center;
        }

        .menu-inner {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu-item {
            padding: 10px;
        }

        .menu-link {
            text-decoration: none;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .menu-icon {
            margin-right: 10px;
        }

        .layout-page {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .layout-navbar {
            padding: 10px;
            background-color: #333;
            color: #fff;
        }

        .content-wrapper {
            flex: 1;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            background-color: #f0f0f0;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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

<body class="dark-theme">
    <nav>
        <a href="index.php">Home</a>
        <a href="../Auth/login.php" style="margin-left: 200px;">Logout</a>
    </nav>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="25" viewBox="0 0 25 42">
                                <!-- SVG content -->
                            </svg>
                        </span>
                        <a href="index.php"> E-Learning </a>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Tables -->
                    <li class="menu-item active">
                        <a href="index.html" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-table"></i>
                            <a href="index.php"> Cours </a><br><br><br>
                            <a href="Categories.php"> Categories </a>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <!-- Navbar content -->
                </nav>
                <!-- / Navbar -->

                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4">Add New Cour</h4>
                        <div class="row">
                            <div class="col-xxl">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Cour Details</h5>
                                        <?php
                                        if ($errMsg != "") {
                                        ?>
                                            <div class="alert alert-danger" role="alert"><?php echo $errMsg ?></div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="card-body">
                                        <form action="add-cour.php" method="post" enctype='multipart/form-data'>
                                            <div class="form-group">
                                                <label for="basic-icon-default-fullname">Cour Name</label>
                                                <input type="text" class="form-control" id="basic-icon-default-fullname" name="name" placeholder="Like : Linux" />
                                            </div>
                                            <div class="form-group">
                                                <label for="basic-icon-default-company">Cour Description</label>
                                                <textarea id="basic-icon-default-message" class="form-control" placeholder="What about this Cour?" name="description"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="basic-icon-default-phone">Category</label>
                                                <select id="largeSelect" class="form-select form-select-lg" name="category">
                                                    <?php
                                                        foreach ($categories as $category) {
                                                    ?>
                                                      <option value="<?php echo $category["id"] ?>"><?php echo $category["name"] ?></option>
                                                       <?php
                                                       }
                                                      ?>
                                                        </select>
                                                        </div>
                                                        <div class="form-group">
                                                             <label for="basic-icon-default-message">Image</label>
                                                              <input class="form-control" type="file" id="formFile" name="image" />
                                                        </div>
                                                        <div class="form-group">
                                                             <label for="basic-icon-default-message">Video</label>
                                                              <input class="form-control" type="file" id="formVideo" name="video" />
                                                               </div>
                                                               <div class="col-sm-10">
                                                                      <button type="submit" class="btn btn-primary">Add</button>
                                                                         <a href="index.php" class="btn btn-warning">Back</a>
                                                                                                       
                                                                        </div>
                                                                                                   
                                                                    </div>
                                                                                               
                                                                </form>
                                                                                          
                                                            </div>
                                                                                       
                                                        </div>
                                                                                 
                                                    </div>
                                                                              
                                                </div>
                                                                         
                                            </div>
                                                                      
                                        </div>
                                                                  
                                    </div>
                                                                
                                                                
                                                                </div>
                                                           
                                                            </div>
                                                       
                                                        
                                                        </body>
                                                        
                                                       
                                                        </html>                                                                                                           <div class="row justify-content-end">
                                                                                                       
                                                        

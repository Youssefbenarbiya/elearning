<?php
session_start();
if (!isset($_SESSION["userRole"]) || $_SESSION["userRole"] != "eleve") {
    header("location:../Auth/login.php ");
}

require_once '../../Controllers/CourController.php';
$CourController = new CourController;
$categories = $CourController->getCategories();

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $Cours = $CourController->searchCoursByName($searchTerm);
} else {

    $Cours = $CourController->getAllCoursWithImages();
}

$errMsg = "";
?><!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <style>
        body {
            background-color: #9fd3c7;
            color: #FFFFFF;
            margin: 0;
            padding: 0;
        }

        .container {
            box-sizing: border-box;
        }

        .card {
            margin-bottom: 15px;
        }

        .search-container {
            text-align: right;
            margin-bottom: 15px;
        }

        .search-box {
            width: 200px;
            padding: 8px;
            box-sizing: border-box;
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
        <!-- Search bar -->
        <div class="search-container">
            <form action="index.php" method="GET">
                <input type="text" name="search" class="search-box" placeholder="Search by course name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <h4 class="fw-bold py-3 mb-4" style="color: black;">Cours</h4>

        <div class="row">
            <?php foreach ($Cours as $index => $Cour) : ?>
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $Cour['image'] ?>" width="300px" height="300px" alt="Card image cap" />
                        <div class="card-body">
                            <h5 class="card-title" style="color: black;"><?php echo $Cour['name'] ?></h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter<?php echo $index ?>">
                                Detail
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter<?php echo $index ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
             
                echo isset($Cour['description']) ? $Cour['description'] : 'Description not available';
                ?>
                <br>

                <?php
              
                if (isset($Cour['video'])) {
                    echo '<video width="100%" height="auto" controls>';
                    echo '<source src="' . $Cour['video'] . '" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video>';
                } else {
                    echo 'Video not available';
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>


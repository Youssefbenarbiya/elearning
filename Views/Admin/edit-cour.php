<?php

require_once '../../Controllers/CourController.php';
require_once '../../Models/cour.php';


$courController = new CourController();

if (isset($_GET["id"])) {
    $courId = $_GET["id"];
    $courDetails = $courController->getCourDetailsById($courId);

    if ($courDetails && isset($courDetails[0])) {
        $currentCourName = isset($courDetails[0]["name"]) ? $courDetails[0]["name"] : '';
        $currentDescription = isset($courDetails[0]["description"]) ? $courDetails[0]["description"] : '';
        $currentImage = isset($courDetails[0]["image"]) ? $courDetails[0]["image"] : '';
        $currentVideo = isset($courDetails[0]["video"]) ? $courDetails[0]["video"] : '';
        $currentCategoryId = isset($courDetails[0]["categoryid"]) ? $courDetails[0]["categoryid"] : '';
    } else {
        
        echo "Error: Course not found.";
        exit;
    }
}


if (isset($_POST["update"])) {
  
    $courId = $_POST["courId"];
    $newCourName = $_POST["newCourName"];
    $newDescription = $_POST["newDescription"];

    // Check if a new image file is uploaded
    if (isset($_FILES['newImageFile']) && $_FILES['newImageFile']['size'] > 0) {
        $newImageFile = $_FILES['newImageFile'];
        $uploadDirectory = '../images/'; 
        $uploadedFilePath = $uploadDirectory . basename($newImageFile['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($newImageFile['tmp_name'], $uploadedFilePath)) {
            
            $newImage = $uploadedFilePath;
        } else {
          
            echo "Error uploading file.";
            exit;
        }
    } else {
        
        $newImage = $currentImage;
    }

    // Check if a new video file is uploaded
    if (isset($_FILES['newVideoFile']) && $_FILES['newVideoFile']['size'] > 0) {
        $newVideoFile = $_FILES['newVideoFile'];
        $uploadVideoDirectory = '../videos/'; 
        $uploadedVideoPath = $uploadVideoDirectory . basename($newVideoFile['name']);

        // Move the uploaded video file to the specified directory
        if (move_uploaded_file($newVideoFile['tmp_name'], $uploadedVideoPath)) {
         
            $newVideo = $uploadedVideoPath;
        } else {
          
            echo "Error uploading video.";
            exit;
        }
    } else {
       
        $newVideo = $currentVideo;
    }

    // Get the selected category
    $newCategoryId = $_POST["newCategoryId"];

    // Create a new cour object
    $updatedCour = new Cour();
    $updatedCour->id = $courId;
    $updatedCour->name = $newCourName;
    $updatedCour->description = $newDescription;
    $updatedCour->image = $newImage;
    $updatedCour->video = $newVideo; 
    $updatedCour->categoryid = $newCategoryId;

    $courController->updateCour($updatedCour);

    header("Location: edit-cour.php?id=$courId");
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <style>
           body {
            font-family: Arial, sans-serif;
            background-color: #f0f5f9;
            margin: 0;
            padding: 0;
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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 20px auto;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input,
        textarea,
        button,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #3498db;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }
        .image-preview {
            max-width: 100%;
            margin-bottom: 16px;
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
    <h2>Edit Course</h2>

    <form action="edit-cour.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="courId" value="<?php echo $courId; ?>">
        <label for="newCourName">Course Name:</label>
        <input type="text" name="newCourName" value="<?php echo $currentCourName; ?>" required>
        
        <label for="newDescription">Description:</label>
        <textarea name="newDescription"><?php echo $currentDescription; ?></textarea>
        
        <?php if (!empty($currentImage)) : ?>
            <img src="<?php echo $currentImage; ?>" alt="Current Photo" class="image-preview">
        <?php endif; ?>
        
        <label for="newImageFile">Upload New Image:</label>
        <input type="file" name="newImageFile">
            
        <?php if (!empty($currentVideo)) : ?>
            <p>Current Video: <a href="<?php echo $currentVideo; ?>" target="_blank"><?php echo $currentVideo; ?></a></p>
        <?php endif; ?>
        
        <label for="newVideoFile">Upload New Video:</label>
        <input type="file" name="newVideoFile">

        <label for="newCategoryId">Select Category:</label>
        <select name="newCategoryId" required>
            <?php
         
            $categories = $courController->getCategories();

            // Check if categories are available
            if ($categories) {
                foreach ($categories as $category) {
                    $categoryId = $category['id'];
                    $categoryName = $category['name'];

                    // Check if the category is the current one and mark it as selected
                    $selected = ($currentCategoryId == $categoryId) ? 'selected' : '';

                    echo "<option value='$categoryId' $selected>$categoryName</option>";
                }
            } else {
                echo "<option value=''>No Categories</option>";
            }
            ?>
        </select>
        
        <button type="submit" name="update">Update Course</button>
    </form>
    
</body>
</html>

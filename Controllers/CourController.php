<?php 

require_once '../../Models/cour.php';
require_once '../../Controllers/DBController.php';
class CourController
{
    protected $db;
    
    public function getCategories()
    {
        $this->db = new DBController;
    
        if ($this->db->openConnection()) {
            $query = "SELECT * FROM categories";
            $result = $this->db->connection->query($query);
    
            if ($result) {
                $categories = $result->fetch_all(MYSQLI_ASSOC);
                
                $result->close();
                
                return $categories;
            } else {
                echo "Error in Database Query";
                return false;
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }
    
    public function addCour(Cour $cour)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            
            $query = "INSERT INTO cours (name, description, image, video, categoryid) VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->db->connection->prepare($query);

            $stmt->bind_param("ssssi", $cour->name, $cour->description, $cour->image, $cour->video, $cour->categoryid);

            $success = $stmt->execute();

            $stmt->close();

            return $success;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

    public function addCategory(Category $category)
    {
        $this->db = new DBController;

        if ($this->db->openConnection()) {
            $query = "INSERT INTO categories (name) VALUES (?)";
            $stmt = $this->db->connection->prepare($query);

            $stmt->bind_param("s", $category->name);

            $success = $stmt->execute();

            $stmt->close();

            return $success;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

    public function deleteCategory($id)
    {
        $this->db = new DBController;

        if ($this->db->openConnection()) {
            $query = "DELETE FROM categories WHERE id = ?";
            $stmt = $this->db->connection->prepare($query);

            $stmt->bind_param("i", $id);

            $success = $stmt->execute();

            $stmt->close();
            header("Location: Categories.php");
        exit; 
            return $success;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }


    public function getAllCours()
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            $query="select cours.id,cours.name,categories.name as 'category' from cours,categories where cours.categoryid=categories.id;";
            return $this->db->select($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }
    public function deleteCour($id)
{
    $this->db = new DBController;

    if ($this->db->openConnection()) {
        $query = "DELETE FROM cours WHERE id = ?";
        $stmt = $this->db->connection->prepare($query);

        $stmt->bind_param("i", $id);

        $success = $stmt->execute();

        $stmt->close();

        return $success;
    } else {
        echo "Error in Database Connection";
        return false;
    }
}

    public function updateCour(Cour $cour)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "UPDATE cours SET 
                      name = ?,
                      description = ?,
                      image = ?,
                      video = ?, 
                      categoryid = ?
                      WHERE id = ?";

            $stmt = $this->db->connection->prepare($query);

            $stmt->bind_param("ssssii", $cour->name, $cour->description, $cour->image, $cour->video, $cour->categoryid, $cour->id);

            $success = $stmt->execute();

            $stmt->close();

            return $success;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }
    public function searchCoursByName($searchTerm)
    {
        $this->db = new DBController;

        if ($this->db->openConnection()) {
            $query = "SELECT * FROM cours WHERE name LIKE ?";

            $searchTerm = '%' . $searchTerm . '%';

            $stmt = $this->db->connection->prepare($query);

            $stmt->bind_param("s", $searchTerm);

            $stmt->execute();

            $result = $stmt->get_result();

            $cours = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            $this->db->closeConnection();

            return $cours;
        } else {

            echo "Error in Database Connection";
            return false;
        }
    }



public function getCourDetailsById($id)
{
    $this->db = new DBController;

    if ($this->db->openConnection()) {
        $query = "SELECT * FROM cours WHERE id = $id";
        $courDetails = $this->db->select($query);
        return $courDetails;
    } else {
        echo "Error in Database Connection";
        return false;
    }
}



    public function getAllCoursWithImages()
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            $query="select cours.id,cours.name,cours.description,categories.name as 'category',image,video from cours,categories where cours.categoryid=categories.id;";
            return $this->db->select($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }
    
    
    public function getCategoryCour($id)
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            $query="select cours.id,cours.name,categories.name as 'category',image from cours,categories where cours.categoryid=categories.id and categories.id=$id;";
            return $this->db->select($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }
    
    
}

?>
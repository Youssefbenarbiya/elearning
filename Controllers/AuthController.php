<?php 

require_once '../../Models/user.php';
require_once '../../Controllers/DBController.php';
class AuthController
{
    protected $db;

    public function login(User $user)
    {
        $this->db = new DBController;
        
        if ($this->db->openConnection()) {
            $query = "SELECT * FROM users WHERE email = ? AND password = ?";
            $stmt = $this->db->connection->prepare($query);
    
           
            $stmt->bind_param("ss", $user->email, $user->password);
    
            $stmt->execute();
    
           
            $result = $stmt->get_result();
    
            if ($result === false) {
                echo "Error in Query";
                return false;
            } else {
                $userDetails = $result->fetch_assoc();
    
                if (!$userDetails) {
                    
                    $_SESSION["errMsg"] = "You have entered wrong email or password";
                    $stmt->close();
                    $this->db->closeConnection();
                    return false;
                } else {
                    session_start();
                    $_SESSION["userId"] = $userDetails["id"];
                    $_SESSION["userName"] = $userDetails["name"];
                    $_SESSION["userRole"] = ($userDetails["roleid"] == 1) ? "Admin" : "eleve";
                    $stmt->close();
                    $this->db->closeConnection();
                    return true;
                }
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }
    
    public function register(User $user)
{
    $this->db = new DBController;

    if ($this->db->openConnection()) {
        $query = "INSERT INTO users (name, email, password, roleid) VALUES (?, ?, ?, 2)";
        $stmt = $this->db->connection->prepare($query);

        $stmt->bind_param("sss", $user->name, $user->email, $user->password);

      
        $success = $stmt->execute();

        if ($success) {
            session_start();
            $_SESSION["userId"] = $stmt->insert_id;
            $_SESSION["userName"] = $user->name;
            $_SESSION["userRole"] = "eleve";
            $stmt->close();
            $this->db->closeConnection();
            return true;
        } else {
            session_start();
            $_SESSION["errMsg"] = "Something went wrong... try again later";
            $stmt->close();
            $this->db->closeConnection();
            return false;
        }
    } else {
        echo "Error in Database Connection";
        return false;
    }
}

}

?>
<?php
class AccountModel
{
    private $conn;
    private $table_name = "account";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAccountByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function save($username, $fullName, $email, $password, $role = 'user')
    {
        try {
            // Kiểm tra username và email đã tồn tại
            if ($this->getAccountByUsername($username)) {
                return false;
            }
            if ($this->getAccountByEmail($email)) {
                return false;
            }

            $query = "INSERT INTO " . $this->table_name . " SET 
                      username=:username, 
                      fullname=:fullname, 
                      email=:email, 
                      password=:password, 
                      role=:role";

            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $username = htmlspecialchars(strip_tags($username));
            $fullName = htmlspecialchars(strip_tags($fullName));
            $email = htmlspecialchars(strip_tags($email));
            $password = password_hash($password, PASSWORD_BCRYPT);
            $role = htmlspecialchars(strip_tags($role));

            // Bind parameters
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":fullname", $fullName);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":role", $role);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in AccountModel::save: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfile($username, $fullname, $email, $phone = '', $address = '')
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET 
                      fullname=:fullname, 
                      email=:email, 
 
                      WHERE username=:username";

            $stmt = $this->conn->prepare($query);

            $fullname = htmlspecialchars(strip_tags($fullname));
            $email = htmlspecialchars(strip_tags($email));
            $phone = htmlspecialchars(strip_tags($phone));
            $address = htmlspecialchars(strip_tags($address));
            $username = htmlspecialchars(strip_tags($username));

            $stmt->bindParam(":fullname", $fullname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":username", $username);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in AccountModel::updateProfile: " . $e->getMessage());
            return false;
        }
    }

    public function updatePassword($username, $new_password)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET password=:password WHERE username=:username";

            $stmt = $this->conn->prepare($query);

            $password = password_hash($new_password, PASSWORD_BCRYPT);
            $username = htmlspecialchars(strip_tags($username));

            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":username", $username);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in AccountModel::updatePassword: " . $e->getMessage());
            return false;
        }
    }

    public function getAllUsers()
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error in AccountModel::getAllUsers: " . $e->getMessage());
            return [];
        }
    }

    public function getUserById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Error in AccountModel::getUserById: " . $e->getMessage());
            return false;
        }
    }

    public function createUser($username, $fullName, $email, $password, $role = 'user')
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " SET 
                      username=:username, 
                      fullname=:fullname, 
                      email=:email, 
                      password=:password, 
                      role=:role";

            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $username = htmlspecialchars(strip_tags($username));
            $fullName = htmlspecialchars(strip_tags($fullName));
            $email = htmlspecialchars(strip_tags($email));
            $password = password_hash($password, PASSWORD_BCRYPT);
            $role = htmlspecialchars(strip_tags($role));

            // Bind parameters
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":fullname", $fullName);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":role", $role);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in AccountModel::createUser: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($id, $fullName, $email, $role, $password = '')
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET 
                      fullname=:fullname, 
                      email=:email, 
                      role=:role";

            if (!empty($password)) {
                $query .= ", password=:password";
            }

            $query .= " WHERE id=:id";

            $stmt = $this->conn->prepare($query);

            // Sanitize input
            $fullName = htmlspecialchars(strip_tags($fullName));
            $email = htmlspecialchars(strip_tags($email));
            $role = htmlspecialchars(strip_tags($role));

            // Bind parameters
            $stmt->bindParam(":fullname", $fullName);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":role", $role);
            $stmt->bindParam(":id", $id);

            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt->bindParam(":password", $hashedPassword);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in AccountModel::updateUser: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($id)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error in AccountModel::deleteUser: " . $e->getMessage());
            return false;
        }
    }
}

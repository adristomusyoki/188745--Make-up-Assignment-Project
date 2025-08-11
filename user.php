<?php
require_once __DIR__ . '/dtbs.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO users (Full_Name, email, phone_Number, User_Name, Password, UserType, profile_Image, Address)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $hash = password_hash($data['Password'], PASSWORD_DEFAULT);
        $stmt->bind_param("ssssssss",
            $data['Full_Name'],
            $data['email'],
            $data['phone_Number'],
            $data['User_Name'],
            $hash,
            $data['UserType'],
            $data['profile_Image'],
            $data['Address']
        );
        return $stmt->execute();
    }

    public function getByUsername($username) {
        $sql = "SELECT * FROM users WHERE User_Name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE userId = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data, $changePassword = false) {
        if ($changePassword && !empty($data['Password'])) {
            $sql = "UPDATE users SET Full_Name=?, email=?, phone_Number=?, Password=?, UserType=?, profile_Image=?, Address=? WHERE userId=?";
            $stmt = $this->db->prepare($sql);
            $hash = password_hash($data['Password'], PASSWORD_DEFAULT);
            $stmt->bind_param("sssssssi",
                $data['Full_Name'],
                $data['email'],
                $data['phone_Number'],
                $hash,
                $data['UserType'],
                $data['profile_Image'],
                $data['Address'],
                $id
            );
        } else {
            $sql = "UPDATE users SET Full_Name=?, email=?, phone_Number=?, UserType=?, profile_Image=?, Address=? WHERE userId=?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssssi",
                $data['Full_Name'],
                $data['email'],
                $data['phone_Number'],
                $data['UserType'],
                $data['profile_Image'],
                $data['Address'],
                $id
            );
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE userId = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAll($excludeSuper=false) {
        if ($excludeSuper) {
            $sql = "SELECT * FROM users WHERE UserType <> 'Super_User' ORDER BY userId DESC";
            return $this->db->query($sql);
        }
        $sql = "SELECT * FROM users ORDER BY userId DESC";
        return $this->db->query($sql);
    }

    public function getAuthors() {
        $sql = "SELECT * FROM users WHERE UserType = 'Author' ORDER BY userId DESC";
        return $this->db->query($sql);
    }
}
?>

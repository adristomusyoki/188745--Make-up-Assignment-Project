<?php
// classes/Article.php
require_once __DIR__ . '/dtbs.php';

class Article {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function create($data) {
        $sql = "INSERT INTO articles (authorId, article_title, article_full_text, article_display, article_order)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isssi",
            $data['authorId'],
            $data['article_title'],
            $data['article_full_text'],
            $data['article_display'],
            $data['article_order']
        );
        return $stmt->execute();
    }

    public function getById($id) {
        $sql = "SELECT * FROM articles WHERE articleId = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id, $data) {
        $sql = "UPDATE articles SET article_title=?, article_full_text=?, article_display=?, article_order=? WHERE articleId=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssii",
            $data['article_title'],
            $data['article_full_text'],
            $data['article_display'],
            $data['article_order'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM articles WHERE articleId = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getLastSix() {
        $sql = "SELECT a.*, u.Full_Name FROM articles a LEFT JOIN users u ON a.authorId=u.userId
                WHERE a.article_display = 'yes' ORDER BY a.article_created_date DESC LIMIT 6";
        return $this->db->query($sql);
    }

    public function getAllByAuthor($authorId) {
        $sql = "SELECT * FROM articles WHERE authorId = ? ORDER BY article_created_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $authorId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAll() {
        $sql = "SELECT a.*, u.Full_Name FROM articles a LEFT JOIN users u ON a.authorId=u.userId ORDER BY article_created_date DESC";
        return $this->db->query($sql);
    }
}
?>

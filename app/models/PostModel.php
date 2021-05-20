<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}

require_once __DIR__ . '/Database.php';

class PostModel {
    private $pdo;
    
    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->dbh;
    }

    //insert a new post into database
    public function createPost($data) {
        $stmt = $this->pdo->prepare('INSERT INTO posts (post_title, post_src, id_user, created_at)
                                    VALUES (:post_title, :post_src, :id_user, :created_at)');
        $stmt->bindValue(':post_title', $data['title']);
        $stmt->bindValue(':post_src', $data['src']);
        $stmt->bindValue(':id_user', $data['id_user']);
        $stmt->bindValue(':created_at', $data['created_at']);
        $stmt->execute();
    }

    public function getUserPosts($id) {
        $stmt = $this->pdo->prepare('SELECT id_post FROM posts WHERE id_user = :id_user ORDER BY id_post DESC');
        $stmt->bindValue(':id_user', $id);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        return $posts;
    }

    public function getPostById($id) {
        $stmt = $this->pdo->prepare('SELECT id_post, post_title, post_src, id_user, created_at
                FROM posts WHERE id_post = :id_post');
        $stmt->bindValue(':id_post', $id);
        $stmt->execute();
        $post = $stmt->fetch();
        return $post;
    }

    public function getAuthorById($id) {
        $stmt = $this->pdo->prepare('SELECT username FROM users WHERE id_user = :id_user');
        $stmt->bindValue(':id_user', $id);
        $stmt->execute();
        $author = $stmt->fetch();
        return $author['username'];
    }

    public function getPosts() {
        $stmt = $this->pdo->prepare('SELECT id_post FROM posts ORDER BY id_post DESC');
        $stmt->execute();
        $posts = $stmt->fetchAll();
        return $posts;
    }

    public function getLike($user, $post) {
        $stmt = $this->pdo->prepare('SELECT id_like FROM likes WHERE id_user = :id_user AND id_post = :id_post');
        $stmt->bindValue(':id_user', $user);
        $stmt->bindValue(':id_post', $post);
        $stmt->execute();
        $like = $stmt->fetch();
        if ($like) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function createLike($data) {
        $stmt = $this->pdo->prepare('INSERT INTO likes (id_post, id_user, created_at)
                                    VALUES (:id_post, :id_user, :created_at)');
        $stmt->bindValue(':id_post', $data['id_post']);
        $stmt->bindValue(':id_user', $data['id_user']);
        $stmt->bindValue(':created_at', $data['created_at']);
        $stmt->execute();
    }

    public function deleteLike($data) {
        $stmt = $this->pdo->prepare('DELETE FROM likes WHERE id_user = :id_user AND id_post = :id_post');
        $stmt->bindValue(':id_post', $data['id_post']);
        $stmt->bindValue(':id_user', $data['id_user']);
        $stmt->execute();
    }

    public function createComment($data) {
        $stmt = $this->pdo->prepare('INSERT INTO comments (comment, id_post, id_user, created_at)
                                    VALUES (:comment, :id_post, :id_user, :created_at)');
        $stmt->bindValue(':comment', $data['comment']);
        $stmt->bindValue(':id_post', $data['id_post']);
        $stmt->bindValue(':id_user', $data['id_user']);
        $stmt->bindValue(':created_at', $data['created_at']);
        $stmt->execute();
    }

    public function deletePostLikes($data) {
        $stmt = $this->pdo->prepare('DELETE FROM likes WHERE id_post = :id_post');
        $stmt->bindValue(':id_post', $data['id_post']);
        $stmt->execute();
    }

    public function deletePostComments($data) {
        $stmt = $this->pdo->prepare('DELETE FROM comments WHERE id_post = :id_post');
        $stmt->bindValue(':id_post', $data['id_post']);
        $stmt->execute();
    }

    public function deletePost($data) {
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE id_post = :id_post');
        $stmt->bindValue(':id_post', $data['id_post']);
        $stmt->execute();
    }

    public function getPostLikes($post) {
        $stmt = $this->pdo->prepare('SELECT id_like FROM likes WHERE id_post = :id_post');
        $stmt->bindValue(':id_post', $post);
        $stmt->execute();
        $count = $stmt->fetchAll();
        return count($count);
    }

    public function getPostComments($post) {
        $stmt = $this->pdo->prepare('SELECT id_comment, comment, id_user, created_at FROM comments WHERE id_post = :id_post');
        $stmt->bindValue(':id_post', $post);
        $stmt->execute();
        $count = $stmt->fetchAll();
        return $count;
    }

    /*
    public function getPostViews($post) {
        $stmt = $this->pdo->prepare('SELECT id_like FROM likes WHERE id_post = :id_post');
        $stmt->bindValue(':id_post', $post);
        $stmt->execute();
        $like = $stmt->fetch();
        return $like;
    }*/

    public function getExamplePost($i) {
        $post = array();
        
        $post['name'] = 'Example post #' . $i;
        $post['img'] = 'https://source.unsplash.com/random/?sig=' . $i;
        $post['date'] = date("d M Y", mt_rand(1, time()));

        return ($post);
    }

}

//id_post int NOT NULL PRIMARY KEY AUTO_INCREMENT,
//post_title varchar(255),
//post_src varchar(5000) NOT NULL,
//id_user int NOT NULL,
//created_at datetime NOT NULL,
<?php

require_once __DIR__ . '/../models/PostModel.php';

class PostController {
    private $model;

    public function __construct() {
        $this->model = new PostModel();
    }

    public function getPosts() {
        $posts = array();
        $index = $_POST['index'];
        $limit = $_POST['limit'];

        for ($x = 0; $x < $limit; $x++) {
            $posts[$x] = $this->model->getPost(++$index);
        }
        echo json_encode($posts);
        exit ;
    }

    public function viewGallery() {
        require_once __DIR__ . '/../views/pages/gallery.php';
    }

    public function redirect($url) {
        header("Location: " . $url);
    }
}
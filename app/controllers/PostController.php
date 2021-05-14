<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}

require_once DIRPATH . '/app/models/PostModel.php';

class PostController {
    private $model;

    public function __construct() {
        $this->model = new PostModel();
    }

    //check if request was submitted by ajax
    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    //get directory for user file uploads, create dir if not exist
    public function getUserDir() {
        if (isset($_SESSION['id_user'])) {
            $uploadDir = DIRPATH . '/app/assets/img/uploads/';
            $userDir = $uploadDir . $_SESSION['id_user'] . '/';
            if (!file_exists($userDir) && !is_dir($userDir)) {
                mkdir($userDir);
            }
            return $userDir;
        }
        else {
            return false;
        }
    }

    //get url path for user upload dir
    public function getUserUrl() {
        if (isset($_SESSION['id_user'])) {
            $dir = URL . '/app/assets/img/uploads/';
            $url = $dir . $_SESSION['id_user'] . '/';
            return $url;
        }
        else {
            return false;
        }
    }

    //upload user image before editing
    public function uploadUserImage() {
        $dir = $this->getUserDir();
        $allowed = ['jpeg','jpg','png','gif'];
        $data = array();
        $errors = array();

        if ($this->isAjax()) {
            if (!empty($_FILES['fileAjax']) && $dir &&
            (isset($_POST["action"]) && $_POST["action"] === "uploadImage")) {
                //check file extension for images
                $ext = pathinfo($_FILES['fileAjax']['name'], PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed))
                    $errors['format'] = 'Uploaded file is not an image.';
                //check filesize limit
                else if ($_FILES['fileAjax']['size'] > 2*MB)
                    $errors['size'] = 'Size limit for uploads is 2MB.';
                //error check
                if (!empty($errors)) {
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                //save file as temp                
                else {
                    $file = $dir . 'tmp.' .$ext;
                    $url = $this->getUserUrl();
                    $url .= 'tmp.' .$ext;
                    if (move_uploaded_file($_FILES['fileAjax']['tmp_name'], $file)) {
                        $data['code'] = 200;
                        $data['path'] = $url;
                    }
                    else {
                        $data['code'] = 500;
                    }
                }                
            }
            else {
                $data['code'] = 401;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //upload user webcam image before editing
    public function uploadUserCapture() {
        $dir = $this->getUserDir();

        $data = array();
        $errors = array();

        if ($this->isAjax()) {
            if (!empty($_POST['capture']) && $dir &&
            (isset($_POST["action"]) && $_POST["action"] === "uploadImage")) {
                $img = $_POST['capture'];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $fileData = base64_decode($img);

                $file = $dir . 'tmp.png';
                $url = $this->getUserUrl();
                $url .= 'tmp.png';
                if (file_put_contents($file, $fileData)) {
                    $data['code'] = 200;
                    $data['path'] = $url;
                }
                else {
                    $data['code'] = 500;
                }     
            }
            else {
                $data['code'] = 401;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //cancel image creation and remove temp file
    public function cancelUpload() {
        $dir = $this->getUserDir();
        $file = basename($_POST['file']);
        $data = array();

        if ($this->isAjax()) {
            if (($dir && $file) && (isset($_POST["action"]) && $_POST["action"] === "cancelUpload")) {
                if (file_exists($dir . $file)) {
                    unlink($dir . $file);
                    $data['status'] = 'unlinked';
                }
                else {
                    $data['status'] = 'nope';
                }      
            }

            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
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
        require_once DIRPATH . '/app/views/pages/gallery.php';
    }

    public function redirect($url) {
        header("Location: " . URL . $url);
    }
}
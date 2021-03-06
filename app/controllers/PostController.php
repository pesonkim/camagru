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
                mkdir($userDir, 0777, true);
            }
            return $userDir;
        }
        else {
            return false;
        }
    }

    public function deleteUserDir() {
        if (isset($_SESSION['id_user'])) {
            $uploadDir = DIRPATH . '/app/assets/img/uploads/';
            $userDir = $uploadDir . $_SESSION['id_user'] . '/';
            if (file_exists($userDir) && is_dir($userDir)) {
                array_map('unlink', glob($userDir.'/*'));
                rmdir($userDir);
            }
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

    public function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct) {
        // creating a cut resource
        $cut = imagecreatetruecolor($src_w, $src_h);
    
        // copying relevant section from background to the cut resource
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
       
        // copying relevant section from watermark to the cut resource
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
       
        // insert cut resource to destination image
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
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
                if (!in_array($ext, $allowed) || !exif_imagetype($_FILES['fileAjax']['tmp_name']))
                    $errors['format'] = 'Uploaded file is not an image.';
                //check filesize limit
                else if ($_FILES['fileAjax']['size'] > 5*MB)
                    $errors['size'] = 'Size limit for uploads is 5MB.';
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

        if ($this->isAjax()) {
            if (($dir && $file) && (isset($_POST["action"]) && $_POST["action"] === "cancelUpload")) {
                if (file_exists($dir . $file)) {
                    unlink($dir . $file);
                }  
            }
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //creates a post in database from given src
    public function createPost() {
        $dir = $this->getUserDir();
        $file = basename($_POST['file']);
        $data = array();
        $errors = array();

        if ($this->isAjax()) {
            if (($dir && $file) && (isset($_POST["action"]) && $_POST["action"] === "createPost")) {
                if (!file_exists($dir . $file)) {
                    $errors['file'] = 'Upload file is missing.';
                }
                else if (empty($_POST['title'])) {
                    $errors['title'] = 'Please give your post a title.';
                }
                if (!empty($errors)) {
                    $data['code'] = 400;
                    $data['errors'] = $errors;
                }
                else {
                    $hash = bin2hex(random_bytes(12));
                    $ext = pathinfo($dir . $file, PATHINFO_EXTENSION);
                    $hash .= '.';
                    $hash .= $ext;

                    if (isset($_POST['sticker'])) {
                        switch ($ext) {
                            case "jpg":
                            case "jpeg": {
                                $dest = imagecreatefromjpeg($dir . $file);
                                $stickerDir = DIRPATH . '/app/assets/img/stickers/';
                                $json = json_decode($_POST['sticker'], true);    
        
                                for ($i = 0; $i < count($json); $i++) {
                                    $src = imagecreatefrompng($stickerDir . basename(urldecode($json[$i]['src'])));
                                    $scale = $json[$i]['scale'];
                                    $top = $scale*$json[$i]['top'];
                                    $left = $scale*$json[$i]['left'];
                                    $width = $scale*$json[$i]['width'];
                                    $height = $scale*$json[$i]['height'];
                                    $src = imagescale($src, $width, $height);
                                    $this->imagecopymerge_alpha($dest, $src, $left, $top, 0, 0, $width, $height, 100);
                                }

                                imagejpeg($dest, $dir . $file);
                                imagedestroy($dest);
                                break ;
                            }
                            case "png": {
                                $dest = imagecreatefrompng($dir . $file);
                                $stickerDir = DIRPATH . '/app/assets/img/stickers/';
                                $json = json_decode($_POST['sticker'], true);    
        
                                for ($i = 0; $i < count($json); $i++) {
                                    $src = imagecreatefrompng($stickerDir . basename(urldecode($json[$i]['src'])));
                                    $scale = $json[$i]['scale'];
                                    $top = $scale*$json[$i]['top'];
                                    $left = $scale*$json[$i]['left'];
                                    $width = $scale*$json[$i]['width'];
                                    $height = $scale*$json[$i]['height'];
                                    $src = imagescale($src, $width, $height);
                                    $this->imagecopymerge_alpha($dest, $src, $left, $top, 0, 0, $width, $height, 100);
                                }

                                imagepng($dest, $dir . $file);
                                imagedestroy($dest);
                                break ;
                            }
                            case "gif": {
                                $dest = $dir . $file;
                                $stickerDir = 'app/assets/img/stickers/';
                                $json = json_decode($_POST['sticker'], true);    

                                for ($i = 0; $i < count($json); $i++) {
                                    $src = $stickerDir . basename(urldecode($json[$i]['src']));
                                    $scale = $json[$i]['scale'];
                                    $top = $scale*$json[$i]['top'];
                                    $left = $scale*$json[$i]['left'];
                                    $width = $scale*$json[$i]['width'];
                                    $height = $scale*$json[$i]['height'];

                                    $cmd = " $dest -coalesce -gravity NorthWest ". 
                                    " -geometry +$left+$top null: $src -layers composite "; 
                                    
                                    exec("convert $cmd $dest ");
                                }
                                break ;
                            }
                        }
                    }

                    rename($dir . $file, $dir . $hash);
                    
                    $url = $this->getUserUrl();
                    $url .= $hash;

                    $data['id_user'] = $_SESSION['id_user'];
                    $data['title'] = substr($_POST['title'], 0,70);
                    $data['src'] = $url;
                    $data['created_at'] = date('Y-m-d H:i:s');
            
                    $this->model->createPost($data);

                    $data['code'] = 200;
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

    //fetch all post id that match logged in user id
    public function getUserPosts() {
        $ids = array();
        $posts = array();

        $author = $this->model->getAuthorById($_SESSION['id_user']);
        $ids = $this->model->getUserPosts($_SESSION['id_user']);

        for ($x = 0; $x < count($ids); $x++) {
            $posts[$x] = $this->model->getPostById($ids[$x]['id_post']);
            $posts[$x]['author'] = $author;
        }

        echo json_encode($posts);
        exit ;
    }

    //delete a user post
    public function deletePost() {
        $data = array();

        if ($this->isAjax()) {
            if (isset($_POST["action"]) && $_POST["action"] === "deletePost" && isset($_SESSION["id_user"])
                && isset($_POST["id"])) {

                    $data['id_post'] = $_POST["id"];

                    $this->model->deletePostLikes($data);
                    $this->model->deletePostComments($data);
                    $this->model->deletePost($data);
            }
            else {
                $data['error'] = 400;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //delete all posts linked to a user
    public function deleteUserPosts() {
        if ($this->isAjax()) {
            if (isset($_POST["action"]) && $_POST["action"] === "deleteUserPosts" && isset($_SESSION["id_user"])) {

                $posts = array();
                $user = $_SESSION['id_user'];
                $posts = $this->model->getUserPosts($user);
        
                for ($x = 0; $x < count($posts); $x++) {
                    $this->model->deletePostLikes($posts[$x]);
                    $this->model->deletePostComments($posts[$x]);
                    $this->model->deletePost($posts[$x]);
                }
                $data['id_user'] = $_SESSION['id_user'];
                $this->model->deleteUserLikes($data);
                $this->model->deleteUserComments($data);
                $this->deleteUserDir();
            }
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //fetch all post ids in database
    public function getPosts() {
        $posts = array();

        $posts = $this->model->getPosts();

        echo json_encode($posts);
        exit ;
    }

    //fetch post data by post id
    public function getPostById() {
        $post = array();

        $post = $this->model->getPostById($_POST['id']);
        $post['author'] = $this->model->getAuthorById($post['id_user']);
        $post['likes'] = $this->model->getPostLikes($post['id_post']);
        $post['comments'] = $this->model->getPostComments($post['id_post']);

        foreach($post['comments'] as $key => $value) {
            $post['comments'][$key]['author'] = $this->model->getAuthorById($value['id_user']);
        }
        $post['views'] = $this->model->getPostViews($post['id_post']);
        $this->model->updateViewCount($post['id_post']);
        if (isset($_SESSION["id_user"])) {
            $post['like'] = $this->model->getLike($_SESSION["id_user"], $post["id_post"]);
        }

        echo json_encode($post);
        exit ;
    }

    //like button functionality; either create or delete like in PostModel
    public function likePost() {
        $data = array();

        if ($this->isAjax()) {
            if (isset($_POST["action"]) && $_POST["action"] === "likePost" && isset($_SESSION["id_user"])
                && isset($_POST["id"])) {
                
                //post already liked; delete existing entry
                if ($this->model->getLike($_SESSION["id_user"], $_POST["id"])) {
                    $data['id_post'] = $_POST["id"];
                    $data['id_user'] = $_SESSION['id_user'];
            
                    $this->model->deleteLike($data);
                }
                //create new like for post
                else {
                    $data['id_post'] = $_POST["id"];
                    $data['id_user'] = $_SESSION['id_user'];
                    $data['created_at'] = date('Y-m-d H:i:s');
            
                    $this->model->createLike($data);
                }
            }
            else {
                $data['error'] = 400;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //like button functionality; either create or delete like in PostModel
    public function commentPost() {
        $data = array();

        if ($this->isAjax()) {
            if (isset($_POST["action"]) && $_POST["action"] === "commentPost" && isset($_SESSION["id_user"])
                && (isset($_POST["id"]) && isset($_POST["body"]))) {
                
                $data['comment'] = $_POST["body"];
                $data['id_post'] = $_POST["id"];
                $data['id_user'] = $_SESSION['id_user'];
                $data['created_at'] = date('Y-m-d H:i:s');
        
                $this->model->createComment($data);

                $data['author'] = $this->model->getAuthorById($data['id_user']);
                $data['notif'] = $this->emailNotif($data);
            }
            else {
                $data['error'] = 400;
            }
            echo json_encode($data);
            exit ;
        }
        else {
            $this->redirect('/index.php?auth=false');
        }
    }

    //check if post author has email notifactions enabled, send email if yes
    public function emailNotif($data) {
        $pref = $this->model->getNotifyPref($data['id_post']);

        if ($pref) {
            $subject = 'New comment on your Camagru post';
            $profilelink = URL . '/index.php?page=profile&tab=notif';
            $body = "
Hello,

User '".$data['author']."' just left you a comment on your Camagru post '".$pref['post_title']."':

'".$data['comment']."'

If you don't wish to receive these notifactions, you can update your preferences on your profile page:
".$profilelink."

-Camagru
";
            mail($pref['email'], $subject, $body);
            return true;
        }
        else
            return false;
    }

    //generate example posts for index.php?page=example
    public function getExamplePosts() {
        $posts = array();
        $index = $_POST['index'];
        $limit = $_POST['limit'];

        for ($x = 0; $x < $limit; $x++) {
            $posts[$x] = $this->model->getExamplePost(++$index);
        }
        echo json_encode($posts);
        exit ;
    }

    public function viewExample() {
        require_once DIRPATH .  '/app/views/pages/example.php';
    }

    public function viewGallery() {
        require_once DIRPATH . '/app/views/pages/gallery.php';
    }

    public function redirect($url) {
        header("Location: " . URL . $url);
    }
}
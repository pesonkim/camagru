<?php

class BaseController {

    public function __constuct() {
        
    }


    public function redirect($url) {
        header("Location: " . $url);
    }
}
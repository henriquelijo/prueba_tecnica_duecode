<?php

require_once '../middlewares/SessionMiddleware.php';

class HomeController
{

    public function home()
    {
        $validation = SessionMiddleware::handle();
        
        header("Location: ../html/views/home/home.php");
    }

}

?>
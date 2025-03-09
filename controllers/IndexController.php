<?php
require_once '../repository/NewsRepository.php';
require_once '../middlewares/SessionMiddleware.php';

class IndexController
{
    function showIndex()
    {
        $news = new NewsRepository();
        $news_result = $news->getAllNews();
        
        include '../html/index.html';
    }

    function addNews()
    {
        session_start();
        
        $validation = SessionMiddleware::handle();
        
        if(!$validation){
            return header("Location: ../html/views/login/login.html");
        }
        header("Location: ../html/views/addnews/addnews.html");
    }
}
$index = new IndexController();

switch ($_GET) {
    case isset($_GET['add']):
        
        $index->addNews();
        break;
    case isset($_GET['edit']):
        
        break;
    case isset($_GET['delete']):
        
        break;
    default:
        
        $index->showIndex();
        break;
}

?>
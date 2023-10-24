<?php 
namespace SuperBlog\Controller;

class BaseController 
{
    public function response(array $data){
        $response = json_encode($data);
        header('Content-Type: application/json');
        echo $response;
    }
}
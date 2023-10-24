<?php 
namespace SuperBlog\Controller;

/**
 * Summary of BaseController
 */
class BaseController 
{
    /**
     * Summary of response
     * @param array $data
     * @return void
     */
    public function response(array $data){
        $response = json_encode($data);
        header('Content-Type: application/json');
        echo $response;
    }
}
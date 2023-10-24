<?php

namespace SuperBlog\Controller;
use SuperBlog\Model\Task;
use SuperBlog\Model\TaskRepository;


class TaskController extends BaseController
{
    
    private $taskRepository;
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    public function create()
    {
        try{
            $task = Task::makeFromArray($_POST);

            return $this->response([
                "status"=> "success",
                "data"=>$this->taskRepository->create($task)
            ]);
        }
        catch(\Throwable $e){
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function read(int $id)
    {
        try{
            return $this->response([
                "status"=> "success",
                "data"=>$this->taskRepository->read($id)
            ]);
        }
        catch(\Throwable $e){
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function update(int $id)
    {
        try{
            $requestBody = file_get_contents('php://input');
            $putParams = json_decode($requestBody, true);
            $task = Task::makeFromArray($putParams);

            return $this->response([
                "status"=> "success",
                "data"=>$this->taskRepository->update($id, $task)
            ]);
        }
        catch(\Throwable $e){
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try{
            return $this->response([
                "status"=> "success",
                "data"=>$this->taskRepository->delete($id)
            ]);
        }
        catch(\Throwable $e){
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function list()
    {
        try{
            $requestBody = file_get_contents('php://input');
            $putParams = json_decode($requestBody, true);
            return $this->response([
                "status"=> "success",
                "data"=>$this->taskRepository->list($putParams)
            ]);
        }
        catch(\Throwable $e){
            throw new \RuntimeException($e->getMessage());
        }
    }
}

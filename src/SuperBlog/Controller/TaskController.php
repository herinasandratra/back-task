<?php

namespace SuperBlog\Controller;
use SuperBlog\Model\Task;
use SuperBlog\Model\TaskRepository;


/**
 * Summary of TaskController
 */
class TaskController extends BaseController
{
    
    /**
     * Summary of taskRepository
     * @var 
     */
    private $taskRepository;
    /**
     * Summary of __construct
     * @param \SuperBlog\Model\TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    /**
     * Summary of create
     * @throws \RuntimeException
     * @return void
     */
    public function create()
    {
        try{
            $requestBody = file_get_contents('php://input');
            $putParams = json_decode($requestBody, true);
            $task = Task::makeFromArray($putParams);

            return $this->response([
                "status"=> "success",
                "data"=>$this->taskRepository->create($task)
            ]);
        }
        catch(\Throwable $e){
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * Summary of read
     * @param int $id
     * @throws \RuntimeException
     * @return void
     */
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

    /**
     * Summary of update
     * @param int $id
     * @throws \RuntimeException
     * @return void
     */
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

    /**
     * Summary of delete
     * @param int $id
     * @throws \RuntimeException
     * @return void
     */
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

    /**
     * Summary of list
     * @throws \RuntimeException
     * @return void
     */
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

<?php 
namespace SuperBlog\Model;

interface TaskRepository 
{
    public function create(Task $task);
    public function read(int $id);
    public function update(int $id, Task $task);
    public function delete(int $id);
    public function list($params);
}
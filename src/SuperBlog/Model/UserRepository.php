<?php 
namespace SuperBlog\Model;
use SuperBlog\Model\User;

interface UserRepository
{
   public function create(User $user);
   public function read(int $id);
   public function delete(int $id): bool;

}
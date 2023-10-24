<?php 

namespace SuperBlog\Persistence;
use SuperBlog\Model\Task;
use SuperBlog\Model\TaskRepository;

/**
 * Summary of InMemoryTaskRepository
 */
class InMemoryTaskRepository implements TaskRepository
{
    /**
     * Summary of connection
     * @var 
     */
    private $connection;
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $db = Database::getInstance();
        $this->connection = $db->getConnection();
    }
    /**
     * Summary of create
     * @param \SuperBlog\Model\Task $task
     * @throws \RuntimeException
     * @return array
     */
    public function create(Task $task)
    {
        try{
            $query = $this->connection->prepare("INSERT INTO tasks (title, description, status, creation_date, echeance) VALUES (:title, :description, :status, :creation_date, :echeance)");

            // Exécutez la requête d'insertion en passant les valeurs en tant que paramètres
            $query->bindValue(':title', $task->getTitle());
            $query->bindValue(':description', $task->getDescription());
            $query->bindValue(':status', $task->getStatus());
            $query->bindValue(':creation_date', $task->getCreationDate());
            $query->bindValue(':echeance', $task->getEcheance());
            
            if ($query->execute()) {
                $task->setId($this->connection->lastInsertId());
                return $task->toArray();
            } else {
                throw new \RuntimeException( "Échec de l'insertion de l'enregistrement.");
            }
        } catch (\PDOException $e) {
            throw new \RuntimeException( "Erreur d'insertion : " . $e->getMessage());
        }
    }
    /**
     * Summary of read
     * @param int $taskId
     * @throws \RuntimeException
     * @return array
     */
    public function read(int $taskId)
    {
        try {
            $query = $this->connection->prepare("SELECT * FROM tasks WHERE id = :taskId");
            $query->bindParam(':taskId', $taskId, \PDO::PARAM_INT);

            if ($query->execute()) {
                $taskData = $query->fetch(\PDO::FETCH_ASSOC);

                if ($taskData) {
                    // Create a Task object from the retrieved data
                    $task = new Task(
                        $taskData['id'],
                        $taskData['description'],
                        $taskData['title'],
                        $taskData['status'],
                        $taskData['echeance'] ?? '',
                        $taskData['creation_date'] ?? ''
                    );

                    return $task->toArray();
                } else {
                    throw new \RuntimeException("Task not found.");
                }
            } else {
                throw new \RuntimeException("Error executing the query.");
            }
        } catch (\PDOException $e) {
            throw new \RuntimeException("Error fetching task: " . $e->getMessage());
        }
    }

    /**
     * Summary of update
     * @param int $id
     * @param \SuperBlog\Model\Task $task
     * @throws \RuntimeException
     * @return array
     */
    public function update(int $id, Task $task)
    {
        try {
            // Check if the task with the given ID exists
            $existingTask = $this->read($id);

            if ($existingTask) {
                $query = $this->connection->prepare("UPDATE tasks SET title = :title, description = :description, status = :status, creation_date = :creation_date, echeance = :echeance WHERE id = :taskId");

                $query->bindValue(':title', $task->getTitle());
                $query->bindValue(':description', $task->getDescription());
                $query->bindValue(':status', $task->getStatus());
                $query->bindValue(':creation_date', $task->getCreationDate());
                $query->bindValue(':echeance', $task->getEcheance());
                $query->bindValue(':taskId', $id, \PDO::PARAM_INT);

                if ($query->execute()) {
                    // Task successfully updated
                    $task->setId($id);
                    return $task->toArray();
                } else {
                    throw new \RuntimeException("Failed to update the task.");
                }
            } else {
                throw new \RuntimeException("Task not found.");
            }
        } catch (\PDOException $e) {
            throw new \RuntimeException("Error updating task: " . $e->getMessage());
        }
    }

    /**
     * Summary of delete
     * @param int $id
     * @throws \RuntimeException
     * @return bool
     */
    public function delete(int $id)
    {
        try {
            // Check if the task with the given ID exists
            $existingTask = $this->read($id);

            if ($existingTask) {
                $query = $this->connection->prepare("DELETE FROM tasks WHERE id = :taskId");
                $query->bindParam(':taskId', $id, \PDO::PARAM_INT);

                if ($query->execute()) {
                    // Task successfully deleted
                    return true;
                } else {
                    throw new \RuntimeException("Failed to delete the task.");
                }
            } else {
                throw new \RuntimeException("Task not found.");
            }
        } catch (\PDOException $e) {
            throw new \RuntimeException("Error deleting task: " . $e->getMessage());
        }
    }

    /**
     * Summary of list
     * @param mixed $params
     * @throws \RuntimeException
     * @return array
     */
    public function list($params)
    {
        try {
            $page = $params['page'] ?? 1;
            $per_page = $params['per_page'] ?? 10;

            // Calculate the offset based on page and per_page values
            $offset = ($page - 1) * $per_page;

            // Prepare and execute a query to fetch a paginated list of tasks
            $query = $this->connection->prepare("SELECT * FROM tasks LIMIT :per_page OFFSET :offset");
            $query->bindParam(':per_page', $per_page, \PDO::PARAM_INT);
            $query->bindParam(':offset', $offset, \PDO::PARAM_INT);

            if ($query->execute()) {
                $tasksData = $query->fetchAll(\PDO::FETCH_ASSOC);

                // Create an array of Task objects from the retrieved data
                $tasks = [];
                foreach ($tasksData as $taskData) {
                    $task = new Task(
                        $taskData['id'],
                        $taskData['description'],
                        $taskData['title'],
                        $taskData['status'],
                        $taskData['echeance'] ?? '',
                        $taskData['creation_date'] ?? ''
                    );
                    $tasks[] = $task->toArray();
                }

                // Calculate total records and total pages
                $totalRecords = $this->getTotalRecords();
                $totalPages = ceil($totalRecords / $per_page);

                // Create a response array with pagination details
                $response = [
                    'data' => $tasks,
                    'total_page' => $totalPages,
                    'current_page' => $page,
                    'per_page' => $per_page,
                    'last_page' => $totalPages,
                ];

                return $response;
            } else {
                throw new \RuntimeException("Error executing the query.");
            }
        } catch (\PDOException $e) {
            throw new \RuntimeException("Error fetching task list: " . $e->getMessage());
        }
    }

    // Method to calculate the total number of records (replace with your own logic)
    /**
     * Summary of getTotalRecords
     * @return mixed
     */
    private function getTotalRecords()
    {
        // Implement your logic to count the total records in the database
        // Replace this with the appropriate code for your database
        $query = $this->connection->prepare("SELECT COUNT(*) FROM tasks");
        $query->execute();
        return $query->fetchColumn();
    }


}
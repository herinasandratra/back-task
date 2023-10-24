<?php 
namespace SuperBlog\Model;

class Task
{
    private $id;
    private $description;
    private $title;
    private $status;
    private $echeance;
    private $creation_date;
    const FORMAT = 'Y-m-d';
    public function __construct(
        int $id,
        string $description,
        string $title,
        string $status,
        string $echeance,
        string $creation_date
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->title = $title;
        $this->status = $status;
        
        if (\DateTime::createFromFormat(self::FORMAT, $echeance)) {
            $this->echeance = $echeance;
        }
        if (\DateTime::createFromFormat(self::FORMAT, $creation_date)) {
            $this->creation_date = $creation_date;
        }
    }

    // Getter methods
    public function getId():int
    {
        return $this->id;
    }

    public function getDescription():string
    {
        return $this->description;
    }

    public function getTitle():string
    {
        return $this->title;
    }

    public function getStatus():string
    {
        return $this->status;
    }

    public function getEcheance():string
    {
        return $this->echeance;
    }

    public function getCreationDate():string
    {
        return $this->creation_date;
    }

    // Setter methods (if needed)
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setEcheance($echeance)
    {
        $this->echeance = $echeance;
    }

    public static function makeFromArray($array)
    {
        return new self(
            $array['id'] ?? 0,
            $array['description'] ?? '',
            $array['title'] ?? '',
            $array['status'] ?? '',
            $array['echeance'] ?? date('Y-m-d'),
            $array['creation_date'] ?? date('Y-m-d'),
        );
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'title' => $this->title,
            'status' => $this->status,
            'echeance' => $this->echeance,
            'creation_date' => $this->creation_date,
        ];
    }

	/**
	 * @param int $id 
	 * @return self
	 */
	public function setId(int $id): self {
		$this->id = $id;
		return $this;
	}
}

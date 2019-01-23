<?php 

class Domain
{
    private $_conn;
    public $id;
    public $name;

    public function __construct($conn)
    {
        $this->_conn = $conn;
    }

    /**
     * Find domain by name      
     * 
     * @return $domain
     */ 
    public static function find($conn, $name)
    {
        // prepare and bind
        $stmt = $conn->prepare(sprintf("SELECT id,name FROM tbDomain WHERE name = ?"));
        $stmt->bind_param("s", $name);

        if (!$stmt->execute()) {
            exit($stmt->error);
        } else {
            $stmt->bind_result($id, $name);
            $stmt->fetch();

            if (isset($id)) {
                $domain = new Domain($conn);
                $domain->id = $id;
                $domain->name = $name;
            } else {
                $domain = null;
            }
        }
        return $domain;
    }

    /**
     * Find id by domain name      
     * 
     * @return $id
     */ 
    public static function findId($conn, $name)
    {
        // prepare and bind
        $stmt = $conn->prepare(sprintf("SELECT id FROM tbDomain WHERE name = ?"));
        $stmt->bind_param("s", $name);
    
        if (!$stmt->execute()) {
            exit($stmt->error);
        } else {
            $stmt->bind_result($id);
            $stmt->fetch();
        }

        $stmt->close();

        return $id === null ? 0 : $id;
    }

    /**
     * Save a new domain name      
     * 
     * @return void
     */ 
    public function save()
    {
        if ($this->name === null) {
            return;
        }

        // assign id if the name exists
        $this->id = self::findId($this->_conn, $this->name);

        // insert a new record
        if ($this->id === 0) {
            $stmt = $this->_conn->prepare(sprintf("INSERT INTO tbDomain(name) VALUES (?)"));
            $stmt->bind_param("s", $name);
            $name = $this->name;
            if (!$stmt->execute()) {
                exit($stmt->error);
            }

            // update id in the object
            $this->id = self::findId($this->_conn, $this->name);

            $stmt->close();
        }
    }
}
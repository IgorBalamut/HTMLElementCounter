<?php 

class Url
{
    private $_conn;

    public $id;
    public $name;

    public function __construct($conn)
    {
        $this->_conn = $conn;
    }

    public static function All($conn)
    {
        $sql = "SELECT id, name FROM tbUrl";
        $result = $conn->query($sql);
        return $result;
    }

    // find url by name
    public static function find($conn, $name)
    {
        // prepare and bind
        $stmt = $conn->prepare(sprintf("SELECT id,name FROM tbUrl WHERE name = ?"));
        $stmt->bind_param("s", $name);
        $stmt->execute();

        if (!$stmt->execute()) {
            exit($stmt->error);
        } else {
            $stmt->bind_result($id, $name);
            $stmt->fetch();

            if (isset($id)) {
                $url = new Url($conn);
                $url->id = $id;
                $url->name = $name;
            } else {
                $url = null;
            }
        }
        return $url;
    }


    //find id by element name
    public static function findId($conn, $name)
    {

        // prepare and bind
        $stmt = $conn->prepare(sprintf("SELECT id FROM tbUrl WHERE name = ?"));

        $stmt->bind_param("s", $name);
        $stmt->execute();

        if (!$stmt->execute()) {
            exit($stmt->error);
        } else {
            $stmt->bind_result($id);
            $stmt->fetch();
        }

        $stmt->close();

        return $id === null ? 0 : $id;
    }

    //save a new element
    public function save()
    {
        if ($this->name === null) {
            return;
        }

        // assign id if the name exists
        $this->id = self::findId($this->_conn, $this->name);

        // insert a new record
        if ($this->id === 0) {
            $stmt = $this->_conn->prepare(sprintf("INSERT INTO tbUrl(name) VALUES (?)"));
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


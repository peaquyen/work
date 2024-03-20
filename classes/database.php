<?
class Database
{
    //Property
    protected $db_host;
    protected $db_name;
    protected $db_user;
    protected $db_pass;

    //Constructor
    public function __construct($host, $name, $user, $pass)
    {
        $this->db_host = $host;
        $this->db_name = $name;
        $this->db_user = $user;
        $this->db_pass = $pass;
    }

    //Connection, use DSN
    public function getConn()
    {
        //create dsn (datasource name)
        $dsn = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8";
        try {
            $conn = new PDO($dsn, $this->db_user, $this->db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function query($sql, $data = [], $className = NULL)
    {
        $conn = $this->getConn();

        try {
            $stmt = $conn->prepare($sql);

            foreach ($data as $key => $value) {
                if (is_int($value)) {
                    $stmt->bindValue(':' . $key, $value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(':' . $key, $value);
                }
            }

            if (isset($className))
                $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $className);

            $stmt->execute();
            return  $stmt;
        } catch (Exception $e) {
            echo $e->getMessage() . '<br>';
            echo 'File: ' . $e->getFile() . '<br>';
            echo 'Line: ' . $e->getLine();
            die();
        }
    }


    public function insert($table, $data)
    {
        $key = array_keys($data);
        $param = implode(',', $key);
        $value = ':' . implode(',:', $key);

        $sql = 'insert into ' . $table . '(' . $param . ') ' . 'values(' . $value . ')';

        $result = $this->query($sql, $data);
        return $result;
    }

    public function update($table, $data = [], $condition = '')
    {
        $update = '';
        foreach ($data as $key => $value)
            $update .= $key . '=:' . $key . ',';
        $update = trim($update, ',');

        if (!empty($condition))
            $sql = 'update ' . $table . ' set ' . $update . ' where ' . $condition;
        else
            $sql = 'update ' . $table . ' set ' . $update;
        $result = $this->query($sql, $data);
        return $result;
    }

    public function delete($table, $condition = '', $data = [])
    {
        if (!empty($condition))
            $sql = 'delete from ' . $table .  ' where ' . $condition;
        else
            $sql = 'delete from ' . $table;

        $result = $this->query($sql, $data);
        return $result;
    }
}

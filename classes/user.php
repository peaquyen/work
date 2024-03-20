<?
class User
{
    public $id;
    public $email;
    public $password;
    public $fullname;
    public $phone;
    public $active;
    public $create_at;
    public $status;

    public function __construct($fullname = null, $email = null, $phone = null, $password = null, $active = null, $create_at = null, $status = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->phone = $phone;
        $this->active = $active;
        $this->create_at = $create_at;
        $this->status = $status;
    }

    // Authenticate user
    public static function authenticate($conn, $email, $password)
    {
        $user = $conn->query("select * from users where email=:email", ['email' => $email], 'User')->fetch();
        if ($user) {
            $hash = $user->password;
            return password_verify($password, $hash);
        }
    }

    // check whether user exists
    public static function isExist($conn, $email)
    {
        $id = $conn->query("select id from users where email= :email and status = 1", ['email' => $email])->fetchColumn();
        return ($id !== false) ? $id : false;
    }

    public static function isDelete($conn, $email)
    {
        return $conn->query("select * from users where email=:email and status = 0", ['email' => $email], 'User')->fetch();
    }

    public static function isEmail($conn, $email, $userID)
    {
        $id = $conn->query(
            "select id from users where email=:email and id!=:userID",
            [
                'email' => $email,
                'userID' => $userID
            ]
        )->fetchColumn();
        return ($id !== false) ? $id : false;
    }

    public function updateUser($conn, $id)
    {
        return $conn->update('users', [
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'password' => $this->password,
            'active' => $this->active,
            'create_at' => $this->create_at,
            'status' => $this->status
        ], 'id = ' . $id);
    }


    public function insertUser($conn)
    {
        return $conn->insert('users', [
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'active' => $this->active,
            'create_at' => $this->create_at
        ]);
    }

    public static function getAllUsers($conn)
    {
        return $conn->query("select * from users")->fetchAll();
    }

    public static function getPaging($db, $limit, $offset)
    {
        return $db->query(
            "SELECT * FROM users ORDER BY fullname ASC LIMIT :limit OFFSET :offset",
            ['limit' => $limit, 'offset' => $offset],
            'User'
        )->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getById($db, $id)
    {
        return $db->query("SELECT * FROM users WHERE id = :id", ['id' => $id], 'User')->fetch(PDO::FETCH_OBJ);
    }
}

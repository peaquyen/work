<?php
class Login
{
    private $user_id;
    private $token;
    private $create_at;

    public function __construct($user_id = null, $token = null, $create_at = null)
    {
        $this->user_id = $user_id;
        $this->token = $token;
        $this->create_at = $create_at;
    }

    public function checkLogin($conn, $userID)
    {
        $userLogin = $conn->query("select * from login where user_id=:userID", ['userID' => $userID])->rowCount() > 0;
        if ($userLogin > 0) {
            $conn->delete("login", 'user_id = ' . $userID);
        }
    }

    public function insertDataUserInLogin($conn)
    {
        return $conn->insert('login', [
            'user_id' => $this->user_id,
            'token' => $this->token,
            'create_at' => $this->create_at
        ]);
    }
}

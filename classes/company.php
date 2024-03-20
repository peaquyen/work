<?
class Company
{
    public $id;
    public $title;
    public $description;
    public $address;
    public $phone;
    public $email;

    public function __construct($title = null, $description = null, $address = null, $phone = null, $email = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->address = $address;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function add($db)
    {
        return  $db->insert('company', [
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email
        ]);
    }

    public static function getById($db, $id)
    {
        return $db->query('SELECT * FROM company WHERE id = :id', ['id' => $id], 'Company')->fetch(PDO::FETCH_OBJ);
    }

    public static function getAllById($db, $company_id)
    {
        return $db->query('SELECT * FROM company WHERE id = :company_id', ['company_id' => $company_id])->fetch(PDO::FETCH_OBJ);
    }

    public static function getIdByTitle($db, $title)
    {
        return $db->query('SELECT id FROM company WHERE title = :title', ['title' => $title])->fetchColumn();
    }

    public static function isExist($db, $title)
    {
        return $db->query('SELECT * FROM company WHERE title = :title', ['title' => $title])->fetch(PDO::FETCH_OBJ);
    }

    public function update($db, $id)
    {
        return $db->update(
            'company',
            [
                'title' => $this->title,
                'description' => $this->description,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email
            ],
            'id = ' . $id
        );
    }
}

<?php
class Listing
{
    public $id;
    public $title;
    public $description;
    public $salary;
    public $tags;
    public $requirement;
    public $benefit;
    public $company_id;
    public $user_id;

    public function __construct(
        $title = null,
        $description = null,
        $salary = null,
        $tags = null,
        $requirement = null,
        $benefit = null,
        $company_id = null,
        $user_id = null
    ) {

        $this->title = $title;
        $this->description = $description;
        $this->salary = $salary;
        $this->tags = $tags;
        $this->requirement = $requirement;
        $this->benefit = $benefit;
        $this->company_id = $company_id;
        $this->user_id = $user_id;
    }

    private function validate()
    {
        return $this->title;
    }

    public function add($db)
    {

        if ($this->validate()) {
            return $db->insert('listing', [
                'user_id' => $this->user_id,
                'company_id' => $this->company_id,
                'title' => $this->title,
                'description' => $this->description,
                'salary' => $this->salary,
                'tags' => $this->tags,
                'requirement' => $this->requirement,
                'benefit' => $this->benefit
            ]);
        } else {
            return false;
        }
    }

    public static function getAll($db)
    {
        return $db->query("SELECT * FROM listing ORDER BY title ASC ", [], 'Listing')->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getAllById($db, $user_id)
    {
        return $db->query("SELECT * FROM listing WHERE user_id = :user_id", ['user_id' => $user_id], 'Listing')->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getById($db, $id)
    {
        return $db->query("SELECT * FROM listing WHERE id = :id", ['id' => $id], 'Listing')->fetch(PDO::FETCH_OBJ);
    }

    public static function getPaging($db, $limit, $offset)
    {
        return $db->query(
            "SELECT * FROM listing ORDER BY title ASC LIMIT :limit OFFSET :offset",
            ['limit' => $limit, 'offset' => $offset],
            'Listing'
        )->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getPagingByUserId($db, $limit, $offset, $id)
    {
        return $db->query(
            "SELECT * FROM listing WHERE user_id = :id ORDER BY title ASC LIMIT :limit OFFSET :offset",
            ['limit' => $limit, 'offset' => $offset, 'id' => $id],
            'Listing'
        )->fetchAll(PDO::FETCH_OBJ);
    }

    public function update($db, $id)
    {
        if ($this->validate()) {
            return $db->update(
                'listing',
                [
                    'title' => $this->title,
                    'description' => $this->description,
                    'salary' => $this->salary,
                    'tags' => $this->tags,
                    'requirement' => $this->requirement,
                    'benefit' => $this->benefit
                ],
                'id =' . $id
            );
        } else {
            return false;
        }
    }

    public function deleteById($db, $id)
    {
        try {
            // 1. get data from table listing
            $listingData = $db->query("SELECT * FROM listing WHERE id = :id", ['id' => $id], 'Listing')->fetch(PDO::FETCH_OBJ);

            // 2. insert data into listing_storage
            if ($listingData) {
                $db->insert('listing_storage', [
                    'id' => $listingData->id,
                    'title' => $listingData->title,
                    'description' => $listingData->description,
                    'salary' => $listingData->salary,
                    'tags' => $listingData->tags,
                    'requirement' => $listingData->requirement,
                    'benefit' => $listingData->benefit,
                    'company_id' => $listingData->company_id,
                    'user_id' => $listingData->user_id
                ]);
            }

            // 3. Delete data from table listing
            return $db->delete('listing', 'id =' . $id);
        } catch (PDOException $e) {
            Dialog::getMsg($e->getMessage(), 'error');
            return false;
        }
    }


    public static function count($db)
    {
        return $db->query("SELECT COUNT(*) FROM listing")->fetchColumn();
    }

    public static function lastId($db)
    {
        return $db->query("SELECT MAX(id) FROM listing")->fetchColumn();
    }
}

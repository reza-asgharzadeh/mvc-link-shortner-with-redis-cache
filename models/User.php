<?php
namespace app\models;

class User
{
    public ?int $id = null;
    public string $fullName;
    public string $email;
    public string $password;

    public function load($data)
    {
        $this->id = $data['id'] ?? null;
        $this->fullName = $data['fullName'];
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    public function save()
    {
        $db = Database::$db;
        if ($this->id) {
            $db->register($this);
        } else {
            $db->register($this);
        }
    }
}
<?php
require_once ("Classes/Database.php");

class User
{
    protected $id;
    protected $username;
    protected $role;
    protected $email;
    protected $avatar_url;

    public function __construct($id,$username,$role,$email,$avatar_url)
    {
        $this->id = $id;
        $this->username = $username;
        $this->role = $role;
        $this->email = $email;
        $this->avatar_url = $avatar_url;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAvatarUrl()
    {
        return $this->avatar_url;
    }

    public function getRole()
    {
        return $this->role;
    }
}
?>

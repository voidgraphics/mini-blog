<?php

class M_Users extends Model
{
    public function getUser($username, $password)
    {
        $sql = 'SELECT * FROM users WHERE username=:username AND password=:password';
        $pdost = $this->connexion->prepare($sql);
        $pdost->execute([':username' => $username, ':password' => $password]);
        return $pdost->fetch();
    }

    public function createUser($username, $password)
    {
        $sql = 'INSERT INTO users(username, password) VALUES(:username, :password)';
        $pdost = $this->connexion->prepare($sql);
        $pdost->execute([':username' => $username, ':password' => $password]);
    }
}
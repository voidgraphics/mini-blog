<?php

class C_Users extends C_Base
{

    private $usersModel = null;
    private $categoriesModel = null;

    function __construct()
    {
        $this->usersModel = new M_Users();
        $this->categoriesModel = new M_Categories();
    }

    public function collect()
    {
        $data['data']['categories'] = $this->categoriesModel->getCategories();
        $data['data']['page_title'] = 'S&rsquo;identifier';
        $data['view'] = 'collect_user.php';
        return $data;
    }

    private function create($username, $password)
    {
        $this->usersModel->createUser($username, $password);
        $this->connect($username);
    }

    public function connect($user)
    {
        $_SESSION['user'] = $user;
        $_SESSION['connected'] = '1';
        header('Location: http://localhost');
    }

    public function disconnect(){
        session_destroy();
        unset($_SESSION['username']);
        unset($_SESSION['connected']);
        header('Location: http://localhost');
    }

    public function check()
    {
        if (empty($_REQUEST['username']) || empty($_REQUEST['password'])) {
            die('oops');
        }
        $user = $this->usersModel->getUser($_REQUEST['username'], sha1($_REQUEST['password']));
        if ($user) {
            $this->connect($user->username);
        } else {
            $this->create($_REQUEST['username'], sha1($_REQUEST['password']));
        }
    }
}
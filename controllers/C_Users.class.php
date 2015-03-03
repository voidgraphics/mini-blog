<?php

class C_Users extends C_Base
{
    public function check()
    {
        if(empty($_REQUEST['username']) || empty($_REQUEST['password'])){
            die('oops');
        }
        $user = $this->userModel->getUser($_REQUEST['username'], sha1($_REQUEST['password']));
        if ($user) {
            $this->connect($user);
        } else {
            $this->create($_REQUEST['username'], sha1($_REQUEST['password']));
        }
    }
}
<?php

class C_Error extends C_Base
{

    private $categoriesModel = null;

    public function __construct()
    {
        $this->categoriesModel = new M_Categories();
    }

    public function view()
    {
        $data['data']['categories'] = $this->categoriesModel->getCategories();
        $data['data']['page_title'] = 'Erreur';
        $data['view'] = 'view_error.php';

        if (!isset($_GET['x'])) {
            $data['data']['x'] = 'Erreur non définie';
        } elseif ($_GET['x'] == '1') {
            $data['data']['x'] = '404 - Route inexistante';
        } elseif ($_GET['x'] == '2') {
            $data['data']['x'] = 'Vous essayez de faire un truc interdit !';
        } elseif ($_GET['x'] == '3') {
            $data['data']['x'] = 'L’id fourni devrait être un nombre';
        } elseif ($_GET['x'] == '4') {
            $data['data']['x'] = 'Vous avez oublié de préciser un id';
        }

        return $data;
    }
}
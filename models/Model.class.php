<?php

/**
 * Class Model
 */
class Model
{
    /**
     * @var null|PDO
     */
    protected $connexion = null;

    /**
     *
     */
    public function __construct()
    {
        include('db.php');
        try {
            $this->connexion = new PDO(sprintf('mysql:host=%s;dbname=%s',
                HOST_NAME,
                DB_NAME), USER_NAME, PASSWORD, $db_options);
            $this->connexion->query('SET CHARACTER SET UTF8');
            $this->connexion->query('SET NAMES UTF8');
        } catch (PDOException $e) {
            die ($e->getMessage());
            //À remplacer par une redirection vers view/error/x
        }
    }
}
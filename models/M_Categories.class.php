<?php

class M_Categories extends Model
{

    function getCategories(){

        $sql = 'SELECT  * FROM categories;';
        $pdost = $this->connexion->query($sql);
        return $pdost->fetchAll();

    }

    function getCategory($id){
        $sql = 'SELECT * FROM categories WHERE id = :id;';
        $pdost = $this->connexion->prepare($sql);
        $pdost->execute([
            ':id' => $id
        ]);
        return $pdost->fetch();
    }

    # Ajoute une catégorie
    function createCategory($name){

        $sql = 'INSERT INTO categories(name) VALUES(:name);';
        try{
            $pdost = $this->connexion->prepare($sql);
            $pdost->execute([
                ':name' => $name
            ]);
        } catch(PDOException $e){
            die($e->getMessage());
        }

    }

    # Supprime une catégorie
    function deleteCategory($categoryId){
        $sql = 'DELETE FROM categories WHERE id = :id;';
        $pdost = $this->connexion->prepare($sql);
        $pdost->execute([
            ':id' => $categoryId
        ]);
    }


    # Modifie une catégorie
    function editCategory($name, $id){
        $sql = 'UPDATE categories SET name = :name  WHERE id = :id;';
        try{
            $pdost = $this->connexion->prepare($sql);
            $pdost->execute([
                ':name' => $name,
                ':id' => $id
            ]);
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }

}
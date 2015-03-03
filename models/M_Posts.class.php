<?php

/**
 * Class M_Posts
 */
class M_Posts extends Model
{
    /**
     * @param $id
     * @return mixed
     */
    public function getPost($id)
    {
        $sql = 'SELECT  posts.id as post_id,
                        posts.title as post_title,
                        posts.body as post_body,
                        posts.img as post_img,
                        posts.date as post_date,
                        categories.name as category_name,
                        category_id
                        FROM posts
                        JOIN categories ON category_id = categories.id
                        WHERE posts.id = :id;';
        $pdost = $this->connexion->prepare($sql);
        $pdost->execute([':id' => $id]);

        return $pdost->fetch();
    }

    public function getAll()
    {
        $sql = 'SELECT  posts.id as post_id,
                        posts.title as post_title,
                        posts.img as post_img,
                        posts.date as post_date,
                        posts.body as post_body,
                        categories.name as category_name
                        FROM posts
                        LEFT JOIN categories ON category_id = categories.id
                        ORDER BY posts.id DESC;';
        $pdost = $this->connexion->query($sql);
        return $pdost->fetchAll();
    }

    # Récupère les articles pour la catégorie spécifiée
    public function getPostsByCat($categoryName)
    {
        $sql = 'SELECT  posts.id as post_id,
                        posts.title as post_title,
                        posts.img as post_img,
                        posts.date as post_date,
                        posts.body as post_body,
                        categories.name as category_name
                        FROM posts
                        JOIN categories ON category_id = categories.id
                        WHERE categories.name = :name
                        ORDER BY posts.id DESC;';
        $pdost = $this->connexion->prepare($sql);
        $pdost->execute([
            ':name' => $categoryName
        ]);
        return $pdost->fetchAll();
    }

    public function createPost($postTitle, $postBody, $postImg, $postCategory)
    {

        $date = date("Y-m-d H:i:s");
        # On échappe les caractères html par sécurité
        $postBody = htmlspecialchars($postBody);

        $sql = 'INSERT INTO posts(title, body, date, img, category_id) VALUES(:title, :body, :date, :img, :category);';
        try {
            $pdost = $this->connexion->prepare($sql);
            $pdost->execute([
                ':title' => $postTitle,
                ':body' => $postBody,
                ':date' => $date,
                ':img' => $postImg,
                ':category' => $postCategory
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    public function deletePost($id)
    {
        $sql = 'DELETE FROM posts WHERE id = :id;';
        $pdost = $this->connexion->prepare($sql);
        $pdost->execute([':id' => $id]);
    }

    public function editPost($title, $body, $postImg, $category, $id)
    {
        $body = htmlspecialchars($body);
        $sql = 'UPDATE posts SET title = :title, body = :body, img = :img, category_id = :category  WHERE id = :id;';
        try {
            $pdost = $this->connexion->prepare($sql);
            $pdost->execute([
                ':title' => $title,
                ':body' => $body,
                ':img' => $postImg,
                ':category' => $category,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function truncate($string, $length = 100, $append = "&hellip;")
    {
        $string = trim($string);

        if (strlen($string) > $length) {
            $string = wordwrap($string, $length, '\break');
            $string = explode('\break', $string, 2);
            $string = $string[0] . $append;
        }

        return $string;
    }

    public function formatText($string)
    {
        $string = str_replace('[b]', '<b>', $string);
        $string = str_replace('[/b]', '</b>', $string);

        return $string;
    }

}


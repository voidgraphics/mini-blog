<?php

/**
 * Class C_Posts
 */
class C_Posts extends C_Base
{
    /**
     * @var M_Posts|null
     */
    private $postsModel = null;
    private $categoriesModel = null;

    /**
     *
     */
    public function __construct()
    {
        $this->postsModel = new M_Posts();
        $this->categoriesModel = new M_Categories();
    }

    /**
     *
     */
    public function index()
    {
        $data['data']['posts'] = $this->postsModel->getAll();
        foreach ($data['data']['posts'] as $post) {
            $post->post_body = $this->postsModel->truncate($post->post_body, 415);
            $post->post_body = $this->postsModel->formatText($post->post_body);
        }
        $data['data']['categories'] = $this->categoriesModel->getCategories();
        $data['data']['page_title'] = 'articles récents';
        $data['view'] = 'index_posts.php';
        return $data;
    }

    public function admin()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            header('Location: http://localhost/index.php?a=view&e=error&x=2');
            die('Vous essayez de faire un truc interdit');
        }

        $data['data']['posts'] = $this->postsModel->getAll();
        $data['data']['categories'] = $this->categoriesModel->getCategories();
        $data['data']['page_title'] = 'articles récents';
        $data['view'] = 'admin_posts.php';
        return $data;
    }

    /**
     *
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            header('Location: http://localhost/index.php?a=view&e=error&x=2');

        # Le tableau errors contient un message pour chaque champ non complété
        $errors = [];
        # Le talbeau sent contient les valeurs déjà entrées par l'utilisateur pour re-compléter les champs en cas d'erreur
        $sent = [];

        if ($_POST['title'] !== '') {
            $sentTitle = $_POST['title'];
            $sent['title'] = $sentTitle;
        } else
            $errors['title'] = 'Veuillez entrer un titre';

        if ($_POST['body'] !== '') {
            $sentBody = $_POST['body'];
            $sent['body'] = $sentBody;
        } else
            $errors['body'] = 'Veuillez entrer du texte pour l&rsquo;article';

        if ($_FILES['file_banner']['name'] !== '')
            $sentImg = $_FILES['file_banner']['name'];
        else
            $errors['file_banner'] = 'Veuillez inclure une image de bannière';

        if ($_FILES['file_fullsize']['name'] == '')
            $errors['file_fullsize'] = 'Veuillez inclure une image pour l&rsquo;article';

        $sentCategory = $_POST['category'];

        if ($errors) {
            $data['data']['errors'] = $errors;
            $data['data']['sent'] = $sent;
            $data['data']['posts'] = $this->postsModel->getAll();
            $data['data']['categories'] = $this->categoriesModel->getCategories();
            $data['data']['page_title'] = 'Erreur(s) lors de l&rsquo;envoi de l&rsquo;article';
            $data['view'] = 'admin_posts.php';
            return $data;
        }

        move_uploaded_file($_FILES['file_banner']['tmp_name'],
            './img/' . $_FILES['file_banner']['name']);

        move_uploaded_file($_FILES['file_fullsize']['tmp_name'],
            './img/fullsize/' . $_FILES['file_fullsize']['name']);


        $this->postsModel->createPost($sentTitle, $sentBody, $sentImg, $sentCategory);
        header('Location: http://localhost/index.php?a=admin&e=posts');
    }

    /**
     *
     */
    public function update()
    {
        //Tester si la méthode est get ou post. En get, on affiche le formulaire, en post, on fait effectivement l’action d’ajouter, puis on redirige vers view/posts/x
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset($_GET['id'])) {
                header('Location: http://localhost/index.php?a=view&e=error&x=4');
                die('Vous avez oublié de préciser un id');
            }
            if (!is_numeric($_GET['id'])) {
                header('Location: http://localhost/index.php?a=view&e=error&x=3');
                die('L’id fourni devrait être un nombre');
            }
            $id = $_GET['id'];
            $data = [];
            $data['data']['categories'] = $this->categoriesModel->getCategories();
            $data['data']['post'] = $this->postsModel->getPost($id);
            $data['data']['page_title'] = 'Modifier l&rsquo;article : ' . $data['data']['post']->post_title;
            $data['view'] = 'update_posts.php';

            return $data;

        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_GET['id'])) {
                header('Location: http://localhost/index.php?a=view&e=error&x=4');
                die('Vous avez oublié de préciser un id');
            }
            if (!is_numeric($_GET['id'])) {
                header('Location: http://localhost/index.php?a=view&e=error&x=3');
                die('L’id fourni devrait être un nombre');
            }

            $id = $_GET['id'];

            # Le tableau errors contient un message pour chaque champ non complété
            $errors = [];
            # Le talbeau sent contient les valeurs déjà entrées par l'utilisateur pour re-compléter les champs en cas d'erreur
            $sent = [];

            if ($_POST['title'] !== '') {
                $sentTitle = $_POST['title'];
                $sent['title'] = $sentTitle;
            } else
                $errors['title'] = 'Veuillez entrer un titre';

            if ($_POST['body'] !== '') {
                $sentBody = $_POST['body'];
                $sent['body'] = $sentBody;
            } else
                $errors['body'] = 'Veuillez entrer du texte pour l&rsquo;article';

            $sentCategory = $_POST['category'];

            if ($errors) {
                $data['data']['errors'] = $errors;
                $data['data']['sent'] = $sent;
                $data['data']['post'] = $this->postsModel->getPost($id);
                $data['data']['categories'] = $this->categoriesModel->getCategories();
                $data['data']['page_title'] = 'Erreur(s) lors de la modification de l&rsquo;article';
                $data['view'] = 'update_posts.php';
                return $data;
            }

            $sentImg = $_POST['oldImg'];

            if ($_FILES['file_banner']['name'] != '') {
                $sentImg = $_FILES['file_banner']['name'];
                move_uploaded_file($_FILES['file_banner']['tmp_name'],
                    "./img/" . $_FILES['file_banner']['name']);

                move_uploaded_file($_FILES['file_fullsize']['tmp_name'],
                    "./img/fullsize/" . $_FILES['file_fullsize']['name']);
            }

            $this->postsModel->editPost($sentTitle, $sentBody, $sentImg, $sentCategory, $id);
            header('Location: http://localhost/index.php?a=view&e=posts&id=' . $id);
        }
    }

    public function delete()
    {
        if (!isset($_GET['id'])) {
            header('Location: http://localhost/index.php?a=view&e=error&x=4');
            die('Vous avez oublié de préciser un id');
        }
        if (!is_numeric($_GET['id'])) {
            header('Location: http://localhost/index.php?a=view&e=error&x=3');
            die('L’id fourni devrait être un nombre');
        }

        $id = $_GET['id'];
        if (!isset($_GET['confirm']) || $_GET['confirm'] == false) {
            $data['data']['post'] = $this->postsModel->getPost($id);
            $data['data']['post']->post_body = $this->postsModel->truncate($data['data']['post']->post_body, 415);
            $data['data']['post']->post_body = $this->postsModel->formatText($data['data']['post']->post_body);
            $data['data']['categories'] = $this->categoriesModel->getCategories();
            $data['data']['page_title'] = 'Supprimer l&rsquo;article : ' . $data['data']['post']->post_title;
            $data['view'] = 'delete_posts.php';
            return $data;
        } else {
            $this->postsModel->deletePost($id);
            header('Location: http://localhost');
        }
    }

    /**
     * @return array
     */
    public function view()
    {
        //Exemple de ce qu’on pourrait faire avec view(). Cette méthode sert à voir un article particulier sur la base de son id.
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            header('Location: http://localhost/index.php?a=view&e=error&x=2');
            die('Vous essayez de faire un truc interdit');
        }
        if (!isset($_GET['id'])) {
            header('Location: http://localhost/index.php?a=view&e=error&x=4');
            die('Vous avez oublié de préciser un id');
        }
        if (!is_numeric($_GET['id'])) {
            header('Location: http://localhost/index.php?a=view&e=error&x=3');
            die('L’id fourni devrait être un nombre');
        }
        $id = $_GET['id'];
        $data = [];
        $data['data']['categories'] = $this->categoriesModel->getCategories();
        $data['data']['post'] = $this->postsModel->getPost($id);
        $data['data']['post']->post_body = $this->postsModel->formatText($data['data']['post']->post_body);
        $data['data']['page_title'] = $data['data']['post']->post_title;
        $data['view'] = 'view_posts.php';

        return $data;
    }

    public function viewByCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            header('Location: http://localhost/index.php?a=view&e=error&x=2');
            die('Vous essayez de faire un truc interdit');
        }
        $catName = $_GET['cat'];
        $data = [];
        $data['data']['categories'] = $this->categoriesModel->getCategories();
        $data['data']['posts'] = $this->postsModel->getPostsByCat($catName);
        foreach ($data['data']['posts'] as $post) {
            $post->post_body = $this->postsModel->truncate($post->post_body, 415);
            $post->post_body = $this->postsModel->formatText($post->post_body);
        }
        $data['data']['page_title'] = $catName;
        $data['view'] = 'viewByCategory_posts.php';
        return $data;
    }

}

<?php
    if(isset($data['errors'])){
        $errors = $data['errors'];
    }
    if(isset($data['sent'])){
        $sent = $data['sent'];
    }
?>

<div class="admin">
    <form action="index.php?a=create&e=posts" method="post" enctype='multipart/form-data'>
        <div>
            <h3>Ajouter un article (tous les champs sont obligatoires)</h3>
            <label for="title">Titre</label>
            <?= isset($errors['title'])?'<span class="error">' . $errors['title'] . '</span>':'' ?>
            <input
                type="text"
                id="title"
                name="title"
                placeholder="Entrez le titre de l'article..."
                <?= isset($errors['title']) ? 'class="error"' : '' ?>
                value="<?= isset($sent['title'])?$sent['title']:'' ?>"
                required
            />
            <label for="body">Texte de l'article</label>
            <?= isset($errors['body'])?'<span class="error">' . $errors['body'] . '</span>':'' ?>
            <small>Vous pouvez utiliser [b]texte[/b] pour mettre en gras</small>
            <textarea
                name="body"
                id="body"
                cols="30"
                rows="10"
                placeholder="Entrez le contenu de l'article..."
                <?= isset($errors['body'])?'class="error"':'' ?>
                required
            ><?= isset($sent['body'])?$sent['body']:'' ?></textarea>
            <label for="file_banner">Bannière (480px * 155px)</label>
            <?= isset($errors['file_banner'])?'<span class="error">' . $errors['file_banner'] . '</span>':'' ?>
            <input
                type="file"
                name="file_banner"
                id="file_banner"
                <?= isset($errors['file_banner'])?'class="error"':'' ?>
            />
            <label for="file_fullsize">Poster</label>
            <?= isset($errors['file_fullsize'])?'<span class="error">' . $errors['file_fullsize'] . '</span>':'' ?>
            <input
                type="file"
                name="file_fullsize"
                id="file_fullsize"
                <?= isset($errors['file_fullsize'])?'class="error"':'' ?>
            />
            <label for="category">Catégorie</label>
            <select name="category" id="category">
                <?php foreach($data['categories'] as $category): ?>
                    <option value="<?= $category->id ?>">
                        <?= $category->name ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit"/>
        </div>
    </form>


    <div class="posts">
        <?php foreach($data['posts'] as $post): ?>
            <div class="post">
                <img src="img/<?= $post->post_img ?>" alt=""/>
                <div class="info">
                    <h3>
                        <a href="index.php?a=view&e=posts&id=<?= $post->post_id ?>">
                            <?= $post->post_title ?>
                        </a>
                    </h3>
                    <p class="date"><?= strftime('%A %e %B %Y',strtotime($post->post_date)); ?></p>
                    <a class="category" href="index.php?a=viewByCategory&e=posts&cat=<?= $post->category_name ?>"><?= $post->category_name; ?></a>
                    <a class="edit" href="index.php?a=update&e=posts&id=<?= $post->post_id ?>">Modifier</a>
                    <a class="delete" href="index.php?a=delete&e=posts&id=<?= $post->post_id ?>">Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
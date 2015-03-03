<?php
$post = $data['post'];
if (isset($data['errors'])) {
    $errors = $data['errors'];
}
if (isset($data['sent'])) {
    $sent = $data['sent'];
}
?>
<div class="admin">
    <form action="index.php?a=update&e=posts&id=<?= $post->post_id ?>" method="post" enctype="multipart/form-data">
        <h3><?= $post->post_title ?></h3>

        <div>
            <label for="title">Titre</label>
            <?= isset($errors['title']) ? '<span class="error">' . $errors['title'] . '</span>' : '' ?>
            <input
                type="text"
                id="title"
                name="title"
                <?= isset($errors['title']) ? 'class="error"' : '' ?>
                value="<?= isset($sent['title']) ? $sent['title'] : $post->post_title ?>"
                required/>
            <label for="body">Texte de l'article</label>
            <?= isset($errors['body']) ? '<span class="error">' . $errors['body'] . '</span>' : '' ?>
            <textarea
                name="body"
                id="body"
                cols="30"
                rows="10"
                <?= isset($errors['body']) ? 'class="error"' : '' ?>
                required><?= isset($sent['body']) ? $sent['body'] : $post->post_body ?></textarea>
            <label for="file_banner">Bannière (480px * 155px)</label>
            <input type="file" name="file_banner" id="file_banner">
            <label for="file_fullsize">Poster</label>
            <input type="file" name="file_fullsize" id="file_fullsize">
            <label for="category">Catégorie</label>
            <select name="category" id="category">
                <?php foreach ($data['categories'] as $category): ?>
                    <option
                        value="<?= $category->id ?>"<?= $post->category_id == $category->id ? ' selected="selected"' : '' ?>>
                        <?= $category->name ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="oldImg" value="<?= $post->post_img ?>"/>
            <input type="submit"/>
        </div>
    </form>
    <img class="postEditImage" src="img/fullsize/<?= $post->post_img ?>" alt="<?= $post->post_title ?>"/>
    <a class="deleteLink" href="index.php?a=delete&e=posts&id=<?= $post->post_id ?>">Supprimer l&rsquo;article</a>
</div>
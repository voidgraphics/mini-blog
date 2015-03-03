<?php $post = $data['post'] ?>
<div class="fullPost">
    <div class="info">
        <p class="date"><?= strftime('%A %e %B %Y',strtotime($post->post_date)); ?></p>
        <a class="category" href="index.php?a=viewByCategory&e=posts&cat=<?= $post->category_name ?>">Plus d'articles de la catégorie <?= $post->category_name; ?></a>
        <p class="previewText"><?= nl2br($post->post_body) ?></p>
    </div>
</div>
<img src="img/fullsize/<?= $post->post_img ?>" alt="<?= $post->post_title ?>"/>
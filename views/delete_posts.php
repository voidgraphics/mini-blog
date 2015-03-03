<?php $post = $data['post']; ?>

<div class="confirm">
    <p>Êtes-vous sûr de vouloir supprimer l'article &laquo;&nbsp;<?= $post->post_title ?>&nbsp;&raquo;&nbsp;?</p>
    <a class="confirmDelete" href="index.php?a=delete&e=posts&confirm=true&id=<?= $post->post_id ?>">Confirmer la suppression</a>
    <a class="confirmCancel" href="index.php?a=admin&e=posts">Annuler</a>
</div>

<div class="post left">
    <img src="img/<?= $post->post_img ?>" alt=""/>
    <div class="info">
        <h3>
            <a href="index.php?a=view&e=posts&id=<?= $post->post_id ?>">
                <?= $post->post_title ?>
            </a>
        </h3>
        <p class="date"><?= strftime('%A %e %B %Y',strtotime($post->post_date)); ?></p>
        <a class="category" href="index.php?a=viewByCategory&e=posts&cat=<?= $post->category_name ?>"><?= $post->category_name; ?></a>
        <p class="previewText"><?= $post->post_body ?></p>
    </div>
    <a class="readMore" href="index.php?a=view&e=posts&id=<?= $post->post_id ?>">Lire la suite...</a>
</div>
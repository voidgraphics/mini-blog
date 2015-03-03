<section class="posts">
    <!-- Bouclage sur les $posts récupérés -->
    <?php foreach($data['posts'] as $post): ?>

        <div class="post">
            <img src="img/<?= $post->post_img ?>" alt=""/>

            <div class="info">
                <h3>
                    <a href="index.php?a=view&e=posts&id=<?= $post->post_id ?>">
                        <?= $post->post_title ?>
                    </a>
                </h3>

                <p class="date"><?= strftime('%A %e %B %Y', strtotime($post->post_date)); ?></p>
                <a class="category"
                   href="index.php?a=viewByCategory&e=posts&cat=<?= $post->category_name ?>"><?= $post->category_name; ?></a>

                <p class="previewText"><?= $post->post_body ?></p>
            </div>
            <a class="readMore" href="index.php?a=view&e=posts&id=<?= $post->post_id ?>">Lire la suite...</a>
        </div>

    <?php endforeach; ?>
</section>
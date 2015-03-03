<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $data['page_title'] ?></title>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato" />
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
</head>
<body>
<header>
    <div class="wrap">
        <h1>
            <a href="index.php" class="logo">
                movie reviews
            </a>
        </h1>
        <input type="checkbox" id="menuToggle" />
        <label for="menuToggle" class="menuToggle">☰</label>
        <nav>
            <a href="index.php">accueil</a>
            <?php
            foreach($data['categories'] as $category):
                ?>
                <a href="index.php?a=viewByCategory&e=posts&cat=<?= $category->name ?>"><?= $category->name ?></a>
            <?php endforeach; ?>
        </nav>
    </div>
</header>
<div class="wrap">
    <h2><?= $data['page_title'] ?></h2>
        <?php include($view); ?>

</div> <!-- div.wrap -->
<footer>
    <div class="wrap">
        <a href="index.php?a=admin&e=posts" class="adminLink">Administration</a>
    </div>
</footer>

</body>
</html>
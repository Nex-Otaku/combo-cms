<?php include TEMPLATE_PATH . "/include/header.php" ?>

<ul id="headlines" class="archive">

    <?php foreach ($results['articles'] as $article): ?>

        <li>
            <h2>
                
                <a href="<?= Route::getUrl('viewArticle', array('articleId' => $article->id))?>"><?php echo htmlspecialchars($article->getTitle()) ?></a>
            </h2>
            <a href="<?= Route::getUrl('editArticle', array('articleId' => $article->id))?>">Редактировать</a>
        </li>

    <?php endforeach; ?>

</ul>

<p>Всего статей: <?php echo $results['totalRows'] ?>.</p>

<p><a href="<?= Route::getUrl('newArticle') ?>">Добавить статью</a></p>

<?php
include TEMPLATE_PATH . "/include/footer.php";

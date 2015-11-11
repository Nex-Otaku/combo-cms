<?php include TEMPLATE_PATH . "/include/header.php" ?>

<ul class="list-group">

    <?php foreach ($results['articles'] as $article): ?>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-10">
                    <a href="<?= Route::getUrl('viewArticle', array('articleId' => $article->id))?>"><?php echo $article->getTitle() ?></a>
                </div>
                <div class="col-md-2">
                    <a href="<?= Route::getUrl('editArticle', array('articleId' => $article->id))?>"><span class="glyphicon glyphicon-edit"></span> Редактировать</a>
                </div>
            </div>
        </li>

    <?php endforeach; ?>

</ul>

<p>Всего статей: <?php echo $results['totalRows'] ?>.</p>

<a class="btn btn-default" href="<?= Route::getUrl('newArticle') ?>"><span class="glyphicon glyphicon-plus"></span> Добавить статью</a>

<?php
include TEMPLATE_PATH . "/include/footer.php";

<?php include TEMPLATE_PATH . "/include/header.php" ?>

<script src="/js/external/ckeditor-4.5.4-basic/ckeditor.js"></script>
<form action="<?= Route::getUrl($results['formAction'], $results['formActionParams']) ?>" method="post">
    <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>

    <ul>

        <li>
            <label for="title">Заголовок</label>
            <input type="text" name="title" id="title" placeholder="Название статьи" required autofocus maxlength="255" value="<?php echo $results['article']->getTitle() ?>" />
        </li>

        <li>
            <label for="content">Основной текст</label>
            <textarea name="content" id="content" placeholder="Содержимое статьи" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars($results['article']->content) ?></textarea>
        </li>

    </ul>

    <div class="row">
        <div class="col-md-3">
            <div>
                <button class="btn btn-success" type="submit" name="saveChanges">Сохранить</button>
                <button class="btn btn-default" type="submit" formnovalidate name="cancel">Отмена</button>
            </div>
        </div>
        <div class="col-md-2">
            <div>
                <?php if ($results['article']->id) { ?>
                    <a class="btn btn-link" href="<?= Route::getUrl('deleteArticle', array('articleId' => $results['article']->id)) ?>" onclick="return confirm('Вы уверены, что хотите удалить статью?')">Удалить</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <script>
        // Replace the <textarea id="content"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('content');
    </script>
</form>

<?php
include TEMPLATE_PATH . "/include/footer.php";

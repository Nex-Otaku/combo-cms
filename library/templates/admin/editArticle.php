<?php include TEMPLATE_PATH . "/include/header.php" ?>
 
      <h1><?php echo $results['pageTitle']?></h1>
 
      <form action="<?= Route::getUrl($results['formAction'], $results['formActionParams']) ?>" method="post">
        <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>
 
        <ul>
 
          <li>
            <label for="title">Заголовок</label>
            <input type="text" name="title" id="title" placeholder="Название статьи" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $results['article']->getTitle(false) )?>" />
          </li>
 
          <li>
            <label for="content">Основной текст</label>
            <textarea name="content" id="content" placeholder="Содержимое статьи" required maxlength="100000" style="height: 30em;"><?php echo htmlspecialchars( $results['article']->content )?></textarea>
          </li>
 
        </ul>
 
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Сохранить" />
          <input type="submit" formnovalidate name="cancel" value="Отмена" />
        </div>
 
      </form>
 
<?php if ( $results['article']->id ) { ?>
      <p><a href="<?= Route::getUrl('deleteArticle', array('articleId' => $results['article']->id))?>" onclick="return confirm('Вы уверены, что хотите удалить статью?')">Удалить</a></p>
<?php } ?>
 
<?php include TEMPLATE_PATH . "/include/footer.php";
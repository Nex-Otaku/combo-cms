<?php include TEMPLATE_PATH . "/include/header.php" ?>
      
      <?php 
      $user = $results['user']; 
      $newUser = empty($user->id);
      $editCurrentUser = $user->username == User::get()->username;
      $canEditPass = $newUser || $editCurrentUser;
      $canDelete = !$newUser && !$editCurrentUser;
      ?>

      <form action="<?= Route::getUrl($results['formAction'], $results['formActionParams']) ?>" method="post">
        <input type="hidden" name="userId" value="<?php echo $user->id ?>"/>
 
        <ul>
 
          <li>
            <label for="username">Логин</label>
            <input type="text" name="username" id="username" placeholder="Имя пользователя" required autofocus maxlength="255" value="<?php echo htmlspecialchars( $user->username )?>" />
          </li>
          
          <?php if ($canEditPass): ?>
          <li>
            <label for="password">Пароль</label>
            <input type="text" name="password" id="password" placeholder="Пароль" maxlength="255" value="" />
          </li>
          <?php endif; ?>
 
        </ul>
 
        <div class="buttons">
          <input type="submit" name="saveChanges" value="Сохранить" />
          <input type="submit" formnovalidate name="cancel" value="Отмена" />
        </div>
 
      </form>
 
<?php if ($canDelete) { ?>
      <p><a href="<?= Route::getUrl('deleteUser', array('userId' => $user->id))?>" onclick="return confirm('Вы уверены, что хотите удалить пользователя?')">Удалить</a></p>
<?php } ?>
 
<?php include TEMPLATE_PATH . "/include/footer.php";
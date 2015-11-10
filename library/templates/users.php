<?php include TEMPLATE_PATH . "/include/header.php" ?>

<ul id="headlines" class="archive">

    <?php if (!empty($results['users'])): ?>
    <?php foreach ($results['users'] as $user): ?>

        <li>
            <h2>
                <?php echo htmlspecialchars($user->username) ?>
            <h2>
            <a href="<?= Route::getUrl('editUser', array('userId' => $user->id)) ?>">Редактировать</a>
        </li>

    <?php endforeach; ?>
    <?php endif; ?>
</ul>

<p><a href="<?= Route::getUrl('newUser') ?>">Добавить пользователя</a></p>

<?php
include TEMPLATE_PATH . "/include/footer.php";

<?php include TEMPLATE_PATH . "/include/header.php" ?>

<ul class="list-group">

    <?php if (!empty($results['users'])): ?>
    <?php foreach ($results['users'] as $user): ?>

        <li class="list-group-item">
            <div class="row">
                <div class="col-md-10">
                    <?php echo htmlspecialchars($user->username) ?>
                </div>
                <div class="col-md-2 pull-right">
                    <a href="<?= Route::getUrl('editUser', array('userId' => $user->id)) ?>"><span class="glyphicon glyphicon-edit"></span> Редактировать</a>
                </div>
            </div>
        </li>

    <?php endforeach; ?>
    <?php endif; ?>
</ul>

<a class="btn btn-default" href="<?= Route::getUrl('newUser') ?>"><span class="glyphicon glyphicon-plus"></span> Добавить пользователя</a></p>

<?php
include TEMPLATE_PATH . "/include/footer.php";

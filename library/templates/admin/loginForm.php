<?php include TEMPLATE_PATH . "/include/header.php" ?>

<form action="<?= Route::getUrl('login') ?>" method="post" style="width: 50%;">
    <input type="hidden" name="login" value="true" />

    <div class="form-group">
        <label for="username">Логин</label>
        <input class="form-control" type="text" name="username" id="username" placeholder="user@server.com" required autofocus maxlength="20" />
    </div>

    <div class="form-group">
        <label for="password">Пароль</label>
        <input class="form-control" type="password" name="password" id="password" placeholder="Пароль" required maxlength="20" />
    </div>

    <input class="btn btn-default" type="submit" name="login" value="Вход" />

</form>

<?php
include TEMPLATE_PATH . "/include/footer.php";

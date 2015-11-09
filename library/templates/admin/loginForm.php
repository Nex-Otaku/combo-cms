<?php include TEMPLATE_PATH . "/include/header.php" ?>

<form action="<?= Route::getUrl('login') ?>" method="post" style="width: 50%;">
    <input type="hidden" name="login" value="true" />

    <ul>

        <li>
            <label for="username">Логин</label>
            <input type="text" name="username" id="username" placeholder="user@server.com" required autofocus maxlength="20" />
        </li>

        <li>
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" placeholder="Пароль" required maxlength="20" />
        </li>

    </ul>

    <div class="buttons">
        <input type="submit" name="login" value="Вход" />
    </div>

</form>

<?php
include TEMPLATE_PATH . "/include/footer.php";

<?php
$menuList = Menu::getMenuList();
if (!empty($menuList)):
    ?>
    <div id="top-menu">
        <ul>
            <?php foreach ($menuList as $menu): ?>
                <li>
                    <?php if ($menu->isSelected()): ?>
                    <b>[&nbsp;<?= $menu->label; ?>&nbsp;]</b>
                    <?php else: ?>
                    <a href="<?= $menu->getUrl(); ?>"><?= $menu->label; ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<div id="adminHeader">
    <p>Добро пожаловать, <b><?php echo htmlspecialchars(User::get()->username); ?></b>. <a href="<?= Route::getUrl('logout') ?>">Выход</a></p>
</div>
<?php
$menuList = Menu::getMenuList();
if (!empty($menuList)):
    ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><?= SITE_NAME ?></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                <?php foreach ($menuList as $menu): ?>
                    <?php if ($menu->isSelected()): ?>
                        <li class="active"><a href="<?= $menu->getUrl(); ?>"><?= $menu->label; ?></a></li>
                    <?php else: ?>
                        <li><a href="<?= $menu->getUrl(); ?>"><?= $menu->label; ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
<?php endif; ?>
<!--
STUB
<div id="adminHeader">
    <p>Добро пожаловать, <b><?php echo htmlspecialchars(User::get()->username); ?></b>. <a href="<?= Route::getUrl('logout') ?>">Выход</a></p>
</div>
-->

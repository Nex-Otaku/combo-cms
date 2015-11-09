<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo htmlspecialchars($results['pageTitle']) ?></title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <div id="container">

            <a href="/">Combo CMS</a>

            <?php
            if (User::isLoggedIn()) {
                include TEMPLATE_PATH . "/include/top-menu.php";
            }
            ?>

            <?php if (Notification::hasError()) { ?>
                <div class="errorMessage"><?= Notification::getError() ?></div>
            <?php } ?>

            <?php if (Notification::hasStatus()) { ?>
                <div class="statusMessage"><?= Notification::getStatus() ?></div>
            <?php } ?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <title><?php echo htmlspecialchars($results['pageTitle']) ?></title>
        <!-- Bootstrap -->
        <link href="css/bootstrap/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap/bootstrap-3.3.5/css/bootstrap-theme.min.css" rel="stylesheet">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/external/jquery/jquery-2.1.4.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap/bootstrap-3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        if (User::isLoggedIn()) {
            include TEMPLATE_PATH . "/include/top-menu.php";
        }
        ?>
        <div class="container">

            <div class="page-header">
                <h1><?= htmlspecialchars($results['pageTitle']) ?></h1>
            </div>
            
            <?php if (Notification::hasError()) { ?>
                <div class="errorMessage"><?= Notification::getError() ?></div>
            <?php } ?>

            <?php if (Notification::hasStatus()) { ?>
                <div class="statusMessage"><?= Notification::getStatus() ?></div>
            <?php } ?>

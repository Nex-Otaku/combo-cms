<?php include TEMPLATE_PATH . "/include/header.php" ?>
 
      <h1 style="width: 75%;"><?php echo htmlspecialchars( $results['article']->getTitle() )?></h1>
      <div style="width: 75%;"><?php echo $results['article']->content?></div>

 
<?php include TEMPLATE_PATH . "/include/footer.php";
<?php 
$components = $_SERVER['DOCUMENT_ROOT'].'/resources/Components';
$title = 'Aston Events | FAQ';
if (isset($_COOKIE['theme'])) {$theme = $_COOKIE['theme'];} else {$_COOKIE['theme'] = 'blue-gray'; $theme = 'blue-gray';}
include("$components/head.php"); ?>

<body class="w3-<?php echo($theme) ?>">
  <?php include("$components/navbar.php") ?>
  <div class="w3-padding-large" id="main">

    <section>
      <h1><em>This page is deprecated, please select another page</em></h1>
    </section>

    <?php include("$components/footer.php") ?>
  </div>
</body>

</html>
<?php
ini_set('display_errors', 1);
error_reporting(-1);

//Sets up variables for imported scripts 
$components = $_SERVER['DOCUMENT_ROOT'] . '/resources/Components';
$title = 'Aston Events | Home';

//Sets theme cookie if it doesn't already exist (default theme: blue-gray)
if (isset($_COOKIE['theme'])) {
  $theme = $_COOKIE['theme'];
} else {
  $_COOKIE['theme'] = 'blue-gray';
  $theme = 'blue-gray';
}

include("$components/head.php");
?>

<body class="w3-<?php echo ($theme) ?>">
  <?php include("$components/navbar.php") ?>
  <div id="main" class="w3-padding-large">

    <header id="header" class="w3-container w3-bottombar w3-margin-bottom w3-round">
        <h1 class="w3-center">Welcome to the Aston Events Portal<?php if (isset($_SESSION['authenticated'])) {echo ', '.$_SESSION['username'];} ?>!</h1>
    </header>

    <div>
      <p class="w3-large">
        Here you can sign up for any number of upcoming and ongoing events at Aston University! <br>
        Please enjoy this short video before exploring the rest of the site:
        <br><br>
      </p>
      <div class="w3-center">
        <iframe width="854" height="480" src="https://youtube.com/embed/O7yukzMj310?controls=0"></iframe>
      </div>
    </div>

    <?php include("$components/footer.php") ?>
  </div>
</body>

</html>
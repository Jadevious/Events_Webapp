<?php 
ini_set('display_errors',1);
error_reporting(-1);
$components = $_SERVER['DOCUMENT_ROOT'].'/resources/Components';
$title = 'Aston Events | Buttons';
if (isset($_COOKIE['theme'])) {$theme = $_COOKIE['theme'];} else {$_COOKIE['theme'] = 'blue-gray'; $theme = 'blue-gray';}
$styles = array("Hover.css");
include("$components/head.php");
?>

<body class="w3-<?php echo($theme)?>">
  <?php include("$components/navbar.php") ?>


  <div class="w3-padding-large" id="main">
    <h2>Hoverable Buttons</h2>
    <p>
    For context, you shouldn't be seeing this - this is just a CSS :hover test page <br>
    Please be aware a number of features may break upon use within this page, given the nature of it being a test page
    </p>


    <button class="button button1" onclick="toGreen()">Green</button>
    <button class="button button2" onclick="toBlue()">Blue</button>
    <button class="button button3" onclick="toRed()">Red</button>
    <button class="button button4" onclick="toGray()">Gray</button>
    <button class="button button5" onclick="toBlack()">Black</button>
    <button><a href="index.php"> Back </a></button>

    <?php include("$components/footer.php") ?>
  </div>


</body>

<script>
  function toGreen() {
    document.body.style.backgroundColor = "lightgreen";
  }

  function toBlue() {
    document.body.style.backgroundColor = "lightblue";
  }

  function toRed() {
    document.body.style.backgroundColor = "orange";
  }

  function toGray() {
    document.body.style.backgroundColor = "white";
    document.body.style.color = "black";
  }

  function toBlack() {
    document.body.style.backgroundColor = "#555555";
    document.body.style.color = "white";
  }
</script>

</html>
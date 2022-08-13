<!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav id="sidebar" class="w3-sidebar w3-bar-block w3-small w3-center hideable">
    <img src="/resources/images/AU.jpg" style="width:100%">

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <input type="submit" name="submitTheme" class="w3-bar-item w3-button w3-padding-large w3-border-bottom w3-hover-<?php echo ($theme); echo (" w3-border-$theme"); ?>" value="CHANGE THEME" />
    </form>

    <a href="/" class="w3-bar-item w3-button w3-padding-large w3-hover-<?php echo ($theme); if ($_SERVER['PHP_SELF'] == '/index.php') {echo (" w3-$theme");} ?>">
        <i class="fa fa-home w3-xxlarge"></i>
        <p>HOME</p>
    </a>
    <a href="/events.php" class="w3-bar-item w3-button w3-padding-large w3-hover-<?php echo ($theme); if ($_SERVER['PHP_SELF'] == '/events.php') {echo (" w3-$theme");} ?>">
        <i class="fa fa-calendar w3-xxlarge"></i>
        <p>EVENTS</p>
    </a>
    <a href="/faq.php" class="w3-bar-item w3-button w3-padding-large w3-hover-<?php echo ($theme); if ($_SERVER['PHP_SELF'] == '/faq.php') {echo (" w3-$theme");} ?>">
        <i class="fa fa-question w3-xxlarge"></i>
        <p>FAQ</p>
    </a>

    <div><a id="login" onclick="document.getElementById('loginForm').style.display='block'" class="w3-bar-item w3-button w3-padding-large w3-display-bottomleft w3-leftbar w3-hover-<?php echo ($theme); echo (" w3-border-$theme"); ?>">
        <i class="fa fa-sign-in w3-xxlarge"></i>
        <p>Login</p>
    </a></div>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div id="myNavbar" class="w3-top hide" >
    <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
        <a href="/" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
        <a href="/" class="w3-bar-item w3-button" style="width:25% !important">EVENTS</a>
        <a href="/" class="w3-bar-item w3-button" style="width:25% !important">ACCOUNT</a>
        <a href="/" class="w3-bar-item w3-button" style="width:25% !important">HELP</a>
    </div>
</div>
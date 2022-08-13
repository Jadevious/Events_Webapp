<?php
#region EVENT SORT TYPE
//Sets the event sort type based on GET variable (defaults to other)
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['category'])) {
  if ($_GET['category'] == "sport") {
    $eventType = "sports";
    $pageHeader = "Upcoming Sporting Events";
  } else if ($_GET['category'] == "culture") {
    $eventType = "cultural";
    $pageHeader = "Upcoming Cultural Events";
  } else{
    $eventType = "other";
    $pageHeader = "Other Upcoming Events";
  }
} else {
  $eventType = "other";
  $pageHeader = "Other Upcoming Events";
}
#endregion

#region HEAD - Same as index.php
$components = $_SERVER['DOCUMENT_ROOT'] . '/resources/Components';
$title = 'Aston Events | Events';

if (isset($_COOKIE['theme'])) {
  $theme = $_COOKIE['theme'];
} else {
  $_COOKIE['theme'] = 'blue-gray';
  $theme = 'blue-gray';
}

include("$components/head.php");
#endregion

#region BOOKING SUBMISSION HANDLER
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['bookEvent'])) {
  //Booking validation
  if (!isset($_SESSION['authenticated'])) {
    $bookingError = "You are not signed in!";
  }

  //Database validation
  if (!isset($bookingError)) {
    try {
      $query = prepareQuery('SELECT UUID, UEID FROM Bookings WHERE UUID = ? AND UEID = ?');
      $query->execute(array($_SESSION['UID'], $_GET['bookEvent']));

      if ($query->rowCount() == 0) {
        $query2 = prepareQuery('SELECT Name FROM Events WHERE UEID = ?');
        $query2->execute(array($_GET['bookEvent']));

        if ($query2->rowCount() > 0) {
            $query3 = prepareQuery('INSERT INTO Bookings (UEID, UUID) VALUES (?, ?)');
            $query3->execute(array($_GET['bookEvent'], $_SESSION['UID']));
            $bookingSuccess = $_GET['bookEvent'];
        } else {
          $bookingError = "No such event exists";
        }
      } else {
        $bookingError = "Booking already exists!";
      }

    } catch (PDOException $e) {
      $bookingError = "Database booking validation failed, please contact an admin";
    }
  }

}
#endregion
?>


<!-- #region Event page body -->
<body class="w3-<?php echo ($theme) ?>">
  <?php include("$components/navbar.php") ?>

  <!-- #region ALERT DIALOGUE - lets me communicate booking errors/success without needing to re-open the modal -->
  <?php 
  if (isset($bookingError)) {?>

    <div id="alert" class="w3-center w3-animate-top w3-red">
      <span onclick="document.getElementById('alert').style.display='none'" class="w3-button w3-display-right w3-round-xlarge marginalise"> &times </span>
      <p><b>Booking Failed:</b> <?php echo $bookingError ?></p>
    </div>

  <?php } else if (isset($bookingSuccess)) {?>

    <div id="alert" class="w3-center w3-animate-top w3-green">
    <span onclick="document.getElementById('alert').style.display='none'" class="w3-button w3-display-right w3-round-xlarge marginalise"> &times </span>
      <p><b>Booking Successfully Made!</b></p>
    </div>
  <?php } ?>
  <!-- #endregion -->

  
  <div id="main" class="w3-padding-large">
    <?php
    //Fetching any records matching the selected eventType category
    try {
      $query = prepareQuery('SELECT UEID, Name, Description, Organiser, Location, ImageURL, URL, DATE_FORMAT(DATE(Date), "%a %D %b %Y") as eventDate, DATE_FORMAT(TIME(Date), "%H:%i") as eventTime FROM Events WHERE Category = ? ORDER BY Date');
      $query->execute(array($eventType));
      $results = $query->fetchAll();
      ?>
        <header id="header" class="w3-container w3-bottombar w3-margin-bottom w3-round">
          <h1 class="w3-center"><?php echo $pageHeader ?></h1>
        </header>
  
        <!-- If there are upcoming results, display them, otherwise default to the no-events-message -->
        <?php if (!empty($results)) { 
          $position = 0;
            ?> <div class="w3-row w3-margin-bottom"> <?php
              foreach ($results as $event) {
                if ($position != 0 && $position % 3 == 0) {echo "</div>\n\n<div class='w3-row w3-margin-bottom'>";}
                eventBox($event, $position);
                $position++;
              }
            ?> </div> <?php
        } else {
          echo ("Sorry, no upcoming $eventType events");
        }

    } catch (PDOException $e) {
      echo ("Failed to retrieve events, please try again later!");
    }

    #region EVENT BOX  
    //The miniature event box displayed for each relevant event
    function eventBox($event, $positionInResults) { ?>
      <a onclick="openEventForm(<?php echo $positionInResults ?>)" class="w3-third w3-container eventDisplay">
      <div class="w3-display-container">
        <img src="/resources/images/events/<?php echo $event["ImageURL"] ?>" alt="Event Image" class="eventImage">
        <div class="w3-display-middle w3-opacity-off hideUnlessHover w3-large">Click to expand</div>
      </div>
      <div class="w3-container defaultTheme2">
        <p><b><?php echo $event["Name"] ?></b></p>
        <p><?php echo $event["Description"]?></p>
        <p>Date: <b><?php echo ($event["eventDate"] . ", " . $event["eventTime"])?></b></p>
      </div>
    </a>
    <?php }
    #endregion

    #region EVENT MODAL FORM
    ?>
    <!-- Default Event Modal appearance before being dynamically updated by js to be relevant to the event pressed  -->
    <div id="eventForm" class="w3-modal">
      <div class="w3-modal-content w3-card-4">
        <header class="w3-display-container">
          <img id="eventImage" alt="Event Image" class="w3-modal-content">
          <span onclick="closeEventForm()" class="w3-button w3-xlarge w3-display-topright w3-round-large marginalise">&times</span>
        </header>

        <div class="w3-container defaultTheme2">
          <h3 id="eventTitle"></h3> <a id="eventURL"><i class="fa fa-external-link w3-xlarge"></i></a>
          <p id="eventDescription"></p>
          <div class="w3-row w3-center w3-margin-bottom">
            <p id="eventDate" class="w3-third"></p>
            <p id="eventOrganiser" class="w3-third"></p>
            <p id="eventLocation" class="w3-third"></p>
          </div>

          <div class="w3-row w3-margin-bottom">
            <form method="get" action=<?php echo $_SERVER['PHP_SELF']?>>
              <input type="hidden" name="category" value="<?php if (isset($_GET['category'])) {echo $_GET['category'];} ?>"/>
              <?php
              if (isset($_SESSION['authenticated'])) {
                ?>
                <button id="submitBooking" name="bookEvent" type="submit" class="w3-button w3-deep-orange w3-hover-red w3-large w3-round-large w3-threequarter">
                Book Event <i class="fa fa-check-square-o"></i>
                </button>
                <?php
              } else {
                ?>
                <button id="submitBooking" class="w3-button w3-deep-orange w3-hover-red w3-large w3-round-large w3-threequarter" disabled>
                Sign in to book event
                </button>
                <?php
              }
              ?>
            </form>
            <button id="likeEvent" onclick="setLikeStatus()" class="w3-button w3-large w3-round-large"><i class="fa fa-heart w3-xlarge"></i></button>
            <!-- Insert Like button here -->
          </div>
          
        </div>
      </div>
    </div>
    <?php
    #endregion

    include("$components/footer.php") ?>
  </div>

</body>
</html>


<script>
//Converting displayed events array to js
var loadedEvents = <?php echo json_encode($results); ?>;
var loadedPosition = "";

//Loading event information into modal
function openEventForm(eventPosition) {
  loadedPosition = eventPosition;
  var currentEvent = loadedEvents[eventPosition];
  document.getElementById('eventImage').src = `resources/images/events/${currentEvent['ImageURL']}`;
  document.getElementById('eventTitle').innerHTML = currentEvent['Name'];
  document.getElementById('eventDescription').innerHTML = currentEvent['Description'];
  document.getElementById('eventDate').innerHTML = `<b>Date: </b><br>${currentEvent["eventDate"]}, ${currentEvent["eventTime"]}`;
  document.getElementById('eventOrganiser').innerHTML = `<b>Organiser: </b><br>${currentEvent["Organiser"]}`;
  document.getElementById('eventLocation').innerHTML = `<b>Location: </b><br>${currentEvent["Location"]}`;
  document.getElementById('submitBooking').value = currentEvent['UEID'];

  if (currentEvent['URL']) {
    document.getElementById('eventURL').href = currentEvent['URL'];
    document.getElementById('eventURL').style.display = "inline-block";
  }

  if (checkLikeStatus()) {
    document.getElementById('likeEvent').style.color = "red";
  } else {
    document.getElementById('likeEvent').style.color = "inherit";
  }

  document.getElementById('eventForm').style.display = "block";
}

//Closes form and resets it for the next event
function closeEventForm() {
  document.getElementById('eventForm').style.display = "none";

  document.getElementById('eventURL').style.display = "none";
  loadedPosition = "";
}

//Toggles the current event's like status
function setLikeStatus() {
  var likesCookie = getCookie("likes");
  var likesArray = JSON.parse(likesCookie);
  var currentStatus = checkLikeStatus();

  //Creates a new likes cookie if one doesn't already exist and add the event to it
  if (currentStatus) {
    likesArray.splice(likesArray.indexOf(loadedPosition, 1));
    likesArray = JSON.stringify(likesArray);
    createCookie("likes", likesArray);
    document.getElementById('likeEvent').style.color = "inherit";
    return;
  } else {
    likesArray.push(loadedPosition);
    likesArray = JSON.stringify(likesArray);
    createCookie("likes", likesArray);
    document.getElementById('likeEvent').style.color = "red";
    return;
  }
}

//Checks if the current event is liked
function checkLikeStatus() {
  var likesCookie = getCookie("likes");
  
  //Creates an empty likes cookie if one doesn't already exist
  if (likesCookie === "") {
    createCookie("likes", JSON.stringify(['0']));
    return false;
  }
  var likesArray = JSON.parse(likesCookie);
  if (likesArray.includes(loadedPosition)) {
    return true;
  } else {
    return false;
  }
  
}

//region COOKIE HANDLERS
function createCookie(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}
//endregion
</script>
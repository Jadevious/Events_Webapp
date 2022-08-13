<?php
//Same as index.php
$components = $_SERVER['DOCUMENT_ROOT'] . '/resources/Components';
$title = 'Aston Events | Bookings';

if (isset($_COOKIE['theme'])) {
  $theme = $_COOKIE['theme'];
} else {
  $_COOKIE['theme'] = 'blue-gray';
  $theme = 'blue-gray';
}

include("$components/head.php");

//Redirects user if not authenticated
if (!isset($_SESSION['authenticated'])) {
  header("Location: index.php?required=account");
}
?>

<body class="w3-<?php echo ($theme) ?>">

  <?php include("$components/navbar.php") ?>

  <div id="main" class="w3-padding-large">

  <header id="header" class="w3-container w3-bottombar w3-margin-bottom w3-round">
    <h1 class="w3-center">Your Bookings</h1>
  </header>

  <?php
    try {
    //Fetching any events matching the 
    $query = prepareQuery('SELECT Events.UEID, Events.Name, Events.Description, Events.Organiser, Events.Location, Events.ImageURL, Events.URL, DATE_FORMAT(DATE(Events.Date), "%a %D %b %Y") as eventDate, DATE_FORMAT(TIME(Events.Date), "%H:%i") as eventTime FROM Bookings INNER JOIN Events ON Bookings.UEID = Events.UEID WHERE Bookings.UUID = ? ORDER BY Date');
    $query->execute(array($_SESSION['UID']));
    $results = $query->fetchAll();
    ?>
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
        echo ("Sorry, you've not booked any events yet!");
      }
    } catch (PDOException $e) {
      echo ("Failed to retrieve bookings, please try again later");
    }


    #region EVENT BOX  
    //The miniature event box displayed for each relevant event - reused fromn events
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

    #region EVENT MODAL FORM
    ?>
    <!-- Default Event Modal appearance (taken from events.php, minus the buttons) -->
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

function openEventForm(eventPosition) {
  //Loading event information into modal
  var currentEvent = loadedEvents[eventPosition];
  document.getElementById('eventImage').src = `resources/images/events/${currentEvent['ImageURL']}`;
  document.getElementById('eventTitle').innerHTML = currentEvent['Name'];
  document.getElementById('eventDescription').innerHTML = currentEvent['Description'];
  document.getElementById('eventDate').innerHTML = `<b>Date: </b><br>${currentEvent["eventDate"]}, ${currentEvent["eventTime"]}`;
  document.getElementById('eventOrganiser').innerHTML = `<b>Organiser: </b><br>${currentEvent["Organiser"]}`;
  document.getElementById('eventLocation').innerHTML = `<b>Location: </b><br>${currentEvent["Location"]}`;
  if (currentEvent['URL']) {
    document.getElementById('eventURL').href = currentEvent['URL'];
    document.getElementById('eventURL').style.display = "inline-block";
  }


  document.getElementById('eventForm').style.display = "block";
}

function closeEventForm() {
  document.getElementById('eventForm').style.display = "none";
  document.getElementById('eventURL').style.display = "none";
}
</script>
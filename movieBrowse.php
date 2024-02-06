<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Module 1.1 - Movie Browser</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <style>
    /* : adjust the movieSummary class to achieve the following
     *   - Add a solid 1 pixel black or lightgrey border
     *   - Give the border a 10px radius
     *   - add a lightgrey box-shadow offset by (3px, 3px) and with a 6px blur
     *   - add a transition for box-shadow that lasts 0.3 seconds with an ease-in-out
     *   - Make the text centered
     *   - add 5 pixel padding all around
     **/
    .movieSummary {
      margin-bottom: 15px;
      vertical-align: bottom;
      border-style: solid;
      border-width: 1px;
      border-color: lightgrey;
      border-radius: 10px;
      box-shadow: 3px 3px 6px lightgrey;
      transition: box-shadow 0.3s ease-in-out;
      text-align: center;
      padding: 5px;
    }
    .summaryTitle { display: block; font-size: medium; height: 4.5em; }
    .summaryInfo { display: block; font-size: medium; height: 5em; }
    </style>
  </head>
  <body>
    <div class='container'>
      <div class='row'>
        <div class="pb-2 mt-4 mb-2 border-bottom" style="width: 100%;">
          <h1>MyFlix Movie Browser</h1>
          Click on a movie below for more information.
        </div>
      </div>
<?php
// Establish the database connection
include "database.php"; //: <-- Don't forget to update this file with your username and password
$db = connectToDatabase("myflix");
if($db == NULL) {
  die("<p>Failed to connect to database.</p></body></html>\n");
}

// Prepare and execute a query for the basic movie information
// Fill in the Query below to retrieve the following values from the 'movies' table
//    - id, title, year, genres, image, rated
$stmt = simpleQuery($db, "SELECT id, title, year, genres, image, rated FROM movies ORDER BY year");
if($stmt == NULL) {
  die("<p>SQL Query Error</p></body></html>\n");
}

// Bind variables to the results (same order as in the query)
$stmt->bind_result($movieID, $movieName, $movieYear, $movieGenre, $movieImage, $movieRating);

//Process the resutls and output in bootstrap grid form
echo "      <div class='row'>\n";

while($stmt->fetch()) {
  // Output a grid cell for the current movie
?>
        <div class='col-sm-6 col-md-4 col-lg-3'>
          <a href='movieDetails.php?movieID=<?=$movieID?>' style="text-decoration:none; color:inherit;">
            <div class='movieSummary' onmouseover='overCard(this)' onmouseout='outCard(this)'>
              <span class=summaryTitle><?=$movieName?></span>
              <image src=..\assets\images\Assignment1.1\myfliximages-2024\thumbs\<?=$movieImage?> height=250px alt=<?=$movieName?>>
              <br>
              <span class=summaryInfo><?=$movieGenre?><br><?=$movieYear?> <?=$movieRating?></span>
            </div> <!-- /movieSummary-->
          </a>
        </div> <!-- /col* -->
<?php
} //end of while loop

echo "      </div> <!-- /row -->\n";

// Close the database connection
$stmt->close();
$db->close();
?>
    </div> <!-- /container -->

    <!-- Custom JS -->
    <script>
      function overCard(card) {
        card.style.boxShadow = "5px 5px 10px gray";
      }

      function outCard(card) {
        card.style.boxShadow = "3px 3px 6px rgb(170,170,170)";
      }
    </script>

    <!-- Bootstrap JS (with popper integerated) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Movie Details</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  </head>
  <body>
<?php
if(isset($_GET['movieID']))
{
  // Get ID of movie from form GET data
  $movieID = $_GET['movieID'];

  // 1. Connect to the database
  include "database.php"; // <-- Don't forget to update this file with your username and password
  $db = connectToDatabase("myflix");
  if ($db->connect_error) {
    die("<p>Failed to connect to database.</p></body></html>\n");
  }

  // 2. Run the Query
  $query = "SELECT title,year,rated,imdbrating,description,image,genres,directors,writers,actors FROM movies WHERE id=?;";
  $stmt = simpleQueryParam($db, $query, "s", $movieID);
  if($stmt == NULL) {
    die("<p>SQL Query Error</p></body></html>\n");
  }

  // 3. Bind and access the result variables
  if(!$stmt->bind_result($movieName, $movieYear, $movieRated, $movieIMDB, $movieDesc, $movieImage,
    $movieGenres, $movieDirectors, $movieWriters, $movieActors)) {
    die("<p>Query Result Binding Failed: " . $stmt->error . "</p></div></body></html>");
  }

  // Fetch and display the results
  if($stmt->fetch()) {
    // TODO: Adjust the following to present all of this information in a more 
    //   organized format. You must use an image tag to display the full resolution
    //   poster, a table to organize all the data (or the Bootstrap column system),
    //   and CSS to keep things looking styled similar to the movieBrowse page.
    //   Feel free to use Bootstrap classes to achieve better styling.
?>
    <div class="container-fluid p-3 bg-danger text-white text-center">
      <h1><?=$movieName?></h1>
      <p>
        <?=$movieYear?><br>
        <?=$movieGenres?>
      </p>
    </div>
    <div class="container mt-4 mx-2">
      <div class="row">
        <div class="col-sm-3">
          <image src=\assets\images\Assignment1.1\myfliximages-2024\posters\<?=$movieImage?> class="img-thumbnail" alt=<?=$movieName?>>
        </div>
        <div class="col-sm-6">
          <h3>Summary</h3>
          <p><?=$movieDesc?></p>
        </div>
        <div class="col-sm-3">
          <h3>Cast & Crew</h3>
          <p>
            <b>Director(s):</b> <?=$movieDirectors?><br>
            <b>Writers:</b> <?=$movieWriters?><br>
            <b>Actors:</b> <?=$movieActors?>
          </p>
          <h3> Rating & Score</h3>
          <p>
            <b>Rating:</b> <?=$movieRated?><br>
            <b>IMDB Score:</b> <?=$movieIMDB?><br>
          </p>
        </div>
      </div>
    </div>
<?php
  }
} else { // Not isset($_GET['movieID'])
?>
        <p>Error: no movie ID provided.</p>
<?php
}
?>

  <!-- Bootstrap JS (with popper integerated) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  </body>
</html
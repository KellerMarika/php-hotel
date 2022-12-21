<?php

$hotels = [
  [
    'name' => 'Hotel Belvedere',
    'description' => 'Hotel Belvedere Descrizione',
    'parking' => true,
    'vote' => 4,
    'distance_to_center' => 10.4
  ],
  [
    'name' => 'Hotel Futuro',
    'description' => 'Hotel Futuro Descrizione',
    'parking' => true,
    'vote' => 2,
    'distance_to_center' => 2
  ],
  [
    'name' => 'Hotel Rivamare',
    'description' => 'Hotel Rivamare Descrizione',
    'parking' => false,
    'vote' => 1,
    'distance_to_center' => 1
  ],
  [
    'name' => 'Hotel Bellavista',
    'description' => 'Hotel Bellavista Descrizione',
    'parking' => false,
    'vote' => 5,
    'distance_to_center' => 5.5
  ],
  [
    'name' => 'Hotel Milano',
    'description' => 'Hotel Milano Descrizione',
    'parking' => true,
    'vote' => 2,
    'distance_to_center' => 50
  ],
];

$filtredHotels = [];
$startToFilter = isset($_GET["parking"]) || isset($_GET["vote"]);

if ($startToFilter) {

  foreach ($hotels as $hotel) {
    $isIncluded = true;


    if (isset($_GET["parking"]) && !(($hotel["parking"]) == ($_GET["parking"]))) {
      $isIncluded = false;
    }

    if (isset($_GET["vote"]) && $hotel["vote"] < $_GET["vote"]) {
      $isIncluded = false;
    }
    if ($isIncluded) {
      $filtredHotels[] = $hotel;
    }
  }
} else {
  $filtredHotels = $hotels;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOTELS</title>

  <!-- font-family: 'Roboto', sans-serif; -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <!-- font-family: fontawesome -->
  <script src="https://kit.fontawesome.com/a19b158346.js" crossorigin="anonymous"></script>

  <!-- bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>


<body>
  <div class="form-container position-absolute p-4  m-5  rounded-4 w-25">
    <!-- action (pagina corrente) e method (GET) di default -->
    <form class="m">
      <fieldset>
        <legend class=" border-bottom">
          <h1 class="text-danger fw-bold text-uppercase">find your hotel:</h1>
        </legend>

        <div class="form-group ">
          <label class="hs-6 fw-bold my-2" for="vote">Min vote accepted</label>
          <select class="form-select" name="vote" id="vote">

            <?php for ($i = 1; $i <= 5; $i++) {     ?>
              <option value="<?php echo $i ?>"  <?php echo isset($_GET["vote"])? "selected" : "" ?>> <?php echo $i === 1 ? $i . " stella" : $i . " stelle" ?></option>
            <?php } ?>

          </select>
        </div>
        <div class="d-flex justify-content-between my-3 ">
        <div class="form-group">
          <label class="hs-6 fw-bold  pe-3"> parking required:</label>
          <input type="checkbox" id="parking-true" name="parking" value="1" <?php echo isset($_GET["parking"])? "checked" : "" ?> >
        </div>

          <button class="btn btn-danger my-2">search!</button>
        </div>
      </fieldset>
    </form>

    <table class="table table-striped rounded-3 text-center">
      <thead>
        <tr>
          <?php foreach ($hotels[0] as $key => $value) {   ?>
            <th>
              <?php echo $key === "distance_to_center" ? "distance" : $key; ?>
            </th>
          <?php }  ?>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($filtredHotels as $hotel) { ?>
          <tr>
            <td> <?php echo $hotel["name"]  ?></td>
            <td class=""> <?php echo $hotel["description"]  ?></td>
            <td> <?php echo $hotel['parking'] ? ("present") : ("absent") ?></td>
            <td> <?php echo $hotel["vote"] ?>/5</td>
            <td> <?php echo $hotel["distance_to_center"] ?>Km</td>
          </tr>
        <?php }  ?>
      </tbody>

    </table>

  </div>


  <div class="map-container position-relative w-100 h-100">
    <?php foreach ($filtredHotels as $hotel) {  ?>
      <div class="card-container position-absolute" id=<?php echo $hotel['name'] ?>>
        <div class="card p-1">

          <div class="card-header text-center ">
            <h4 class="name title"><?php echo $hotel['name'] ?></h4>
          </div>

          <div class="card-body">
            <p class="description"> <?php echo $hotel['description'] ?></p>

            <h6 class="parking"> <span class="pe-2">parking:</span>
              <?php echo $hotel['parking'] ? ("present") : ("absent") ?></h6>

            <h6 class="distance"> <span class="pe-2">distance:</span>
              <?php echo " {$hotel['distance_to_center']}km" ?></h6>

            <div class="distance d-flex align-items-baseline">
              <h6 class="pe-2">vote:</h6>

              <div class="vote stars-container gradient-background">
                <div class="negative-vote-percentage bg-light" <?php echo " style= width:" . 100 - $hotel['vote'] * 20 . "%"  ?>></div>

                <?php for ($i = 0; $i < 5; $i++) {     ?>
                  <i class="fa fa-star"></i>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <i class="fa-sharp fa-solid fa-location-dot fs-1 position-absolute text-danger"></i>
      </div>
    <?php  } ?>
  </div>
</body>

</html>

<style>
  body {
    background-color: #710f10;
    background-image: url("img/hotel-gioco-copertina.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    overflow: hidden;
    font-family: 'Roboto', sans-serif;
  }

  .form-container {
    top: 50px;
    background: rgb(247,140,0);
    background: rgb(247,165,0);
background: linear-gradient(0deg, rgba(247,165,0,1) 0%, rgba(255,201,0,1) 5%, rgba(238,217,139,1) 22%, rgba(240,215,125,1) 63%, rgba(241,214,114,1) 87%, rgba(255,198,0,1) 98%, rgba(249,148,5,1) 100%);
  }
  /* stars */
  .gradient-background {
    position: relative;
    display: flex;
    justify-content: end;
    background: -webkit-linear-gradient(0deg, rgba(247, 0, 0, 1) 0%, rgba(255, 201, 0, 1) 50%, rgba(5, 249, 8, 1) 100%);
    width: fit-content;
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .negative-vote-percentage {
    position: absolute;
    height: 100%;
    background-color: black;
  }

  /* card */
  #Hotel {
    width: fit-content;
    transform: scale(80%);
    background-color: #efd884;
  }

  .card:hover {
    width: fit-content;
    height: inherit;
  }

  .card:hover+.fa-location-dot {
    display: none;

  }

  .card {
    height: 60px;
    overflow: hidden;
  }


  #Hotel:nth-child(1) {
    transform: translateX(1040px) translateY(630px);
  }

  #Hotel:nth-child(2) {
    transform: translateX(660px) translateY(590px);
  }

  #Hotel:nth-child(3) {
    transform: translateX(1580px) translateY(750px);
  }

  #Hotel:nth-child(4) {
    transform: translateX(1300px) translateY(700px);
  }

  #Hotel:nth-child(5) {
    transform: translateX(1380px) translateY(430px);
  }




  .fa-location-dot {
    bottom: 0;
    transform: translateY(50px);
  }
</style>
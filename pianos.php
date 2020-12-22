
 <?php
 require_once('partials/head.php');
 require_once('conn.php');
 require_once("functions.php");

 $pdo = connectDB('piano_shop', 'admin', 'admin');
 echo "<div class='mt-5'></div>";
 if($_GET['type']) {
   //echo "type is comming from get<br>";
   if($_GET['type']==1 || $_GET['type']==2) { // valid type
     // echo "type is valid $_GET[type]";
     $pianos_data = getPianosByType($pdo,$_GET['type']);

   }
  else {
     // echo "type is another number, invalid type<br>,getting all pianos<br>";
     $pianos_data = dataDashboardPiano($pdo);
   }
 }
 else if ($_GET['brand_id']){
   if ($_GET['brand_id']>6){
     // echo "brand_id is comming from get, not a vaild id getting all pianos<br>";
     $pianos_data = dataDashboardPiano($pdo);
   } else {
     $pianos_data = getPianosByBrand($pdo,$_GET['brand_id']);
   }
 }
 else {
   // echo "unrecognized params from get, getting all pianos<br>";
   $pianos_data = dataDashboardPiano($pdo);
 }

 $brands = getBrands($pdo);


  ?>
<title>Pianos</title>
</head>
<body>
  <?php require_once('partials/top_nav.php');?>

  <main>
    <div class="container bg-light mt-5 pt-4">
      <div class="row">
          <div class="col-12 col-md-10 offset-md-1  d-flex justify-content-end">
            <form class="form-inline" action="pianos.php" method="get">
              <label for="all">All: </label>
              <input type="radio" name="all" class="form-control mr-3" value="all" onchange='this.form.submit()'>
              <!-- <select class="form-control" name="type" id="piano_type" onchange='this.form.submit()'>
                <option value="">choose</option>
              </select> -->
            </form>
              <form class="form-inline" action="pianos.php" method="get">
                <label for="type">Filter by type: </label>
                <select class="form-control mr-3" name="type" id="piano_type" onchange='this.form.submit()'>
                  <option value="">choose</option>
                  <option value="1">Upright</option>
                  <option value="2">Grand piano</option>
                </select>
              </form>
              <form class="form-inline" action="pianos.php" method="get" >
                <label for="brand_id">Filter by brand: </label>
                <select class="form-control" name="brand_id" id="brand_id" onchange='this.form.submit()' >
                  <option value="">choose</option>
                  <?php foreach ($brands as $brand) { ?>
                    <option value='<?="$brand[brand_id]";?>' >
                      <?="$brand[name]";?>
                    </option>
                  <?php } ?>
                </select>
                <!-- <input type="submit" name="submit" value="Submit" style="visibility:hidden;"> -->
              </form>
          </div>
      </div>
    </div>
    <div class="container bg-light mt-5">
      <?php  foreach($pianos_data as $piano){?>
      <div class="row mt-5">
        <div class="col-12 col-md-10 offset-md-1">
          <div class="card mb-3" >
            <div class="row no-gutters">
              <div class="col-md-4">
                <img src="<?=$piano['img_url']?>" class="card-img" alt="piano">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h3 class="card-title"><?=$piano['name']?></h3>
                  <p class="card-text"><?=$piano['description']?></p>
                </div>
                <div class="card-footer">
                  <button type="button" class="btn btn-info" name="button">Watch it</button>
                  <button type="button" class="btn btn-info" name="button">Learn more</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!--end row-->
    <?php }?>

    </div>
  </main>

  <?php include_once("partials/modal_contact.html") ?>
  <?php require_once('partials/footer.php');?>
  <?php require_once('partials/js_scripts.php');?>
</body>
</html>
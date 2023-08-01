<style>
      nav .fas{
    display:none;
}
      nav{
    display:flex;
    align-items: right;
    justify-content: space-between;
    flex-wrap: wrap;
}

nav ul li{
    display:inline;
    margin:10px 20px;
}
nav ul li a{
    color:black;
    text-decoration: none;
    font-size:18px;
    position:relative;
}
nav ul li a::after{
content:'';
width: 0%;
height:3px;
background:#ff004f;
position: absolute;
left:0;
bottom:-6px;
transition:0.5s;
}
nav ul li a:hover::after{
    width:100%;
}
@media only screen and (max-width:600px){

nav .fas{
    display:block;
    font-size:25px;
}
nav ul{
    background: #fff;
    position:fixed;
    right:-200px;
    top:0;
    width:200px;
    height:100vh;
    padding-top:50px;
    z-index:2;
 transition:right 0.5s;
}
nav ul li{
    display:block;
    margin:25px;
}

nav ul .fas{
    position:absolute;
    top:25px;
    left:25px;
    cursor:pointer;
}
nav ul li a::after{
content:'';
width: 0%;
height:3px;
background:#ff004f;
position: absolute;
left:0;
bottom:-6px;
transition:0.5s;
}
nav ul li a:hover::after{
width:100%;
}
}
   
  </style>

<script>
$(document).ready(function() {
	$(".wish-icon i").click(function(){
		$(this).toggleClass("fa-heart fa-heart-o");
	});
});	
</script>
<script>

var sidemeu =document.getElementById("sidemenu");
        function openmenu(){
            sidemeu.style.right="0";
        }
        function closemenu(){
sidemeu.style.right="-200px";
}
</script>


    
</head>
<body>
  <?php
  include 'header.php';
  ?>
<div class="container-xl">
  <div class="row">
    <div class="col-md-12">
      <h2 align="center"> <b><u>CATTLE</u></b></h2>
      <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>   
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
          <?php
          include 'database/conn.php';
          // Assuming you're using PHP and have a database connection
          $query = "SELECT * FROM cows";
          $result = mysqli_query($conn, $query);

          $totalCows = mysqli_num_rows($result);
          $numItemsPerGroup = 4;
          $numGroups = ceil($totalCows / $numItemsPerGroup);

          $group = 0;
          while ($row = mysqli_fetch_assoc($result)) {
            $cow_id = $row['cow_id'];
            $name = $row['cow_name'];
            $image = $row['image'];

            if ($group % $numItemsPerGroup === 0) {
              $activeClass = ($group === 0) ? 'active' : '';
              echo '<div class="item carousel-item ' . $activeClass . '"><div class="row">';
            }
          ?>
            <div class="col-sm-3">
              <div class="thumb-wrapper">
                <span class="wish-icon"><i class="fa fa-heart-o"></i></span>
                <div class="img-box">
                  <a href="cow.php?cow_id=<?php echo $cow_id; ?>">
                    <img src="<?php echo $image; ?>" class="img-fluid" alt="">
                  </a>
                </div>
                <div class="thumb-content">
                  <h4><?php echo $name; ?></h4>
                  <div class="star-rating">
                    <ul class="list-inline">
                      <!-- Add your star rating code here -->
                    </ul>
                  </div>
                  <a href="cow.php?cow_id=<?php echo $cow_id; ?>" class="btn btn-primary">View</a>
                </div>
              </div>
            </div>
          <?php
            $group++;

            if ($group % $numItemsPerGroup === 0 || $group === $totalCows) {
              echo '</div></div>';
            }
          }
          ?>
        </div>
      </div>
	  
      <!-- Carousel controls -->
      <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
        <i class="fa fa-angle-left"></i>
      </a>
      <a class="carousel-control-next" href="#myCarousel" data-slide="next">
        <i class="fa fa-angle-right"></i>
      </a>
    </div>
  </div>
		</div>

    
	<section id="feeds">
	<div class="container-xl">
  <div class="row">
    <div class="col-md-12">
      <h2 class="text text-black py-3" align="center"> <b><u>ANIMAL FEEDS</u></b></h2>
	  <div class="table-responsive">
<!-- Milk Table -->
<!-- Milk Table -->
<table id="feeds-table" class=" table table-bordered table-hover table-striped" width="100%" cellspacing="0">
  <!-- table content here -->
 
  <thead>
    <tr>
      <th>FEED ID</th>
      <th>FEED TYPE</th>
      <th>QUANTITY</th>
      <th>COST</th>
      <th>DATE</th>
      <th>STATUS</th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    // Fetch cow images from the database
    $feedsQuery = "SELECT feeds.*,feedtable.name FROM feeds JOIN feedtable ON feeds.feed_id=feedtable.feed_id";
    $feedsResult = mysqli_query($conn, $feedsQuery);
    $feedsData = array();
    while ($row = mysqli_fetch_assoc($feedsResult)) {
      $feedsData[] = $row;
    }
    
    // Define the number of records per page
    $recordsPerPage = 10;
    
    // Get the total number of pages
    $totalPages = ceil(count($feedsData) / $recordsPerPage);
    
    // Get the current page number
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    
    // Calculate the starting and ending indices of the data array for the current page
    $startIndex = ($currentPage - 1) * $recordsPerPage;
    $endIndex = $startIndex + $recordsPerPage;
    
    // Loop through the data array to display the table rows for the current page
    for ($i = 0; $i < count($feedsData); $i++) {
      $feeds_id = $feedsData[$i]['id'];
      $feed_type = $feedsData[$i]['name'];
      $quantity = $feedsData[$i]['quantity'];
      $cost = $feedsData[$i]['cost'];
      $date = $feedsData[$i]['date'];
      $status = $feedsData[$i]['status'];
      
    ?>
    <tr <?php if ($i < $startIndex || $i >= $endIndex) { echo 'style="display: none;"'; } ?>>
      <td><?php echo $feeds_id ?></td>
      <td><?php echo $feed_type ?></td>
      <td><?php echo $quantity ?></td>
      <td><?php echo $cost ?></td>
      <td><?php echo $date ?></td>
      <td><?php echo $status ?></td>
     
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<!-- Pagination -->
<div class="pagination">
  <?php
  // Display pagination links
  for ($i = 1; $i <= $totalPages; $i++) {
    echo '<a href="?page=' . $i . '"' . ($i == $currentPage ? ' class="active"' : '') . '>' . $i . '</a>';
  }
  ?>
</div>

<script>
$(document).ready(function() {
  // Handle pagination link click event
  $('.pagination a').click(function(event) {
    event.preventDefault();
    
    // Get the page number from the clicked link
    var page = $(this).attr('href').split('=')[1];
    
    // Remove the active class from all pagination links
    $('.pagination a').removeClass('active');
    
    // Add the active class to the clicked link
    $(this).addClass('active');
    
    // Show the corresponding table rows for the selected page
    var startIndex = (page - 1) * <?php echo $recordsPerPage ?>;
    var endIndex = startIndex + <?php echo $recordsPerPage ?>;
    $('#feeds-table tbody tr').hide();
    $('#feeds-table tbody tr').slice(startIndex, endIndex).show();
  });
});
</script>

	</div>
  </div>
		</div>
  </div>
	</section>
  
 
    
</body>

<?php include_once("custom/_ext/dashboard_footer.php");?>
<!---------------------------------------------------------------------------->
<?php include_once("custom/_ext/default_js.php");?>

<?php include_once("custom/_ext/dashboard_owlphin-box.php");?>


<footer class="sticky-footer" align="center">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Steve's Farm 2023</span>
            </div>
          </div>
        </footer>

      
</html>                                		
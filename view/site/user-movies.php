<?php 
//  $this->print_stuf($this->movie_info_controller);
?>

<section class="movie-section padding-top padding-bottom">
    <div class="container">
        <div class="row flex-wrap-reverse justify-content-center">
            <div class="col-lg-9 mb-50 mb-lg-0">
                <div class="filter-tab tab">
                        
<?php
foreach ($this->movie_info_controller as $key => $value) { 
    
$id = $this->movie_info_controller[$key]["movie_id"];
$name = $this->movie_info_controller[$key]["movie_name"];
$tamato_rating = $this->movie_info_controller[$key]["movie_tomato_rating"];
$box_office_rating = $this->movie_info_controller[$key]["movie_box_office_rating"];
$img = $this->movie_info_controller[$key]["movie_img"];
$available = $this->movie_info_controller[$key]["available"];
$dates=$this->movie_info_controller[$key]["dates"];
$seats = $this->movie_info_controller[$key]["chacked_seats"];
// $this->print_stuf($seats);

?>

                
<div class="col-sm-6 col-lg-4">
    <div class="movie-grid">
        <div class="movie-thumb c-thumb">
            <a href="movie-details.html">
                <img src="<?php echo $img;?>" alt="movie">
            </a>
        </div>
        <div class="movie-content bg-one">
            <h5 class="title m-0">
                <a href="movie-details.html"><?php echo $name?></a>
            </h5>
            <h7>Date:- <?php echo $dates?></h7> 
            <p>Seat's:- <?php 
                    foreach ($seats as $key => $value) {
                        echo "[ ".$value." ]";
                    }
                    ?></p> 
            <ul class="movie-rating-percent">
                <li>
                    <div class="thumb">
                        <img src="<?php echo $this->assets;?>images/icons/heart.png" alt="movie">
                    </div>
                    <span class="content"><?php echo $tamato_rating?></span>
                </li>
                <li>
                    <div class="thumb">
                        <img src="<?php echo $this->assets;?>images/movie/cake.png" alt="movie">
                    </div>
                    <span class="content"><?php echo $box_office_rating?></span>
                </li>
               
            </ul>
        </div>
    </div>
</div>
            
            
<?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
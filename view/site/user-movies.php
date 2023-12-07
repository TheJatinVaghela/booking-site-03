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
            <label for="user-booked-movie<?php echo $id ;?>-seats">Seat's:- </label>
            <select id="user-booked-movie<?php echo $id ;?>-seats" style="background: #16277d;"><?php 
                    foreach ($seats as $key => $value) {
                        
                        echo "<option value=$value> $value </option>";
                    }
                    ?></select> 
            <button class="user-booked-movies" id="user-booked-movie-<?php echo $id ;?>"
            style="background: #b02e28;"
            onclick="deleteUserBookedSeat(<?php echo $id; ?>,this)" >remove</button>
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

<script>
    function deleteUserBookedSeat(id,event){
        const selected_seat = event.previousElementSibling;
        let date =selected_seat.previousElementSibling.previousElementSibling.innerText;
        date = date.replace("Date:- ","");

        const data ={
            "movie_id" : id,
            "date_time" : date,
            "seatNum":selected_seat.value,
            "user_id":<?php echo $this->user_info["user_id"] ;?>
        }
        // console.log(data);
        fetch("http://localhost/clones/booking-site-03/removeBookedSeat", {
            headers: {
                "Content-Type": "application/json", // sent request
                "Accept": "application/json" // expected data sent back
            },
            method: 'POST',
            body: JSON.stringify(data)
        }).then((reponse)=>{
            window.location.replace("http://localhost/clones/booking-site-03/user-movies");
           return reponse.json();
        }).then((result)=> {
            console.log(result.Ans);
            if(result.Ans === true){
              }else{
                  alert("There was An Error realoed Site FOr more info");
              }
        })
    }
</script>
<!-- ==========Banner-Section========== -->
<section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="assets/images/banner/banner02.jpg"></div>
        <div class="container">
            <div class="banner-content">
                <h1 class="title bold">get <span class="color-theme">movie</span> tickets</h1>
                <p>Buy movie tickets in advance, find movie times watch trailer, read movie reviews and much more</p>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Ticket-Search========== -->
      
    <!-- ==========Ticket-Search========== -->

    <!-- ==========Movie-Section========== -->
    <section class="movie-section padding-top padding-bottom">
        <div class="container">
            <div class="row flex-wrap-reverse justify-content-center">
              
                <div class="col-lg-9 mb-50 mb-lg-0">
                    <div class="filter-tab tab">
                     
   
                       <div class="tab-item active">
                                <div class="movie-area mb-10">


                                    
                               <?php
                                foreach ($this->get_data as $key => $value) { 
                                    
                                $id = $value["movie_id"];
                                $name = $value["movie_name"];
                                $tamato_rating = $value["movie_tomato_rating"];
                                $box_office_rating = $value["movie_box_office_rating"];
                                $img = $value["movie_img"];
                                $available = $value["available"];
                                ?>

                                 <form action="movie-seats" class="movie-list" method="post">
                                        <div class="movie-thumb c-thumb">
                                                <a >
                                                    <img src="<?php echo $img;?>" alt="movie">
                                                </a>
                                        </div>
                                        <div class="movie-content bg-one">
                                            <h5 class="title">
                                                <a href="movie-details.html"><?php echo $name;?></a>
                                            </h5>
                                            <p class="duration">2hrs 50 min</p>
                                            <div class="movie-tags">
                                                <a href="">action</a>
                                                <a href="">adventure</a>
                                                <a href="">fantasy</a>
                                            </div>
                                            <div class="release">
                                                <span>Release Date : </span> <a href=""> November 8 , 2020</a>
                                            </div>
                                            <ul class="movie-rating-percent">
                                                <li>
                                                    <div class="thumb">
                                                        <img src="<?php echo $this->assets;?>images/movie/tomato.png" alt="movie">
                                                    </div>
                                                    <span class="content"><?php echo $tamato_rating;?>%</span>
                                                </li>
                                                <li>
                                                    <div class="thumb">
                                                        <img src="<?php echo $this->assets;?>images/movie/cake.png" alt="movie">
                                                    </div>
                                                    <span class="content"><?php echo $box_office_rating;?>%</span>
                                                </li>
                                                <li class="header-button pr-0">
                                                <input type="text" disabled name="available" value="<?php echo $available?>" style="color:green; border:none; display:contents;">
                                                    <?php echo ($available == 1)? '🟢' : '🔴';  ?>
                                                </input>
                                            </li>
                                            </ul>
                                            <div class="book-area">
                                                <div class="book-ticket">
                                                    <div class="react-item">
                                                        <a href="">
                                                            <div class="thumb">
                                                                <img src="<?php echo $this->assets;?>images/icons/heart.png" alt="icons">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="react-item mr-auto">
                                                      
                                                            <div class="thumb">
                                                                <img src="<?php echo $this->assets;?>images/icons/book.png" alt="icons">
                                                            </div>
                                                            <input type="text" hidden name="last_page" value="<?php echo $_SERVER["PATH_INFO"]?>">
                                                            <button type="submit" name="movie_id" value="<?php echo $id?>"
                                                             style="width:50%; background-color:green; margin-left:.5rem;">book ticket</button>
                                                      
                                                    </div>
                                                    <div class="react-item">
                                                        <a href="" class="popup-video">
                                                            <div class="thumb">
                                                                <img src="<?php echo $this->assets;?>images/icons/play-button.png" alt="icons">
                                                            </div>
                                                            <span>watch trailer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                                
                            <?php 
                                } 
                            ?>


                                </div>
                            </div> 
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========Movie-Section========== -->

    
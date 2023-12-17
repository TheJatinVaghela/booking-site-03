    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="assets/images/banner/banner01.jpg"></div>
        <div class="container">
            <div class="banner-content">
                <h1 class="title  cd-headline clip"><span class="d-block">book your</span> tickets for 
                    <span class="color-theme cd-words-wrapper p-0 m-0">
                        <b class="is-visible">Movie</b>
                        <b>Event</b>
                        <b>Sport</b>
                    </span>
                </h1>
                <p>Safe, secure, reliable ticketing.Your ticket to live entertainment!</p>
            </div>
        </div>
    </section>
    <!-- ==========Banner-Section========== -->

    <!-- ==========Ticket-Search========== -->

    <!-- ==========Ticket-Search========== -->

    <!-- ==========Movie-Main-Section========== -->
    <section class="movie-section padding-top padding-bottom bg-two">
        <div class="container">
            <div class="row flex-wrap-reverse justify-content-center">
               
                <div class="col-lg-9">
                    <div class="article-section padding-bottom">
                        <div class="section-header-1">
                            <h2 class="title">movies</h2>
                            <a class="view-all" href="all-movies-list">View All</a>
                        </div>
                        <div class="row mb-30-none justify-content-center">
                            
                            <?php
                           
                            foreach ($this->get_data as $key => $value) { 
                                if($key == 3){
                                    break;
                                }
                                $id = $value["movie_id"];
                                $name = $value["movie_name"];
                                $tamato_rating = $value["movie_tomato_rating"];
                                $box_office_rating = $value["movie_box_office_rating"];
                                $img = $value["movie_img"];
                                $available = $value["available"];
                                ?>
                                    <!-- //    echo "<pre>";
                                        //    print_r($value);
                                        //    echo "</pre>"; -->
                            <form class="col-sm-6 col-lg-4" action="movie-seats" method="post">
                                <div class="movie-grid">
                                    <div class="movie-thumb c-thumb">
                                        <a >
                                            <img src="<?php echo $img;?>" alt="movie">
                                        </a>
                                    </div>
                                    <div class="movie-content bg-one">
                                        <h5 class="title m-0">
                                            <a name="movie_name" value="alone"><?php echo $name?></a>
                                        </h5>
                                        <ul class="movie-rating-percent">
                                            <li>
                                                <div class="thumb">
                                                    <img src="<?php echo $this->assets;?>images/movie/tomato.png" alt="movie">
                                                </div>
                                                <span class="content" name="movie_tomato_rating" ><?php echo $tamato_rating?>%</span>
                                            </li>
                                            <li>
                                                <div class="thumb">
                                                    <img src="<?php echo $this->assets;?>images/movie/cake.png" alt="movie">
                                                </div>
                                                <span class="content" name="movie_box_office_rating"><?php echo $box_office_rating?>%</span>
                                            </li>
                                            <li class="header-button pr-0">
                                                <input type="text" disabled name="available" value="<?php echo $available?>" style="color:green; border:none; display:contents;">
                                                    <?php echo ($available == 1)? '🟢' : '🔴';  ?>
                                                </input>
                                            </li>
                                            <input type="text" hidden name="last_page" value="<?php echo (isset($_SERVER["PATH_INFO"]))? $_SERVER["PATH_INFO"] : "home" ?>">
                                            <li class="header-button pr-0">
                                                <button type="submit" name="movie_id" value="<?php echo $id?>" style="color:blue;">book ticket</button>
                                            </li>
                                        </ul>
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
    </section>
    <!-- ==========Movie-Main-Section========== -->
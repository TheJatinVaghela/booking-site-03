<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from pixner.net/boleto/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 05 Nov 2023 08:47:24 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="<?php echo $this->assets;?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/all.min.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/animate.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/flaticon.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/odometer.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/nice-select.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/jquery.animatedheadline.css">
    <link rel="stylesheet" href="<?php echo $this->assets;?>css/main.css">

    <link rel="shortcut icon" href="<?php echo $this->assets ;?>images/favicon.png" type="image/x-icon">

    <title>BOOKING - 2</title>


</head>

<body>
    <?php //print_r($this->user_info)?>
    <!-- ==========Preloader========== -->
    <!-- <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div> -->
    <!-- ==========Preloader========== -->
    <!-- ==========Overlay========== -->
    <div class="overlay"></div>
    <a href="#0" class="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- ==========Overlay========== -->

    <!-- ==========Header-Section========== -->
    <header class="header-section">
        <div class="container">
            <div class="header-wrapper">
                <div class="logo">
                    <a href="index.html">
                        <img src="<?php echo $this->assets;?>images/logo/logo.png" alt="logo">
                    </a>
                </div>
                <ul class="menu">
                    <li>
                        <a href="http://localhost/clones/booking-site-03/home" class="active">Home</a>
                    </li>
                    <li>
                        <a href="all-movies-list">View All Movies</a>
                    </li>
                    <li>
                        <a href="#0">🛒</a>
                        <ul class="submenu">
                            <li>
                                <a href="user-movies">MOVIES</a>
                            </li>
                        </ul>
                    </li>
                  
                    <?php 
                        if(isset($this->user_info["user_name"])){
                            $name = $this->user_info["user_name"];
                            
                            ?>
                            
                                <li class="header-button pr-0">
                                    <a href="http://localhost/clones/booking-site-03/user"><?php echo $name?></a>
                                </li>
                        <?php   
                        }else{ ?>
                                <li class="header-button pr-0">
                                    <a href="sign-in">join us</a>
                                </li>
                        <?php }
                    ?>
                    
                </ul>
                <div class="header-bar d-lg-none">
					<span></span>
					<span></span>
					<span></span>
				</div>
            </div>
        </div>
    </header>
    <!-- ==========Header-Section========== -->

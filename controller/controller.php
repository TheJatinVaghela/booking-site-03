<?php
require_once("./model/model.php");
class controller extends model{
    public $date="";
    public $datetime;
    public $seat_info;
    public $last_page;
    public $movie_id;
   public function __construct() {
    parent::__construct();
    
    switch ($_SERVER["PATH_INFO"]) {
        case '/home':{
            $this->site_header_footer("view/site/home.php");
            break;
        }
        case '/sign-in':{
            if(isset($_REQUEST["sign_in"])){
                $answer = $this->get_user("account",$_REQUEST["user_email"],"user_email");
                if($answer == false){
                    echo "Please enter valid information";
                }else{
                    setcookie("user_id", $answer["user_id"], time() + (86400 * 30), "/"); // 86400 = 1 day
                    header("Location:home");
                }
            }
            $this->site_header_footer("view/site/sign-in.php");
            break;
        }
        case '/sign-up':{
            if(isset($_REQUEST["sign_up"])){
                if($_REQUEST["user_pass"] == $_REQUEST["user_pass_2"] && $_REQUEST["Terms"] == "on"){
                    $data = ["user_name"=>$_REQUEST["user_name"],"user_email"=>$_REQUEST["user_email"],"user_password"=>$_REQUEST["user_pass"]];
                    $answer = $this->add_user("account",$data,"user_email");
                    if($answer == true){
                        $answer = $this->get_user("account",$_REQUEST["user_email"],"user_email");
                        if($answer !== false){
                            setcookie("user_id", $answer["user_id"], time() + (86400 * 30), "/"); // 86400 = 1 day
                            header("Location:home");
                        }
                    }else{
                        $this->print_stuf("ERROR: 404");
                    }
                }else{
                    $this->print_stuf("Password not same <br> or <br> Please accept Terms");
                }
            }
            $this->site_header_footer("view/site/sign-up.php");
            break;
        }
        
        case "/user":{
            if(!isset($_COOKIE["user_id"]) || $_COOKIE["user_id"] == 0){
                header("Location:http://localhost/clones/booking-site-03/sign-in");
                break;
            };
            $this->user_info = $this->get_user("account",$_COOKIE["user_id"],"user_id");
            $this->print_stuf($this->user_info);
            if(isset($_REQUEST["delete_ac"])){
                $answer = $this->delete("account",$this->user_info["user_id"],"user_id",);
                // $this->print_stuf($answer);
                 if($answer == true){
                    $cookie_name ="user_id";
                    setcookie($cookie_name, "0", time() + (86400 * 30), "/"); // 86400 = 1 day
                    header("Location:http://localhost/clones/booking-site-03/sign-up");
                 }else{
                    echo "error: " . $answer ."";
                 }
            };
            if(isset($_REQUEST["log_out"])){
                if($_COOKIE["user_id"]){
                    $cookie_name ="user_id";
                 
                    // $this->print_stuf($_SESSION);
                    setcookie($cookie_name, "0", time() + (86400 * 30), "/"); // 86400 = 1 day
                    header("Location:http://localhost/clones/booking-site-03/sign-in");
                }
            };
            $this->site_header_footer("view/site/user.php");
        }

        case "/all-movies-list":{
            $this->site_header_footer("view/site/all-movies-list.php");
            break;
        }

        case "/movie-seats":{
            if(!isset($_REQUEST["movie_id"])){
                $this->print_stuf(
                    "<h2>no movie selected <a style='color:blue;' href='http://localhost/clones/booking-site-03/all-movies-list' >click here</a> to select a movie</h2>"
                );
                break;
                // return;
            };
            $this->last_page = $_REQUEST["last_page"];
            $this->movie_id = $_REQUEST["movie_id"];
            $this->date = $this->get_user("movie_list",$_REQUEST["movie_id"],"movie_id");
            $this->date = substr($this->date["dates"],1,-1);
            $this->date = substr($this->date,0,-1);
            $this->date = explode("/",$this->date);
            $this->seat_info = $this->seat_check("seats",$this->date[0]);
            // $this->print_stuf($this->seat_info);
            if(isset($_REQUEST["DATETIME"])){
                $this->datetime = $this->date[$_REQUEST['datetime']];
                // $this->print_stuf($_REQUEST);
                $this->seat_info = $this->seat_check("seats",$this->datetime);
            };
            if(isset($_REQUEST["proceed"])){
                $seat_selected_arr = array();
                $this->last_page = $_REQUEST['last_page'];
                $this->movie_id = $_REQUEST["movie_id"];
                $datetime = $_REQUEST["datetime"];
                array_shift($_REQUEST);
                array_shift($_REQUEST);
                array_shift($_REQUEST);
                array_pop($_REQUEST);
                $seat_selected_arr = $_REQUEST;
                $new_connection = $this->connect_to_server();
                // $this->print_stuf([$new_connection,$this->connection]);
                // echo "<br>";
                // $this->print_stuf($seat_selected_arr);
                $chack_movie_datetime_answer = $this->chack_movie_id_datetime("movie_list",$this->movie_id,$datetime);
                if($chack_movie_datetime_answer !== false){
                   $this->print_stuf($chack_movie_datetime_answer);
                   $chack_seat_empty_answer = $this->chack_seat_empty("seats",$chack_movie_datetime_answer["datetime_value"],$seat_selected_arr);
                   $this->print_stuf($chack_seat_empty_answer);
                   if($chack_seat_empty_answer !== false){
                        $this->Add_chack_bookedseat_toUser("account","bookedseat","user_id",$this->movie_id,$datetime,$seat_selected_arr);
                   }else if($chack_seat_empty_answer == false){
  
                      $this->print_stuf([$_REQUEST,"seat teken"]);
                   }  
                }
            };
            $this->site_header_footer("view/site/movie-seats.php");
            break;
        }

        default:{
            $this->site_header_footer("view/site/home.php");
            break;
        }
    }
   }

   protected function site_header_footer($location){
    require_once("view/site/header.php");
    require_once($location);
    require_once("view/site/footer.php");
   }
} 
$obj_controller = new controller();
$obj_controller->__construct();
?>
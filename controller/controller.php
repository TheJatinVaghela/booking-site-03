<?php
require_once("./model/model.php");
class controller extends model{
    public $date="";
    public $datetime;
    public $seat_info;
    public $last_page;
    public $movie_id;
    public $movie_info_controller;
    public $admin_update_movie_details = null;
   public function __construct() {
    parent::__construct();
    $path = (isset($_SERVER["PATH_INFO"]))? $_SERVER["PATH_INFO"] : "/home";
    switch ($path) {
        case '/home':{

            $this->site_header_footer("view/site/home.php");
            break;
        }
        case '/sign-in':{
            if(isset($_REQUEST["sign_in"])){
                $this->chack_user_real($_REQUEST["user_email"],"user_email","home");
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
                       $this->chack_user_real($_REQUEST["user_email"],"user_email","home");
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
            // $this->print_stuf($this->user_info);
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
                //    $this->print_stuf($chack_movie_datetime_answer);
                   $chack_seat_empty_answer = $this->chack_seat_empty("seats",$chack_movie_datetime_answer["datetime_value"],$seat_selected_arr);
                //    $this->print_stuf($chack_seat_empty_answer);
                   if($chack_seat_empty_answer !== false){
                        $this->Add_chack_bookedseat_toUser("account","bookedseat","user_id",$this->movie_id,$datetime,$seat_selected_arr);
                   }else if($chack_seat_empty_answer == false){
  
                    //   $this->print_stuf([$_REQUEST,"seat teken"]);
                      echo "<h3 style='margin-top:5rem;'>SORRY BUT YOUR LATE THAT SEAT HAS BEEN BOOKED</h3>";
                   }  
                }
            };
            $this->site_header_footer("view/site/movie-seats.php");
            break;
        }
        case "/user-movies":{
            $this->chack_user_real($_COOKIE["user_id"],"user_id");
            $booked_info =  explode("),",$this->user_info["bookedseat"]);
            $this->movie_info_controller = array();
            array_pop($booked_info);

            foreach ($booked_info as $key => $value) {
                $booked_info[$key] = ltrim($value,"(");
                $booked_info[$key] = explode(",",$value);
                $booked_info[$key][0] = ltrim($booked_info[$key][0],"(");
                array_push($this->movie_info_controller,$this->get_user("movie_list",$booked_info[$key][0],"movie_id"));
                $this->movie_info_controller[$key]["dates"] = explode("/",$this->movie_info_controller[$key]["dates"]);
                $this->movie_info_controller[$key]["dates"][0] = ltrim($this->movie_info_controller[$key]["dates"][0],"(");
                array_pop($this->movie_info_controller[$key]["dates"]);
                $date_num = $booked_info[$key][1];
                $movie_date = $this->movie_info_controller[$key]["dates"][$date_num];
                $this->movie_info_controller[$key]["dates"] = null;
                $this->movie_info_controller[$key]["dates"] = $movie_date;
                $seats = explode("chacked_seats=>[",rtrim($booked_info[$key][2],"]"));
                array_shift($seats);
                $seats = explode("/",$seats[0]);
                array_pop($seats);
                $this->movie_info_controller[$key]["chacked_seats"]=$seats;
            }
            // $this->movie_info_controller = $this->get_user("movie_list",);
            //  $this->print_stuf($booked_info);
            //  $this->print_stuf($this->movie_info_controller);
            $this->site_header_footer("view/site/user-movies.php");
            break;
        }
        case "/user-events":{
            $this->chack_user_real($_COOKIE["user_id"],"user_id");
            // $this->print_stuf($this->user_info);
            $this->site_header_footer("view/site/user-events.php");
            break;
        }

        case "/removeBookedSeat":{
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $data = json_decode(file_get_contents("php://input"),true);
                $movie_info = $this->get_movie_datetime("movie_list",$data["movie_id"],"movie_id","dates");
                if($movie_info == false){ echo "Something Went Wrong"; break;};
                $movie_date_pos = strpos($movie_info["dates"],$data["date_time"]);
                if($movie_date_pos === false){ echo "Date Of Movie Not Found"; break;};
                $movie_info = ltrim($movie_info["dates"],"(");
                $movie_info = rtrim($movie_info,")");
                $movie_info = explode("/",$movie_info);
                array_pop($movie_info);
                foreach ($movie_info as $key => $value) {
                    if($data["date_time"] == $value){
                        $movie_info = $key;
                        // $data["date_time"] = $key;
                        break;
                    }
                };
                $this->chack_user_real($data["user_id"],"user_id");
                $booked_info =  explode("),",$this->user_info["bookedseat"]);
                array_pop($booked_info); 
                $userbooks_movie_and_date = "$data[movie_id],$movie_info";
                $booked_info_key_toChange ="";
                foreach ($booked_info as $key => $value) {
                    $userbooks_movie_and_date_pos = strpos($value,"(".$userbooks_movie_and_date);
                    if($userbooks_movie_and_date_pos === false){ echo "Date Of Movie Not Found -Ignore";}
                    else{$booked_info_key_toChange = $key; break;};
                };
                // print_r($booked_info[$booked_info_key_toChange]);
                $booked_info[$booked_info_key_toChange]=str_replace($data["seatNum"]."/","",$booked_info[$booked_info_key_toChange]);
                $chack_is_no_seat = explode(">",$booked_info[$booked_info_key_toChange]);
               
                if($chack_is_no_seat[1] == "[]"){
                    // print_r($booked_info_key_toChange);
                    //this means that the index is null so we remove it 
                    array_splice($booked_info,$booked_info_key_toChange,1);
                    if(isset($booked_info[0])){
                        $first_char = substr($booked_info[0],0,1);
                    }
                    if($first_char == "("){
                        // array_shift($booked_info);
                        if(isset($booked_info[0])){
                            $booked_info[0] = $booked_info[0].")" ;
                        }else{
                            $booked_info="";
                        }
                    }else{
                        if(isset($booked_info[0])){
                         $booked_info[0] = "(".$booked_info[0];
                        }else{
                            $booked_info="";
                        }
                    };
                    if($booked_info != ""){
                        if(count($booked_info) == 1){
                            $booked_info = $booked_info[0].",";
                        }
                    }
                    // print_r($booked_info);
                }else{
                    $booked_info = implode("),",$booked_info);
                    $booked_info .= "),";
                    // print_r($booked_info[$booked_info_key_toChange]."==="."[]");
                }
                
                print_r($booked_info);

                $remove_seat = $this->remove_seat("seats",$data["date_time"],$data["seatNum"]);
                $update_user = $this->update_user("account",$data["user_id"],"bookedseat",$booked_info);
                // print_r($update_user);
                    $answer = ['Ans'=>true];
                  if($remove_seat==true && $update_user == true){
                     print_r (json_encode($answer));
                  }else{
                     print_r (json_encode($answer));
                  }
                //  print_r (json_encode(["Ans"=>true]));
                // print_r($booked_info."<br>");
                // print_r($movie_info."<br>");
                //  print_r($remove_seat."<br>");
                //  print_r($update_user."<br>");
                
                
            }else{
                echo "Invalid Request";
            }
            break;
        }
        case "/admin_home":{
            //admin_id,admin_name,admin_email,admin_password
            if(isset($_REQUEST["movieUpdate_id"])){
                $this->admin_update_movie_details = $this->get_user('movie_list',$_REQUEST["movie_id"],'movie_id');
                print_r ($this->admin_update_movie_details );
            }
            if(isset($_REQUEST["update_movie"])){
                $this->print_stuf($_REQUEST["olddates1"]);
                if(isset($_REQUEST["available"])){
                    if(isset($_REQUEST['dates']) && $_REQUEST["dates"] != ''){
                        $_REQUEST['dates'] = str_replace('T',' ',$_REQUEST['dates']).':00';
                    }
                    $olddate=null;
                    $date=null;
                    if(isset($_REQUEST["olddateCount"]) && isset($_REQUEST["olddates0"])){
                        for ($i=0; $i <= $_REQUEST["olddateCount"]; $i++) { 
                            $chackiflast = (($i+1) > $_REQUEST["olddateCount"])? true : false;
                            $answer=str_contains($_REQUEST["olddates".$i],'_delete');
                            if($answer == true){
                                // $this->print_stuf("no");

                                $_REQUEST["olddates".$i] = null;
                                unset($_REQUEST["olddates".$i]);
                                if((isset($chackiflast))&& ($_REQUEST["dates"] !== '('.$_REQUEST["dates"].'/)')){
                                    $this->print_stuf("no");
                                    if($olddate !== null){
                                        $olddate .= $_REQUEST["dates"].'/)'; 
                                    }else if($olddate === null){

                                        $date = '('.$_REQUEST["dates"].'/)';
                                    }
                                }
                            }else{
                                $this->print_stuf("yes");
                                
                                if($olddate === null){
                                    if($chackiflast == true){
                                        var_dump( $chackiflast );
                                        echo "fiart";
                                        $olddate = '('.$_REQUEST["olddates".$i].'/'.$_REQUEST["dates"].'/)';
                                        unset($_REQUEST["olddates".$i]);
                                    }else{
                                        $olddate = '('.$_REQUEST["olddates".$i].'/';
                                    }
                                }else{
                                    if($chackiflast == true){
                                        var_dump( $chackiflast );
                                        echo "second";
                                       $olddate .= (isset($_REQUEST['dates']) && $_REQUEST["dates"] != '')?
                                         $_REQUEST["olddates".$i].'/'.$_REQUEST['dates'].'/)':
                                         $_REQUEST["olddates".$i].'/)';
                                        // $_REQUEST["dates"] = $olddate;
                                        unset($_REQUEST["olddates".$i]);

                                    }else{
                                        $olddate .= $_REQUEST["olddates".$i].'/';
                                        unset($_REQUEST["olddates".$i]);
                                    }
                                }
                            }
                        }
                        unset($_REQUEST["olddateCount"]);
                    };
                     if($olddate == null || $olddate == ''){
                         $olddate = '('.$_REQUEST["dates"].'/)';
                         $_REQUEST["dates"] = $olddate;
                     }else if($olddate != null || $olddate != ''){
                        $_REQUEST["dates"] = $olddate;
                     }
                    // echo "date :";
                    // $this->print_stuf($date); //null //one //null//one
                    // echo "olddate :";
                    // $this->print_stuf($olddate);//three //two // two//null
                    echo "request :";
                    $this->print_stuf($_REQUEST["dates"]);
                    $target_dir = "assets/images/movie/";
                    $target_file = $target_dir . basename($_FILES["movie_img"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    // Check if image file is a actual image or fake image
                    $check = getimagesize($_FILES["movie_img"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }

                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    } else {
                        // If everything is ok, try to upload file
                        if (move_uploaded_file($_FILES["movie_img"]["tmp_name"], $target_file)) {

                            // Insert into database
                            $imagePath = $target_file;
                            array_pop($_REQUEST);
                            $this->print_stuf(array_merge($_REQUEST,["movie_img"=>$imagePath]));
                            $answer = $this->update_movie_ADMIN('movie_list',$_REQUEST['movie_id'],'movie_id',$_REQUEST);
                            $this->print_stuf($answer);
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }
                }
                
            }
            $this->user_info = $this->get_user('admin_table',$_COOKIE["admin_user_id"],'admin_id');
            if($this->user_info !== false){
                $this->admin_site_header_footer('view/admin/home.php');
                break;
            }else{
                echo "<h1> First Do <a href='http://localhost/clones/booking-site-03/admin_sign_in'>ADMIN Log IN</a> Then Come </h1>";
                break;
            }
        }
        case "/admin_sign_in":{
            if(isset($_REQUEST["admin_sign_in"])){
                $this->adminchack_user_real($_REQUEST["admin_email"],"admin_email","admin_home");
            }
            $this->admin_site_header_footer('view/admin/sign-in.php');
            break;
        }
        default:{
            header("Location:http://localhost/clones/booking-site-03/home");
            break;
        }
    }
   }

   protected function chack_user_real($data,$key,$tranfer_location=NULL){
    $answer = $this->get_user("account",$data,$key);
    if($answer == false){
        echo "Please enter valid information";
        return false;
    }else{
        setcookie("user_id", $answer["user_id"], time() + (86400 * 30), "/"); // 86400 = 1 day
        if($tranfer_location != NULL){
            header("Location:$tranfer_location");
        }else{

             return $answer;
        }
    }
   }
   protected function adminchack_user_real($data,$key,$tranfer_location=NULL){
    $answer = $this->get_user("admin_table",$data,$key);
    if($answer == false){
        echo "Please enter valid information";
        return false;
    }else{
        setcookie("admin_user_id", $answer["admin_id"], time() + (86400 * 30), "/"); // 86400 = 1 day
        if($tranfer_location != NULL){
            header("Location:$tranfer_location");
        }else{
            header("Location:http://localhost/clones/booking-site-03/admin_home");
            //  return $answer;
        }
    }
   }
   protected function site_header_footer($location){
    require_once("view/site/header.php");
    require_once($location);
    require_once("view/site/footer.php");
   }
   protected function admin_site_header_footer($location){
    require_once("view/admin/header.php");
    require_once($location);
    require_once("view/admin/footer.php");
   }
} 
$obj_controller = new controller();
// $obj_controller->__construct();
?>
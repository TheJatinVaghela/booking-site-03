<?php

class model {
    public $assets = "assets/";
    protected $connection;
    public $user_info;
    public $get_data;
    public function __construct() {
        $hostname = "localhost";
        $directri = "root";
        $data_base = "booking-2";
        $pass = "";
        $this->connect_to_server($hostname,$directri,$data_base,$pass);
        if(isset($_COOKIE["user_id"])){

            $this->user_info = $this->get_user("account",$_COOKIE["user_id"],"user_id");
        };
        $this->get_data = $this->get_table_data("movie_list");
        // $this->add_all_movie_data_in_database();

    }

    protected function connect_to_server($hostname= "localhost",$directri= "root",$data_base= "booking-3",$pass= "" ){
        try {
            $new_connection = new mysqli($hostname,$directri,$pass,$data_base);
            $this->connection = $new_connection;
            return $new_connection;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    protected function print_stuf($stuf){
        echo"<pre>";
        print_r($stuf);
        echo"</pre>";
    }

    public function jatin_fetch_object($sqlex){
        // $data = array();
        $arr = array();
        while ($a = $sqlex->fetch_object()) {
            foreach ($a as $key => $value) {
                $arr[$key]=$value;
            };
            // array_push($data, $arr);
        };
        return $arr;
   }
    public function jatin_fetch_All($sqlex){
        $data = array();
        $arr = array();
        while ($a = $sqlex->fetch_object()) {
            foreach ($a as $key => $value) {
                $arr[$key]=$value;
            };
            array_push($data, $arr);
        };
        return $data;
   }

    protected function add_user($table,$data,$key){
        $sql = "SELECT * FROM $table WHERE $key = '".$data['user_email']."'";
        $sqli = $this->connection->query($sql);
        if($sqli->num_rows < 1){
            $sql = "insert into $table (";
            foreach($data as $key => $value){
                $sql .= $key." ,";
            };
            $sql = substr($sql,0,-1);
            $sql .= ") VALUES (";
            foreach($data as $key => $value){
                $sql.="'".$value."'".",";
            }
            $sql = substr($sql,0,-1);
            $sql .= ")";
            $sqli = $this->connection->query($sql);
            $this->print_stuf($sqli);
            if($sqli == 1){
                return true;
            }else{
                return false;
            }
        }else if($sqli->num_rows > 0 ){
            return false;
        };
    }


    protected function get_user($table , $data , $key){
        $sql = "SELECT * FROM $table WHERE $key = '$data'";
        $sqli = $this->connection->query($sql);
        if($sqli->num_rows > 0){
           $data = $this->jatin_fetch_object($sqli);
           return $data;
        }else{
            return false;
        }
    }

    protected function delete($table,$data,$key){
        $sql = "DELETE FROM $table where $key = '$data' ";
        $sqli = $this->connection->query($sql);
        if($sqli == 1){
            return true;
        }else{
            return false;
        }
    }

    protected function get_table_data($table_names_array){
            $sql = "select * from $table_names_array";
            $sqli = $this->connection->query($sql);
            // $answer = ($sqlex->num_rows > 0)? $sqlex->fetch_all() : false;
            if($sqli->num_rows > 0){
                $data = $this->jatin_fetch_All($sqli);
                // $this->print_stuf($data);
                // exit();
                $this->get_data = $data;
                return $data;
            }
   }

    protected function seat_check($table , $key){
        if($key === "" || $key === null){
            // $this->print_stuf("MODEL");
            $key =  explode(",",$this->get_data[0]["dates"])[0];
            $key = substr($key,1,-1);
            $key = substr($key,0,-1);
            $key = explode("/",$key);
            $key = $key[0];
            // $this->print_stuf($key);
            // exit();
        };
        $key = trim($key);
        $this->print_stuf($key);
        $sql = "SELECT `seat`,`$key` FROM $table WHERE `$key`= 1"; // ( ` ) = 🟢 | ( ' ) = 🔴
        $this->print_stuf($sql);
        // exit();
        $sqlex = $this->connection->query($sql);
        $this->print_stuf($sqlex);
        if ($sqlex->num_rows > 0) {
            $data = $this->jatin_fetch_All($sqlex);
            $this->print_stuf($data);
            return $data; 
        };
        return "No"; 
    }

    protected function chack_movie_id_datetime($table,$movie_id,$datetime){
        //movie_id and datetime chacking
        $sql = "SELECT * FROM $table WHERE `movie_id` = $movie_id";
        $sqlex = $this->connection->query($sql);
        if($sqlex->num_rows > 0) {
            $data = $sqlex->fetch_object();
            $date_arr = explode(",",$data->dates);
            $date_arr = substr($date_arr[0],1,-1);
            $date_arr = substr($date_arr,0,-1);
            $date_arr = explode("/",$date_arr);
            // $this->print_stuf($date_arr);
            return ["movie_id"=>$movie_id,"datetime_value"=>$date_arr[$datetime],"datetime_key"=>$datetime];
        };
        return false;
    }

    protected function chack_seat_empty($table,$key,$seat_arr){
        $datetime_name = $key;
        $sql = "SELECT `seat`,`$key` FROM $table WHERE `$key`= 1"; // ( ` ) = 🟢 | ( ' ) = 🔴
        $sqlex = $this->connection->query($sql);
         $this->print_stuf($sqlex);
        //   exit();
        if ($sqlex->num_rows > 0) {
            $data = $sqlex->fetch_all();
            $arr=false;
            foreach($data as $key => $value){
                if(isset($seat_arr[$value[0]]) && $seat_arr[$value[0]] == 'yes'){
                    $this->print_stuf($seat_arr['G-0']);
                      echo "0";
                      $arr=true;
                    //  exit();
                    return false; 
                }
            };
            $sql = "UPDATE `$table` SET `$datetime_name`= 1 WHERE `seat`IN (";
            foreach ($seat_arr as $key => $value) {
                // UPDATE `seats` SET `2023-09-09 09:30:00` = '1' WHERE `seat`IN ('G-5','G-6');
                $sql.="'$key',";
            };
            $sql = substr($sql,0,-1);
            $sql .= ");";
            $sqlex = $this->connection->query($sql);
            $this->print_stuf($sqlex);
            if ($sqlex == 1) {
                echo "1";
                    // exit();
                    return true;
            };
        }else{
            $sql = "UPDATE `$table` SET `$datetime_name`= 1 WHERE `seat`IN (";
            foreach ($seat_arr as $key => $value) {
                // UPDATE `seats` SET `2023-09-09 09:30:00` = '1' WHERE `seat`IN ('G-5','G-6');
                $sql.="'$key',";
            };
            $sql = substr($sql,0,-1);
            $sql .= ");";
            $sqlex = $this->connection->query($sql);
            $this->print_stuf($sqlex);
            if ($sqlex == 1) {
                echo "1";
                    // exit();
                    return true;
            };
        }
        // return $arr; 
        //  return $data; 
        
        
    }

    protected function Add_chack_bookedseat_toUser($table,$_1key,$_2key,$movie_id,$datetime,$seat_chacked_arr){
        $sql = "SELECT $_1key FROM $table where $_2key = $_COOKIE[user_id]";
        $this->print_stuf([$_COOKIE["user_info"],$table,$_1key,$_2key,$movie_id,$datetime,$seat_chacked_arr]);
        $sqlex = $this->connection->query($sql);
        if($sqlex->num_rows > 0){
           $data = $sqlex->fetch_object();
           $pre_query = $data->bookedseat;
           $data = explode(",",$data->bookedseat);
        //    return $data;
        //    exit();
           if($data[0] != "" || $data[1] != NULL){
                $pre_movie_id = ltrim($data[0],"("); 
               //  $this->print_stuf($pre_movie_id);
               $pre_datetime = $data[1];
               //  $this->print_stuf($pre_datetime);
               //  $this->print_stuf($data[2]);
               $pre_bockedSeat = rtrim($data[2],")");
               $pre_bockedSeat = explode("=>",$pre_bockedSeat);
               $pre_bockedSeat = ltrim($pre_bockedSeat[1],"[");
               $pre_bockedSeat = rtrim($pre_bockedSeat,"]");
               //  $this->print_stuf($pre_bockedSeat);
               $this->print_stuf($pre_query);
            };
        }
        if($movie_id == $pre_movie_id && $datetime == $pre_datetime){
           $pre_bockedSeat = $pre_bockedSeat;
           $pre_query = "";
        }else{
           $pre_bockedSeat ="";
           $pre_query = $pre_query;
        }
        //  exit();
       $sql = "UPDATE $table SET `$_1key` = '$pre_query($movie_id,$datetime,chacked_seats=>[";
       $sql .= $pre_bockedSeat;
       foreach ($seat_chacked_arr as $arr_key => $arr_value) {
           $sql.=$arr_key.'/' ;

       };
       // $this->print_stuf($sql);
       $sql .= "]";
       //  $sql =substr($sql,0,-1);
       $sql.="),' WHERE `$_2key` = $_COOKIE[user_id]";
        // $this->print_stuf($sql);
        // exit();
       $sqlex = $this->connection->query($sql);
       if($sqlex == 1){
           header("Location: http://localhost/clones/booking-site-03/home");
       }
   }

   private function add_all_movie_data_in_database(){
    $data = [
        ["alone",80,70,"assets/images/movie/movie01.jpg",1],
        ["mars",90,90,"assets/images/movie/movie02.jpg",1],
        ["venus",56,47,"assets/images/movie/movie03.jpg",1],
        ["on watch",78,45,"assets/images/movie/movie04.jpg",1],
        ["fury",34,8,"assets/images/movie/movie05.jpg",1],
        ["trooper",76,74,"assets/images/movie/movie06.jpg",1],
        ["horror night",67,34,"assets/images/movie/movie07.jpg",1],
        ["the lost name",67,56,"assets/images/movie/movie08.jpg",1],
        ["calm stedfast",66,69,"assets/images/movie/movie09.jpg",1],
        ["criminal on party",92,93,"assets/images/movie/movie10.jpg",1],
        ["halloween party",97,12,"assets/images/movie/movie11.jpg",1],
        ["the most wanted",20,20,"assets/images/movie/movie12.jpg",1],
    ];
    $sql = "INSERT into movie_list(movie_name , movie_tomato_rating , movie_box_office_rating , movie_img , available ) VALUES(";
    foreach ($data as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $sql .= "'$value2' ,";
        };
        $sql = substr($sql , 0 , -1);
        $sql .= ") ,(";

    }
    $sql = substr($sql , 0 , -2);
    $this->print_stuf($sql);
    exit();
   }

   protected function seat_add(){
    $arr = ['G-0','G-1','G-2','G-3','G-4','G-5','G-6','G-7','G-8','G-9','G-1','G-1','G-1','G-1','F-0','F-1','F-2','F-3','F-4','F-5','F-6','F-7','F-8',
            'F-9','F-1','F-1','F-1','F-1','E-0','E-1','E-2','E-3','E-4','E-5','D-0','D-1','D-2','D-3','D-4','D-5','D-6','D-7','C-0','C-1','C-2','C-3',
            'C-4','C-5','C-6','C-7','C-8','B-0','B-1','B-2','B-3','B-4','B-5','B-6','B-7','B-8','A-1','A-2','A-3','A-4','A-5','A-6','A-7','A-8' ];
   
    $sql = "INSERT INTO seats (seat) VALUES (";
    foreach ($arr as $key => $value) {
        $sql .= "'$value'), (";
    };
    $this->print_stuf($sql);
    }
}

?>
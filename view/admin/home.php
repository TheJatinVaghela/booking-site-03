<body class="container">
    <div class="">
        <h1>MOVIES</h1>
    <table class="table table-dark table-sm table-bordered border-primary">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>TomatoRating</th>
                <th>BoxofficeRating</th>
                <th>movieImg</th>
                <th>Available</th>
                <th>dates</th>
            </tr>
            <tr>
            <?php if($this->admin_update_movie_details == null){?>
             <th>
                <form  action="" method="post">
                    <select name="movie_id" id="movie_id" style="color: black;" class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option value="1" select>1</option>
                        <?php
                            foreach ($this->get_data as $key => $value) { 
                
                            $id = $value["movie_id"];
                            if($id == 1){
                                continue;    
                            };
                           
                        ?>
                        <option value="<?php echo $id?>" ><?php echo $id?></option>
                        <?php }?>
                    </select>
                    <button style="color: black;" type="submit" name="movieUpdate_id" value="movie_id">update</button>
                    
                </form>
             </th>
            <tr>
             
            <?php }else{
                
                $movie_name = $this->admin_update_movie_details["movie_name"];
                $movie_id = $this->admin_update_movie_details["movie_id"];
                $movie_tomato_rating = $this->admin_update_movie_details["movie_tomato_rating"];
                $movie_box_office_rating = $this->admin_update_movie_details["movie_box_office_rating"];
                $dates = $this->admin_update_movie_details["dates"];
                if($dates == ''){
                    $dates = "nop";
                }else{
                    $dates = rtrim($dates,'/)');
                    $dates = ltrim($dates,'(');
                    $dates = explode('/',$dates);
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <th>
                        <input type="number" name="movie_id" value="<?php echo $movie_id?>" hidden ></input>
                    </th>
                    <th>
                    <label for="">
                        movie name
                        <input type="text" name="movie_name" value="<?php echo $movie_name?>"></input>
                    </label>
                    </th>
                    <th>
                    <label for="">
                        movie tomato rating
                        <input type="number" name="movie_tomato_rating" value="<?php echo $movie_tomato_rating?>"></input>
                    </label>
                    </th>
                    <th>
                    <label for="">
                        movie box office rating
                        <input type="number" name="movie_box_office_rating" value="<?php echo $movie_box_office_rating?>"></input>
                    </label>
                    </th>
                    <th>
                    <label for="">
                        movie img
                        <input type="file" accept="image/*" name="movie_img" required  ></input>
                    </label>
                    </th>
                    <th>
                    <label for="" >
                        available
                        <input name="available" type="checkbox" style="height: 20px; " value="1"  checked/>
                    </label>
                    </th>
                    <th>
                        <?php 
                        echo "oldDates";
                        foreach ($dates as $key => $value) { ?>
                            <input name="olddateCount" type="text" value="<?php $count = $count+$key ; echo $count?>" hidden/>
                            <input type="text" name="olddates<?php echo $key?>" id="olddates<?php echo $key?>" value="<?php echo $value ?>" hidden />
                            <span id="olddates<?php echo $key?>_span"><?php echo $value ?></span>
                            <input type="submit" class="olddates<?php echo $key?>" onclick="deleteoldDates(this)" value="❌"/>
                        <?php }
                        echo "Add Dates";
                        ?>
                        <label for="">DateTime <span style="font-size:smaller;">(day-mothe-year,hour-minitue-seconds)</span>
                            <input type="datetime-local" name="dates" value="" />
                        </label>
                    </th>
                    <th><input type="submit" name="update_movie" value="update movie"/></th>
                </form>
            <?php }?>
            </tr>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>TomatoRating</th>
                <th>BoxofficeRating</th>
                <th>movieImg</th>
                <th>Available</th>
                <th>dates</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($this->get_data as $key => $value) { 
            
        $id = $value["movie_id"];
        $name = $value["movie_name"];
        $tamato_rating = $value["movie_tomato_rating"];
        $box_office_rating = $value["movie_box_office_rating"];
        $img = $value["movie_img"];
        $imgname;
        if($img){
            $imgname = explode('/',$img);
            $imgname = $imgname[array_key_last($imgname)];
        }
        $available = $value["available"];
        $dates = $value["dates"];
        if($dates == ''){
            $dates = "nop";
        }else{
            $dates = rtrim($dates,'/)');
            $dates = ltrim($dates,'(');
            $dates = explode('/',$dates);
            $dates = implode('<br/>',$dates);
        }
        ?>
            <tr>
             <td><?php echo $id ?></td>
             <td><?php echo $name ?></td>
             <td><?php echo $tamato_rating ?>%</td>
             <td><?php echo $box_office_rating ?>%</td>
             <td>
                <span><?php echo $imgname ?></span>
                <img src="<?php echo $img ?>" width="50px" height="50px" alt="IMG NOT FOUND">
             </td>
             <td><?php echo $available ?></td>
             <td><?php echo $dates  ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <h2 id="movies_update">MoveiSettings</h2>
    <form active="" method="post">
        <table>

        </table>
        <label for="movie_id">Select id</label>
        
    </form>
        
    </div>
</body>



<script>
    function deleteoldDates(e) {
        event.preventDefault();
        let hideSpan = document.getElementById(e.className+'_span');
        let hideInput = document.getElementById(e.className);
        let hideInput_value = hideInput.value;
         hideInput.value= hideInput_value+"_delete";
         hideSpan.style.display = 'none';
         e.style.display = 'none';
    }
</script>
<html>
    <head>
        <title>Homework 4</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="styles.css"> <!--Remove for a better bootstrap experience (Alerts will look better)-->
    </head>

    <body>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand mb-0 h1" href="./index.html">Homework 4</a>
        </nav>
            <?php
            function draw_message($e_text){
                echo '<div class="alert alert-danger" role="alert"><b>Error:</b> '.$e_text.'</div>
                        <div class="text-center px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                            <a class="btn btn-dark" href="./form_sbs.php" role="button">Try again</a>
                        </div>';
            }




            $CodC = $_GET['CodC'];
            $CodS = $_GET['CodS'];

            if (empty($CodC) || empty($CodS)){
                draw_message('danger' ,'Please do not leave any empty input fields');
                die();
            }
            
            $con = mysqli_connect('localhost','tester','tester','Championship');
            if (mysqli_connect_errno()){
                draw_message('Failed to connect to the database');
                die();
            }

            $query_title = "SELECT CYCLIST.Name, CYCLIST.Surname, TEAM.NameT
                            FROM CYCLIST, TEAM
                            WHERE CYCLIST.CodC = '$CodC'
                            AND TEAM.CodT = CYCLIST.CodT";

            $query_stage_exists = "SELECT STAGE.CodS
                                   FROM STAGE
                                   WHERE STAGE.CodS = $CodS";

            $query_classifications = "SELECT INDIVIDUAL_CLASSIFICATION.Edition, INDIVIDUAL_CLASSIFICATION.Ranking, STAGE.StartingCity, STAGE.ArrivalCity, STAGE.Length
                                      FROM INDIVIDUAL_CLASSIFICATION, STAGE
                                      WHERE INDIVIDUAL_CLASSIFICATION.CodS = STAGE.CodS
                                      AND INDIVIDUAL_CLASSIFICATION.Edition = STAGE.Edition
                                      AND INDIVIDUAL_CLASSIFICATION.CodS = '$CodS'
                                      AND INDIVIDUAL_CLASSIFICATION.CodC = '$CodC'
                                      ORDER BY INDIVIDUAL_CLASSIFICATION.Edition ASC";

            $r_title = mysqli_query($con, $query_title);
            $r_stage_exists = mysqli_query($con, $query_stage_exists);
            $r_classifications = mysqli_query($con, $query_classifications);

            if (!$query_title or !$query_classifications){
                draw_message('Could not retrieve information');
                die();
            }

            if (mysqli_num_rows($r_title) < 1) {
                draw_message('No data available for this cyclist');
                die();
            }

            if (mysqli_num_rows($r_stage_exists) < 1) {
                draw_message('The selected stage ('.$CodS.') does not exist');
                die();
            }

            if (mysqli_num_rows($r_classifications) < 1) {
                draw_message('No data available for this cyclist on this stage');
                die();
            }
            
            $title = mysqli_fetch_row($r_title);
            echo '<div class="text-center px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                    <h3>Classifications for <b>'.$title[0].' '.$title[1].'</b> (Team '.$title[2].'):</h3>
                  </div>
                  <div class = "container text-center" max-width="960px"> 
                    <table class = "table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Edition</th>
                                <th scope="col">Ranking</th>
                                <th scope="col">Start City</th>
                                <th scope="col">Arrival City</th>
                                <th scope="col">Distance (m)</th>
                            </tr>
                        </thead>
                        <tbody>';
            while ($row = mysqli_fetch_row($r_classifications)){
                echo "\t<tr>\n";
                foreach ($row as $cell) {
                    echo "\t\t<td>$cell</td>\n";
                }
                echo "\t</tr>\n";
            }
            echo '</tbody></table></div> ';
            
            mysqli_close($con);
            ?>
            <div class="text-center px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                <a class="btn btn-dark" href="./form_sbs.php" role="button">Search again</a>
            </div>
    </body>
</html>
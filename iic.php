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
                            <a class="btn btn-dark" href="./form_iic.php" role="button">Try again</a>
                        </div>';
            }



            $CodC = $_GET['CodC'];
            $CodS = $_GET['CodS'];
            $Edition = $_GET['Edition'];
            $Ranking = $_GET['Ranking'];

            if (empty($CodC) || empty($CodS) || empty($Edition) || empty($Ranking)){
                draw_message('Please do not leave any empty input fields');
                die();
            }
            
            if (!is_numeric($CodS) || $CodS < 1){
                draw_message('The inserted stage code is invalid');
                die();
            }

            if (!is_numeric($Ranking) || $Ranking < 1){
                draw_message('The inserted ranking is invalid');
                die();
            }

            if (!is_numeric($Edition) || $Edition < 1){
                draw_message('The inserted ranking is invalid');
                die();
            }

            $con = mysqli_connect('localhost','tester','tester','Championship');
            if (mysqli_connect_errno()){
                draw_message('Failed to connect to the database');
                die();
            }

            $query = "START TRANSACTION";
            $result = mysqli_query($con, $query);
            if (!$query){
                draw_message('Unable to make the insertion');
                die();
            }

            $query = "SELECT CYCLIST.CodC
                      FROM CYCLIST
                      WHERE CYCLIST.CodC = '$CodC'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) < 1){
                draw_message('The cyclist '.$CodC.' does not exist in the database, please insert the cyclist first, then the ranking');
                mysqli_query($con, 'ROLLBACK');
                die();
            }

            $query = "SELECT STAGE.CodS
                      FROM STAGE
                      WHERE STAGE.CodS = $CodS";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) < 1){
                draw_message('The selected stage does not exist');
                mysqli_query($con, 'ROLLBACK');
                die();
            }

            $query = "SELECT STAGE.CodS
                      FROM STAGE
                      WHERE STAGE.CodS = $CodS
                      AND STAGE.Edition = $Edition";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) < 1){
                draw_message('The edition '.$Edition.' does not exist for stage '.$CodS);
                mysqli_query($con, 'ROLLBACK');
                die();
            }

            $query = "SELECT INDIVIDUAL_CLASSIFICATION.Ranking
                      FROM INDIVIDUAL_CLASSIFICATION
                      WHERE INDIVIDUAL_CLASSIFICATION.CodC = '$CodC'
                      AND INDIVIDUAL_CLASSIFICATION.CodS = $CodS
                      AND INDIVIDUAL_CLASSIFICATION.Edition = $Edition";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0){
                draw_message('A ranking for cyclist '.$CodC.' on this stage and edition already exists');
                mysqli_query($con, 'ROLLBACK');
                die();
            }

            $query = "SELECT INDIVIDUAL_CLASSIFICATION.Ranking
                      FROM INDIVIDUAL_CLASSIFICATION
                      WHERE INDIVIDUAL_CLASSIFICATION.CodS = $CodS
                      AND INDIVIDUAL_CLASSIFICATION.Edition = $Edition
                      AND INDIVIDUAL_CLASSIFICATION.Ranking = $Ranking";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0){
                draw_message('Another cyclist has already achieved ranking '.$Ranking.' on this stage and edition');
                mysqli_query($con, 'ROLLBACK');
                die();
            }

            $query = "INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
                      VALUES ('$CodC', $CodS, $Edition, $Ranking)";
            $result = mysqli_query($con, $query);
            if ($result === TRUE){
                echo '<div class="alert alert-success" role="alert"><b>Success:</b> The ranking was correctly inserted into the database</div>';
                mysqli_query($con, 'COMMIT');
            } else {
                draw_message('Could not complete the insertion');
                mysqli_query($con, 'ROLLBACK');
                die();
            }
            
            mysqli_close($con);
            ?>
            <div class="text-center px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                <a class="btn btn-dark" href="./form_iic.php" role="button">Insert another ranking</a>
            </div>
    </body>
</html>
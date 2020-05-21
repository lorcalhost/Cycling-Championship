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
                            <a class="btn btn-dark" href="./form_inc.php" role="button">Try again</a>
                        </div>';
            }



            $CodC = $_GET['CodC'];
            $Name = $_GET['Name'];
            $Surname = $_GET['Surname'];
            $Nationality = $_GET['Nationality'];
            $CodT = $_GET['CodT'];
            $BirthYear = $_GET['BirthYear'];

            if (empty($CodC) || empty($Name) || empty($Surname) || empty($Nationality) || empty($CodT) || empty($BirthYear)){
                draw_message('Please do not leave any empty input fields');
                die();
            }
            
            if (!is_numeric($BirthYear) || $BirthYear > 2155 || $BirthYear < 1901){
                draw_message('The inserted birth year is invalid');
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

            $query = "SELECT TEAM.CodT
                      FROM TEAM
                      WHERE TEAM.CodT = '$CodT'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) < 1){
                draw_message('The selected team ('.$CodC.') does not exists');
                mysqli_query($con, 'ROLLBACK');
                die();
            }

            $query = "SELECT CYCLIST.CodC
                      FROM CYCLIST
                      WHERE CYCLIST.CodC = '$CodC'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0){
                draw_message('A cyclist with code '.$CodC.' already exists');
                mysqli_query($con, 'ROLLBACK');
                die();
            }

            $query = "INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
                      VALUES ('$CodC', '$Name', '$Surname', '$Nationality', '$CodT', $BirthYear)";
            $result = mysqli_query($con, $query);
            if ($result === TRUE){
                echo '<div class="alert alert-success" role="alert"><b>Success:</b> The cyclist was correctly inserted into the database</div>';
                mysqli_query($con, 'COMMIT');
            } else {
                draw_message('Could not complete the insertion');
                mysqli_query($con, 'ROLLBACK');
                die();
            }
            
            mysqli_close($con);
            ?>
            <div class="text-center px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                <a class="btn btn-dark" href="./form_inc.php" role="button">Insert a new cyclist</a>
            </div>
    </body>
</html>
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
        <div class="text-center px-3 py-3 pt-md-5 pb-md-4 mx-auto">
            <h3>Insert individual ranking</h3>
        </div>
        <div class = "container text-center" max-width="960px">
        <form action="iic.php" method="GET">
            <?php
                $con = mysqli_connect('localhost','tester','tester','Championship');
                if (mysqli_connect_errno()){
                    echo '<div class="alert alert-danger" role="alert"><b>Error:</b> Failed to connect to MySQL</div>';
                    die();
                }

                $query_cyclist = "SELECT DISTINCT CYCLIST.CodC, CYCLIST.Name, CYCLIST.Surname
                                  FROM CYCLIST";
                $result_cyclist = mysqli_query($con, $query_cyclist);

                $query_stage = "SELECT DISTINCT STAGE.CodS, STAGE.StartingCity, STAGE.ArrivalCity
                                  FROM STAGE";
                $result_stage = mysqli_query($con, $query_stage);

                $query_edition = "SELECT DISTINCT STAGE.Edition
                                  FROM STAGE";
                $result_edition = mysqli_query($con, $query_edition);
                if (!$query_cyclist || !$query_stage || !$query_edition){
                    echo '<div class="alert alert-danger" role="alert"><b>Error:</b> Could not retrieve information from the database</div>';
                    die();
                }
                if (mysqli_num_rows($result_cyclist) < 1){
                    echo '<div class="alert alert-danger" role="alert"><b>Error:</b> No cyclists found</div>';
                    die();
                }
                if (mysqli_num_rows($result_stage) < 1){
                    echo '<div class="alert alert-danger" role="alert"><b>Error:</b> No stages found</div>';
                    die();
                }
                if (mysqli_num_rows($result_edition) < 1){
                    echo '<div class="alert alert-danger" role="alert"><b>Error:</b> No editions found</div>';
                    die();
                }

                
                echo '<div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Cyclist code: </b></label>
                        <div class="col-sm-10">
                            <select name = "CodC" class="form-control">';
                    while($row = mysqli_fetch_row($result_cyclist)){
                        echo '<option value="'.$row[0].'">'.$row[0].' ('.$row[1].' '.$row[2].')</option>';
                    }
                echo '</select></div></div>';

                echo '<div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Stage code: </b></label>
                        <div class="col-sm-10">
                            <select name = "CodS" class="form-control">';
                    while($row = mysqli_fetch_row($result_stage)){
                        echo '<option value="'.$row[0].'">'.$row[0].' ('.$row[1].' - '.$row[2].')</option>';
                    }
                echo '</select></div></div>';

                echo '<div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Edition: </b></label>
                        <div class="col-sm-10">
                            <select name = "Edition" class="form-control">';
                    while($row = mysqli_fetch_row($result_edition)){
                        echo '<option value="'.$row[0].'">'.$row[0].'</option>';
                    }
                echo '</select></div></div>';

                echo '<div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Ranking position: </b></label>
                        <div class="col-sm-10">
                            <input name="Ranking" type="text" class="form-control" placeholder="e.g. 2">
                        </div>
                      </div>
                      <input type="submit" value="Insert" class="btn btn-dark">';
                mysqli_close($con);
                ?>
        </form>
        </div>
    </body>
</html>
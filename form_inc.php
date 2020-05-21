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
            <h3>Insert new cyclist</h3>
        </div>
        <div class = "container text-center" max-width="960px">
        <form action="inc.php" method="GET">
            <?php
                $con = mysqli_connect('localhost','tester','tester','Championship');
                if (mysqli_connect_errno()){
                    echo '<div class="alert alert-danger" role="alert"><b>Error:</b> Failed to connect to MySQL</div>';
                    die();
                }

                $query = "SELECT DISTINCT TEAM.CodT, TEAM.NameT
                          FROM TEAM";
                $result = mysqli_query($con, $query);
                if (!$query){
                    echo '<div class="alert alert-danger" role="alert"><b>Error:</b> Could not retrieve information from the database</div>';
                    die();
                }
                if (mysqli_num_rows($result) < 1){
                    echo '<div class="alert alert-danger" role="alert"><b>Error:</b> No teams found</div>';
                    die();
                }

                echo '<div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Code: </b></label>
                        <div class="col-sm-10">
                            <input name="CodC" type="text" class="form-control" placeholder="e.g. APT-1337">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Name: </b></label>
                        <div class="col-sm-10">
                            <input name="Name" type="text" class="form-control" placeholder="e.g. Eddy">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Surname: </b></label>
                        <div class="col-sm-10">
                            <input name="Surname" type="text" class="form-control" placeholder="e.g. Merckx">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Nationality: </b></label>
                        <div class="col-sm-10">
                            <input name="Nationality" type="text" class="form-control" placeholder="e.g. Belgian">
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label"><b>Team: </b></label>
                        <div class="col-sm-10">
                            <select name = "CodT" class="form-control">';
                    while($row = mysqli_fetch_row($result)){
                        echo '<option value="'.$row[0].'">'.$row[1].' ('.$row[0].')</option>';
                    }

                echo '</select></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><b>Date of birth: </b></label>
                    <div class="col-sm-10">
                        <input name="BirthYear" type="text" class="form-control" placeholder="e.g. 1945">
                    </div>
                </div>
                <input type="submit" value="Insert" class="btn btn-dark">';
                mysqli_close($con);
                ?>
        </form>
        </div>
    </body>
</html>
<!doctype html>
                <html lang="en">
                <head>
                    <!-- Required meta tags -->
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

                    <!-- Bootstrap CSS -->
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                    <link rel="stylesheet" href="../style.css">
                    <title>Sign Up</title>
                </head>
<?php

    include "../enironment.php";
    $data = unserialize($_COOKIE['userInfo'],["allowed_classes" => false]);

    $con = mysqli_connect($host,$dbusername,$dbpassword,$dbname);
    if($con){
        $user = mysqli_query($con,"SELECT * FROM userinfo WHERE firstName = '$data[0]' AND lastName = '$data[1]' AND latitude = '$data[2]' AND longitude = '$data[3]' ");
        if(mysqli_num_rows($user)>0){
            ?>
            <body id="parallex-image"> 
                    <div class="container p-5">
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Your address already exists!</h4>
                            <p>We already have your address.Please sit back and relax!!!</p>
                            <hr>
                            <a href="../signupForm.html" class="btn btn-outline-danger">Go Back</a>
                        </div>
            </body>
            </html>
        <?php
        }else{

            $insertQuery = "INSERT INTO userinfo (firstName,lastName,latitude,longitude) VALUES ('$data[0]','$data[1]','$data[2]','$data[3]')";
            $execInsertQuery = mysqli_query($con,$insertQuery);

            if(!$execInsertQuery){
                echo "Did not write to db";
            }
            ?>
                <body id="parallex-image"> 
                    <div class="container p-5">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Successfull!</h4>
                            <p>Congratulations you have successfully finished setting up your address for drone delivery</p>
                            <hr>
                            <a href="../signupForm.html" class="btn btn-outline-success">Go Back</a>
                        </div>

                        <div class="my-4">
                            <h3 class="display-4 text-white"> Here are our happy customers </h3>
                            <table class="table  my-3 w-50 border text-white">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $selectQuery = "SELECT firstName,lastName FROM userinfo";
                                    $execSelectQuery = mysqli_query($con,$selectQuery);

                                    if (!$execSelectQuery) {
                                        echo "Could not successfully run query ($sql) from DB: " . mysql_error();
                                        exit;
                                    }

                                    if (mysqli_num_rows($execSelectQuery) == 0) {
                                        echo "No rows found, nothing to print so am exiting";
                                        exit;
                                    }
                            
                                    $count =0;
                                    while ($row = mysqli_fetch_assoc($execSelectQuery)) {
                                        $count++;
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $count ?></th>
                                            <td><?php echo $row["firstName"]." ".$row["lastName"]?></td>
                                        </tr>
                                        <?php    
                                    }
                                        ?>
                                </tbody>
                            </table>                          
                        </div>
                    </div>
           
    <?php
    }
    }
    else{
        echo "Connection did not establish";
    } 
    mysqli_close($con);
    setcookie("userinfo",null,time()-3600);  
?>
</body>
</html> 
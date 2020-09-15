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

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $address1 = $_POST["inputAddress1"];
    $address2 = $_POST["inputAddress2"];
    $city = $_POST["city"];
    $state= $_POST["state"];
    $zip = $_POST['zip'];

    $streetAddress = urlencode($address1.$address2);
    $city = urlencode($city);
    $state = urlencode($state);
    

    $url = "https://us-street.api.smartystreets.com/street-address?auth-id={$apiAuthId}&auth-token={$apiAuthToken}&street=".$streetAddress."&city=".$city."&state=".$state."&candidates=1";

    $response_json = file_get_contents($url);

    $response = json_decode($response_json,true);

    if($response){
        $latitude= $response[0]['metadata']['latitude'];
        $longitude= $response[0]['metadata']['longitude'];

        $cookie_name = "userInfo";
        $cookie_value = array($firstName,$lastName,$latitude,$longitude);

        setcookie($cookie_name,serialize($cookie_value),time()+3600);
        ?>
            <body id="parallex-image"> 
                <div class="container p-5">
                    <h3 class="text-center display-3 text-white">Confirm your address</h3>
                    <form action="./signedUsers.php" method="POST">
            
                        <label for="inputAddress" class="text-white">Name</label>
                        <div class="form-row mb-3">
                            <div class="col">
                            <input type="text" class="form-control"  name="firstName" value="<?php echo $firstName ?>" disabled>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control"  name="lastName" value = "<?php echo $lastName ?>" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputAddress" class="text-white">Address</label>
                            <input type="text" class="form-control" name="inputAddress1" value = "<?php echo $address1 ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="inputAddress2" class="text-white">Address 2</label>
                            <input type="text" class="form-control" name="inputAddress2" value="<?php echo $address2 ?>" disabled>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity" class="text-white">City</label>
                                <input type="text" class="form-control" name="city" value="<?php echo $city ?>" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputstate" class="text-white">State</label>
                                <input type="text" class="form-control" name="state" value="<?php echo $state ?>" disabled>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputZip" class="text-white">Zip</label>
                                <input type="text" class="form-control" id="inputZip" name="zip" value=<?php echo $zip ?> disabled>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <!-- <a href="./signupForm.html" class="btn btn-outline-warning">Edit</a> -->
                                <button type="button" id="edit" onclick="goback()" class="btn btn-warning">Edit</button>
                            </div>
                            <div class="form-group col-md-6">
                                <a  href="./signedUsers.php" onclick="goback()" type="button"  class="btn btn-primary">Confirm</a>
                            </div>
                        </div>
            
                    </form>
        
                </div>
            </body>
            <script>
                function goback(){
                    window.history.back();
                }  
            </script>
            </html>  
        <?php
    }else{
        ?>
        <body id="parllex-image">
            <div class="container p-5">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Invalid Address!</h4>
                    <p>Please make sure that the provided address is acurate or is a valid united states postal address</p>
                    <hr>
                    <a href="../signupForm.html" class="btn btn-outline-danger">Go Back</a>
                </div>
            </div>
        </body>
        </html>
        <?php    
        }
    ?>

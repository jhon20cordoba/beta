<?php
     //DB connection
     require('../../config/db_connection.php');
     // Get data from regidter form 

     $email = $_POST['email'];
     $pass = $_POST['passwd'];
     // Encrypt the password using MD5 hashing algorithm
     $enc_pass = md5($pass);

     //echo "Email: " . $email;
     //echo "<br>Password: " . $pass;
     //echo "<br>Encrypted Password: " . $enc_pass;

  //query to insert data into users table
    $query = "INSERT INTO users (email, password)
     VALUES ('$email', '$enc_pass')
     ";
    
    $result = pg_query($conn, $query);
    
    if ($result) {
        echo "Registration successful!";
    } else {
        echo "Registration failed! ";
    }
    pg_close($conn);
    
    // close the database connection
//pg_close($conn);

?>

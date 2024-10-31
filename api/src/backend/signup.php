<?php
function save_data_supabase($email, $passwd) {
    // supabase database configuration
    $SUPABASE_URL = 'https://vakjcryudadfebanpasg.supabase.co';
    $SUPABASE_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InZha2pjcnl1ZGFkZmViYW5wYXNnIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzAzODg2NzMsImV4cCI6MjA0NTk2NDY3M30.0LkuDUPLjx50PLMkdjYaL2HE0-Qi_bBF9QUopSCi3Io';
    $url = "$SUPABASE_URL/rest/v1/users";
    $data = [ 
        'email' => $email,
        'password' => $passwd,
    ];
    $options = [
        'http' => [
            'header' => [
                "Content-Type: application/json",
                "Authorization: Bearer $SUPABASE_KEY",
                "apikey: $SUPABASE_KEY"
            ],
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];    

    $context = stream_context_create($options);
    $response = file_get_contents($url, true, $context);
    
    if ($response === false) {
        echo "Error: Unable to save data to Supabase";
        exit;
    }
    
    //$response_data = json_decode($response, true);
    echo "User has been created: ";// . json_encode($response_data);
}

// Database connection
require('../../config/db_connection.php');

// Get data from register form
$email = $_POST['email'];
$pass = $_POST['passwd'];

$enc_pass = password_hash($pass, PASSWORD_DEFAULT);

// Validate if email already exists
$query = "SELECT * FROM users WHERE email = '$email'";
$result = pg_query($conn, $query);
$row = pg_fetch_assoc($result);

if ($row) {
    header('Location: http://127.0.0.1/beta/api/src/.html');
    exit;
}

// Validate that passwords match


// Query to insert data into users table
$query = "INSERT INTO users (email, password) VALUES ('$email', '$enc_pass')";

// Execute the query
$result = pg_query($conn, $query);

if ($result) {
    save_data_supabase($email, $enc_pass);
    echo "<script>alert('Registro exitoso!')</script>";
    header('Location: http://127.0.0.1/beta/api/src/login_form.html');
    exit;
} else {
    echo "Error en el registro: " . pg_last_error($conn);
}

// Close the database connection
pg_close($conn);
?>

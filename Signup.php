<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    // Check if the email and password are set 
    if (!empty($_POST['email']) && !empty($_POST['password'])) { 
        $email = trim($_POST['email']); 
        $password = password_hash($_POST['password'], 
PASSWORD_DEFAULT); 
 
        // Connect to the database 
        $conn = new mysqli("localhost", "root", "", 
"krubise_db"); 
        if ($conn->connect_error) { 
            die("Connection failed: " . $conn->connect_error); 
        } 
 
        // Insert the new user into the database 
        $stmt = $conn->prepare("INSERT INTO users (email, 
password) VALUES (?, ?)"); 
        $stmt->bind_param("ss", $email, $password); 
 
        if ($stmt->execute()) { 
            // If signup is successful, redirect to myntra.html 
            header("Location: krubise.html"); // Redirect to 
myntra.html 
            exit(); 
        } else { 
            // If the query fails, display the error 
            echo "Signup failed: " . $stmt->error; 
        } 
 
        // Close the connection 
        $stmt->close(); 
        $conn->close(); 
    } else { 
        // If fields are empty, show error message 
        echo "Please fill in all fields."; 
    } 
} else { 
    // If the request method is not POST, show the signup form 
    header("Location: signup.html"); // Redirect to signup.html 
if accessed incorrectly 
    exit(); 
} 
?>

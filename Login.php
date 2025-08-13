<?php 
session_start(); 
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (isset($_POST['email']) && isset($_POST['password'])) { 
        $email = trim($_POST['email']); 
        $password = $_POST['password']; 
 
        $conn = new mysqli("localhost", "root", "", 
"krubise_db"); 
        if ($conn->connect_error) { 
            die("Connection failed: " . $conn->connect_error); 
        } 
 
        $stmt = $conn->prepare("SELECT * FROM users WHERE email 
= ?"); 
        $stmt->bind_param("s", $email); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
 
        if ($result->num_rows === 1) { 
            $user = $result->fetch_assoc(); 
            if (password_verify($password, $user['password'])) { 
                $_SESSION['user_id'] = $user['id']; 
                echo "Login successful. Redirecting..."; 
                header("Location: explore.html"); 
                exit; 
            } else { 
                echo "Invalid password."; 
            } 
        } else { 
            echo "No account found."; 
        } 
 
        $stmt->close(); 
        $conn->close(); 
    } else { 
        echo "Please enter email and password."; 
    } 
} else { 
    echo "Invalid request method."; 
} 
?> 

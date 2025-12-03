<?php
// register_user.php - Receives form data and inserts into DB

// 1. Connect to the database
require 'db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    
    // 2. Capture and sanitize user input (Security!)
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password']; 
    
    // 3. Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $default_role_id = 1; 

    try {
        // 4. Use a Prepared Statement (Prevents SQL Injection)
        $sql = "INSERT INTO users (username, email, password_hash, role_id) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        // Execute the statement with the user's data
        $stmt->execute([$username, $email, $password_hash, $default_role_id]);
        
        echo "Registration successful! User: " . htmlspecialchars($username);

    } catch (\PDOException $e) {
        // Handle database errors (e.g., email already exists)
        if ($e->getCode() == 23000) {
            echo "Error: That email is already registered.";
        } else {
            echo "An unknown error occurred.";
        }
    }
} else {
    // If the file is accessed directly without a form submission
    header('Location: register_form.html');
    exit;
}
?>

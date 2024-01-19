<?php
require_once 'system.php';
try {
    $bdLink = new PDO('mysql:host=' . $paramsServer['server'] . ';port=' . $paramsServer['port'] . ';dbname=' . $paramsServer['database'] . ';charset=utf8', $paramsServer['username'], $paramsServer['password']);
    $bdLink->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $bdLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "Error ! database connection error<br/>";
    die();
}
function isUsernameFree($bdLink, $pUsername) {
    if (IsNullOrEmptyString($pUsername)) {
        return false;
    }

    $query = 'SELECT name FROM users WHERE name = ?';

    try {
        $stmt = $bdLink->prepare($query);
        $stmt->bindParam(1, $pUsername);
        $stmt->execute();

        return !$stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function insertUser($bdLink, $pUsername, $pPassword) {
    if (IsNullOrEmptyString($pUsername) || IsNullOrEmptyString($pPassword)) {
        throw new InvalidArgumentException('Parameters not proper strings');
    }

    $query = 'INSERT INTO users (name, password) VALUES (?, ?)';

    try {
        $stmt = $bdLink->prepare($query);

        $hashedPassword = getHashedString($pPassword);

        $stmt->bindParam(1, $pUsername);
        $stmt->bindParam(2, $hashedPassword);

        if ($stmt->execute()) {
            return $bdLink->lastInsertId();
        } else {
            throw new PDOException('INSERT FAILED');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function IsNullOrEmptyString($s) {
    return (!isset($s) || trim($s) === '');
}

function getHashedString($pString) {
    return password_hash($pString, PASSWORD_DEFAULT);
}
// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password
    if (!IsNullOrEmptyString($username) && !IsNullOrEmptyString($password)) {
        $hashedPassword = getHashedString($password);

        // Check if the provided credentials are valid
        $query = 'SELECT id, name, password FROM users WHERE name = ?';
        $stmt = $bdLink->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['name'] = $user['name'];
            header('location: ../index.php'); // Redirect to index or another page
            exit();
        } else {
            $loginError = "Invalid username or password.";
        }
    } else {
        $loginError = "Username and password are required.";
    }
}

// Handle sign-up
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];

    // Validate new username and password
    if (!IsNullOrEmptyString($newUsername) && !IsNullOrEmptyString($newPassword)) {
        // Check if the username is available
        if (isUsernameFree($bdLink, $newUsername)) {
            // Insert the new user
            try {
                $userId = insertUser($bdLink, $newUsername, $newPassword);
                $_SESSION['name'] = $userId;
                header('Location: login_register.php'); // Redirect to index or another page
                exit();
            } catch (Exception $e) {
                $signupError = "Error creating a new user.";
            }
        } else {
            $signupError = "Username is already taken.";
        }
    } else {
        $signupError = "New username and password are required.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/SignUp</title>
    <style>
    body {
        height: 100%;
        margin: 0;
        background-image: url("clouds.gif");
        background-size: cover;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    
    .card {
      width: 300px;
      height: 300px;
      perspective: 1000px;
    }
    
    .card-inner {
      width: 100%;
      height: 100%;
      transition: transform 0.6s;
      transform-style: preserve-3d;
    }
    
    .card-flip {
      transform: rotateY(180deg);
    }
    
    .card-front,
    .card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
    }
    
    .card-front {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      overflow: hidden;
    }
    
    .card-back {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      overflow: hidden;
      transform: rotateY(180deg);
    }
    .ghost {
    display: inline-block;
    padding: 10px 16px;
    font-size: 12px;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    border: 2px solid #3498db;
    border-radius: 5px;
    color: #3498db;
    background-color: #fff;
    transition: background-color 0.3s, color 0.3s;
}
.ghost:hover {
  background-color: #3498db;
  color: #fff;
}
.ghost:active {
  transform: scale(0.95);
}
  </style>
</head>
<body>

<div class="container">
    <div class="card">
      <div class="card-inner">
        <!-- Login Form -->
        <div class="card-front">
            <h2>Login</h2>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <input class="ghost" type="submit" name="login" value="Login">
            </form>
            <?php if (isset($loginError)) echo "<p>$loginError</p>"; ?>
            <p>Don't have an account? <a class="ghost" href="#" onclick="flipCard()">Sign Up</a></p>
        </div>

        <!-- Sign Up Form -->
        <div class="card-back">
            <h2>Sign Up</h2>
            <form method="post">
                <label for="new_username">Full Name:</label>
                <input type="text" id="new_username" name="new_username" required><br><br>
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" required><br><br>
                <input class="ghost" type="submit" name="signup" value="Sign Up">
            </form>
            <p>Already have an account? <a class="ghost" href="#" onclick="flipCard()">Login</a></p>
            <?php if (isset($signupError)) echo "<p>$signupError</p>"; ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    function flipCard() {
      const card = document.querySelector('.card-inner');
      card.classList.toggle('card-flip');
    }
  </script>

</body>
</html>


<?php require_once 'database.php';
require_once 'header.php';
// =================================================================================================

if (!isset($_SESSION['csrf_token'])) {
    echo "CSRF token not found in the session.";
    exit();
}
function isNullOrEmptyString($s) {
    return (!isset($s) || trim($s) === '');
}
function getHashedString($pString) {
    return password_hash($pString, PASSWORD_DEFAULT);
}
function isUsernameFree($bdLink, $pUsername) {
    if (IsNullOrEmptyString($pUsername)) {
        return false;
    }
    $query = 'SELECT name FROM user WHERE name = ?';
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

// =================================================================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "CSRF token validation failed.";
        exit();
    }
    $username = $_POST['email'];
    $password = $_POST['password'];
    if (!isNullOrEmptyString($username) && !isNullOrEmptyString($password)) {
        $hashedPassword = getHashedString($password);
        $query = 'SELECT id, name, password FROM user WHERE name = ?';
        $stmt = $bdLink->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['status'] = 'Connected';
            header('Location: index.php'); 
            exit();
        } else {
            $loginError = "Invalid username or password.";
        }
    } else {
        $loginError = "Username and password are required.";
    }
}

// =================================================================================================

function insertUser($bdLink, $pUsername, $pPassword) {
    if (IsNullOrEmptyString($pUsername) || IsNullOrEmptyString($pPassword)) {
        throw new InvalidArgumentException('Parameters not proper strings');
    }
    $query = 'INSERT INTO user (name, password) VALUES (?, ?)';
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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];
    if (!IsNullOrEmptyString($newUsername) && !IsNullOrEmptyString($newPassword)) {
        if (isUsernameFree($bdLink, $newUsername)) {
            try {
                insertUser($bdLink, $newUsername, $newPassword);
                header('Location: login.php'); 
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

// =================================================================================================


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/817262485e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <title>Login</title>
</head>

<body>
<div class="container">
    <div class="card">
        <div class="card-inner">
            <!-- Login Form -->
            <div class="card-front">
                <h2 class="active">Login</h2>
                <form action="login.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div>
                        <label for="email">Name:</label>
                        <input type="text" id="email" name="email" class="text" required>
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="text" required>
                    </div>
                    <input class="ghost" type="submit" name="login" value="Login">
                </form>
                <?php if (isset($loginError)) echo "<p>$loginError</p>"; ?>
                <p>Don't have an account? <a class="ghost" onclick="flipCard()">Register</a></p>
            </div>
            <!-- Register Form -->
            <div class="card-back">
                <h2>Register</h2>
                <form method="post">
                    <label for="new_username">Name:</label>
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
  <style>
    html {
        background-color: #181B1E;
        color: white;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 75vh;
    }
    
    .card {
        border: 4mm ridge #383637;
        background-color: #181B1E;
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
</body>
</html>
<?php require_once 'footer.php'; ?> 
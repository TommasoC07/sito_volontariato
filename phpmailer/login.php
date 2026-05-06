<?php
require_once __DIR__.'\utility.php';
$errore = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['emaillog'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM utente WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
if(empty($user)){
    $errore = '<div class="alert alert-danger">Email o password errati.</div>';
}
 elseif($user['email']===$email &&  password_verify($password, $user['passkey'])) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
        if($user['ruolo']==="user")
        header("Location: dashboard.php");
    else
        header("Location: usermanager.php");
        exit();
    } 
}

$title = "login";
echo $header;
?>


    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>SITO VOLONTARIATO</h1>
    </div>

    <div class="container mt-4">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <?php echo $errore?>
                
                <form action="" method="post">
                    <div class="mb-3 mt-3">
                        <label class="form-label" for="emaillog">Email:</label>
                        <input type="email" name="emaillog" id="emaillog" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-end">
                    <a href="register.php" class="btn btn-link">Non sei registrato?</a>
</div>
                    <input type="submit" class="btn btn-primary w-100" value="Login">
                </form>
            </div>
        </div>
    </div>
</body>
</html>

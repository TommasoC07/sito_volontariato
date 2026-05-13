<?php
require_once __DIR__.'\utility.php';
$errore = "";
if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['emaillog'])){
    $email = $_POST['emaillog'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $ruolo = "user";

    try{
    $oggetto = "Conferma Registrazione";
    $messaggio = "<h1>Sei stato registrato!</h1>";
    //inviaEmail($email, $oggetto, $messaggio);

    $pdo->beginTransaction();
    $sql = "INSERT INTO utente (nome, cognome, email, passkey, ruolo) VALUES (:nome, :cognome, :email, :pass, :ruolo) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
    'nome' => $_POST['nome'],
    'cognome' => $_POST['cognome'],
    'email' => $email,
    'pass'  => $password,
    'ruolo' => $ruolo
]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $pdo->commit();
    echo "<div class='alert alert-success alert-dismissible fade show'> Utente inserito correttamente\n <button type='button' class='btn-close' data-bs-dismiss='alert'></button> </div>";
    writeOnFile('utente inserito correttamente');

    }catch(PDOException $e) {
    $pdo->rollback();
    die("Errore di connessione: " . $e->getMessage());
    writeOnFile($e);
}
}

$title = "register";
echo $header;
?>


    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>REGISTRATI</h1>
    </div>

    <div class="container mt-4">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <?php echo $errore?>
                
                <form action="" method="post">
                    <div class="mb-3 mt-3">
                        <label class="form-label" for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label" for="cognome">Cognome:</label>
                        <input type="text" name="cognome" id="cognome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="emaillog">Email:</label>
                        <input type="email" name="emaillog" id="emaillog" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-end">
                    <a href="login.php" class="btn btn-link">Sei registrato?</a>
</div>
                    <input type="submit" class="btn btn-primary w-100" value="Registrati">
                </form>
            </div>
        </div>
    </div>
</body>
</html>

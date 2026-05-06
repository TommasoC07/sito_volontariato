<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once('assets\mailhandler.php');
require_once __DIR__ . '\utility.php';


if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['emaillog'])){
    $email = $_POST['emaillog'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $ruolo =  $_POST['ruolo'];

    try{
    $oggetto = "Conferma Registrazione";
    $messaggio = "<h1>Sei stato registrato!</h1>";
    //inviaEmail($email, $oggetto, $messaggio);

    $sql = "INSERT INTO utente (email, passkey, ruolo) VALUES (:email, :pass, :ruolo) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
    'email' => $email,
    'pass'  => $password,
    'ruolo' => $ruolo
]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<div class='alert alert-success'> Utente inserito correttamente\n </div>";
    writeOnFile('utente inserito correttamente');
    }catch(PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
    writeOnFile($e);
}
}

if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['id'])){
    $id = $_POST['id'];

try {
    $sql = "DELETE FROM utente WHERE id = (:id) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
    'id' => $id,
]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<div class='alert alert-danger'> Utente eliminato correttamente\n </div>";
}catch(PDOException $e) {
    $message= "\n" . date('Y-m-d H:i:s'). " Errore di eliminazione utente: " . $e->getMessage();
    writeOnFile($message);
    die($message);
}
}

if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['id_update'])){
    $id = $_POST['id_update'];
    $newemail = $_POST['newemail'];

try{
    $sql = "UPDATE utente SET email = (:email) WHERE id = (:id) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
    'email' => $newemail,
    'id' => $id
]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<div class='alert alert-warning'> Utente aggiornato correttamente\n </div>";
}catch(PDOException $e) {
    $message= "\n" .date('Y-m-d H:i:s'). " Errore di aggiornamento utente: " . $e->getMessage();
    writeOnFile($message);
    die($message);
}
}

$sql = "SELECT * FROM utente";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);

    $table = "";
    
    while($user = $stmt->fetch(PDO::FETCH_ASSOC)){
        $table .= " <form action=usermanager.php method='post'><tr>
        <td><input type='hidden' name='id_update' value='" . $user["id"] . "'>" . $user["id"] . "</td>
        <td> <input type='email' name='newemail' value='" . $user["email"] . "' class='form-control form-control-sm' style='width:150px' required></td>
        <td>" . $user["ruolo"] . "</td>
        <td class='colonna-azioni'>" . 
        "<button type='submit' class='btn btn-warning'><i class='bi bi-pencil-square'></i> Modifica</button></form>
        <form action=usermanager.php method='post'>
        <input type='hidden' name='id' value=". $user['id'] . "><button type='submit' class='btn btn-danger'><i class='bi bi-trash'></i> Elimina</button>
        </form></td></tr>";
    }

    $title = 'usermanager';
    echo $header;
?>
<div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>AREA ADMIN: <?php echo $_SESSION['user_email']; ?></h1>
    </div>

    <br>
    <div class="d-flex">
<a href="donation.php" class="btn btn-primary"> DONAZIONI </a>
<a href="logout.php" class="btn btn-primary ms-auto"><i class="bi bi-person-circle"></i> LOGOUT</a>
</div>
<hr>
<div>
    <h1>Tabella utenti</h1>
</div>

<div class="container">
    <div class="table-container">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Ruolo</th>
                    <th class="text-center">Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $table; ?>
            </tbody>
        </table>
    </div>
</div>


<hr>

    <div>
    <h1>Registra utente</h1>
</div>

<div class="container mt-4">
    <br>

    <div class="card">
    <div class="card-body">
        <form action="usermanager.php" method="post">
                <div class="mb-3 mt-3">
                    <label class="form-label" for="emaillog">Email:</label><br>
                    <input type="email" name="emaillog" id="emaillog" class="form-control" style="max-width: 300px;" required><br>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label" for="password">Password:</label><br>
                    <input type="password" name="password" id="password" class="form-control" style="max-width: 300px;" required><br>
                </div>
                <div class="mb-3 mt-3">
                    <label class="form-label" for="ruolo">Ruolo:</label>
                    <select name="ruolo" id="ruolo" class="form-select" style="max-width: 300px;"  required>
                    <option value="" selected disabled>Scegli un ruolo</option>
                    <option value="admin">Admin</option>
                    <option value="user">Utente</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="Registra">
            </form>
        </div>
</div>
</div>
<hr>
 
<!-- <div>
    <h1>Aggiorna utente</h1>
</div>

<div class="container mt-4">
   
    <div class="card">
    <div class="card-body">
        <form action="usermanager.php" method="post">
                <div class="mb-3 mt-3">
                    <label class="form-label" for="id_update">ID:</label><br>
                    <select class="form-select">
                        <option selected>Scegli un'opzione</option>
                        <option value="1">Opzione 1</option>
                        <option value="2">Opzione 2</option>
                    </select>

                    
                    <input type="number" name="id_update" id="id_update"><br>
                </div>
                 <div class="mb-3 mt-3">
                    <label class="form-label" for="newemail">Email:</label><br>
                    <input type="email" name="newemail" id="newemail"><br>
                </div>
                <input type="submit" class="btn btn-warning" value="Aggiorna">
            </form>
        </div>
</div>
</div>-->

<h1>Scarica Database in json</h1>

<div class="container mt-4">
    <div class="card">
    <div class="card-body">
    <a href="download.php" class="btn btn-primary">
    Scarica Database in JSON
</a>
</div>
</div>
</div>

</body>
</html>
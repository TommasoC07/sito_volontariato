<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once __DIR__.'\utility.php';

if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['donation'])){
    $importo = $_POST['donation'];
    $id = $_SESSION['user_id'];

    $sql = "INSERT INTO donazione (importo, id_utente) VALUES (:importo, :id_utente) ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
    'importo' => $importo,
    'id_utente'  => $id
]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<div class='alert alert-success'> Donazione effettuata con successo </div>";
}

$title = "dashboard";
echo $header;


?>


    
<script src="script.js"></script>
<div class="container-fluid p-5 bg-primary text-white text-center">
    <h1>DASHBOARD</h1>
</div>
<br>
<div class="d-flex">
<h4>Benvenuto, <?php echo $_SESSION['user_email']; ?></h4>
<a href="logout.php" class="btn btn-primary ms-auto"><i class="bi bi-person-circle"></i> LOGOUT</a>
</div>
<hr>
<div>
    <h1>Effettua donazione</h1>
</div>
<div class="container mt-4">
    <div class="card">
    <div class="card-body">
        <!--onsubmit="salvaDati()"-->
        <form action="dashboard.php" method="post">
            <div class="mb-3 mt-3">
                <label class="form-label" for="donation">Importo:</label><br>
                <input type="number" name="donation" id="donation" placeholder="€"><br>
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
            </form>
 </div>
    </div>
</div>




</html>


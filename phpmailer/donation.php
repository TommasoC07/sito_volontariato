<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
require_once('assets\mailhandler.php');
require_once __DIR__ . '\utility.php';

try{
$sql = "SELECT utente.id, utente.email, donazione.importo, donazione.data_donazione FROM utente INNER JOIN donazione ON utente.id = donazione.id_utente";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);

    $table = "";
    
    while($user = $stmt->fetch(PDO::FETCH_ASSOC)){
        $table .= " <tr>
        <td>" . $user["id"] . "</td>
        <td>" . $user["email"] . "</td>
        <td>" . $user["importo"] . "</td>
        <td>" . $user["data_donazione"]. "</td></tr>";
    }
}catch(PDOException $e) {
    $message= "\n" . date('Y-m-d H:i:s') . " Errore di scrittura della tabella donazioni: " . $e->getMessage();
    writeOnFile($message);
    die($message);
}

try{
$sql = "SELECT email FROM utente WHERE id IN (SELECT id_utente FROM donazione WHERE data_donazione > NOW() - INTERVAL 10 DAY)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);

    $table2 = "";
    
    while($user = $stmt->fetch(PDO::FETCH_ASSOC)){
        $table2 .= " <tr>
        <td>" . $user["email"] . "</td></tr>";
    }
}catch(PDOException $e) {
    $message= "\n" . date('Y-m-d H:i:s') . " Errore di scrittura della tabella statistiche 10g: " . $e->getMessage();
    writeOnFile($message);
    die($message);;
}

try{
$sql = "SELECT utente.email, SUM(donazione.importo) AS totale_donato FROM utente INNER JOIN donazione ON utente.id = donazione.id_utente GROUP BY utente.email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([]);

    $table3 = "";
    
    while($user = $stmt->fetch(PDO::FETCH_ASSOC)){
        $table3 .= " <tr>
        <td>" . $user["email"] . "</td>
        <td>". $user["totale_donato"] . "</tr>";
    }
}catch(PDOException $e) {
    $message= "\n" . date('Y-m-d H:i:s') . " Errore di scrittura della tabella statistiche 10g: " . $e->getMessage();
    writeOnFile($message);
    die($message);;
}

$title = 'donation';
    echo $header;
    ?>

    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>DONAZIONI</h1>
    </div>
    <br>
<a href="usermanager.php" class="btn btn-primary"><i class="bi bi-arrow-bar-left"></i> INDIETRO </a>
<hr>
<div>
    <h1>Tabella donazioni</h1>
</div>

<div class="container">
<?php echo "<table class='table table-striped'>
<th>id</th>
<th>email</th>
<th>importo</th>
<th>data</th>
" . $table . "
</table>" ?>
</div>

<hr>
<div>
    <h1>Tabella Utenti che hanno donato negli ultimi 10 giorni</h1>
</div>

<div class="container">
<?php echo "<table class='table table-striped'>
<th>email</th>
" . $table2 . "
</table>" ?>

<hr>
<div>
    <h1>Donazioni totali</h1>
</div>

<div class="container">
<?php echo "<table class='table table-striped'>
<th>email</th><th>importo totale</th>
" . $table3 . "
</table>" ?>
</div>
</body>
</html>
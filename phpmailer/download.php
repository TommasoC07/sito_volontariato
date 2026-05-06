<?php
$host = "localhost";
$dbname = "sito_volontariato";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    $sql = "SELECT * FROM utente"; 
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $json_data = json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="backup_utenti_'.date('d-m-Y').'.json"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($json_data));

    ob_clean();
    flush();

    echo $json_data;
    exit();

} catch (PDOException $e) {
    die("Errore: " . $e->getMessage());
}
?>
<?php require_once "db.php" ?>
<?php 
    $query = $db->prepare("SELECT * FROM sorular ORDER BY kelime_sayi ASC LIMIT 0,14");
    $query->execute([]);
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows)
?>
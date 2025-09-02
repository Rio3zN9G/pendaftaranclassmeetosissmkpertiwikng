<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = htmlspecialchars($_POST['team_name']);
    $leader_phone = htmlspecialchars($_POST['leader_phone']);
    $class = htmlspecialchars($_POST['class']);
    $major = htmlspecialchars($_POST['major']);
    $class_number = htmlspecialchars($_POST['class_number']);
    $competition = htmlspecialchars($_POST['competition']);
    
    // Format kelas (contoh: XI RPL 2)
    $full_class = "$class $major $class_number";
    
    // Simpan ke file database sederhana
    $data = [
        'team_name' => $team_name,
        'leader_phone' => $leader_phone,
        'class' => $full_class,
        'competition' => $competition,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    $file = 'registrations.json';
    $registrations = [];
    
    if (file_exists($file)) {
        $registrations = json_decode(file_get_contents($file), true);
    }
    
    $registrations[] = $data;
    file_put_contents($file, json_encode($registrations, JSON_PRETTY_PRINT));
    
    // Set session untuk modal
    $_SESSION['show_modal'] = true;
    $_SESSION['competition'] = $competition;
    
    header('Location: index.php');
    exit();
}
?>
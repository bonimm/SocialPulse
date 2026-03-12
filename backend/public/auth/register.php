<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../frontend/pages/register.html');
    exit;
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = ($_POST['password'] ?? '');
$confirm = ($_POST['confirm_password'] ?? '');

//Validaciones
$errors = [];

if (empty($username)) $errors[] = "El usuario es obligatorio";
if (empty($email)) $errors[] = "El email es obligatorio";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email no valido";
if (strlen($password) < 8) $errors[] = "La contraseña debe tener mínimo 8 caracteres";
if ($password !== $confirm) $errors[] = "Las contraseñas no coinciden";

if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

//Verificvar si usuario o email ya existen
$check = $conn->prepare("SELECT id FROM usuarios WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'errors' => ['Usuario o email ya registrado']]);
    exit;
}

//Hashear contraseña y guardar usuario
$hashed = password_hash($password, PASSWORD_BCRYPT);
$stmt = $conn->prepare("INSERT INTO usuarios (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Usuario registrado correctamente']);
} else { 
    echo json_encode(['success' => true, 'message' => 'Error al registrar el usuario']);
}
?>
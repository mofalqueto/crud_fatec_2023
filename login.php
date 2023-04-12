<?php

ob_start();

session_start(); // Inicia a sessão

require_once 'config.php';

//VERIFICA SE O MÉTODO DE SOLICITAÇÃO HTTP UTILIZADO PARA ACESSAR UMA PÁGINA É DO TIPO "POST".
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email_login'];
    $senha = $_POST['senha_login'];

    // Verifica se o email e senha são válidos
    $query = "SELECT id, nome FROM fatec_admin WHERE email='$email' AND senha=md5('$senha')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['nome'] = $row['nome'];
        header('Location: dashboard.html'); // Redireciona para a página de dashboard
    } else {
        //EMITE UMA MENSAGEM DIZENDO QUE O EMAIL OU SENHA DIGITADOS ESTÃO INCORRETOS
        echo '<script>alert("Email ou senha incorretos!")</script>'; 
        header("Location: index.html#paralogin");               
    }
}
//função usada para liberar o contedúdo do buffer de saída e enviar os dados para o navegador imediatamente
ob_end_flush();

?>


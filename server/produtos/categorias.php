<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if(isset($_GET['categoria'])) {
                    getProdutos($_GET['categoria']);
            } else {
                header('HTTP/1.0 400 Bad Request');
                    die('Categoria não enviada');
            }
        
    } else {
        header('HTTP/1.0 405 Method Not Allowed');
        die('Método não permitido');
    }
} else {
    header('HTTP/1.0 403 Forbidden');
    die('Acesso proibido');
}

function getProdutos($categoria) {
    $conexao = new mysqli("localhost:3306", "root", "", "thriftshop");

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

$categoria =  urldecode($categoria);
    $categoria = $conexao->real_escape_string($categoria);
    $sql = "SELECT * FROM produtos WHERE categoria = '$categoria'";
    $resultado = $conexao->query($sql);

    $dados = [];
    while ($linha = $resultado->fetch_assoc()) {
        $dados[] = $linha;
    }

    $conexao->close();

    header('Content-Type: application/json');
    echo json_encode($dados);
}
?>

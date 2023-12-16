<?php
try {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(isset($_GET['id'])) {
                if(is_numeric($_GET['id'])){
                    getProdutos($_GET['id']);
                } else {
                    header('HTTP/1.0 400 Bad Request');
                    die('ID deve ser numérico');
                }
            } else {
                getProdutos();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            postProdutos();
        } else {
            header('HTTP/1.0 405 Method Not Allowed');
            die('Método não permitido');
        }
    } else {
        header('HTTP/1.0 403 Forbidden');
        die('Acesso proibido');
    }
} catch (Exception $e) {
    header('HTTP/1.0 500 Internal Server Error');
    echo 'Exceção capturada: ', $e->getMessage(), "\n";
}

function getProdutos($id = null) {
    $conexao = new mysqli("localhost:3306", "root", "", "thriftshop");

    if ($conexao->connect_error) {
        header('HTTP/1.0 500 Internal Server Error');
        die("Falha na conexão: " . $conexao->connect_error);
    }

    if ($id){
        $sql = "SELECT * FROM produtos WHERE id =".$id;

        $resultado = $conexao->query($sql);

        if ($resultado->num_rows > 0) {
            $dados = $resultado->fetch_assoc();
        } else {
            http_response_code(404);
            die('Produto não encontrado');
        }
    } else {
        $sql = "SELECT * FROM produtos";

        $resultado = $conexao->query($sql);

        $dados = [];
        while ($linha = $resultado->fetch_assoc()) {
            $dados[] = $linha;
        }
    }

    $conexao->close();

    header('Content-Type: application/json');
    echo json_encode($dados);
}
function postProdutos() {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];



    $imagem = $_FILES['imagem'];
    $tempNomeArquivo = $imagem['tmp_name'];
    $diretorioDestino = '../web/public/imagens/';
    $nomeArquivo = $imagem['name'];
    $caminhoCompleto = $diretorioDestino . $nomeArquivo;

    move_uploaded_file($tempNomeArquivo, $caminhoCompleto);

    $conexao = new mysqli("localhost:3306", "root", "", "thriftshop");

    if ($conexao->connect_error) {
        header('HTTP/1.0 500 Internal Server Error');
        die("Falha na conexão: " . $conexao->connect_error);
    }

    $sql = "INSERT INTO produtos (nome, descricao, imagem, valor, categoria) VALUES ('$nome', '$descricao', '$nomeArquivo', '$valor', '$categoria')";

    if ($conexao->query($sql) === TRUE) {
        echo "Dados inseridos com sucesso!";
    } else {
        header('HTTP/1.0 500 Internal Server Error');
        echo "Erro ao inserir dados: " . $conexao->error;
    }

    $conexao->close();
}
?>

<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../Modal/ClienteDAO.php';
require_once __DIR__ . '/../Modal/FuncionarioDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['nome-usuario']) || !isset($data['senha'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Usuário e senha são obrigatórios']);
        exit();
    }

    $username = $data['nome-usuario'];
    $senha = $data['senha'];
    $tipoUsuario = $data['tipo-usuario'] ?? 'cliente';

    // Verificar se é cliente ou funcionário
    if ($tipoUsuario === 'funcionario') {
        try {
            $funcionarioDAO = new FuncionarioDAO();
            $funcionario = $funcionarioDAO->autenticar($username, $senha);
            
            if ($funcionario) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Login realizado com sucesso',
                    'tipo' => 'funcionario',
                    'usuario' => [
                        'id' => $funcionario['id_funcionario'],
                        'nome' => $funcionario['nome_funcionario'],
                        'email' => $funcionario['email_funcionario'],
                        'cargo' => $funcionario['cargo']
                    ]
                ]);
                exit();
            } else {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Funcionário não encontrado ou senha incorreta']);
                exit();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erro ao autenticar funcionário: ' . $e->getMessage()]);
            exit();
        }
    } else {
        // Tentar como cliente
        try {
            $clienteDAO = new ClienteDAO();
            $cliente = $clienteDAO->autenticar($username, $senha);
            
            if ($cliente) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Login realizado com sucesso',
                    'tipo' => 'cliente',
                    'usuario' => [
                        'id' => $cliente['id_cliente'],
                        'nome' => $cliente['nome_cliente'],
                        'email' => $cliente['email_cliente']
                    ]
                ]);
                exit();
            } else {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Cliente não encontrado ou senha incorreta']);
                exit();
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erro ao autenticar cliente: ' . $e->getMessage()]);
            exit();
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>


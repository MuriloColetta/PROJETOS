<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../Modal/Cliente.php';
require_once __DIR__ . '/../Modal/ClienteDAO.php';

$method = $_SERVER['REQUEST_METHOD'];
$dao = new ClienteDAO();

try {
    switch ($method) {
        case 'GET':
            // Buscar todos os clientes
            $clientes = $dao->LerCliente();
            $result = [];
            foreach ($clientes as $cliente) {
                $result[] = [
                    'id' => $cliente->getIdCliente() ?? null,
                    'nome' => $cliente->getNomeCliente(),
                    'cpf' => $cliente->getCpfCliente(),
                    'dataNascimento' => $cliente->getDataNascimento(),
                    'email' => $cliente->getEmailCliente(),
                    'telefone' => $cliente->getTelefoneCliente(),
                    'senha' => $cliente->getSenhaCliente()
                ];
            }
            echo json_encode(['success' => true, 'data' => $result]);
            break;

        case 'POST':
            // Criar novo cliente
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
                break;
            }
            
            // Validar campos obrigatórios
            if (empty(trim($data['nome'] ?? '')) || empty(trim($data['cpf'] ?? '')) || 
                empty(trim($data['dataNascimento'] ?? '')) || empty(trim($data['email'] ?? '')) || 
                empty(trim($data['telefone'] ?? '')) || empty(trim($data['senha'] ?? ''))) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios']);
                break;
            }

            // Validar email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Email inválido']);
                break;
            }

            try {
                $cliente = new Cliente(
                    null,
                    trim($data['nome']),
                    trim($data['cpf']),
                    trim($data['dataNascimento']),
                    trim($data['email']),
                    trim($data['telefone']),
                    trim($data['senha'])
                );

                $dao->criarCliente($cliente);
                echo json_encode(['success' => true, 'message' => 'Cliente criado com sucesso']);
            } catch (PDOException $e) {
                http_response_code(500);
                error_log("Erro ao criar cliente: " . $e->getMessage());
                $errorMessage = 'Erro ao criar cliente';
                // Verificar se é erro de duplicata
                if (strpos($e->getMessage(), 'Duplicate') !== false || strpos($e->getMessage(), 'UNIQUE') !== false) {
                    $errorMessage = 'Email ou CPF já cadastrado';
                }
                echo json_encode(['success' => false, 'message' => $errorMessage]);
            } catch (Exception $e) {
                http_response_code(500);
                error_log("Erro ao criar cliente: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Erro ao criar cliente: ' . $e->getMessage()]);
            }
            break;

        case 'PUT':
            // Atualizar cliente
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['id']) || !isset($data['nome'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID e nome são obrigatórios']);
                break;
            }

            // Buscar cliente original para obter o nome
            $clientes = $dao->LerCliente();
            $clienteOriginal = null;
            foreach ($clientes as $c) {
                if ($c->getIdCliente() == $data['id']) {
                    $clienteOriginal = $c;
                    break;
                }
            }

            if (!$clienteOriginal) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Cliente não encontrado']);
                break;
            }

            $dao->atualizarCliente(
                $clienteOriginal->getNomeCliente(),
                $data['nome'],
                $data['cpf'] ?? $clienteOriginal->getCpfCliente(),
                $data['dataNascimento'] ?? $clienteOriginal->getDataNascimento(),
                $data['email'] ?? $clienteOriginal->getEmailCliente(),
                $data['telefone'] ?? $clienteOriginal->getTelefoneCliente(),
                $data['senha'] ?? $clienteOriginal->getSenhaCliente()
            );

            echo json_encode(['success' => true, 'message' => 'Cliente atualizado com sucesso']);
            break;

        case 'DELETE':
            // Deletar cliente
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID é obrigatório']);
                break;
            }

            // Buscar cliente para obter o nome
            $clientes = $dao->LerCliente();
            $clienteParaDeletar = null;
            foreach ($clientes as $c) {
                if ($c->getIdCliente() == $data['id']) {
                    $clienteParaDeletar = $c;
                    break;
                }
            }

            if (!$clienteParaDeletar) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Cliente não encontrado']);
                break;
            }

            $dao->deletarCliente($clienteParaDeletar->getNomeCliente());
            echo json_encode(['success' => true, 'message' => 'Cliente deletado com sucesso']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
}
?>


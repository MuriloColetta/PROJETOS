<?php
/**
 * Script para criar contas de teste (Cliente e Administrador)
 * Execute este arquivo uma vez para criar as contas de teste
 */

require_once __DIR__ . '/Modal/Connection.php';
require_once __DIR__ . '/Modal/Cliente.php';
require_once __DIR__ . '/Modal/ClienteDAO.php';
require_once __DIR__ . '/Modal/Funcionario.php';
require_once __DIR__ . '/Modal/FuncionarioDAO.php';

try {
    $conn = Connection::getInstance();
    
    // Criar DAOs
    $clienteDAO = new ClienteDAO();
    $funcionarioDAO = new FuncionarioDAO();
    
    echo "<h2>Criando contas de teste...</h2>";
    
    // ========== CRIAR CLIENTE DE TESTE ==========
    echo "<p>Criando conta de CLIENTE...</p>";
    
    // Verificar se o cliente já existe
    $clienteExistente = $clienteDAO->buscarCliente("cliente_teste");
    
    if (!$clienteExistente) {
        $cliente = new Cliente(
            null,
            "cliente_teste",
            "123.456.789-00",
            "1990-01-15",
            "cliente@techfit.com",
            "(19) 99999-8888",
            "123456"
        );
        
        $clienteDAO->criarCliente($cliente);
        echo "<p style='color: green;'>✓ Conta CLIENTE criada com sucesso!</p>";
        echo "<p><strong>Usuário:</strong> cliente_teste</p>";
        echo "<p><strong>Senha:</strong> 123456</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Conta CLIENTE já existe.</p>";
    }
    
    // ========== CRIAR ADMINISTRADOR DE TESTE ==========
    echo "<p>Criando conta de ADMINISTRADOR...</p>";
    
    // Verificar se o funcionário já existe
    $funcionarioExistente = $funcionarioDAO->buscarFuncionario("admin");
    
    if (!$funcionarioExistente) {
        $funcionario = new Funcionario(
            null,
            "admin",
            "987.654.321-00",
            "Gerente",
            5000.00,
            8,
            "admin@techfit.com",
            "(19) 98888-7777",
            "admin123"
        );
        
        $funcionarioDAO->criarFuncionario($funcionario);
        echo "<p style='color: green;'>✓ Conta ADMINISTRADOR criada com sucesso!</p>";
        echo "<p><strong>Usuário:</strong> admin</p>";
        echo "<p><strong>Senha:</strong> admin123</p>";
    } else {
        echo "<p style='color: orange;'>⚠ Conta ADMINISTRADOR já existe.</p>";
    }
    
    echo "<hr>";
    echo "<h3>Contas criadas:</h3>";
    echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>CLIENTE:</h4>";
    echo "<p><strong>Usuário:</strong> cliente_teste</p>";
    echo "<p><strong>Senha:</strong> 123456</p>";
    echo "<p><strong>Tipo:</strong> Cliente</p>";
    echo "</div>";
    
    echo "<div style='background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h4>ADMINISTRADOR:</h4>";
    echo "<p><strong>Usuário:</strong> admin</p>";
    echo "<p><strong>Senha:</strong> admin123</p>";
    echo "<p><strong>Tipo:</strong> Funcionário (Gerente)</p>";
    echo "</div>";
    
    echo "<p style='color: blue;'><strong>Você pode usar essas contas para fazer login no sistema!</strong></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Erro ao criar contas: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>


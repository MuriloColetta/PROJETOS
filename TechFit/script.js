async function entrar() {
    const username = document.getElementById("username");
    const senha = document.getElementById("senha");
    const tipoUsuario = document.querySelector('input[name="tipo-usuario"]:checked');
    
    if (!username || !senha) {
        Notification.error("Por favor, preencha todos os campos!");
        return;
    }
    
    if (username.value.trim() === "" || senha.value.trim() === "") {
        Notification.error("Por favor, preencha todos os campos!");
        return;
    }
    
    if (!tipoUsuario) {
        Notification.error("Por favor, selecione um tipo de usuário!");
        return;
    }
    
    // Validar login com backend
    try {
        const dadosLogin = {
            'nome-usuario': username.value.trim(),
            'senha': senha.value.trim(),
            'tipo-usuario': tipoUsuario.value
        };
        
        console.log('Dados do login sendo enviados:', dadosLogin);
        
        const response = await fetch('api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dadosLogin)
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Erro na resposta:', errorText);
            try {
                const errorResult = JSON.parse(errorText);
                Notification.error("Erro ao fazer login: " + (errorResult.message || 'Erro desconhecido'));
            } catch (e) {
                Notification.error("Erro ao fazer login: " + errorText);
            }
            return;
        }

        const result = await response.json();
        console.log('Resultado do login:', result);

        if (result.success) {
            // Salvar dados do usuário na sessão
            sessionStorage.setItem('usuarioLogado', JSON.stringify(result.usuario || result.cliente));
            sessionStorage.setItem('tipoUsuario', result.tipo || 'cliente');
            
            Notification.success("Login realizado com sucesso!");
            
            // Redirecionar baseado no tipo de usuário
            setTimeout(() => {
                if (result.tipo === 'funcionario') {
                    window.location.href = "funcionario.html";
                } else {
                    window.location.href = "index.html";
                }
            }, 1000);
        } else {
            Notification.error("Usuário ou senha inválidos: " + (result.message || ''));
        }
    } catch (error) {
        console.error('Erro completo:', error);
        Notification.error("Erro ao fazer login: " + (error.message || 'Erro de conexão. Verifique se o servidor está rodando.'));
    }
}

function cadastroUsuario() {
    window.location.href = "cadastro.html";
}

async function cadastrarUsuario() {
    const username = document.getElementById("username");
    const cpf = document.getElementById("cpf");
    const dataNascimento = document.getElementById("data-nascimento");
    const email = document.getElementById("email");
    const telefone = document.getElementById("telefone");
    const senha = document.getElementById("senha");
    const confirmarSenha = document.getElementById("confirmar-senha");
    
    // Validação de campos obrigatórios
    if (!username || !cpf || !dataNascimento || !email || !telefone || !senha || !confirmarSenha) {
        Notification.error("Erro ao acessar os campos do formulário!");
        return;
    }
    
    if (username.value.trim() === "" || cpf.value.trim() === "" || dataNascimento.value === "" || 
        email.value.trim() === "" || telefone.value.trim() === "" || senha.value.trim() === "" || 
        confirmarSenha.value.trim() === "") {
        Notification.error("Por favor, preencha todos os campos!");
        return;
    }
    
    // Validação de senha
    if (senha.value !== confirmarSenha.value) {
        Notification.error("As senhas não coincidem!");
        return;
    }
    
    if (senha.value.length < 6) {
        Notification.error("A senha deve ter pelo menos 6 caracteres!");
        return;
    }
    
    // Validação básica de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
        Notification.error("Por favor, insira um e-mail válido!");
        return;
    }
    
    // Salvar cliente no banco de dados
    try {
        const novoCliente = {
            nome: username.value.trim(),
            cpf: cpf.value.trim(),
            dataNascimento: dataNascimento.value,
            email: email.value.trim(),
            telefone: telefone.value.trim(),
            senha: senha.value // Em produção, isso deveria ser criptografado
        };

        const response = await fetch('api/clientes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(novoCliente)
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Erro na resposta:', errorText);
            try {
                const errorResult = JSON.parse(errorText);
                Notification.error("Erro ao cadastrar: " + (errorResult.message || 'Erro desconhecido'));
            } catch (e) {
                Notification.error("Erro ao cadastrar: " + errorText);
            }
            return;
        }

        const result = await response.json();

        if (result.success) {
            Notification.success("Cadastro realizado com sucesso!");
            setTimeout(() => {
                window.location.href = "login.html";
            }, 1500);
        } else {
            Notification.error("Erro ao cadastrar: " + (result.message || 'Erro desconhecido'));
        }
    } catch (error) {
        console.error('Erro completo:', error);
        Notification.error("Erro ao cadastrar: " + (error.message || 'Erro de conexão. Verifique se o servidor está rodando.'));
    }
}

// === Dados fixos dos horários ===
const horarios = {
    capoeira: ["Segunda - 16:30", "Sexta - 16:00"],
    zumba: ["Terça - 13:40", "Quinta - 14:00"],
    sanda: ["Terça - 17:00", "Quinta - 18:00"],
    yoga: ["Segunda - 14:00", "Quinta - 15:00"],
    muaythai: ["Quarta - 19:00", "Sexta - 19:00"]
};

// === Atualiza horários ao escolher modalidade ===
const modalidadeSelect = document.getElementById("modalidade");
const horarioSelect = document.getElementById("horario");

if (modalidadeSelect && horarioSelect) {
    modalidadeSelect.addEventListener("change", function () {
        const modalidadeEscolhida = this.value;
        horarioSelect.innerHTML = "<option value='' disabled selected>Horário</option>";

        if (modalidadeEscolhida && horarios[modalidadeEscolhida]) {
            horarios[modalidadeEscolhida].forEach(function (h) {
                const option = document.createElement("option");
                option.value = h;
                option.textContent = h;
                horarioSelect.appendChild(option);
            });
        }
    });
}

// === Agendar Aula ===
async function agendarAula() {
    const nome = document.getElementById("nome_cliente");
    const modalidade = document.getElementById("modalidade");
    const horario = document.getElementById("horario");

    if (!nome || !modalidade || !horario) {
        Notification.error("Erro ao acessar os campos do formulário!");
        return;
    }

    const nomeValue = nome.value.trim();
    const modalidadeValue = modalidade.value;
    const horarioValue = horario.value;

    if (!nomeValue || !modalidadeValue || !horarioValue) {
        Notification.error("Por favor, preencha todos os campos!");
        return;
    }

    try {
        const novoAgendamento = {
            tipo: "Aula",
            nome: nomeValue,
            modalidade: modalidadeValue,
            horario: horarioValue,
            data: new Date().toISOString().slice(0, 19).replace('T', ' ')
        };

        const response = await fetch('api/agendamentos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(novoAgendamento)
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Erro na resposta:', errorText);
            try {
                const errorResult = JSON.parse(errorText);
                Notification.error("Erro ao agendar aula: " + (errorResult.message || 'Erro desconhecido'));
            } catch (e) {
                Notification.error("Erro ao agendar aula: " + errorText);
            }
            return;
        }

        const result = await response.json();

        if (result.success) {
            Notification.success("Aula agendada com sucesso!");
            document.querySelectorAll('.agendar-aula input, .agendar-aula select').forEach(el => el.value = "");
            if (horarioSelect) {
                horarioSelect.innerHTML = "<option value='' disabled selected>Horário</option>";
            }
        } else {
            Notification.error("Erro ao agendar aula: " + (result.message || 'Erro desconhecido'));
        }
    } catch (error) {
        console.error('Erro completo:', error);
        Notification.error("Erro ao agendar aula: " + (error.message || 'Erro de conexão. Verifique se o servidor está rodando.'));
    }
}

async function agendarAvaliacao() {
    const nome = document.getElementById("nome_avaliacao");
    const peso = document.getElementById("peso_avaliacao");
    const altura = document.getElementById("altura_avaliacao");
    const dataAvaliacao = document.getElementById("data_avaliacao_form");

    if (!nome || !peso || !altura || !dataAvaliacao) {
        Notification.error("Erro ao acessar os campos do formulário!");
        return;
    }

    const nomeValue = nome.value.trim();
    const pesoValue = peso.value.trim();
    const alturaValue = altura.value.trim();
    const dataValue = dataAvaliacao.value;

    if (!nomeValue || !pesoValue || !alturaValue || !dataValue) {
        Notification.error("Por favor, preencha todos os campos!");
        return;
    }

    try {
        const novaAvaliacao = {
            tipo: "Avaliação",
            nome: nomeValue,
            peso: pesoValue,
            altura: alturaValue,
            dataAvaliacao: dataValue,
            data: new Date().toISOString().slice(0, 19).replace('T', ' ')
        };

        const response = await fetch('api/avaliacoes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(novaAvaliacao)
        });

        if (!response.ok) {
            const errorText = await response.text();
            console.error('Erro na resposta:', errorText);
            try {
                const errorResult = JSON.parse(errorText);
                Notification.error("Erro ao agendar avaliação: " + (errorResult.message || 'Erro desconhecido'));
            } catch (e) {
                Notification.error("Erro ao agendar avaliação: " + errorText);
            }
            return;
        }

        const result = await response.json();

        if (result.success) {
            Notification.success("Avaliação agendada com sucesso!");
            document.querySelectorAll('.agendar-avaliacao input').forEach(el => {
                if (el.type === "date" || el.type === "text") el.value = "";
            });
        } else {
            Notification.error("Erro ao agendar avaliação: " + (result.message || 'Erro desconhecido'));
        }
    } catch (error) {
        console.error('Erro completo:', error);
        Notification.error("Erro ao agendar avaliação: " + (error.message || 'Erro de conexão. Verifique se o servidor está rodando.'));
    }
}

function verAgendamentos() {
    const agendamentos = JSON.parse(localStorage.getItem("agendamentos")) || [];
    console.table(agendamentos);
}

function carregarAgendamentos() {
    const agendamentos = JSON.parse(localStorage.getItem("agendamentos")) || [];
    const tbody = document.getElementById("tabela-agendamentos");
    const msg = document.getElementById("mensagem-vazio");
    tbody.innerHTML = "";

    if (agendamentos.length === 0) {
        msg.style.display = "block";
        return;
    } else {
        msg.style.display = "none";
    }

    agendamentos.forEach((a, i) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${i + 1}</td>
          <td>${a.tipo}</td>
          <td>${a.nome}</td>
          <td>${a.email}</td>
          <td>${a.telefone}</td>
          <td>${a.modalidade || a.avaliador}</td>
          <td>${a.horario || "-"}</td>
          <td>${a.data}</td>
          <td><button class="btn btn-danger btn-sm" onclick="removerAgendamento(${i})">Excluir</button></td>
        `;
        tbody.appendChild(tr);
    });
}

function removerAgendamento(index) {
    const agendamentos = JSON.parse(localStorage.getItem("agendamentos")) || [];
    agendamentos.splice(index, 1);
    localStorage.setItem("agendamentos", JSON.stringify(agendamentos));
    carregarAgendamentos();
}

// Função para cadastrar cliente pelo painel administrativo
function cadastrarClienteAdmin() {
    const nome = document.getElementById("nome-cliente-admin");
    const cpf = document.getElementById("cpf-cliente-admin");
    const dataNasc = document.getElementById("data-nasc-cliente-admin");
    const email = document.getElementById("email-cliente-admin");
    const telefone = document.getElementById("telefone-cliente-admin");
    const senha = document.getElementById("senha-cliente-admin");
    
    if (!nome || !cpf || !dataNasc || !email || !telefone || !senha) {
        Notification.error("Erro ao acessar os campos do formulário!");
        return;
    }
    
    if (nome.value.trim() === "" || cpf.value.trim() === "" || dataNasc.value === "" || 
        email.value.trim() === "" || telefone.value.trim() === "" || senha.value.trim() === "") {
        Notification.error("Por favor, preencha todos os campos!");
        return;
    }
    
    // Validação básica de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
        Notification.error("Por favor, insira um e-mail válido!");
        return;
    }
    
    const novoCliente = {
        id: Date.now(),
        nome: nome.value.trim(),
        cpf: cpf.value.trim(),
        dataNascimento: dataNasc.value,
        email: email.value.trim(),
        telefone: telefone.value.trim(),
        senha: senha.value
    };
    
    const clientes = JSON.parse(localStorage.getItem("clientes")) || [];
    clientes.push(novoCliente);
    localStorage.setItem("clientes", JSON.stringify(clientes));
    
    Notification.success("Cliente cadastrado com sucesso!");
    
    // Limpar formulário
    nome.value = "";
    cpf.value = "";
    dataNasc.value = "";
    email.value = "";
    telefone.value = "";
    senha.value = "";
    
    // Recarregar tabela se a função existir
    if (typeof carregarClientes === 'function') {
        carregarClientes();
    }
}

// Só executa carregarAgendamentos se o elemento existir na página
if (document.getElementById("tabela-agendamentos")) {
    carregarAgendamentos();
}

// Função para voltar ao login
function voltarLogin() {
    // Limpar dados da sessão
    sessionStorage.removeItem('usuarioLogado');
    // Redirecionar para a página de login
    window.location.href = "login.html";
}
// Controller - Lógica de Negócio
class Controller {
  static clienteEditandoId = null;

  // ========== CLIENTES ==========
  static async carregarClientes() {
    try {
      const clientes = await Model.getClientes();
      View.renderClientes(clientes);
    } catch (error) {
      Notification.error('Erro ao carregar clientes: ' + error.message);
    }
  }

  static async cadastrarCliente() {
    const nome = document.getElementById("nome-cliente-admin").value.trim();
    const cpf = document.getElementById("cpf-cliente-admin").value.trim();
    const dataNasc = document.getElementById("data-nasc-cliente-admin").value;
    const email = document.getElementById("email-cliente-admin").value.trim();
    const telefone = document.getElementById("telefone-cliente-admin").value.trim();
    const senha = document.getElementById("senha-cliente-admin").value.trim();

    // Validações
    if (!nome || !cpf || !dataNasc || !email || !telefone || !senha) {
      Notification.error("Por favor, preencha todos os campos!");
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      Notification.error("Por favor, insira um e-mail válido!");
      return;
    }

    const button = document.querySelector('#form-cadastro-cliente button[type="submit"]');
    const modo = button.dataset.modo;

    try {
      if (modo === 'editar' && this.clienteEditandoId) {
        // Atualizar cliente
        await Model.updateCliente(this.clienteEditandoId, {
          nome,
          cpf,
          dataNascimento: dataNasc,
          email,
          telefone,
          senha
        });

        Notification.success("Cliente atualizado com sucesso!");
        View.limparFormularioCliente();
        View.alterarBotaoCliente('cadastrar');
        this.clienteEditandoId = null;
        await this.carregarClientes();
      } else {
        // Cadastrar novo cliente
        await Model.addCliente({
          nome,
          cpf,
          dataNascimento: dataNasc,
          email,
          telefone,
          senha
        });

        Notification.success("Cliente cadastrado com sucesso!");
        View.limparFormularioCliente();
        await this.carregarClientes();
      }
    } catch (error) {
      Notification.error("Erro: " + error.message);
    }
  }

  static async editarCliente(id) {
    try {
      const cliente = await Model.getClienteById(id);
      if (cliente) {
        View.preencherFormularioCliente(cliente);
        View.alterarBotaoCliente('editar');
        this.clienteEditandoId = id;
        const button = document.querySelector('#form-cadastro-cliente button[type="submit"]');
        button.dataset.clienteId = id;
        
        // Scroll para o formulário
        document.getElementById("form-cadastro-cliente").scrollIntoView({ behavior: 'smooth' });
      } else {
        Notification.error("Cliente não encontrado!");
      }
    } catch (error) {
      Notification.error("Erro ao buscar cliente: " + error.message);
    }
  }

  static async excluirCliente(id) {
    if (!confirm("Tem certeza que deseja excluir este cliente?")) return;

    try {
      const sucesso = await Model.deleteCliente(id);
      if (sucesso) {
        Notification.success("Cliente excluído com sucesso!");
        await this.carregarClientes();
      } else {
        Notification.error("Erro ao excluir cliente!");
      }
    } catch (error) {
      Notification.error("Erro: " + error.message);
    }
  }

  static async buscarCliente() {
    const termo = document.getElementById("buscar-cliente-input")?.value.trim();
    if (!termo) {
      Notification.warning("Digite um nome para buscar");
      return;
    }

    try {
      const clientes = await Model.getClientes();
      const resultados = clientes.filter(cliente => 
        cliente.nome.toLowerCase().includes(termo.toLowerCase()) ||
        cliente.cpf.includes(termo) ||
        cliente.email.toLowerCase().includes(termo.toLowerCase())
      );
      
      if (resultados.length === 0) {
        Notification.info("Nenhum cliente encontrado com esse termo");
      } else {
        Notification.success(`${resultados.length} cliente(s) encontrado(s)`);
      }
      
      View.renderClientes(resultados);
    } catch (error) {
      Notification.error("Erro ao buscar cliente: " + error.message);
    }
  }

  // ========== AGENDAMENTOS DE AULAS ==========
  static async carregarAgendamentosAulas() {
    try {
      const agendamentos = await Model.getAgendamentosAulas();
      View.renderAgendamentosAulas(agendamentos);
    } catch (error) {
      Notification.error('Erro ao carregar agendamentos: ' + error.message);
    }
  }

  static async editarAgendamentoAula(index) {
    try {
      const agendamento = await Model.getAgendamentoAulaByIndex(index);
      if (agendamento) {
        // Converter formato do banco para formato da view
        const agendamentoFormatado = {
          nome: agendamento.nome_cliente || agendamento.nome,
          modalidade: agendamento.modalidade,
          horario: agendamento.horario
        };
        View.mostrarModalEdicaoAula(agendamentoFormatado, index);
      } else {
        Notification.error("Agendamento não encontrado!");
      }
    } catch (error) {
      Notification.error("Erro ao buscar agendamento: " + error.message);
    }
  }

  static async salvarEdicaoAula(index) {
    const nome = document.getElementById("edit-nome-aula").value.trim();
    const modalidade = document.getElementById("edit-modalidade-aula").value.trim();
    const horario = document.getElementById("edit-horario-aula").value.trim();

    if (!nome || !modalidade || !horario) {
      Notification.error("Por favor, preencha todos os campos!");
      return;
    }

    try {
      await Model.updateAgendamentoAula(index, {
        nome,
        modalidade,
        horario
      });

      Notification.success("Agendamento atualizado com sucesso!");
      await this.carregarAgendamentosAulas();
      const modalElement = document.getElementById('modalEditarAula');
      if (modalElement && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
      }
    } catch (error) {
      Notification.error("Erro ao atualizar agendamento: " + error.message);
    }
  }

  static async excluirAgendamentoAula(index) {
    if (!confirm("Tem certeza que deseja excluir este agendamento?")) return;

    try {
      const sucesso = await Model.deleteAgendamentoAula(index);
      if (sucesso) {
        Notification.success("Agendamento excluído com sucesso!");
        await this.carregarAgendamentosAulas();
      } else {
        Notification.error("Erro ao excluir agendamento!");
      }
    } catch (error) {
      Notification.error("Erro: " + error.message);
    }
  }

  static async buscarAgendamentoAula() {
    const termo = document.getElementById("buscar-agendamento-input")?.value.trim();
    if (!termo) {
      Notification.warning("Digite um nome para buscar");
      return;
    }

    try {
      const agendamentos = await Model.getAgendamentosAulas();
      const resultados = agendamentos.filter(agendamento => {
        const nome = (agendamento.nome_cliente || agendamento.nome || '').toLowerCase();
        const modalidade = (agendamento.modalidade || '').toLowerCase();
        const horario = (agendamento.horario || '').toLowerCase();
        const termoLower = termo.toLowerCase();
        
        return nome.includes(termoLower) || 
               modalidade.includes(termoLower) || 
               horario.includes(termoLower);
      });
      
      if (resultados.length === 0) {
        Notification.info("Nenhum agendamento encontrado com esse termo");
      } else {
        Notification.success(`${resultados.length} agendamento(s) encontrado(s)`);
      }
      
      View.renderAgendamentosAulas(resultados);
    } catch (error) {
      Notification.error("Erro ao buscar agendamento: " + error.message);
    }
  }

  // ========== AVALIAÇÕES ==========
  static async carregarAvaliacoes() {
    try {
      const avaliacoes = await Model.getAgendamentosAvaliacoes();
      View.renderAvaliacoes(avaliacoes);
    } catch (error) {
      Notification.error('Erro ao carregar avaliações: ' + error.message);
    }
  }

  static async editarAvaliacao(index) {
    try {
      const avaliacao = await Model.getAgendamentoAvaliacaoByIndex(index);
      if (avaliacao) {
        // Converter formato do banco para formato da view
        const avaliacaoFormatada = {
          nome: avaliacao.nome_cliente || avaliacao.nome,
          peso: avaliacao.peso || avaliacao.peso_cliente,
          altura: avaliacao.altura || avaliacao.altura_cliente,
          dataAvaliacao: avaliacao.data_avaliacao || avaliacao.dataAvaliacao
        };
        View.mostrarModalEdicaoAvaliacao(avaliacaoFormatada, index);
      } else {
        Notification.error("Avaliação não encontrada!");
      }
    } catch (error) {
      Notification.error("Erro ao buscar avaliação: " + error.message);
    }
  }

  static async salvarEdicaoAvaliacao(index) {
    const nome = document.getElementById("edit-nome-avaliacao").value.trim();
    const peso = document.getElementById("edit-peso-avaliacao").value.trim();
    const altura = document.getElementById("edit-altura-avaliacao").value.trim();
    const dataAvaliacao = document.getElementById("edit-data-avaliacao").value;

    if (!nome || !peso || !altura || !dataAvaliacao) {
      Notification.error("Por favor, preencha todos os campos!");
      return;
    }

    try {
      await Model.updateAgendamentoAvaliacao(index, {
        nome,
        peso,
        altura,
        dataAvaliacao
      });

      Notification.success("Avaliação atualizada com sucesso!");
      await this.carregarAvaliacoes();
      const modalElement = document.getElementById('modalEditarAvaliacao');
      if (modalElement && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
      }
    } catch (error) {
      Notification.error("Erro ao atualizar avaliação: " + error.message);
    }
  }

  static async excluirAvaliacao(index) {
    if (!confirm("Tem certeza que deseja excluir esta avaliação?")) return;

    try {
      const sucesso = await Model.deleteAgendamentoAvaliacao(index);
      if (sucesso) {
        Notification.success("Avaliação excluída com sucesso!");
        await this.carregarAvaliacoes();
      } else {
        Notification.error("Erro ao excluir avaliação!");
      }
    } catch (error) {
      Notification.error("Erro: " + error.message);
    }
  }

  static async buscarAvaliacao() {
    const termo = document.getElementById("buscar-avaliacao-input")?.value.trim();
    if (!termo) {
      Notification.warning("Digite um nome para buscar");
      return;
    }

    try {
      const avaliacoes = await Model.getAgendamentosAvaliacoes();
      const resultados = avaliacoes.filter(avaliacao => {
        const nome = (avaliacao.nome_cliente || avaliacao.nome || '').toLowerCase();
        const peso = (avaliacao.peso || avaliacao.peso_cliente || '').toString();
        const altura = (avaliacao.altura || avaliacao.altura_cliente || '').toString();
        const termoLower = termo.toLowerCase();
        
        return nome.includes(termoLower) || 
               peso.includes(termo) || 
               altura.includes(termo);
      });
      
      if (resultados.length === 0) {
        Notification.info("Nenhuma avaliação encontrada com esse termo");
      } else {
        Notification.success(`${resultados.length} avaliação(ões) encontrada(s)`);
      }
      
      View.renderAvaliacoes(resultados);
    } catch (error) {
      Notification.error("Erro ao buscar avaliação: " + error.message);
    }
  }

  // ========== FUNCIONÁRIOS ==========
  static funcionarioEditandoId = null;

  static async carregarFuncionarios() {
    try {
      const funcionarios = await Model.getFuncionarios();
      View.renderFuncionarios(funcionarios);
    } catch (error) {
      Notification.error('Erro ao carregar funcionários: ' + error.message);
    }
  }

  static async cadastrarFuncionario() {
    const nome = document.getElementById("nome-funcionario-admin").value.trim();
    const cpf = document.getElementById("cpf-funcionario-admin").value.trim();
    const email = document.getElementById("email-funcionario-admin").value.trim();
    const telefone = document.getElementById("telefone-funcionario-admin").value.trim();
    const cargo = document.getElementById("cargo-funcionario-admin").value;
    const salario = document.getElementById("salario-funcionario-admin").value.trim();
    const cargaHoraria = document.getElementById("carga-horaria-funcionario-admin").value.trim();
    const senha = document.getElementById("senha-funcionario-admin").value.trim();

    // Validações
    if (!nome || !cpf || !email || !telefone || !cargo || !salario || !cargaHoraria || !senha) {
      Notification.error("Por favor, preencha todos os campos!");
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      Notification.error("Por favor, insira um e-mail válido!");
      return;
    }

    const button = document.querySelector('#form-cadastro-funcionario button[type="submit"]');
    const modo = button.dataset.modo;

    try {
      if (modo === 'editar' && this.funcionarioEditandoId) {
        // Atualizar funcionário
        await Model.updateFuncionario(this.funcionarioEditandoId, {
          nome,
          cpf,
          email,
          telefone,
          cargo,
          salario: parseFloat(salario),
          cargaHoraria: parseInt(cargaHoraria),
          senha
        });

        Notification.success("Funcionário atualizado com sucesso!");
        View.limparFormularioFuncionario();
        View.alterarBotaoFuncionario('cadastrar');
        this.funcionarioEditandoId = null;
        await this.carregarFuncionarios();
      } else {
        // Cadastrar novo funcionário
        await Model.addFuncionario({
          nome,
          cpf,
          email,
          telefone,
          cargo,
          salario: parseFloat(salario),
          cargaHoraria: parseInt(cargaHoraria),
          senha
        });

        Notification.success("Funcionário cadastrado com sucesso!");
        View.limparFormularioFuncionario();
        await this.carregarFuncionarios();
      }
    } catch (error) {
      Notification.error("Erro: " + error.message);
    }
  }

  static async editarFuncionario(id) {
    try {
      const funcionario = await Model.getFuncionarioById(id);
      if (funcionario) {
        View.preencherFormularioFuncionario(funcionario);
        View.alterarBotaoFuncionario('editar');
        this.funcionarioEditandoId = id;
        const button = document.querySelector('#form-cadastro-funcionario button[type="submit"]');
        button.dataset.funcionarioId = id;
        
        // Scroll para o formulário
        document.getElementById("form-cadastro-funcionario").scrollIntoView({ behavior: 'smooth' });
      } else {
        Notification.error("Funcionário não encontrado!");
      }
    } catch (error) {
      Notification.error("Erro ao buscar funcionário: " + error.message);
    }
  }

  static async excluirFuncionario(id) {
    if (!confirm("Tem certeza que deseja excluir este funcionário?")) return;

    try {
      const sucesso = await Model.deleteFuncionario(id);
      if (sucesso) {
        Notification.success("Funcionário excluído com sucesso!");
        await this.carregarFuncionarios();
      } else {
        Notification.error("Erro ao excluir funcionário!");
      }
    } catch (error) {
      Notification.error("Erro: " + error.message);
    }
  }

  // ========== CADASTRAR AGENDAMENTO DE AULA (pelo admin) ==========
  static async cadastrarAgendamentoAula() {
    const nome = document.getElementById("nome-agendamento-aula").value.trim();
    const modalidade = document.getElementById("modalidade-agendamento-aula").value.trim();
    const horario = document.getElementById("horario-agendamento-aula").value.trim();

    if (!nome || !modalidade || !horario) {
      Notification.error("Por favor, preencha todos os campos!");
      return;
    }

    try {
      await Model.addAgendamentoAula({
        tipo: "Aula",
        nome,
        modalidade,
        horario,
        data: new Date().toISOString().slice(0, 19).replace('T', ' ')
      });

      Notification.success("Agendamento de aula cadastrado com sucesso!");
      
      // Limpar formulário
      document.getElementById("nome-agendamento-aula").value = '';
      document.getElementById("modalidade-agendamento-aula").value = '';
      document.getElementById("horario-agendamento-aula").value = '';
      
      await this.carregarAgendamentosAulas();
    } catch (error) {
      Notification.error("Erro ao cadastrar agendamento: " + error.message);
    }
  }

  // ========== CADASTRAR AVALIAÇÃO (pelo admin) ==========
  static async cadastrarAvaliacao() {
    const nome = document.getElementById("nome-avaliacao-admin").value.trim();
    const peso = document.getElementById("peso-avaliacao-admin").value.trim();
    const altura = document.getElementById("altura-avaliacao-admin").value.trim();
    const dataAvaliacao = document.getElementById("data-avaliacao-admin").value;

    if (!nome || !peso || !altura || !dataAvaliacao) {
      Notification.error("Por favor, preencha todos os campos!");
      return;
    }

    try {
      await Model.addAvaliacao({
        tipo: "Avaliação",
        nome,
        peso,
        altura,
        dataAvaliacao,
        data: new Date().toISOString().slice(0, 19).replace('T', ' ')
      });

      Notification.success("Avaliação cadastrada com sucesso!");
      
      // Limpar formulário
      document.getElementById("nome-avaliacao-admin").value = '';
      document.getElementById("peso-avaliacao-admin").value = '';
      document.getElementById("altura-avaliacao-admin").value = '';
      document.getElementById("data-avaliacao-admin").value = '';
      
      await this.carregarAvaliacoes();
    } catch (error) {
      Notification.error("Erro ao cadastrar avaliação: " + error.message);
    }
  }
}


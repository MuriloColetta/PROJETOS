// View - Atualização da Interface
class View {
  // ========== CLIENTES ==========
  static renderClientes(clientes) {
    const tbody = document.getElementById("tbody-clientes");
    if (!tbody) return;
    
    tbody.innerHTML = "";
    
    if (clientes.length === 0) {
      tbody.innerHTML = '<tr><td colspan="8" class="text-center">Nenhum cliente cadastrado</td></tr>';
      return;
    }
    
    clientes.forEach((cliente, index) => {
      const tr = document.createElement("tr");
      const dataNasc = cliente.dataNascimento ? new Date(cliente.dataNascimento).toLocaleDateString('pt-BR') : '-';
      tr.innerHTML = `
        <td>${index + 1}</td>
        <td>${cliente.nome || '-'}</td>
        <td>${cliente.cpf || '-'}</td>
        <td>${dataNasc}</td>
        <td>${cliente.email || '-'}</td>
        <td>${cliente.telefone || '-'}</td>
        <td>******</td>
        <td>
          <button class="btn btn-sm btn-warning" onclick="Controller.editarCliente(${cliente.id || cliente.id_cliente})">Editar</button>
          <button class="btn btn-sm btn-danger" onclick="Controller.excluirCliente(${cliente.id || cliente.id_cliente})">Excluir</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  static preencherFormularioCliente(cliente) {
    document.getElementById("nome-cliente-admin").value = cliente.nome || '';
    document.getElementById("cpf-cliente-admin").value = cliente.cpf || '';
    document.getElementById("data-nasc-cliente-admin").value = cliente.dataNascimento || '';
    document.getElementById("email-cliente-admin").value = cliente.email || '';
    document.getElementById("telefone-cliente-admin").value = cliente.telefone || '';
    document.getElementById("senha-cliente-admin").value = cliente.senha || '';
  }

  static limparFormularioCliente() {
    document.getElementById("nome-cliente-admin").value = '';
    document.getElementById("cpf-cliente-admin").value = '';
    document.getElementById("data-nasc-cliente-admin").value = '';
    document.getElementById("email-cliente-admin").value = '';
    document.getElementById("telefone-cliente-admin").value = '';
    document.getElementById("senha-cliente-admin").value = '';
  }

  static alterarBotaoCliente(modo) {
    const form = document.getElementById("form-cadastro-cliente");
    const button = form.querySelector('button[type="submit"]');
    if (modo === 'editar') {
      button.textContent = 'Atualizar';
      button.dataset.modo = 'editar';
    } else {
      button.textContent = 'Cadastrar';
      button.dataset.modo = 'cadastrar';
      button.removeAttribute('data-cliente-id');
    }
  }

  // ========== AGENDAMENTOS DE AULAS ==========
  static renderAgendamentosAulas(agendamentos) {
    const tbody = document.getElementById("tbody-agendamentos-aulas");
    if (!tbody) return;
    
    tbody.innerHTML = "";
    
    if (agendamentos.length === 0) {
      tbody.innerHTML = '<tr><td colspan="7" class="text-center">Nenhum agendamento de aula encontrado</td></tr>';
      return;
    }
    
      agendamentos.forEach((agendamento, index) => {
        const tr = document.createElement("tr");
        const nome = agendamento.nome_cliente || agendamento.nome || '-';
        const data = agendamento.data_agendamento || agendamento.data || '-';
        tr.innerHTML = `
          <td>${index + 1}</td>
          <td>${nome}</td>
          <td>${agendamento.modalidade || '-'}</td>
          <td>${agendamento.horario || '-'}</td>
          <td>${data}</td>
          <td>Agendado</td>
          <td>
            <button class="btn btn-sm btn-warning" onclick="Controller.editarAgendamentoAula(${index})">Editar</button>
            <button class="btn btn-sm btn-danger" onclick="Controller.excluirAgendamentoAula(${index})">Excluir</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
  }

  static mostrarModalEdicaoAula(agendamento, index) {
    // Remove modal existente se houver
    const existing = document.getElementById('modalEditarAula');
    if (existing) existing.remove();

    // Criar modal dinamicamente
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'modalEditarAula';
    modal.setAttribute('tabindex', '-1');
    modal.innerHTML = `
      <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title">Editar Agendamento de Aula</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="form-editar-aula">
              <div class="mb-3">
                <label class="form-label">Nome do Cliente</label>
                <input type="text" class="form-control bg-dark text-white" id="edit-nome-aula" value="${(agendamento.nome || '').replace(/"/g, '&quot;')}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Modalidade</label>
                <input type="text" class="form-control bg-dark text-white" id="edit-modalidade-aula" value="${(agendamento.modalidade || '').replace(/"/g, '&quot;')}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Horário</label>
                <input type="text" class="form-control bg-dark text-white" id="edit-horario-aula" value="${(agendamento.horario || '').replace(/"/g, '&quot;')}" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="Controller.salvarEdicaoAula(${index})">Salvar</button>
          </div>
        </div>
      </div>
    `;
    
    document.body.appendChild(modal);
    
    // Aguarda um pouco para garantir que o DOM foi atualizado
    setTimeout(() => {
      if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        modal.addEventListener('hidden.bs.modal', () => {
          modal.remove();
        });
      }
    }, 10);
  }

  // ========== AVALIAÇÕES ==========
  static renderAvaliacoes(avaliacoes) {
    const tbody = document.getElementById("tbody-avaliacoes");
    if (!tbody) return;
    
    tbody.innerHTML = "";
    
    if (avaliacoes.length === 0) {
      tbody.innerHTML = '<tr><td colspan="7" class="text-center">Nenhuma avaliação agendada</td></tr>';
      return;
    }
    
      avaliacoes.forEach((avaliacao, index) => {
        const tr = document.createElement("tr");
        const nome = avaliacao.nome_cliente || avaliacao.nome || '-';
        const peso = avaliacao.peso || avaliacao.peso_cliente || '-';
        const altura = avaliacao.altura || avaliacao.altura_cliente || '-';
        const dataAval = avaliacao.data_avaliacao || avaliacao.dataAvaliacao;
        const dataAvalFormatada = dataAval ? new Date(dataAval).toLocaleDateString('pt-BR') : '-';
        const dataAgendamento = avaliacao.data_agendamento || avaliacao.data || '-';
        tr.innerHTML = `
          <td>${index + 1}</td>
          <td>${nome}</td>
          <td>${peso}</td>
          <td>${altura}</td>
          <td>${dataAgendamento}</td>
          <td>${dataAvalFormatada}</td>
          <td>
            <button class="btn btn-sm btn-warning" onclick="Controller.editarAvaliacao(${index})">Editar</button>
            <button class="btn btn-sm btn-danger" onclick="Controller.excluirAvaliacao(${index})">Excluir</button>
          </td>
        `;
        tbody.appendChild(tr);
      });
  }

  static mostrarModalEdicaoAvaliacao(avaliacao, index) {
    // Remove modal existente se houver
    const existing = document.getElementById('modalEditarAvaliacao');
    if (existing) existing.remove();

    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'modalEditarAvaliacao';
    modal.setAttribute('tabindex', '-1');
    modal.innerHTML = `
      <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
          <div class="modal-header">
            <h5 class="modal-title">Editar Avaliação</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="form-editar-avaliacao">
              <div class="mb-3">
                <label class="form-label">Nome do Cliente</label>
                <input type="text" class="form-control bg-dark text-white" id="edit-nome-avaliacao" value="${(avaliacao.nome || '').replace(/"/g, '&quot;')}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Peso (kg)</label>
                <input type="text" class="form-control bg-dark text-white" id="edit-peso-avaliacao" value="${(avaliacao.peso || '').replace(/"/g, '&quot;')}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Altura (m)</label>
                <input type="text" class="form-control bg-dark text-white" id="edit-altura-avaliacao" value="${(avaliacao.altura || '').replace(/"/g, '&quot;')}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Data da Avaliação</label>
                <input type="date" class="form-control bg-dark text-white" id="edit-data-avaliacao" value="${avaliacao.dataAvaliacao || ''}" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="Controller.salvarEdicaoAvaliacao(${index})">Salvar</button>
          </div>
        </div>
      </div>
    `;
    
    document.body.appendChild(modal);
    
    // Aguarda um pouco para garantir que o DOM foi atualizado
    setTimeout(() => {
      if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        modal.addEventListener('hidden.bs.modal', () => {
          modal.remove();
        });
      }
    }, 10);
  }

  // ========== FUNCIONÁRIOS ==========
  static renderFuncionarios(funcionarios) {
    const tbody = document.getElementById("tbody-funcionarios");
    if (!tbody) return;
    
    tbody.innerHTML = "";
    
    if (funcionarios.length === 0) {
      tbody.innerHTML = '<tr><td colspan="10" class="text-center">Nenhum funcionário cadastrado</td></tr>';
      return;
    }
    
    funcionarios.forEach((funcionario, index) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${index + 1}</td>
        <td>${funcionario.nome || '-'}</td>
        <td>${funcionario.cpf || '-'}</td>
        <td>${funcionario.email || '-'}</td>
        <td>${funcionario.telefone || '-'}</td>
        <td>${funcionario.cargo || '-'}</td>
        <td>R$ ${funcionario.salario ? parseFloat(funcionario.salario).toFixed(2).replace('.', ',') : '-'}</td>
        <td>${funcionario.cargaHoraria || funcionario.carga_horaria || '-'} horas</td>
        <td>******</td>
        <td>
          <button class="btn btn-sm btn-warning" onclick="Controller.editarFuncionario(${funcionario.id || funcionario.id_funcionario})">Editar</button>
          <button class="btn btn-sm btn-danger" onclick="Controller.excluirFuncionario(${funcionario.id || funcionario.id_funcionario})">Excluir</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  static preencherFormularioFuncionario(funcionario) {
    document.getElementById("nome-funcionario-admin").value = funcionario.nome || '';
    document.getElementById("cpf-funcionario-admin").value = funcionario.cpf || '';
    document.getElementById("email-funcionario-admin").value = funcionario.email || '';
    document.getElementById("telefone-funcionario-admin").value = funcionario.telefone || '';
    document.getElementById("cargo-funcionario-admin").value = funcionario.cargo || '';
    document.getElementById("salario-funcionario-admin").value = funcionario.salario || '';
    document.getElementById("carga-horaria-funcionario-admin").value = funcionario.cargaHoraria || funcionario.carga_horaria || '';
    document.getElementById("senha-funcionario-admin").value = funcionario.senha || '';
  }

  static limparFormularioFuncionario() {
    document.getElementById("nome-funcionario-admin").value = '';
    document.getElementById("cpf-funcionario-admin").value = '';
    document.getElementById("email-funcionario-admin").value = '';
    document.getElementById("telefone-funcionario-admin").value = '';
    document.getElementById("cargo-funcionario-admin").value = '';
    document.getElementById("salario-funcionario-admin").value = '';
    document.getElementById("carga-horaria-funcionario-admin").value = '';
    document.getElementById("senha-funcionario-admin").value = '';
  }

  static alterarBotaoFuncionario(modo) {
    const form = document.getElementById("form-cadastro-funcionario");
    const button = form.querySelector('button[type="submit"]');
    if (modo === 'editar') {
      button.textContent = 'Atualizar';
      button.dataset.modo = 'editar';
    } else {
      button.textContent = 'Cadastrar';
      button.dataset.modo = 'cadastrar';
      button.removeAttribute('data-funcionario-id');
    }
  }
}


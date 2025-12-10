// Model - Gerenciamento de Dados (conectado ao banco de dados)
class Model {
  static API_BASE = 'api';

  // Função auxiliar para fazer requisições
  static async request(url, method = 'GET', data = null) {
    const options = {
      method: method,
      headers: {
        'Content-Type': 'application/json'
      }
    };

    if (data && (method === 'POST' || method === 'PUT' || method === 'DELETE')) {
      options.body = JSON.stringify(data);
    }

    try {
      const response = await fetch(url, options);
      const result = await response.json();
      
      if (!response.ok) {
        throw new Error(result.message || 'Erro na requisição');
      }
      
      return result;
    } catch (error) {
      console.error('Erro na requisição:', error);
      throw error;
    }
  }

  // ========== CLIENTES ==========
  static async getClientes() {
    try {
      const result = await this.request(`${this.API_BASE}/clientes.php`);
      return result.data || [];
    } catch (error) {
      console.error('Erro ao buscar clientes:', error);
      return [];
    }
  }

  static async getClienteById(id) {
    try {
      const clientes = await this.getClientes();
      return clientes.find(c => c.id == id);
    } catch (error) {
      console.error('Erro ao buscar cliente:', error);
      return null;
    }
  }

  static async addCliente(cliente) {
    try {
      const result = await this.request(`${this.API_BASE}/clientes.php`, 'POST', cliente);
      return result;
    } catch (error) {
      console.error('Erro ao adicionar cliente:', error);
      throw error;
    }
  }

  static async updateCliente(id, dadosAtualizados) {
    try {
      const dados = { id, ...dadosAtualizados };
      const result = await this.request(`${this.API_BASE}/clientes.php`, 'PUT', dados);
      return result;
    } catch (error) {
      console.error('Erro ao atualizar cliente:', error);
      throw error;
    }
  }

  static async deleteCliente(id) {
    try {
      const result = await this.request(`${this.API_BASE}/clientes.php`, 'DELETE', { id });
      return result.success;
    } catch (error) {
      console.error('Erro ao deletar cliente:', error);
      throw error;
    }
  }

  // ========== AGENDAMENTOS DE AULAS ==========
  static async getAgendamentosAulas() {
    try {
      const result = await this.request(`${this.API_BASE}/agendamentos.php`);
      return result.data || [];
    } catch (error) {
      console.error('Erro ao buscar agendamentos:', error);
      return [];
    }
  }

  static async getAgendamentoAulaByIndex(index) {
    try {
      const aulas = await this.getAgendamentosAulas();
      return aulas[index] || null;
    } catch (error) {
      console.error('Erro ao buscar agendamento:', error);
      return null;
    }
  }

  static async updateAgendamentoAula(idOrIndex, dadosAtualizados) {
    try {
      const aulas = await this.getAgendamentosAulas();
      
      // Primeiro tente localizar por id (mais robusto)
      const idStr = String(idOrIndex);
      let index = aulas.findIndex(a => String(a.id_agendamento) === idStr);

      // Se não encontrar por id, e for um número válido, trate como index
      if (index === -1) {
        const maybeIndex = Number(idOrIndex);
        if (!Number.isNaN(maybeIndex) && maybeIndex >= 0 && maybeIndex < aulas.length) {
          index = maybeIndex;
        }
      }

      const aula = aulas[index];
      if (!aula || !aula.id_agendamento) {
        throw new Error('Agendamento não encontrado');
      }

      const dados = { id: aula.id_agendamento, ...dadosAtualizados };
      const result = await this.request(`${this.API_BASE}/agendamentos.php`, 'PUT', dados);
      return result;
    } catch (error) {
      console.error('Erro ao atualizar agendamento:', error);
      throw error;
    }
  }

  static async deleteAgendamentoAula(idOrIndex) {
    try {
      const aulas = await this.getAgendamentosAulas();
      
      const idStr = String(idOrIndex);
      let index = aulas.findIndex(a => String(a.id_agendamento) === idStr);

      if (index === -1) {
        const maybeIndex = Number(idOrIndex);
        if (!Number.isNaN(maybeIndex) && maybeIndex >= 0 && maybeIndex < aulas.length) {
          index = maybeIndex;
        }
      }

      const aula = aulas[index];
      if (!aula || !aula.id_agendamento) {
        throw new Error('Agendamento não encontrado');
      }

      const result = await this.request(`${this.API_BASE}/agendamentos.php`, 'DELETE', { id: aula.id_agendamento });
      return result.success;
    } catch (error) {
      console.error('Erro ao deletar agendamento:', error);
      throw error;
    }
  }

  // ========== AVALIAÇÕES ==========
  static async getAgendamentosAvaliacoes() {
    try {
      const result = await this.request(`${this.API_BASE}/avaliacoes.php`);
      return result.data || [];
    } catch (error) {
      console.error('Erro ao buscar avaliações:', error);
      return [];
    }
  }

  static async getAgendamentoAvaliacaoByIndex(index) {
    try {
      const avaliacoes = await this.getAgendamentosAvaliacoes();
      return avaliacoes[index] || null;
    } catch (error) {
      console.error('Erro ao buscar avaliação:', error);
      return null;
    }
  }

  static async updateAgendamentoAvaliacao(idOrIndex, dadosAtualizados) {
    try {
      const avaliacoes = await this.getAgendamentosAvaliacoes();
      
      const idStr = String(idOrIndex);
      let index = avaliacoes.findIndex(a => String(a.id_avaliacao) === idStr);

      if (index === -1) {
        const maybeIndex = Number(idOrIndex);
        if (!Number.isNaN(maybeIndex) && maybeIndex >= 0 && maybeIndex < avaliacoes.length) {
          index = maybeIndex;
        }
      }

      const avaliacao = avaliacoes[index];
      if (!avaliacao || !avaliacao.id_avaliacao) {
        throw new Error('Avaliação não encontrada');
      }

      const dados = { id: avaliacao.id_avaliacao, ...dadosAtualizados };
      const result = await this.request(`${this.API_BASE}/avaliacoes.php`, 'PUT', dados);
      return result;
    } catch (error) {
      console.error('Erro ao atualizar avaliação:', error);
      throw error;
    }
  }

  static async deleteAgendamentoAvaliacao(idOrIndex) {
    try {
      const avaliacoes = await this.getAgendamentosAvaliacoes();
      
      const idStr = String(idOrIndex);
      let index = avaliacoes.findIndex(a => String(a.id_avaliacao) === idStr);

      if (index === -1) {
        const maybeIndex = Number(idOrIndex);
        if (!Number.isNaN(maybeIndex) && maybeIndex >= 0 && maybeIndex < avaliacoes.length) {
          index = maybeIndex;
        }
      }

      const avaliacao = avaliacoes[index];
      if (!avaliacao || !avaliacao.id_avaliacao) {
        throw new Error('Avaliação não encontrada');
      }

      const result = await this.request(`${this.API_BASE}/avaliacoes.php`, 'DELETE', { id: avaliacao.id_avaliacao });
      return result.success;
    } catch (error) {
      console.error('Erro ao deletar avaliação:', error);
      throw error;
    }
  }

  // ========== FUNCIONÁRIOS ==========
  static async getFuncionarios() {
    try {
      const result = await this.request(`${this.API_BASE}/funcionarios.php`);
      return result.data || [];
    } catch (error) {
      console.error('Erro ao buscar funcionários:', error);
      return [];
    }
  }

  static async getFuncionarioById(id) {
    try {
      const funcionarios = await this.getFuncionarios();
      return funcionarios.find(f => f.id == id);
    } catch (error) {
      console.error('Erro ao buscar funcionário:', error);
      return null;
    }
  }

  static async addFuncionario(funcionario) {
    try {
      const result = await this.request(`${this.API_BASE}/funcionarios.php`, 'POST', funcionario);
      return result;
    } catch (error) {
      console.error('Erro ao adicionar funcionário:', error);
      throw error;
    }
  }

  static async updateFuncionario(id, dadosAtualizados) {
    try {
      const dados = { id, ...dadosAtualizados };
      const result = await this.request(`${this.API_BASE}/funcionarios.php`, 'PUT', dados);
      return result;
    } catch (error) {
      console.error('Erro ao atualizar funcionário:', error);
      throw error;
    }
  }

  static async deleteFuncionario(id) {
    try {
      const result = await this.request(`${this.API_BASE}/funcionarios.php`, 'DELETE', { id });
      return result.success;
    } catch (error) {
      console.error('Erro ao deletar funcionário:', error);
      throw error;
    }
  }

  // ========== MÉTODOS COMPATIBILIDADE (para index.html) ==========
  static async addAgendamentoAula(dados) {
    try {
      const result = await this.request(`${this.API_BASE}/agendamentos.php`, 'POST', dados);
      return result;
    } catch (error) {
      console.error('Erro ao adicionar agendamento:', error);
      throw error;
    }
  }

  static async addAvaliacao(dados) {
    try {
      const result = await this.request(`${this.API_BASE}/avaliacoes.php`, 'POST', dados);
      return result;
    } catch (error) {
      console.error('Erro ao adicionar avaliação:', error);
      throw error;
    }
  }
}

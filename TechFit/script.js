function entrar() {
    window.location.href = "index.html";
}

function cadastroUsuario() {
    window.location.href = "cadastro.html";
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

// === Agendar Aula ===
function agendarAula() {
    const nome = document.querySelector('.agendar-aula input[placeholder="Nome:"]').value.trim();
    const email = document.querySelector('.agendar-aula input[placeholder="E-mail:"]').value.trim();
    const telefone = document.querySelector('.agendar-aula input[placeholder="Telefone:"]').value.trim();
    const modalidade = document.getElementById("modalidade").value;
    const horario = document.getElementById("horario").value;

    if (!nome || !email || !telefone || !modalidade || !horario) return;

    const novoAgendamento = {
        tipo: "Aula",
        nome,
        email,
        telefone,
        modalidade,
        horario,
        data: new Date().toLocaleString()
    };

    const agendamentos = JSON.parse(localStorage.getItem("agendamentos")) || [];
    agendamentos.push(novoAgendamento);
    localStorage.setItem("agendamentos", JSON.stringify(agendamentos));

    document.querySelectorAll('.agendar-aula input, .agendar-aula select').forEach(el => el.value = "");
    horarioSelect.innerHTML = "<option value='' disabled selected>Horário</option>";
}

function agendarAvaliacao() {
    const nome = document.querySelector('.agendar-avaliacao input[placeholder="Nome:"]').value.trim();
    const email = document.querySelector('.agendar-avaliacao input[placeholder="E-mail:"]').value.trim();
    const telefone = document.querySelector('.agendar-avaliacao input[placeholder="Telefone:"]').value.trim();
    const avaliador = document.querySelector('.agendar-avaliacao input[name="avaliador"]:checked');

    if (!nome || !email || !telefone || !avaliador) return;

    const novoAgendamento = {
        tipo: "Avaliação",
        nome,
        email,
        telefone,
        avaliador: avaliador.value,
        data: new Date().toLocaleString()
    };

    const agendamentos = JSON.parse(localStorage.getItem("agendamentos")) || [];
    agendamentos.push(novoAgendamento);
    localStorage.setItem("agendamentos", JSON.stringify(agendamentos));

    document.querySelectorAll('.agendar-avaliacao input').forEach(el => {
        if (el.type === "radio") el.checked = false;
        else el.value = "";
    });
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

carregarAgendamentos();
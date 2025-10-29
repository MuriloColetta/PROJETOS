const horarios = {
    capoeira: ["Segunda - 16:30", "Sexta - 16:00"],
    zumba: ["Terça - 13:40", "Quinta - 14:00"],
    sanda: ["Terça - 17:00", "Quinta - 18:00"],
    yoga: ["Segunda - 14:00", "Quinta - 15:00"],
    muaythai: ["Quarta - 19:00", "Sexta - 19:00"]
}

const modalidadeSelect = document.getElementById("modalidade");
const horarioSelect = document.getElementById("horario");

modalidadeSelect.addEventListener("change", function() {
const modalidadeEscolhida = this.value;

// limpar opções anteriores
horarioSelect.innerHTML = "<option value=''>Horários</option>";

// adicionar novas opções de acordo com a modalidade
if (modalidadeEscolhida && horarios [modalidadeEscolhida]) {
    horarios[modalidadeEscolhida].forEach(function(h) {
    const option = document.createElement("option");
    option.value = h;
    option.textContent = h;
    horarioSelect.appendChild(option);
        });
    }
});
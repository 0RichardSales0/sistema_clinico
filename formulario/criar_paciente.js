const abrirModalBtn = document.getElementById('abrirModal');
const modal = document.getElementById('modalPaciente');
const fecharModalBtn = document.getElementById('fecharModal');
const formPaciente = document.getElementById('formPaciente');
const msgPopup = document.getElementById('msgPopup');

abrirModalBtn.onclick = () => {
  modal.style.display = 'flex';
  msgPopup.style.display = 'none';
  formPaciente.reset();
};

fecharModalBtn.onclick = () => {
  modal.style.display = 'none';
};

formPaciente.onsubmit = async (e) => {
  e.preventDefault();

  const formData = new FormData(formPaciente);

  try {
    const response = await fetch('criar_paciente.php', {
      method: 'POST',
      body: formData
    });

    const text = await response.text();

    if (response.ok) {
      msgPopup.style.display = 'block';
      msgPopup.style.backgroundColor = '#d4edda';
      msgPopup.style.color = '#155724';
      msgPopup.style.border = '1px solid #c3e6cb';
      msgPopup.textContent = 'Paciente cadastrado com sucesso!';
      formPaciente.reset();
    } else {
      msgPopup.style.display = 'block';
      msgPopup.style.backgroundColor = '#f8d7da';
      msgPopup.style.color = '#721c24';
      msgPopup.style.border = '1px solid #f5c6cb';
      msgPopup.textContent = 'Erro ao cadastrar paciente: ' + text;
    }
  } catch (error) {
    msgPopup.style.display = 'block';
    msgPopup.style.backgroundColor = '#f8d7da';
    msgPopup.style.color = '#721c24';
    msgPopup.style.border = '1px solid #f5c6cb';
    msgPopup.textContent = 'Erro na requisição: ' + error.message;
  }
};

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-cadastro');
  const popup = document.getElementById('popupSucesso');
  const fecharPopup = document.getElementById('fecharPopup');

  fecharPopup.addEventListener('click', () => {
    popup.classList.add('hidden');
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch('cadastrar.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.text();

      if (result.trim().toLowerCase() === 'sucesso') {
        popup.classList.remove('hidden');
      } else {
        alert('Erro: ' + result);
      }
    } catch (error) {
      alert('Erro na requisição: ' + error.message);
    }
  });
});

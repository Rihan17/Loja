document.getElementById('entrar').addEventListener('click', function() {
    var login = document.getElementById('login').value;
    var senha = document.getElementById('senha').value;

    if (!login || !senha) {
        alert('Por favor, preencha todos os campos');
        return;
    }

    fetch('../php/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify([{
            login: login,
            senha: senha
        }])
    })
    .then(response => response.json())
    .then(data => {
        if (data.sucesso) {
            window.location.href = 'perfil.html';
        } else {
            alert(data.erro || 'Erro ao fazer login');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao fazer login');
    });
}); 
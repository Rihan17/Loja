var login = document.getElementById('login');
var senha = document.getElementById('senha');
var formLogin = document.getElementById('form-login');

formLogin.addEventListener('click', function (e) {

    e.preventDefault();

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
            nm_login: login.value,
            ds_senha: senha.value
        }])
    })
        .then(response => response.json())
        .then(function(dados){
                dados = dados.dados;
                console.log(dados);
                localStorage.setItem('nome', dados.nm_usuario);
                localStorage.setItem('login', dados.nm_login);
                localStorage.setItem('senha', dados.ds_senha);
                window.location.href = 'perfil.html';

        })
}); 
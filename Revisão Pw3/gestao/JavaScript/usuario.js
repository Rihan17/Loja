var url = '../php/login.php';
var btnEntrar = document.getElementById('entrar');
var login = document.getElementById('id_usuario');
var senha = document.getElementById('ds_senha');

btnEntrar.addEventListener('submit', function(e){
    e.preventDefault();

    if(login.value.length < 45){
        login.focus();
        alert("login inválido");
    }

    else if(senha.value.length < 8){
        senha.focus();
        alert("login inválido");
    }else {
        var dados = JSON.stringify([{usuario: login.value, senha: senha.value}]);

        fetch("usuario.php",{
            method: 'POST',
            headers: { 'Content-Type' : 'application/json'},
            body: dados
        })

        .then( resposta => resposta.json())
        .then(function(dados){
            localStorage.setItem('id')
            console.log(dados);
        })
    }
})
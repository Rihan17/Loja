Tabela();

var form = document.getElementById('FormCategoria');

form.addEventListener('submit', function (e) {
    e.preventDefault(); //Interrompe o carregamento da página

    var metodo = 'POST';
    var url = 'categoria.php';
    var dados = JSON.stringify([{ nome: document.getElementById('nm_categoria').value, id: document.getElementById('id_categoria').value }]);
    var btn = document.getElementById('btn'); //Botão de envio do formulário

    if (btn.innerHTML == 'Atualizar') {
        url += '?id='+document.getElementById('id_categoria').value;
        metodo = 'PUT';
        dados = JSON.stringify([{ nome: document.getElementById('nm_categoria').value }]);
    }

    fetch(url, {
        method: metodo,
        headers: { 'Content-Type': 'application/json' },
        body: dados
    })
        .then(resposta => resposta.json())
        .then(dados => console.log(dados))
        Tabela();
        alert('Categoria cadastrada com sucesso!');
});



function Tabela() {
    fetch('../PHP/categoria.php')
        .then(resposta => resposta.json())
        .then(function (dados) {
            var registros = '';
            for (var i = 0; i < dados.length; i++) {
                registros += `
            <tr>
                <th scope="row">`+ dados[i].id_produto`</th>
                <td>`+ dados[i].nm_produto`</td>
                <td>0</td>
                <td><button class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger excluir" onClick="Excluir(`+ dados[i].id_categoria`"><i class="bi bi-trash-fill"></i></button></td>
            </tr>`;
            }
            document.getElementById('tabela').innerHTML = registros;
        });

    //Ação do botão excluir

    function Excluir(id) {
        fetch('categoria.php', {
            method: 'DELETE'
        })
            .then(resposta => resposta.json())
            .then(dados => console.log(dados));
    }

    function Atualizar(id) {
        fetch('categoria.php?id=' + id, {
            method: 'GET'
        })
            .then(resposta => resposta.json())
            .then(function (dados) {
                var id = document.getElementById('id_categoria');  
                var nome = document.getElementById('nm_categoria');
                var btn = document.getElementById('btn');

                

            });
    }

}
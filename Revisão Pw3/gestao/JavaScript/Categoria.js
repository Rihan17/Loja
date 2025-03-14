Tabela();

var form = document.getElementById('FormCategoria');

form.addEventListener('submit', function (e) {
    e.preventDefault(); //Interrompe o carregamento da página

    var metodo = 'POST';
    var url = '../php/categoria.php';
    var dados = JSON.stringify([{ nm_categoria: document.getElementById('nm_categoria').value, id_categoria: document.getElementById('id_categoria').value }]);
    var btn = document.getElementById('btn'); //Botão de envio do formulário

    if (btn.innerHTML == 'Atualizar') {
        url += '?id_categoria='+document.getElementById('id_categoria').value;
        metodo = 'PUT';
        dados = JSON.stringify([{ nm_categoria: document.getElementById('nm_categoria').value, id_categoria: document.getElementById('id_categoria').value}]);
    }

    fetch(url, {
        method: metodo,
        headers: { 'Content-Type': 'application/json' },
        body: dados
    })
        .then(resposta => resposta.json())
        .then(function(dados){
        Tabela();
        alert('Categoria cadastrada com sucesso!');
})

//Ações após envio
btn.innerHTML = "Adicionar";
btn.classList.remove('btn-primary');
btn.classList.add('btn-danger');
document.getElementById('nm_categoria').value = "";
document.getElementById('id_categoria').value = "";

});





function Tabela(){

    fetch('../php/categoria.php')
    .then(resposta => resposta.json())
    .then(function(dados){
        var registros = "";
        console.table(dados);
        for(var i=0; i<dados.length; i++){
            registros += `
                <tr>
                <th scope="row">`+dados[i].id_categoria+`</th>
                <td>`+dados[i].nm_categoria+`</td>
                <td>0</td>
                <td>
                    <button class="btn btn-warning" onclick="Atualizar(`+dados[i].id_categoria+`)"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger excluir" onclick="Excluir(`+dados[i].id_categoria+`)"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>`;
        }
        document.getElementById('tabela').innerHTML = registros;
    });    

    
}

    //Ação do botão excluir

    function Atualizar(id_categoria){
        fetch('../php/categoria.php?id_categoria='+id_categoria,{
            method: 'GET'
        })
        .then(resposta => resposta.json())
        .then(function(dados){
            var id = document.getElementById('id_categoria');
            var nome = document.getElementById('nm_categoria');
            var btn = document.getElementById('btn');
    
            btn.innerHTML = "Atualizar";
            btn.classList.remove('btn-danger');
            btn.classList.add('btn-primary');
    
            id.value = dados[0].id_categoria;
            nome.value = dados[0].nm_categoria;
            nome.focus();
        });
    }
    
    function Excluir(id_categoria){
        fetch('../php/categoria.php?id_categoria='+id_categoria,{
            method: 'DELETE'
        })
        .then(resposta => resposta.json())
        .then(dados => Tabela());
    }
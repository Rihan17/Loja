document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM carregado');
    Tabela();
});

var form = document.getElementById('FormProduto');

form.addEventListener('submit', function (e) {
    e.preventDefault(); //Interrompe o carregamento da página

    var metodo = 'POST';
    var url = '../php/produto.php';
    var dados = JSON.stringify([{ 
        nm_produto: document.getElementById('nm_produto').value, 
        id_produto: document.getElementById('id_produto').value,
        id_categoria: document.getElementById('id_categoria').value,
        vl_produto: document.getElementById('vl_produto').value,
        qt_estoque: document.getElementById('qt_estoque').value,
        ds_produto: document.getElementById('ds_produto').value
    }]);
    var btn = document.getElementById('btn');

    if (btn.innerHTML == 'Atualizar') {
        url += '?id_produto='+document.getElementById('id_produto').value;
        metodo = 'PUT';
        dados = JSON.stringify([{ 
            nm_produto: document.getElementById('nm_produto').value, 
            id_produto: document.getElementById('id_produto').value,
            id_categoria: document.getElementById('id_categoria').value,
            vl_produto: document.getElementById('vl_produto').value,
            qt_estoque: document.getElementById('qt_estoque').value,
            ds_produto: document.getElementById('ds_produto').value
        }]);
    }

    fetch(url, {
        method: metodo,
        headers: { 'Content-Type': 'application/json' },
        body: dados
    })
        .then(resposta => resposta.json())
        .then(function(dados){
            if (dados.erro) {
                alert('Erro ao cadastrar produto: ' + dados.erro);
            } else {
                Tabela();
                alert('Produto cadastrado com sucesso!');
            }
        })
        .catch(function(erro) {
            alert('Erro ao cadastrar produto: ' + erro);
        });

    //Ações após envio
    btn.innerHTML = "Adicionar";
    btn.classList.remove('btn-primary');
    btn.classList.add('btn-danger');
    document.getElementById('nm_produto').value = "";
    document.getElementById('id_produto').value = "";
    document.getElementById('id_categoria').value = "";
    document.getElementById('vl_produto').value = "";
    document.getElementById('qt_estoque').value = "";
    document.getElementById('ds_produto').value = "";
});

function Tabela(){

    fetch('../php/categoria.php')
    .then(resposta => resposta.json())
    .then(function(dados){
        var categoria = "";
        for(var i = 0; i < dados.length; i++){
            categoria +=`
            <option value="${dados[i].id_categoria}">${dados[i].nm_categoria}</option>`;
            document.getElementById('id_categoria').innerHTML = categoria;
        }
    })

    fetch('../php/produto.php')
    .then(resposta => resposta.json())
    .then(function(dados){
        var registros = "";
        console.table(dados);
        for(var i=0; i<dados.length; i++){
            registros += `
                <tr>
                <th scope="row">`+dados[i].id_produto+`</th>
                <td>`+dados[i].nm_produto+`</td>
                <td>`+dados[i].ds_produto+`</td>
                <td>R$ `+dados[i].vl_produto+`</td>
                <td>`+dados[i].nm_categoria+`</td>
                <td>`+dados[i].qt_estoque+`</td>
                <td>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFotos" id="${dados[i].id_produto}"  onclick="getId(this)"><i class="bi bi-camera-fill"></i></button>
                    <button class="btn btn-warning" onclick="Atualizar(`+dados[i].id_produto+`)"><i class="bi bi-pencil-square"></i></button>
                    <button class="btn btn-danger excluir" onclick="Excluir(`+dados[i].id_produto+`)"><i class="bi bi-trash-fill"></i></button>
                </td>
            </tr>`;
        }
        document.getElementById('tabela').innerHTML = registros;
        console.log(registros);
    });    
}

function Atualizar(id_produto){
    fetch('../php/produto.php?id_produto='+id_produto,{
        method: 'GET'
    })
    .then(resposta => resposta.json())
    .then(function(dados){
        var id = document.getElementById('id_produto');
        var nome = document.getElementById('nm_produto');
        var categoria = document.getElementById('id_categoria');
        var valor = document.getElementById('vl_produto');
        var estoque = document.getElementById('qt_estoque');
        var descricao = document.getElementById('ds_produto');
        var btn = document.getElementById('btn');

        btn.innerHTML = "Atualizar";
        btn.classList.remove('btn-danger');
        btn.classList.add('btn-primary');

        id.value = dados[0].id_produto;
        nome.value = dados[0].nm_produto;
        categoria.value = dados[0].id_categoria;
        valor.value = dados[0].vl_produto;
        estoque.value = dados[0].qt_estoque;
        descricao.value = dados[0].ds_produto;
        nome.focus();
    });
}

function Excluir(id_produto){
    fetch('../php/produto.php?id_produto='+id_produto,{
        method: 'DELETE'
    })
    .then(resposta => resposta.json())
    .then(dados => Tabela());
}

//Selecionar a foto

const galeria = document.getElementById('previas');

document.getElementById('imagens').addEventListener('change', function(event){

    const files = event.target.files;

    Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = "100px";
                galeria.appendChild(img);
            };
                                                                                                            
            reader.readAsDataURL(file);
        }
    });
});

var btnSalvar = document.getElementById('salvarFoto');

btnSalvar.addEventListener('click', function(e){
    
    var idProduto = document.getElementById('idProduto');
    var imagens = document.getElementById('imagens').files;

    const formData = new FormData();

    formData.append('idProduto', idProduto.value);

    if(imagens.length>0){
        for (let i = 0;i < imagens.length; i++){
            formData.append('imagens[]', imagens[i]);
        }
    

    fetch('../php/foto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert("Fotos Enviadas !!");
    })
    .catch(error => {
        alert('Erro no envio:', error);
        alert('Erro ao enviar as imagens !');
    });

    }else {
        alert("Selecione as imagens !")
    }

});

function getId(campo){
    document.getElementById('idProduto').value = campo.getAttribute('id');
}
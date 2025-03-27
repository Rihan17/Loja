// Verificar login e carregar dados do perfil
fetch('../php/perfil.php')
.then(response => {
    console.log('Status da resposta:', response.status);
    if (!response.ok) {
        throw new Error('Erro na resposta: ' + response.status);
    }
    return response.json();
})
.then(data => {
    console.log('Dados do perfil:', data);
    if (data.erro) {
        alert(data.erro);
        window.location.href = 'index.html';
        return;
    }

    // Preenche os campos com os dados do usuário
    document.getElementById('nome_usuario').textContent = data.usuario.nome;
    document.getElementById('login_usuario').textContent = data.usuario.login;

    // Preenche as estatísticas
    document.getElementById('total_produtos').textContent = data.estatisticas.produtos;
    document.getElementById('total_categorias').textContent = data.estatisticas.categorias;
})
.catch(error => {
    console.error('Erro:', error);
    alert('Erro ao carregar dados do perfil');
    window.location.href = 'index.html';
}); 
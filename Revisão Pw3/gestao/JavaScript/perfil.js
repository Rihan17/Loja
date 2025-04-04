// Verificar login e carregar dados do perfil
fetch('../php/perfil.php')
.then(dados => {
    // Preenche as estatísticas
    document.getElementById('total_produtos').textContent = dados[0].estatisticas.produtos;
    document.getElementById('total_categorias').textContent = dados[0].estatisticas.categorias;
})
.catch(error => {
    console.error('Erro:', error);
    alert('Erro ao carregar dados do perfil');
    window.location.href = 'index.html';
}); 
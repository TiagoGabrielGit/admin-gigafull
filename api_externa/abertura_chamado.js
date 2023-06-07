setTimeout(function () {
    var chamadoId = idChamado;
    fetch('/notificacao/mail/abertura_chamado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id_chamado=' + chamadoId
    }).then(function (response) {
        if (response.ok) {
            // Tratamento para ok
        } else {
            console.error('Erro na requisição. Status:', response.status);
        }
    }).catch(function (error) {
        console.error('Erro na requisição:', error);
    });
});

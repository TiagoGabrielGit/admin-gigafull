<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['idUser']) || empty($_POST['inputDateInicio']) || empty($_POST['inputDateFim']) || empty($_POST['contatoEmergencia'])) {
        echo "Error: Dados obrigatórios não preenchidos!";
    } else {
        if (isset($_POST['ligacao']) || isset($_POST['ligacaoWhatsapp']) || isset($_POST['telegram']) || isset($_POST['whatsapp'])) {
            require "../../../conexoes/conexao_pdo.php";

            // Obter os valores dos campos do formulário
            $idUser = $_POST['idUser'];
            $inputDateInicio = $_POST['inputDateInicio'];
            $inputDateFim = $_POST['inputDateFim'];
            $contatoEmergencia = $_POST['contatoEmergencia'];

            $ligacao = isset($_POST['ligacao']) ? "1" : "0";
            $ligacaoWhatsapp = isset($_POST['ligacaoWhatsapp']) ? "1" : "0";
            $telegram = isset($_POST['telegram']) ? "1" : "0";
            $whatsapp = isset($_POST['whatsapp']) ? "1" : "0";

            // Preparar a consulta SQL
            $sql = "INSERT INTO colaborador_request_plantao (user_id, date_start, date_end, contact_emergency, call_phone, call_whatsapp, telegram, whatsapp, status) 
            VALUES (:user_id, :date_start, :date_end, :contact_emergency, :call_phone, :call_whatsapp, :telegram, :whatsapp, '1')";

            // Preparar a declaração
            $stmt = $pdo->prepare($sql);

            // Bind dos parâmetros
            $stmt->bindParam(':user_id', $idUser);
            $stmt->bindParam(':date_start', $inputDateInicio);
            $stmt->bindParam(':date_end', $inputDateFim);
            $stmt->bindParam(':contact_emergency', $contatoEmergencia);
            $stmt->bindParam(':call_phone', $ligacao);
            $stmt->bindParam(':call_whatsapp', $ligacaoWhatsapp);
            $stmt->bindParam(':telegram', $telegram);
            $stmt->bindParam(':whatsapp', $whatsapp);

            // Executar a consulta
            if ($stmt->execute()) {
                echo "Dados salvos com sucesso!";
            } else {
                echo "Error: Não foi possível salvar os dados.";
            }
        } else {
            echo "Error: Selecione pelo menos uma forma de contato!";
        }
    }
}

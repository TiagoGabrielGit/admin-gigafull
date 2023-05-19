<?php
// ...
// Seu código PHP para obter o valor de $chamadoID

// Inclua o arquivo de conexão PDO
require "../../../conexoes/conexao_pdo.php";

$chamadoID = $_POST['chamadoID'];

try {
    // Montar a consulta preparada
    $sql = "SELECT crr.*
            FROM chamados_relatos_rascunho as crr
            WHERE crr.id_chamado = :chamadoID
            ORDER BY crr.id DESC
            LIMIT 1";
    
    // Preparar a consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':chamadoID', $chamadoID);
    
    // Executar a consulta
    $stmt->execute();
    
    // Obter o resultado
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verificar se houve algum resultado
    if ($resultado) {
        $novoRelato = $resultado['relato']; // Substitua 'coluna_desejada' pelo nome da coluna que você deseja obter
        echo "$novoRelato";
    } else {
        $novoRelato = ""; // Define um valor padrão caso não haja resultados
        echo "$novoRelato";
    }
} catch(PDOException $e) {
    echo "Erro na consulta ao banco de dados: " . $e->getMessage();
}
?>

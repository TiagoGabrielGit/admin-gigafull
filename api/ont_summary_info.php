<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../conexoes/conexao_pdo.php";

    $id_incidente = $_POST['codigoIncidente'];
    $incidente = $_POST['incidente'];
    $idUsuario = $_POST['idUsuario'];

    $dados_olt =
        "SELECT
        ro.olt_ipAddress as 'ip',
        ro.olt_username as 'usuario',
        ro.olt_password as 'password'
        FROM
        incidentes as i
        LEFT JOIN
        redeneutra_olts as ro
        ON
        ro.equipamento_id = i.equipamento_id
        WHERE
        i.id = $id_incidente";

    // Executa a consulta no banco de dados
    $r_dados_olt = $pdo->query($dados_olt);
    $c_dados_olt = $r_dados_olt->fetch(PDO::FETCH_ASSOC);
    $ip = $c_dados_olt['ip'];
    $usuario = $c_dados_olt['usuario'];
    $password = $c_dados_olt['password'];

    // Extrair os valores usando expressões regulares
    if (preg_match('/GPON (\d+)\/(\d+)\/(\d+)/', $incidente, $matches)) {
        $frame = $matches[1];  // Valor "0"
        $slot = $matches[2];   // Valor "4"
        $pon = $matches[3];    // Valor "11"

        exec("bash ../bash/olt/huawei/summary_info.bash $ip $usuario $password $frame $slot $pon", $retorno1);
        $array_result = [];
        foreach ($retorno1 as $key => $value) {

            $pos1 = strpos($value, 'Command');
            if ($pos1 !== false) {
                $array_result1[] = $key;
            }

            $pos2 = strpos($value, 'quit');
            if ($pos2 !== false) {
                $array_result2[] = $key;
            }
        }

        $linhaInicial = $array_result1[0];
        $linhaFinal = $array_result2[0];
        $mensagemRetorno = implode(PHP_EOL, array_slice($retorno1, $linhaInicial, $linhaFinal - $linhaInicial + 1));

        // Preparar a consulta SQL para inserir os dados no banco de dados
        $sql = "INSERT INTO incidentes_relatos (relato_autor, incidente_id, relato, horarioRelato) 
                VALUES (:relato_autor, :incidente_id, :relato, NOW()";

        // Preparar o statement PDO
        $stmt = $pdo->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':incidente_id', $id_incidente);
        $stmt->bindParam(':relato_autor', $idUsuario);
        $stmt->bindParam(':relato', $mensagemRetorno);

        // Executar a consulta
        $stmt->execute();

        // Verificar se a consulta foi executada com sucesso
        if ($stmt->rowCount() > 0) {
            echo "Mensagem do retorno armazenada no banco de dados com sucesso.";
        } else {
            echo "Erro ao armazenar a mensagem do retorno no banco de dados.";
        }
    } else {
        echo "Não foi possível obter slot e pon.";
    }
} else {
    echo "Método não autorizado.";
}

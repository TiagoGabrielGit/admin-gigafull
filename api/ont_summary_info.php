<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../conexoes/conexao_pdo.php";

    $id_chamado = $_POST['codigoIncidente'];
    $incidente = $_POST['incidente'];

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
        i.id = $id_chamado";

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

        // Exibir os valores
        //echo "IP: $ip<br>";
        //echo "Usuario: $usuario<br>";
        //echo "Password: $password<br>";
        //echo "Frame: $frame<br>";
        //echo "SLOT: $slot<br>";
        //echo "PON: $pon<br>";

        exec("bash ../bash/olt/huawei/summary_info.bash $ip $usuario $password $frame $slot $pon", $retorno1);
        echo $retorno1;
    } else {
        echo "Não foi possível obter slot e pon.";
    }
} else {
    echo "Método não autorizado.";
}

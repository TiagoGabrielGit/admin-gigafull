<?php
require "../../conexoes/conexao.php";

$usuarioID = $_GET['usuarioID'];
$profile = $_GET['profile'];
$slotOLT = $_GET['slotOLT'];
$ponOLT = $_GET['ponOLT'];
$serialONU = $_GET['serialONU'];
$codigoParceiro = $_GET['codigoParceiro'];
$codigoReserva = $_GET['codigoReserva'];
$parceiro = $_GET['parceiro'];

$sql =
    "SELECT
    rnps.cvlan as CVLAN,
    rnps.svlan as SVLAN,
    rnps.gemport as GEMPORT,
    rnpp.line_profile_id as line_profile_id,
    rnpp.srv_profile_id as srv_profile_id,
    rno.olt_username as userOLT,
    rno.olt_password as passOLT,
    eqp.ipaddress as ipOLT,
    rno.id as oltId
FROM
    redeneutra_profile_parceiro as rnpp
LEFT JOIN
	redeneutra_profile_service as rnps
ON
	rnpp.id = rnps.profile_id
LEFT JOIN
	redeneutra_olts as rno
ON
	rno.id = rnpp.redeneutra_olt_id
LEFT JOIN
equipamentospop as eqp
ON
eqp.id = rno.equipamento_id
WHERE
    rnpp.id = $profile";

$r_sql = mysqli_query($mysqli, $sql);
$c_sql = $r_sql->fetch_array();

$ipOLT = $c_sql['ipOLT'];
$olt = $c_sql['oltId'];
$userOLT = $c_sql['userOLT'];
$passOLT = $c_sql['passOLT'];
$line_profile_id = $c_sql['line_profile_id'];
$srv_profile_id = $c_sql['srv_profile_id'];
$CVLAN = $c_sql['CVLAN'];
$SVLAN = $c_sql['SVLAN'];
$GEMPORT = $c_sql['GEMPORT'];

$descricaoONU = $codigoParceiro . "_" . $codigoReserva;

exec("bash ../../bash/add_onu.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $serialONU $line_profile_id $srv_profile_id $descricaoONU", $retorno1);

foreach ($retorno1 as $key => $value) {
    $posONTID = strpos($value, 'ONTID :');
    if ($posONTID !== false) {
        $array_result1[] = $key;
    }
}

$linhaONTID = $array_result1[0];
$linhaONTID = $retorno1[$linhaONTID];
$posicaoONTID = strpos($linhaONTID, 'ONTID :');
$idONU = substr($linhaONTID, $posicaoONTID + 7);

echo "ID ONU:" . $idONU . PHP_EOL;

echo "=============" . PHP_EOL;

exec("bash ../../bash/service_port.bash $ipOLT $userOLT $passOLT $CVLAN $slotOLT $ponOLT $idONU $SVLAN $SVLAN $GEMPORT", $retorno2);
exec("bash ../../bash/consulta_service-port.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $idONU", $retorno3);

$r3 = $retorno3[33];
$valida3 = strpos($r3, "Failure");

foreach ($retorno1 as $key1) {
    echo $key1 . "\n";
}

foreach ($retorno2 as $key2) {
    echo $key2 . "\n";
}

if ($valida3 === false) {
    $sql_insert = "INSERT INTO redeneutra_onu_provisionadas (metodo, olt_id, parceiro_id, descricao, slot_olt, pon_olt, id_onu, serial_onu, active, data_provisionamento, criado_por, profile)
    VALUES ('1', '$olt', '$parceiro', '$descricaoONU', '$slotOLT', '$ponOLT', '$idONU', '$serialONU', '1', NOW(), '$usuarioID', '$profile')";
    mysqli_query($mysqli, $sql_insert);
    $idProvisionamento = mysqli_insert_id($mysqli);
}
?>

<!-- script novo HOMOLOGAÇÃO 4.6 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", eventoDiagONU());

    async function eventoDiagONU() {

        let diag = {}
        diag.idOLT = document.getElementById("idOLT").value;
        diag.slotOLT = document.getElementById("slotOLT").value;
        diag.ponOLT = document.getElementById("ponOLT").value;
        diag.idONU = document.getElementById("idONU").value;

        const retornoDiag = await funcaoDiagONU('scripts/diag_onu.php', 'GET', diag)


        let obg = {}
        obg.id_onu = document.getElementById("provID").value;

        obg.signal = "Sinal RX da ONU coletado através do provisionamento de ONU. Sinal " + await retornoDiag.sinalONU;

        funcaoRegisterLOG('/api/insert_register_log_onu.php', 'GET', obg)

        function funcaoRegisterLOG(url, metodo, obg) {
            $.ajax({
                url: url,
                method: metodo,
                dataType: "HTML",
                data: obg,
            })
        }
    }

    async function funcaoDiagONU(url, metodo, diag) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "json",
            data: diag,
        })
    }

    async function funcaoService(url, metodo, service) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "json",
            data: service,
        })
    }
</script>
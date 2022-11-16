<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$idParceiro = $_GET["idParceiro"];
$idOLT = $_GET["idOLT"];

$profiles = 
"SELECT
rnpp.id as idPerfil,
rnpp.perfil as perfil
FROM
redeneutra_profile_parceiro as rnpp
WHERE
rnpp.redeneutra_olt_id = $idOLT
AND
rnpp.redeneutra_parceiro_id = $idParceiro
AND
rnpp.active = 1
ORDER BY
rnpp.perfil ASC
";

$consulta = mysqli_query($mysqli, $profiles);
if($consulta):
    echo "<option value=''>Selecione</option>";
    while($resp = mysqli_fetch_object($consulta)):
        
       echo "<option value='$resp->idPerfil'> $resp->perfil </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
?> 
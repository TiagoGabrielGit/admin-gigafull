<?php
session_start();
require "../../../conexoes/conexao.php";

$usuario_id = $_SESSION['id'];

$sql_pessoa =
  "SELECT
p.id as id_pessoa
FROM
usuarios as u
LEFT JOIN
pessoas as p
ON
p.id = u.pessoa_id
WHERE
u.id = '$usuario_id'
";

$result_pessoa = mysqli_query($mysqli, $sql_pessoa);
$pessoa = mysqli_fetch_assoc($result_pessoa);
$pessoa_id = $pessoa['id_pessoa'];
?>


<?php
require "../../../conexoes/conexao_pdo.php";

$id_empresa = $_POST['idEmpresa1'];
$tipo = "vm";
$privacidade = $_POST['cadastroPrivacidade'];
$id_VM = $_POST['idVMModalSenha2'];
$vm_desc = $_POST['vmDescricao'];
$vm_user = $_POST['vmUsuario'];
$vm_pass = $_POST['vmSenha'];

$cont_insert1 = false;

$credenciais_vms = "INSERT INTO credenciais_vms (empresa_id, tipo, usuario_id, privacidade, vm_id, vmdescricao, vmusuario, vmsenha, active)
                    VALUES (:empresa_id, :tipo, :usuario_id, :privacidade, :vm_id, :vmdescricao, :vmusuario, :vmsenha, '1')";
$stmt1 = $pdo->prepare($credenciais_vms);
$stmt1->bindParam(':empresa_id', $id_empresa);
$stmt1->bindParam(':tipo', $tipo);
$stmt1->bindParam(':usuario_id', $pessoa_id);
$stmt1->bindParam(':privacidade', $privacidade);
$stmt1->bindParam(':vm_id', $id_VM);
$stmt1->bindParam(':vmdescricao', $vm_desc);
$stmt1->bindParam(':vmusuario', $vm_user);
$stmt1->bindParam(':vmsenha', $vm_pass);

if ($stmt1->execute()) {
    $cont_insert1 = true;
} else {
    $cont_insert1 = false;
}


if ($cont_insert1) {
    echo "<p style='color:green;'>Cadastrado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}

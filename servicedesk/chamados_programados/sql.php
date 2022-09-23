<?php
//CAPTURA ID DA PESSOA
$id_usuario = $_SESSION['id'];
$sql_captura_id_pessoa =
    "SELECT
u.pessoa_id as pessoaID
FROM
usuarios as u
WHERE
id = '$id_usuario'
";
$result_cap_pessoa = mysqli_query($mysqli, $sql_captura_id_pessoa);
$pessoaID = mysqli_fetch_assoc($result_cap_pessoa);

//CAPTURA LISTA DE EMPRESAS
$sql_lista_empresas = 
"SELECT
emp.id as id_empresa,
emp.fantasia as fantasia_empresa
FROM
empresas as emp
WHERE
atributoCliente = '1'
or
atributoEmpresaPropria = '1'
ORDER BY
emp.fantasia ASC
";

//CAPTURA LISTA TIPO DE CHAMADOS
$sql_lista_tipos_chamados =
"SELECT
tipo.id as id,
tipo.tipo as tipo
FROM
tipos_chamados as tipo
WHERE
tipo.active = 1
";
?>
<?php
$permissao_abrir_chamado = $_SESSION['permissao_abrir_chamado'];


if ($permissao_abrir_chamado == 1) {
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
} else if ($permissao_abrir_chamado == 0) {
    $sql_lista_empresas =
        "SELECT
    emp.id as id_empresa,
    emp.fantasia as fantasia_empresa
    FROM
    empresas as emp
    WHERE
    atributoCliente = '1'
    and
    emp.id = $s_empresaID
    or
    atributoEmpresaPropria = '1'
    and
    emp.id = $s_empresaID
    ORDER BY
    emp.fantasia ASC
    ";
}


$sql_lista_tipos_chamados =
    "SELECT
tipo.id as id,
tipo.tipo as tipo
FROM
tipos_chamados as tipo
WHERE
tipo.active = 1
ORDER BY
tipo.tipo ASC
";

$sql_lista_atendentes =
    "SELECT
CASE WHEN p.nome IS NULL THEN '0'             ELSE u.id END AS 'id',
CASE WHEN p.nome IS NULL THEN 'Sem Atendente' ELSE p.nome END AS 'nome'
FROM
chamados as ch
LEFT JOIN
usuarios as u
ON
ch.atendente_id = u.id
LEFT JOIN
pessoas as p
ON
p.id = u.pessoa_id
GROUP BY
ch.atendente_id
order by
p.nome ASC
";

$sql_status_chamados =
    "SELECT
cs.id as 'id',
cs.status_chamado as 'status'
FROM
chamados_status as cs
WHERE
cs.active = 1
order by
cs.status_chamado ASC";

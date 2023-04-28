<?php

$sql_equipamentos =
"SELECT
eqp.id as id,
eqp.equipamento as equipamento,
fab.fabricante as fabricante
FROM equipamentos AS eqp
left join fabricante as fab
on fab.id = eqp.fabricante
WHERE eqp.deleted = 1
ORDER BY eqp.equipamento ASC
";

$sql_fabricante =
"SELECT
fab.*
FROM fabricante as fab
WHERE fab.deleted = 1
ORDER BY fab.fabricante
";

$sql_tipo =
"SELECT
tipo.*
FROM tipoequipamento as tipo
WHERE tipo.deleted = 1
ORDER BY tipo.tipo
";

$sql_cidade =
"SELECT
cidade.id as id,
cidade.cidade as cidade,
estado.estado as estado,
pais.pais as pais,
cidade.criado as criado,
cidade.modificado as modificado,
pais.id as idpais,
estado.id as idestado
FROM cidades as cidade
LEFT JOIN estado as estado
ON cidade.estado = estado.id
LEFT JOIN pais as pais
ON cidade.pais = pais.id
WHERE cidade.deleted = 1
ORDER BY cidade.cidade
";

$sql_bairros =
"SELECT
bairro.id as id,
bairro.bairro as bairro,
bairro.criado as criado,
bairro.modificado as modificado,
cidade.cidade as cidade,
cidade.id as idcidade
FROM bairros as bairro
LEFT JOIN cidades as cidade
ON cidade.id = bairro.cidade
WHERE bairro.deleted = 1
ORDER BY 
cidade.cidade ASC,
bairro.bairro ASC
";

$sql_estados =
"SELECT
estado.id as id,
estado.estado as estado,
estado.criado as criado,
estado.modificado as modificado,
pais.pais as pais,
pais.id as idpais
FROM estado as estado
LEFT JOIN pais as pais
ON pais.id = estado.pais
WHERE 
    estado.deleted = 1
ORDER BY 
pais.pais ASC,
estado.estado ASC
";

$sql_pais =
"SELECT
pais.*
FROM pais as pais
WHERE pais.deleted = 1
ORDER BY pais.pais
"; 

$sql_logradouros = 
"SELECT
    logr.id as id,
    pais.pais as pais,
    bai.bairro as bairro,
    cid.cidade as cidade,
    logr.logradouro as logradouro
FROM 
    logradouros as logr
LEFT JOIN
    cidades as cid
    ON
    cid.id = logr.cidade
LEFT JOIN
    bairros as bai
    ON
    bai.id = logr.bairro 
LEFT JOIN
    pais as pais
    ON
    pais.id = logr.pais      
LEFT JOIN
    estado as est
    ON
    est.id = logr.estado   
WHERE
    logr.deleted = 1
ORDER BY 
    pais.pais ASC,
    est.estado ASC,
    cid.cidade ASC,
    logr.logradouro ASC
";

$sql_pesquisa_estados =
"SELECT
    * 
FROM
    estado
ORDER BY
    estado
";

$sql_bug_relatados = 
"SELECT 
bug.id as idBug,
user.id as idUser,
user.nome as usuario,
bug.relataBug as relataBug,
bug.descricao as descricao,
bug.situacao as situacao
FROM
relatabug as bug
LEFT JOIN
usuarios as user
ON
bug.usuarioCriador = user.id
WHERE
bug.deleted = 1
ORDER BY 
bug.relataBug ASC";

$sql_melhorias_relatadas =
"SELECT
melhoria.id as id,
melhoria.situacao as situacao,
melhoria.tituloMelhoria as tituloMelhoria,
user.nome as usuarioCriador
FROM
sugeremelhoria as melhoria
LEFT JOIN
usuarios as user
ON
user.id = melhoria.usuarioCriador
WHERE
melhoria.deleted = 1
ORDER BY 
melhoria.tituloMelhoria ASC";    

$sql_empresas = 
"SELECT
    empresas.*
FROM
    empresas as empresas
WHERE
    empresas.deleted = 1
ORDER BY
    empresas.razaoSocial             
";

//LISTA OS PERFIL CADASTRADO
$sql_perfil = 
"SELECT
    perfil.id as id,
    perfil.perfil as perfil
FROM
    perfil_permissoes as perfil
WHERE
    perfil.id != '1'
ORDER BY
    perfil.perfil ASC           
";

$sql_pessoas = 
"SELECT
pessoa.id as id,
pessoa.nome as nome,
pessoa.email as email,
pessoa.cpf as cpf

FROM
    pessoas as pessoa
WHERE
pessoa.deleted = 1
ORDER BY
pessoa.nome ASC
";
<?php
/////////////////////////////////////////

//SUBMENU >> LOCALIDADES >> BAIRROS
$nav_sub_bairros = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '1'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_bairros = mysqli_query($mysqli, $nav_sub_bairros);
$c_nav_sub_bairros = mysqli_fetch_assoc($r_nav_sub_bairros);
/////////////////////////////////////////

//SUBMENU >> LOCALIDADES >> CIDADES
$nav_sub_cidades = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '2'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_cidades = mysqli_query($mysqli, $nav_sub_cidades);
$c_nav_sub_cidades = mysqli_fetch_assoc($r_nav_sub_cidades);
/////////////////////////////////////////

//SUBMENU >> LOCALIDADES >> ESTADOS
$nav_sub_estados = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '3'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_estados = mysqli_query($mysqli, $nav_sub_estados);
$c_nav_sub_estados = mysqli_fetch_assoc($r_nav_sub_estados);
/////////////////////////////////////////

//SUBMENU >> LOCALIDADES >> LOGRADOUROS
$nav_sub_logradouros = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '4'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_logradouros = mysqli_query($mysqli, $nav_sub_logradouros);
$c_nav_sub_logradouros = mysqli_fetch_assoc($r_nav_sub_logradouros);
/////////////////////////////////////////

//SUBMENU >> LOCALIDADES >> PAIS
$nav_sub_pais = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '5'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_pais = mysqli_query($mysqli, $nav_sub_pais);
$c_nav_sub_pais = mysqli_fetch_assoc($r_nav_sub_pais);
/////////////////////////////////////////

//SUBMENU >> PRODUTOS & SERVICOS >> FABRICANTES
$nav_sub_fabricantes = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '6'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_fabricantes = mysqli_query($mysqli, $nav_sub_fabricantes);
$c_nav_sub_fabricantes = mysqli_fetch_assoc($r_nav_sub_fabricantes);
/////////////////////////////////////////

//SUBMENU >> PRODUTOS & SERVICOS >> PRODUTOS
$nav_sub_produtos = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '7'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_produtos = mysqli_query($mysqli, $nav_sub_produtos);
$c_nav_sub_produtos = mysqli_fetch_assoc($r_nav_sub_produtos);
/////////////////////////////////////////

//SUBMENU >> PRODUTOS & SERVICOS >> SERVICOS
$nav_sub_servicos = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '8'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_servicos = mysqli_query($mysqli, $nav_sub_servicos);
$c_nav_sub_servicos = mysqli_fetch_assoc($r_nav_sub_servicos);
/////////////////////////////////////////

//SUBMENU >> PRODUTOS & SERVICOS >> SISTEMA OPERACIONAL
$nav_sub_sistemaOperacional = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '9'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_sistemaOperacional = mysqli_query($mysqli, $nav_sub_sistemaOperacional);
$c_nav_sub_sistemaOperacional = mysqli_fetch_assoc($r_nav_sub_sistemaOperacional);
/////////////////////////////////////////

//SUBMENU >> PRODUTOS & SERVICOS >> TIPOS DE EQUIPAMENTOS
$nav_sub_tiposEquipamentos = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '10'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_tiposEquipamentos = mysqli_query($mysqli, $nav_sub_tiposEquipamentos);
$c_nav_sub_tiposEquipamentos = mysqli_fetch_assoc($r_nav_sub_tiposEquipamentos);
/////////////////////////////////////////

//SUBMENU >> REDE NEUTRA >> AUDITORIA
$nav_sub_auditoria = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '21'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_auditoria = mysqli_query($mysqli, $nav_sub_auditoria);
$c_nav_sub_auditoria = mysqli_fetch_assoc($r_nav_sub_auditoria);
/////////////////////////////////////////

//SUBMENU >> REDE NEUTRA >> ATIVA????O
$nav_sub_ativacao = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '11'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_ativacao = mysqli_query($mysqli, $nav_sub_ativacao);
$c_nav_sub_ativacao = mysqli_fetch_assoc($r_nav_sub_ativacao);
/////////////////////////////////////////

//SUBMENU >> REDE NEUTRA >> INICIDENTES
$nav_sub_incidentes = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '12'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_inicidentes = mysqli_query($mysqli, $nav_sub_incidentes);
$c_nav_sub_incidentes = mysqli_fetch_assoc($r_nav_sub_inicidentes);
/////////////////////////////////////////

//SUBMENU >> REDE NEUTRA >> OLTS
$nav_sub_olts = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '13'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_olts = mysqli_query($mysqli, $nav_sub_olts);
$c_nav_sub_olts = mysqli_fetch_assoc($r_nav_sub_olts);
/////////////////////////////////////////

//SUBMENU >> REDE NEUTRA >> ONUS PROVISIONADAS
$nav_sub_onusProvisionadas = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '14'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_onusProvisionadas = mysqli_query($mysqli, $nav_sub_onusProvisionadas);
$c_nav_sub_onusProvisionadas = mysqli_fetch_assoc($r_nav_sub_onusProvisionadas);
/////////////////////////////////////////

//SUBMENU >> REDE NEUTRA >> PARCEIROS
$nav_sub_parceiros = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '15'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_parceiros = mysqli_query($mysqli, $nav_sub_parceiros);
$c_nav_sub_parceiros = mysqli_fetch_assoc($r_nav_sub_parceiros);
/////////////////////////////////////////

//SUBMENU >> GERENCIAMENTO >> EQUIPES
$nav_sub_equipes = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '16'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_equipes = mysqli_query($mysqli, $nav_sub_equipes);
$c_nav_sub_equipes = mysqli_fetch_assoc($r_nav_sub_equipes);
/////////////////////////////////////////

//SUBMENU >> GERENCIAMENTO >> PERFIL
$nav_sub_perfil = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '17'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_perfil = mysqli_query($mysqli, $nav_sub_perfil);
$c_nav_sub_perfil = mysqli_fetch_assoc($r_nav_sub_perfil);
/////////////////////////////////////////

//SUBMENU >> GERENCIAMENTO >> USUARIOS
$nav_sub_usuarios = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '18'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_usuarios = mysqli_query($mysqli, $nav_sub_usuarios);
$c_nav_sub_usuarios = mysqli_fetch_assoc($r_nav_sub_usuarios);
/////////////////////////////////////////

//SUBMENU >> SISTEMA >> CHANGELOG
$nav_sub_changelog = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '19'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_changelog = mysqli_query($mysqli, $nav_sub_changelog);
$c_nav_sub_changelog = mysqli_fetch_assoc($r_nav_sub_changelog);
/////////////////////////////////////////

//SUBMENU >> SISTEMA >> LOG ADMIN
$nav_sub_logAdmin = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '20'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_logAdmin = mysqli_query($mysqli, $nav_sub_logAdmin);
$c_nav_sub_logAdmin = mysqli_fetch_assoc($r_nav_sub_logAdmin);
/////////////////////////////////////////
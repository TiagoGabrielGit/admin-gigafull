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

//SUBMENU >> REDE NEUTRA >> ATIVAÇÃO
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
$nav_sub_informativos_incidentes = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '22'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_informativos_incidentes = mysqli_query($mysqli, $nav_sub_informativos_incidentes);
$c_nav_sub_informativos_incidentes = mysqli_fetch_assoc($r_nav_sub_informativos_incidentes);
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

//SUBMENU >> SERVICE DESK >> INCIDENTES
$nav_sub_incidentes = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '22'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_incidentes = mysqli_query($mysqli, $nav_sub_incidentes);
$c_nav_sub_incidentes = mysqli_fetch_assoc($r_nav_sub_incidentes);
/////////////////////////////////////////

$nav_sub_configuracoes_incidentes = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '24'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_configuracoes_incidentes = mysqli_query($mysqli, $nav_sub_configuracoes_incidentes);
$c_nav_sub_configuracoes_incidentes = mysqli_fetch_assoc($r_nav_sub_configuracoes_incidentes);
/////////////////////////////////////////

$nav_sub_competencias = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '25'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_competencias = mysqli_query($mysqli, $nav_sub_competencias);
$c_nav_sub_competencias = mysqli_fetch_assoc($r_nav_sub_competencias);
/////////////////////////////////////////
/////////////////////////////////////////

$nav_sub_configuracoes = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '26'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_configuracoes = mysqli_query($mysqli, $nav_sub_configuracoes);
$c_nav_sub_configuracoes = mysqli_fetch_assoc($r_nav_sub_configuracoes);
/////////////////////////////////////////

$nav_sub_docAPI = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '27'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_docAPI = mysqli_query($mysqli, $nav_sub_docAPI);
$c_nav_sub_docAPI = mysqli_fetch_assoc($r_nav_sub_docAPI);
/////////////////////////////////////////

$nav_sub_cadastroConsulta = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '29'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_cadastroConsulta = mysqli_query($mysqli, $nav_sub_cadastroConsulta);
$c_nav_sub_cadastroConsulta = mysqli_fetch_assoc($r_nav_sub_cadastroConsulta);
/////////////////////////////////////////

$nav_sub_consultas = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '28'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_consultas = mysqli_query($mysqli, $nav_sub_consultas);
$c_nav_sub_consultas = mysqli_fetch_assoc($r_nav_sub_consultas);
/////////////////////////////////////////


$nav_sub_rotasFibra = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '30'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_rotasFibra = mysqli_query($mysqli, $nav_sub_rotasFibra);
$c_nav_sub_rotasFibra = mysqli_fetch_assoc($r_nav_sub_rotasFibra);
/////////////////////////////////////////


$nav_sub_intZabbix = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '31'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_intZabbix = mysqli_query($mysqli, $nav_sub_intZabbix);
$c_nav_sub_intZabbix = mysqli_fetch_assoc($r_nav_sub_intZabbix);
/////////////////////////////////////////

$nav_sub_gpon = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '32'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_gpon = mysqli_query($mysqli, $nav_sub_gpon);
$c_nav_sub_gpon = mysqli_fetch_assoc($r_nav_sub_gpon);
/////////////////////////////////////////

//SUBMENU >> COMUNICAR INCIDENTES
$nav_sub_comunicar = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '34'
and
ppsm.perfil_id = $perfil_id";

$r_sub_comunicar = mysqli_query($mysqli, $nav_sub_comunicar);
$c_sub_comunicar = mysqli_fetch_assoc($r_sub_comunicar);


//SUBMENU >> AGENDAR MANUTENÇÃO
$nav_sub_agendar_manutencao = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '35'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_agendar_manutencao = mysqli_query($mysqli, $nav_sub_agendar_manutencao);
$c_nav_sub_agendar_manutencao = mysqli_fetch_assoc($r_nav_sub_agendar_manutencao);

//SUBMENU >> MANUTENÇÕES PROGRAMADAS
$nav_sub_manutencoes_programadas = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '36'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_manutencoes_programadas = mysqli_query($mysqli, $nav_sub_manutencoes_programadas);
$c_nav_sub_manutencoes_programadas = mysqli_fetch_assoc($r_nav_sub_manutencoes_programadas);

//SUBMENU >> NOVO INCIDENTE
$nav_sub_novo_incidente = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '37'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_novo_incidente = mysqli_query($mysqli, $nav_sub_novo_incidente);
$c_nav_sub_novo_incidente = mysqli_fetch_assoc($r_nav_sub_novo_incidente);

//SUBMENU >> INTEGRAÇÃO WR GATEWAY
$nav_sub_wr_gateway = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '38'
and
ppsm.perfil_id = $perfil_id";

$r_sub_wr_gateway = mysqli_query($mysqli, $nav_sub_wr_gateway);
$c_sub_wr_gateway = mysqli_fetch_assoc($r_sub_wr_gateway);

//SUBMENU >> GERENCIAR COMUNICADOS
$nav_sub_gerenciar_comunicados = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '39'
and
ppsm.perfil_id = $perfil_id";

$r_sub_gerenciar_comunicados = mysqli_query($mysqli, $nav_sub_gerenciar_comunicados);
$c_sub_gerenciar_comunicados = mysqli_fetch_assoc($r_sub_gerenciar_comunicados);

//SUBMENU >> TEMPLATES COMUNICACAO
$nav_sub_templates_comunicacao = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '40'
and
ppsm.perfil_id = $perfil_id";

$r_sub_templates_comunicacao = mysqli_query($mysqli, $nav_sub_templates_comunicacao);
$c_sub_templates_comunicacao = mysqli_fetch_assoc($r_sub_templates_comunicacao);


$nav_sub_iframe_incidentes = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '41'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_iframe_incidentes = mysqli_query($mysqli, $nav_sub_iframe_incidentes);
$c_nav_sub_iframe_incidentes = mysqli_fetch_assoc($r_nav_sub_iframe_incidentes);

$nav_sub_voalle = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '42'
and
ppsm.perfil_id = $perfil_id";

$r_sub_voalle = mysqli_query($mysqli, $nav_sub_voalle);
$c_sub_voalle = mysqli_fetch_assoc($r_sub_voalle);

$nav_importCTO = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '43'
and
ppsm.perfil_id = $perfil_id";

$r_sub_importCTO = mysqli_query($mysqli, $nav_importCTO);
$c_nav_sub_importCTO = mysqli_fetch_assoc($r_sub_importCTO);

$nav_sub_ctos = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '48'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_ctos = mysqli_query($mysqli, $nav_sub_ctos);
$c_nav_sub_ctos = mysqli_fetch_assoc($r_nav_sub_ctos);



$nav_responsaveis_aceite = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '44'
and
ppsm.perfil_id = $perfil_id";

$r_sub_responsaveis_aceite = mysqli_query($mysqli, $nav_responsaveis_aceite);
$c_nav_sub_responsaveis_aceite = mysqli_fetch_assoc($r_sub_responsaveis_aceite);


$nav_produtos_ecommerce = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '45'
and
ppsm.perfil_id = $perfil_id";

$r_sub_produtos_ecommerce = mysqli_query($mysqli, $nav_produtos_ecommerce);
$c_nav_sub_produtos_ecommerce = mysqli_fetch_assoc($r_sub_produtos_ecommerce);

$nav_ecommerce_venda = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '46'
and
ppsm.perfil_id = $perfil_id";

$r_sub_ecommerce_venda = mysqli_query($mysqli, $nav_ecommerce_venda);
$c_nav_sub_ecommerce_venda = mysqli_fetch_assoc($r_sub_ecommerce_venda);

$nav_ecommerce_pedidos = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '47'
and
ppsm.perfil_id = $perfil_id";

$r_sub_ecommerce_pedidos = mysqli_query($mysqli, $nav_ecommerce_pedidos);
$c_nav_sub_ecommerce_pedidos = mysqli_fetch_assoc($r_sub_ecommerce_pedidos);

$nav_sub_novo_chamado = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '50'
and
ppsm.perfil_id = $perfil_id";

$r_sub_novo_chamado = mysqli_query($mysqli, $nav_sub_novo_chamado);
$c_sub_novo_chamado = mysqli_fetch_assoc($r_sub_novo_chamado);

$sub_consultar_chamado = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '49'
and
ppsm.perfil_id = $perfil_id";

$r_sub_consultar_chamado = mysqli_query($mysqli, $sub_consultar_chamado);
$c_sub_consultar_chamado = mysqli_fetch_assoc($r_sub_consultar_chamado);

$sub_telegram = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '51'
and
ppsm.perfil_id = $perfil_id";

$r_sub_telegram = mysqli_query($mysqli, $sub_telegram);
$c_sub_telegram = mysqli_fetch_assoc($r_sub_telegram);

$sub_tipos_chamados = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '52'
and
ppsm.perfil_id = $perfil_id";

$r_sub_tipos_chamados = mysqli_query($mysqli, $sub_tipos_chamados);
$c_sub_tipos_chamados = mysqli_fetch_assoc($r_sub_tipos_chamados);

$sub_mascaras_chamados = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '53'
and
ppsm.perfil_id = $perfil_id";

$r_sub_mascaras_chamados = mysqli_query($mysqli, $sub_mascaras_chamados);
$c_sub_mascaras_chamados = mysqli_fetch_assoc($r_sub_mascaras_chamados);


$sub_status_chamados = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '55'
and
ppsm.perfil_id = $perfil_id";

$r_sub_status_chamados = mysqli_query($mysqli, $sub_status_chamados);
$c_sub_status_chamados = mysqli_fetch_assoc($r_sub_status_chamados);


/////////////////////////////////////////
$nav_sub_atualizacao_massa = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '33'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_atualizacao_massa = mysqli_query($mysqli, $nav_sub_atualizacao_massa);
$c_nav_sub_atualizacao_massa = mysqli_fetch_assoc($r_nav_sub_atualizacao_massa);
/////////////////////////////////////////

/////////////////////////////////////////
$nav_sub_nova_reuniao = "SELECT
count(*) as c
FROM
url_submenu as usm
LEFT JOIN
perfil_permissoes_submenu as ppsm
ON
ppsm.url_submenu = usm.id
WHERE
usm.id = '56'
and
ppsm.perfil_id = $perfil_id";

$r_nav_sub_nova_reuniao = mysqli_query($mysqli, $nav_sub_nova_reuniao);
$c_nav_sub_nova_reuniao = mysqli_fetch_assoc($r_nav_sub_nova_reuniao);
/////////////////////////////////////////

/////////////////////////////////////////
$nav_sub_atas = "SELECT count(*) as c
FROM url_submenu as usm
LEFT JOIN perfil_permissoes_submenu as ppsm ON ppsm.url_submenu = usm.id
WHERE usm.id = '57' and ppsm.perfil_id = $perfil_id";

$r_nav_sub_atas = mysqli_query($mysqli, $nav_sub_atas);
$c_nav_sub_atas = mysqli_fetch_assoc($r_nav_sub_atas);
/////////////////////////////////////////
$nav_sub_ozmap = "SELECT count(*) as c
FROM url_submenu as usm
LEFT JOIN perfil_permissoes_submenu as ppsm ON ppsm.url_submenu = usm.id
WHERE usm.id = '58' and ppsm.perfil_id = $perfil_id";

$r_sub_ozmap = mysqli_query($mysqli, $nav_sub_ozmap);
$c_sub_ozmap = mysqli_fetch_assoc($r_sub_ozmap);
/////////////////////////////////////////
$nav_sub_afericoes = "SELECT count(*) as c
FROM url_submenu as usm
LEFT JOIN perfil_permissoes_submenu as ppsm ON ppsm.url_submenu = usm.id
WHERE usm.id = '59' and ppsm.perfil_id = $perfil_id";

$r_nav_sub_afericoes = mysqli_query($mysqli, $nav_sub_afericoes);
$c_nav_sub_afericoes = mysqli_fetch_assoc($r_nav_sub_afericoes);
/////////////////////////////////////////
$nav_sub_quadros = "SELECT count(*) as c
FROM url_submenu as usm
LEFT JOIN perfil_permissoes_submenu as ppsm ON ppsm.url_submenu = usm.id
WHERE usm.id = '60' and ppsm.perfil_id = $perfil_id";

$r_nav_sub_quadros = mysqli_query($mysqli, $nav_sub_quadros);
$c_nav_sub_quadros = mysqli_fetch_assoc($r_nav_sub_quadros);
/////////////////////////////////////////
$nav_sub_status_tarefas = "SELECT count(*) as c
FROM url_submenu as usm
LEFT JOIN perfil_permissoes_submenu as ppsm ON ppsm.url_submenu = usm.id
WHERE usm.id = '61' and ppsm.perfil_id = $perfil_id";

$r_nav_sub_status_tarefas = mysqli_query($mysqli, $nav_sub_status_tarefas);
$c_nav_sub_status_tarefas = mysqli_fetch_assoc($r_nav_sub_status_tarefas);
/////////////////////////////////////////
$nav_sub_categoria_subcategoria = "SELECT count(*) as c
FROM url_submenu as usm
LEFT JOIN perfil_permissoes_submenu as ppsm ON ppsm.url_submenu = usm.id
WHERE usm.id = '62' and ppsm.perfil_id = $perfil_id";

$r_nav_sub_categoria_subcategoria = mysqli_query($mysqli, $nav_sub_categoria_subcategoria);
$c_nav_sub_categoria_subcategoria = mysqli_fetch_assoc($r_nav_sub_categoria_subcategoria);
/////////////////////////////////////////

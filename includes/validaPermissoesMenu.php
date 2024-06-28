<?php
/////////////////////////////////////////

//MENU >> CONTRATO
$nav_contrato = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '1'
and
ppm.perfil_id = $perfil_id";

$r_nav_contrato = mysqli_query($mysqli, $nav_contrato);
$c_nav_contrato = mysqli_fetch_assoc($r_nav_contrato);
/////////////////////////////////////////

//MENU >> EMPRESAS
$nav_empresas = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '2'
and
ppm.perfil_id = $perfil_id";

$r_nav_empresas = mysqli_query($mysqli, $nav_empresas);
$c_nav_empresas = mysqli_fetch_assoc($r_nav_empresas);
/////////////////////////////////////////

//MENU >> PESSOAS
$nav_pessoas = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '3'
and
ppm.perfil_id = $perfil_id";

$r_nav_pessoas = mysqli_query($mysqli, $nav_pessoas);
$c_nav_pessoas = mysqli_fetch_assoc($r_nav_pessoas);
/////////////////////////////////////////

//MENU >> PRODUTOS E SERVICOS
$nav_localidades = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '11'
and
ppm.perfil_id = $perfil_id";

$r_nav_localidades = mysqli_query($mysqli, $nav_localidades);
$c_nav_localidades = mysqli_fetch_assoc($r_nav_localidades);
/////////////////////////////////////////

//MENU >> PRODUTOS E SERVICOS
$nav_produtosServicos = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '12'
and
ppm.perfil_id = $perfil_id";

$r_nav_produtosServicos = mysqli_query($mysqli, $nav_produtosServicos);
$c_nav_produtosServicos = mysqli_fetch_assoc($r_nav_produtosServicos);
/////////////////////////////////////////

//MENU >> CHAMADOS
$nav_chamados = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '4'
and
ppm.perfil_id = $perfil_id";

$r_nav_chamados = mysqli_query($mysqli, $nav_chamados);
$c_nav_chamados = mysqli_fetch_assoc($r_nav_chamados);
/////////////////////////////////////////

//MENU >> CHAMADOS PROGRAMADOS
$nav_chamadosProgramados = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '10'
and
ppm.perfil_id = $perfil_id";

$r_nav_chamadosProgramados = mysqli_query($mysqli, $nav_chamadosProgramados);
$c_nav_chamadosProgramados = mysqli_fetch_assoc($r_nav_chamadosProgramados);
/////////////////////////////////////////

//MENU >> INFORMATIVOS
$nav_informativos = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '17'
and
ppm.perfil_id = $perfil_id";

$r_nav_informativos = mysqli_query($mysqli, $nav_informativos);
$c_nav_informativos = mysqli_fetch_assoc($r_nav_informativos);
/////////////////////////////////////////


//MENU >> TIPOS DE CHAMADOS
$nav_tiposChamados = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '9'
and
ppm.perfil_id = $perfil_id";

$r_nav_tiposChamados = mysqli_query($mysqli, $nav_tiposChamados);
$c_nav_tiposChamados = mysqli_fetch_assoc($r_nav_tiposChamados);
/////////////////////////////////////////
$nav_reunioes_atas = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '27'
and
ppm.perfil_id = $perfil_id";

$r_nav_reunioes_atas = mysqli_query($mysqli, $nav_reunioes_atas);
$c_nav_reunioes_atas = mysqli_fetch_assoc($r_nav_reunioes_atas);
/////////////////////////////////////////


//MENU >> GUARDPASS
$nav_guardpass = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '5'
and
ppm.perfil_id = $perfil_id";

$r_nav_guardpass = mysqli_query($mysqli, $nav_guardpass);
$c_nav_guardpass = mysqli_fetch_assoc($r_nav_guardpass);
/////////////////////////////////////////

//MENU >> POP SITE
$nav_popSite = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '6'
and
ppm.perfil_id = $perfil_id";

$r_nav_popSite = mysqli_query($mysqli, $nav_popSite);
$c_nav_popSite = mysqli_fetch_assoc($r_nav_popSite);
/////////////////////////////////////////

//MENU >> EQUIPAMENTOS
$nav_equipamentos = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '7'
and
ppm.perfil_id = $perfil_id";

$r_nav_equipamentos = mysqli_query($mysqli, $nav_equipamentos);
$c_nav_equipamentos = mysqli_fetch_assoc($r_nav_equipamentos);
/////////////////////////////////////////

//MENU >> MAQUINA VIRTUAL
$nav_maquinaVirtual = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '8'
and
ppm.perfil_id = $perfil_id";

$r_nav_maquinaVirtual = mysqli_query($mysqli, $nav_maquinaVirtual);
$c_nav_maquinaVirtual = mysqli_fetch_assoc($r_nav_maquinaVirtual);
/////////////////////////////////////////

//MENU >> REDE NEUTRA
$nav_redeNeutra = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '13'
and
ppm.perfil_id = $perfil_id";

$r_nav_redeNeutra = mysqli_query($mysqli, $nav_redeNeutra);
$c_nav_redeNeutra = mysqli_fetch_assoc($r_nav_redeNeutra);
/////////////////////////////////////////

//MENU >> GERENCIAMENTO
$nav_gerenciamento = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '14'
and
ppm.perfil_id = $perfil_id";

$r_nav_gerenciamento = mysqli_query($mysqli, $nav_gerenciamento);
$c_nav_gerenciamento = mysqli_fetch_assoc($r_nav_gerenciamento);
/////////////////////////////////////////

//MENU >> SISTEMA
$nav_sistema = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '15'
and
ppm.perfil_id = $perfil_id";

$r_nav_sistema = mysqli_query($mysqli, $nav_sistema);
$c_nav_sistema = mysqli_fetch_assoc($r_nav_sistema);
/////////////////////////////////////////

//MENU >> CREDENCIAIS
$nav_credentials = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '16'
and
ppm.perfil_id = $perfil_id";

$r_nav_credentials = mysqli_query($mysqli, $nav_credentials);
$c_nav_credenciais = mysqli_fetch_assoc($r_nav_credentials);
/////////////////////////////////////////

//MENU >> CREDENCIAIS
$nav_documentation = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '18'
and
ppm.perfil_id = $perfil_id";

$r_nav_documentation = mysqli_query($mysqli, $nav_documentation);
$c_nav_documentation = mysqli_fetch_assoc($r_nav_documentation);
/////////////////////////////////////////

//MENU >> RELATÓRIOS
$nav_relatorio = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '19'
and
ppm.perfil_id = $perfil_id";

$r_nav_relatorio = mysqli_query($mysqli, $nav_relatorio);
$c_nav_relatorio = mysqli_fetch_assoc($r_nav_relatorio);

/////////////////////////////////////////

//MENU >> REDE
$nav_rede = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '20'
and
ppm.perfil_id = $perfil_id";

$r_nav_rede = mysqli_query($mysqli, $nav_rede);
$c_nav_rede = mysqli_fetch_assoc($r_nav_rede);

//MENU >> MAN PROGRAMADA
$nav_man_programada = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '21'
and
ppm.perfil_id = $perfil_id";

$r_nav_man_programada = mysqli_query($mysqli, $nav_man_programada);
$c_nav_man_programada = mysqli_fetch_assoc($r_nav_man_programada);

//MENU >> COMUNICACAO
$nav_comunicacao = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '22'
and
ppm.perfil_id = $perfil_id";

$r_comunicacao = mysqli_query($mysqli, $nav_comunicacao);
$c_comunicacao = mysqli_fetch_assoc($r_comunicacao);

//MENU >> INTEGRACAO
$nav_integracao = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '23'
and
ppm.perfil_id = $perfil_id";

$r_nav_integracao = mysqli_query($mysqli, $nav_integracao);
$c_nav_integracao = mysqli_fetch_assoc($r_nav_integracao);
/////////////////////////////////////////

//MENU >> INTEGRACAO
$nav_gerenciamento_api = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '24'
and
ppm.perfil_id = $perfil_id";

$r_nav_gerenciamento_api = mysqli_query($mysqli, $nav_gerenciamento_api);
$c_nav_gerenciamento_api = mysqli_fetch_assoc($r_nav_gerenciamento_api);
/////////////////////////////////////////

//MENU >> COMUNICACAO
$nav_ecommerce = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '25'
and
ppm.perfil_id = $perfil_id";

$r_ecommerce = mysqli_query($mysqli, $nav_ecommerce);
$c_ecommerce = mysqli_fetch_assoc($r_ecommerce);

//MENU >> COMUNICACAO
$nav_tipos_chamados = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '26'
and
ppm.perfil_id = $perfil_id";

$r_tipos_chamados = mysqli_query($mysqli, $nav_tipos_chamados);
$c_tipos_chamados = mysqli_fetch_assoc($r_tipos_chamados);


////////////////////////////////////////////////////////
$nav_diagnosticos = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '28'
and
ppm.perfil_id = $perfil_id";

$r_nav_diagnosticos = mysqli_query($mysqli, $nav_diagnosticos);
$c_nav_diagnosticos = mysqli_fetch_assoc($r_nav_diagnosticos);

////////////////////////////////////////////////////////
$nav_quadros_tarefas = "SELECT
count(*) as c
FROM
url_menu as um
LEFT JOIN
perfil_permissoes_menu as ppm
ON
ppm.url_menu = um.id
WHERE
um.id = '29' 
and
ppm.perfil_id = $perfil_id";

$r_nav_quadros_tarefas = mysqli_query($mysqli, $nav_quadros_tarefas);
$c_nav_quadros_tarefas = mysqli_fetch_assoc($r_nav_quadros_tarefas);

////////////////////////////////////////////////////////

$nav_gerar_faturamento = "SELECT count(*) as c
FROM url_menu as um
LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
WHERE um.id = '31' and ppm.perfil_id = $perfil_id";

$r_nav_gerar_faturamento = mysqli_query($mysqli, $nav_gerar_faturamento);
$c_nav_gerar_faturamento = mysqli_fetch_assoc($r_nav_gerar_faturamento);

////////////////////////////////////////////////////////

$nav_faturamentos_gerados = "SELECT count(*) as c
FROM url_menu as um
LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
WHERE um.id = '32' and ppm.perfil_id = $perfil_id";

$r_nav_faturamentos_gerados = mysqli_query($mysqli, $nav_faturamentos_gerados);
$c_nav_faturamentos_gerados = mysqli_fetch_assoc($r_nav_faturamentos_gerados);

////////////////////////////////////////////////////////

$nav_cobrancas = "SELECT count(*) as c
FROM url_menu as um
LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
WHERE um.id = '33' and ppm.perfil_id = $perfil_id";

$r_nav_cobrancas = mysqli_query($mysqli, $nav_cobrancas);
$c_nav_cobrancas = mysqli_fetch_assoc($r_nav_cobrancas);

////////////////////////////////////////////////////////

$nav_meu_plano = "SELECT count(*) as c
FROM url_menu as um
LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
WHERE um.id = '34' and ppm.perfil_id = $perfil_id";

$r_nav_meu_plano = mysqli_query($mysqli, $nav_meu_plano);
$c_nav_meu_plano = mysqli_fetch_assoc($r_nav_meu_plano);

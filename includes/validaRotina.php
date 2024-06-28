<?php

$valida_CRM =
    "SELECT count(*) as c
    FROM url_menu as um
    LEFT JOIN perfil_permissoes_menu as ppm ON  ppm.url_menu = um.id
    WHERE um.rotina = 'CRM' and ppm.perfil_id = $perfil_id";

$r_valida_CRM = mysqli_query($mysqli, $valida_CRM);
$c_valida_CRM = mysqli_fetch_assoc($r_valida_CRM);

////////////////////////////////////////////////////////////////

$valida_cadastros =
    "SELECT count(*) as c
    FROM url_menu as um
    LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
    WHERE um.rotina = 'CADASTROS' and ppm.perfil_id = $perfil_id";

$r_valida_cadastros = mysqli_query($mysqli, $valida_cadastros);
$c_valida_cadastros = mysqli_fetch_assoc($r_valida_cadastros);

////////////////////////////////////////////////////////////////

$valida_service_desk =
    "SELECT count(*) as c
    FROM url_menu as um
    LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
    WHERE um.rotina = 'SERVICE DESK' and ppm.perfil_id = $perfil_id";

$r_valida_service_desk = mysqli_query($mysqli, $valida_service_desk);
$c_valida_service_desk = mysqli_fetch_assoc($r_valida_service_desk);

////////////////////////////////////////////////////////////////

$valida_telecom =
    "SELECT count(*) as c
    FROM url_menu as um
    LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
    WHERE um.rotina = 'TELECOM' and ppm.perfil_id = $perfil_id";

$r_valida_telecom = mysqli_query($mysqli, $valida_telecom);
$c_valida_telecom = mysqli_fetch_assoc($r_valida_telecom);

////////////////////////////////////////////////////////////////

$valida_administracao =
    "SELECT count(*) as c
    FROM url_menu as um
    LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
    WHERE um.rotina = 'ADMINISTRACAO' and ppm.perfil_id = $perfil_id";

$r_valida_administracao = mysqli_query($mysqli, $valida_administracao);
$c_valida_administracao = mysqli_fetch_assoc($r_valida_administracao);

////////////////////////////////////////////////////////////////

$valida_financeiro =
    "SELECT count(*) as c
    FROM url_menu as um
    LEFT JOIN perfil_permissoes_menu as ppm ON ppm.url_menu = um.id
    WHERE um.rotina = 'FINANCEIRO' and ppm.perfil_id = $perfil_id";

$r_valida_financeiro = mysqli_query($mysqli, $valida_financeiro);
$c_valida_financeiro = mysqli_fetch_assoc($r_valida_financeiro);

////////////////////////////////////////////////////////////////
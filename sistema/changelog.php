<?php
require "../includes/menu.php";
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Changelog</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">

            <div class="accordion" id="accordionExample">

            <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-9" aria-expanded="false" aria-controls="collapse10-9">
                    Versão 10.9 - XX/09/2023
                  </button>
                </h2>
                <div id="collapse10-9" class="accordion-collapse collapse" aria-labelledby="heading10-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a coluna step na tabela comunicacao;<br>
                    # Criado a coluna template_email na tabela comunicacao;<br>

                    <br><strong>Backlog</strong><br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>
                    # Revisar acesso a credenciais;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-8" aria-expanded="false" aria-controls="collapse10-8">
                    Versão 10.8 - 25/09/2023
                  </button>
                </h2>
                <div id="collapse10-8" class="accordion-collapse collapse" aria-labelledby="heading10-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado cadastro de template de notificação via email;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado submenu id 39;<br>
                    # Criado submenu id 40;<br>
                    # Criada coluna created na tabela comunicacao;<br>
                    # Criada tabela comunicacao_templates;<br>
                    # Criada coluna assuntoEmail na tabela comunicacao;<br>

                    <br><strong>Backlog</strong><br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Template de mensagem de e-mail;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>
                    # Revisar acesso a credenciais;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-7" aria-expanded="false" aria-controls="collapse10-7">
                    Versão 10.7 - 22/09/2023
                  </button>
                </h2>
                <div id="collapse10-7" class="accordion-collapse collapse" aria-labelledby="heading10-7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado o menu de cadastro da integração com WR Gateway;<br>
                    # Criado o menu de enviar comunicação;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado o menu id 22;<br>
                    # Editado o submenu id 34;<br>
                    # Criado o submenu id 38;<br>
                    # Criado a tabela integracao_wr_gateway;<br>
                    # Criado a tabela comunicacao;<br>
                    # Criado a tabela comunicacao_destinatarios;<br>
                    # Criado o id 6 na tabela notificacao_email;<br>

                    <br><strong>Backlog</strong><br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Template de mensagem de e-mail;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>
                    # Revisar acesso a credenciais;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-6" aria-expanded="false" aria-controls="collapse10-6">
                    Versão 10.6 - 21/09/2023
                  </button>
                </h2>
                <div id="collapse10-6" class="accordion-collapse collapse" aria-labelledby="heading10-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criar incidente manualmente;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado o submenu id 37;<br>

                    <br><strong>Backlog</strong><br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Notificação de incidentes a interessados;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>
                    # Revisar acesso a credenciais;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-5" aria-expanded="false" aria-controls="collapse10-5">
                    Versão 10.5 - 20/09/2023
                  </button>
                </h2>
                <div id="collapse10-5" class="accordion-collapse collapse" aria-labelledby="heading10-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado o cadastro de manutenção programada;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado o submenu id 36;<br>
                    # Criada a tabela "manutencao_programada";<br>
                    # Criada a tabela "manutencao_gpon";<br>
                    # Criada a tabela "manutencao_rotas_fibra";<br>

                    <br><strong>Backlog</strong><br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Notificação de incidentes a interessados;<br>
                    # Criar incidente manualmente;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>
                    # Revisar acesso a credenciais;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-4" aria-expanded="false" aria-controls="collapse10-4">
                    Versão 10.4 - 16/09/2023
                  </button>
                </h2>
                <div id="collapse10-4" class="accordion-collapse collapse" aria-labelledby="heading10-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Mostrar localidades em incidentes;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criada a coluna pon_id na tabela "incidentes";<br>

                    <br><strong>Backlog</strong><br>
                    # Ver localidades em incidentes;<br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Notificação de incidentes a interessados;<br>
                    # Manutenção programada;<br>
                    # Criar incidente manualmente;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>
                    # Revisar acesso a credenciais;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-0" aria-expanded="false" aria-controls="collapse10-0">
                    Versão 10.3 - 16/09/2023
                  </button>
                </h2>
                <div id="collapse10-0" class="accordion-collapse collapse" aria-labelledby="heading10-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Ajustes na API de receber incidentes (preencher slot e pon);<br>
                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a coluna "gpon_slot" e "gpon_pon" na tabela "incidentes";<br>

                    <br><strong>Backlog</strong><br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Notificação de incidentes a interessados;<br>
                    # Manutenção programada;<br>
                    # Criar incidente manualmente;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>
                    # Revisar acesso a credenciais;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-0" aria-expanded="false" aria-controls="collapse10-0">
                    Versão 10.2 - 15/09/2023
                  </button>
                </h2>
                <div id="collapse10-0" class="accordion-collapse collapse" aria-labelledby="heading10-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Cadastro de localidade na PON;<br>
                    # Edição descrição incidente;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado o id "21" na tabela "menu";<br>
                    # Criada a tabela gpon_localidades;<br>

                    <br><strong>Backlog</strong><br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Notificação de incidentes a interessados;<br>
                    # Manutenção programada;<br>
                    # Criar incidente manualmente;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>
                    # Revisar acesso a credenciais;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-0" aria-expanded="false" aria-controls="collapse10-0">
                    Versão 10.1 - 15/09/2023
                  </button>
                </h2>
                <div id="collapse10-0" class="accordion-collapse collapse" aria-labelledby="heading10-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Cadastro de PON;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado o id 34 na tabela "url_submenu";<br>
                    # Criado a tabela gpon_pon;<br>

                    <br><strong>Backlog</strong><br>
                    # Recriar a pagina index e view de chamados;<br>
                    # Cadastro de bairro nas PONs;<br>
                    # Notificação de incidentes a interessados;<br>
                    # Manutenção programada;<br>
                    # Criar incidente manualmente;<br>
                    # Criar dashboards;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Invite Usuários;<br>

                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10-0" aria-expanded="false" aria-controls="collapse10-0">
                    Versão 10.0 - 13/09/2023
                  </button>
                </h2>
                <div id="collapse10-0" class="accordion-collapse collapse" aria-labelledby="heading10-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Adrquado a criação de usuário;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Removido a obrigatoriedada "tipo_usuario" e "notify_email" da tabela "usuarios";<br>
                    # Definica a coluna "dashboard" como obrigatória na tabela "usuarios";<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro GPON PON;<br>
                    # Adequação a criação de usuário;<br>
                    # Notificação de incidentes a interessados;<br>
                    # Manutenção programada;<br>
                    # Criar incidente manualmente;<br>
                    # Criar dashboards;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-9" aria-expanded="false" aria-controls="collapse9-9">
                    Versão 9.9 - 13/09/2023
                  </button>
                </h2>
                <div id="collapse9-9" class="accordion-collapse collapse" aria-labelledby="heading9-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Desenvolvido o método de bloqueio de páginas sem autorização.<br>
                    # Criado a tab "Notificação" em empresas;<br>
                    # Criado o "interessados" em rotas de fibra;<br>
                    # Adequado para gerenciar incidentes através de permissão;<br>
                    # Cadastro GPON OLT;<br>
                    # Interessados GPON OLT;<br>
                    # Adequado incidentes abertos e normalizados;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a tabela "empresas_notificacao"; <br>
                    # Criado a tabela "rotas_fibras_interessados";<br>
                    # Adicionado a coluna "permissao_gerenciar_incidentes" e "dashboard" na tabela "usuarios";<br>
                    # Criado o submenu id 32 "GPON";<br>
                    # Renomeada a tabela "redeneutra_olts" para "gpon_olts" e editado colunas;<br>
                    # Criado a tabela "gpon_olts_interessados";<br>
                    # Editado o submenu id 22 para "Incidentes Abertos";<br>
                    # Criado o submenu id 33;<br>

                    <br><strong>Backlog</strong><br>
                    # Listagem de incidentes somente para interessados;<br>
                    # Cadastro GPON PON;<br>
                    # Adequação a criação de usuário;<br>
                    # Notificação de incidentes a interessados;<br>
                    # Manutenção programada;<br>
                    # Criar incidente manualmente;<br>
                    # Criar dashboards;<br>
                    # Não permitir editar tipos de equipamentos default;<br>
                    # Abertura de chamado através de incidentes;<br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-8" aria-expanded="false" aria-controls="collapse9-8">
                    Versão 9.8 - 04/09/2023
                  </button>
                </h2>
                <div id="collapse9-8" class="accordion-collapse collapse" aria-labelledby="heading9-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Adicionado a opção "Sem Previsão" na atualização de incidentes;<br>
                    # Integrado com zabbix para reconhecimento e relato de incidentes;<br>
                    # Melhorias em incidentes abertos e fechados;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Submenu Integração Zabbix;<br>
                    # Definido o tipo de incidente "backbone" como default id 102;<br>

                    <br><strong>Backlog</strong><br>
                    # Abertura de chamado através de incidentes;<br>
                    # Notificação de incidentes;<br>
                    # Relato em incidentes sobre updates;<br>
                    # Dados de contado técnico de parceiros para notificação;<br>
                    # Interessados em rotas de fibra; <br>
                    # Vincular uma documentação à um tipo de incidente;<br>
                    # Reboot de ONU 17/08/2023;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-7" aria-expanded="false" aria-controls="collapse9-7">
                    Versão 9.7 - 31/08/2023
                  </button>
                </h2>
                <div id="collapse9-7" class="accordion-collapse collapse" aria-labelledby="heading9-7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Cadastro de rotas e coordenadas;<br>
                    # Melhoria na visualizaç~so de incidentes abertos;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Adicionado o menu "Rede" na tabela "url_menu";<br>
                    # Adicionado o submenu "Rotas de Fibra" na tabela "url_submenu";<br>
                    # Criada a tabela rotas_fibras;<br>
                    # Criada a tabela rotas_fibras_coordenadas;<br>
                    # Adicionado a coluna "color" na tabela "incidentes_classificacao"<br>

                    <br><strong>Backlog</strong><br>
                    # Reboot de ONU 17/08/2023;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-6" aria-expanded="false" aria-controls="collapse9-6">
                    Versão 9.6 - 30/08/2023
                  </button>
                </h2>
                <div id="collapse9-6" class="accordion-collapse collapse" aria-labelledby="heading9-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Ajustado para a correlação do equipamento ocorrer através do ID e não do IP na geração de incidente.<br>
                    # Criado o tipo de incidente;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a tabela "incidentes_types";<br>
                    # Adicionado a coluna "incident_type" na tabela "incidentes";<br>

                    <br><strong>Backlog</strong><br>
                    # Reboot de ONU 17/08/2023;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                  </div>
                </div>
              </div>


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-5" aria-expanded="false" aria-controls="collapse9-5">
                    Versão 9.5 - 21/07/2023
                  </button>
                </h2>
                <div id="collapse9-5" class="accordion-collapse collapse" aria-labelledby="heading9-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado vinculo de chamados com melhorias recomendadas;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criada a coluna melhoria_recomendada em chamados;<br>

                    <br><strong>Backlog</strong><br>
                    # Reboot de ONU 17/08/2023;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-4" aria-expanded="false" aria-controls="collapse9-4">
                    Versão 9.4 - 19/07/2023
                  </button>
                </h2>
                <div id="collapse9-4" class="accordion-collapse collapse" aria-labelledby="heading9-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado prioridade de chamados;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a coluna prioridades em chamados;<br>

                    <br><strong>Backlog</strong><br>
                    # Reboot de ONU 17/08/2023;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-3" aria-expanded="false" aria-controls="collapse9-3">
                    Versão 9.3 - 19/07/2023
                  </button>
                </h2>
                <div id="collapse9-3" class="accordion-collapse collapse" aria-labelledby="heading9-3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Cancelar um relato em execução;<br>
                    # Ficar o que foi filtrado em Descrição em Portal;<br>
                    # Editar consulta sql e excluir/inativar;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a coluna permissao_configuracoes_chamados na tabela usuarios;<br>

                    <br><strong>Backlog</strong><br>
                    # Reboot de ONU 17/08/2023;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-2" aria-expanded="false" aria-controls="collapse9-2">
                    Versão 9.2 - 18/07/2023
                  </button>
                </h2>
                <div id="collapse9-2" class="accordion-collapse collapse" aria-labelledby="heading9-2" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Permissao de mudar permissão de acesso a vm/equipamento por usuario;<br>
                    # Não permitir cadastrar baterias com numero de serie duplicado;<br>
                    # Organizar imagens por data;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a coluna permissao_privacidade_credenciais na tabela usuarios;<br>
                    # Definido a coluna n_serie como UQ na tabela produtos_bateria_units;<br>
                    # Criado o diretório uploads/pop/ (mover imagens atuais, inclusive criando subpasta com a data);<br>

                    <br><strong>Backlog</strong><br>
                    # Reboot de ONU 17/08/2023;<br>
                    # Cancelar um relato em execução;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Ficar o que foi filtrado em Descrição em Portal;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-1" aria-expanded="false" aria-controls="collapse9-1">
                    Versão 9.1 - 14/07/2023
                  </button>
                </h2>
                <div id="collapse9-1" class="accordion-collapse collapse" aria-labelledby="heading9-1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Filtro chamado sem atendente;<br>
                    # FIltro chamados com atendentes;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Backlog</strong><br>
                    # Reboot de ONU 17/08/2023;<br>
                    # Organizar imagens por data;<br>
                    # Permissao de mudar permissão de acesso a vm/equipamento por usuario;<br>
                    # Não permitir cadastrar baterias com numero de serie duplicado;<br>
                    # Demora para executar chamado;<br>
                    # Cancelar um relato em execução;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Ficar o que foi filtrado em Descrição em Portal;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9-0" aria-expanded="false" aria-controls="collapse9-0">
                    Versão 9.0 - 14/07/2023
                  </button>
                </h2>
                <div id="collapse9-0" class="accordion-collapse collapse" aria-labelledby="heading9-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Adicionar bateria a POP;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a tabela pop_baterias_in_use;<br>
                    # Excluido a coluna disponibilidade da tabela produtos_bateria_units;<br>

                    <br><strong>Backlog</strong><br>
                    # Permissao de mudar permissão de acesso a vm/equipamento por usuario;<br>
                    # Não permitir cadastrar baterias com numero de serie duplicado;<br>
                    # Demora para executar chamado;<br>
                    # Cancelar um relato em execução;<br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Filtro chamado sem atendente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Ficar o que foi filtrado em Descrição em Portal;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-9" aria-expanded="false" aria-controls="collapse8-9">
                    Versão 8.9 - 13/07/2023
                  </button>
                </h2>
                <div id="collapse8-9" class="accordion-collapse collapse" aria-labelledby="heading8-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Cadastro de atividades conhecidas;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Adicionado coluna status na tabela pop_melhorias_conhecidas;<br>
                    # Adicionado coluna criado na tabela pop_melhorias_conhecidas;<br>
                    # Adicionado coluna usuario_criador na tabela pop_melhorias_conhecidas;<br>

                    <br><strong>Backlog</strong><br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Filtro chamado sem atendente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Ficar o que foi filtrado em Descrição em Portal;<br>
                    # Cancelar um relato em execução;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-8" aria-expanded="false" aria-controls="collapse8-8">
                    Versão 8.8 - 11/07/2023
                  </button>
                </h2>
                <div id="collapse8-8" class="accordion-collapse collapse" aria-labelledby="heading8-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # TAB Agenda/Melhorias conhecidas em POPs;<br>
                    # Apagar upload de anexo/POPs;<br>
                    # Privacidade na visualização de Equipamento;<br>
                    # Privacidade na visualização de VM;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado tabela pop_atividade_programada;<br>
                    # Criado tabela pop_melhorias_conhecidas;<br>
                    # Adicionado a coluna privacidade em equipamentospop;<br>
                    # Adicionado a coluna usuario_criador em equipamentospop;<br>
                    # Adicionado a coluna privacidade em vms;<br>
                    # Adicionado a coluna usuario_criador em vms;<br>
                    # Preencher por default o pravidade equipamento = 1;<br>
                    # Preencher por defaul usuario_criados um administrador;<br>
                    # Criado tabela equipamentos_pop_privacidade_equipe;<br>
                    # Criado tabela equipamentos_pop_privacidade_usuario;<br>
                    # Criado tabela vm_privacidade_equipe;<br>
                    # Criado tabela vm_privacidade_usuario;<br>

                    <br><strong>Backlog</strong><br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Filtro chamado sem atendente;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Ficar o que foi filtrado em Descrição em Portal;<br>
                    # Cancelar um relato em execução;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-7" aria-expanded="false" aria-controls="collapse8-7">
                    Versão 8.7 - 08/07/2023
                  </button>
                </h2>
                <div id="collapse8-7" class="accordion-collapse collapse" aria-labelledby="heading8-7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Relatório em PDF de Chamado;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado atributo "atributoEmpresaPrincipal" na tabela "empresas";
                    # Criado a coluna "site" na tabela "empresa";

                    <br><strong>Backlog</strong><br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # TAB Agenda/Melhorias conhecidas em POPs;<br>
                    # Filtro chamado sem atendente;<br>
                    # Apagar upload de anexo/POPs;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Ficar o que foi filtrado em Descrição em Portal;<br>
                    # Cancelar um relato em execução;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-6" aria-expanded="false" aria-controls="collapse8-6">
                    Versão 8.6 - 07/07/2023
                  </button>
                </h2>
                <div id="collapse8-6" class="accordion-collapse collapse" aria-labelledby="heading8-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Gerador de formulário para vistoria de POP;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Backlog</strong><br>
                    # Não esta listando os tipos de chamados de acordo com permissão do usuario;<br>
                    # Atributo empresa principal;<br>
                    # Apagar upload de anexo/POPs;<br>
                    # Controlar espaço em disco em anexo/POPs;<br>
                    # Ficar o que foi filtrado em Descrição em Portal;<br>
                    # Cancelar um relato em execução;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-5" aria-expanded="false" aria-controls="collapse8-5">
                    Versão 8.5 - 07/07/2023
                  </button>
                </h2>
                <div id="collapse8-5" class="accordion-collapse collapse" aria-labelledby="heading8-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Anexo de imagens em POPs;<br>
                    # Permitir usuário selecionar solicitante na abertura do chamado;<br>
                    # Permitir usuário selecionar atendente na abertura do chamado;<br>
                    # Fechar o modal cadastro de pessoa após cadastrar nova pessoa;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a coluna "permissao_selecionar_solicitante" na tabela "usuarios";<br>
                    # Criado a coluna "permissao_selecionar_atendente" na tabela "usuarios";<br>
                    # Excluido a coluna "permite_atendente_abertura" na tabela "tipos_chamados";<br>


                    <br><strong>Backlog</strong><br>
                    # Cancelar um relato em execução;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>



              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-4" aria-expanded="false" aria-controls="collapse8-4">
                    Versão 8.4 - 06/07/2023
                  </button>
                </h2>
                <div id="collapse8-4" class="accordion-collapse collapse" aria-labelledby="heading8-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Obrigar colocar data de conclusão quando exigida pelo chamado;<br>
                    # Em credenciais, aparecer inclusive os inativados na consulta inicial;<br>
                    # Redirecionar para senha de depois de cadastrar credencial portal;<br>
                    # Notificação quando chamado entra em execução;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Backlog</strong><br>
                    # Permitir usuário selecionar solicitante na abertura do chamado;<br>
                    # Permitir no tipo de chamado selecionar solicitante na abertura do chamado;<br>
                    # Permitir usuário selecionar atendente na abertura do chamado;<br>
                    # Cancelar um relato em execução;<br>
                    # Fechar o modal cadastro de pessoa após cadastrar nova pessoa;<br>
                    # Revisão geral no cadastro de usuário e invites;<br>
                    # Envio de sugestões;<br>
                    # Solicitante Cliente especificar para quando quer pronto um chamado;<br>
                    # Solicitante Tenant especificar para quando quer pronto um chamado;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>


              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-3" aria-expanded="false" aria-controls="collapse8-3">
                    Versão 8.3 - 06/07/2023
                  </button>
                </h2>
                <div id="collapse8-3" class="accordion-collapse collapse" aria-labelledby="heading8-3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Configurações de notify_email_encaminhamento;<br>
                    # Configurações de notify_email_relatos;<br>
                    # Configurações de notify_email_apropriacao;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Backlog</strong><br>
                    # Permitir selecionar solicitante na abertura do chamado;<br>
                    # Permitir selecionar atendente na abertura do chamado;<br>
                    # Cancelar um relato em execução;<br>
                    # Fechar o modal cadastro de pessoa após cadastrar nova pessoa;<br>
                    # Envio de sugestões;<br>
                    # Em credenciais, aparecer inclusive os inativados na consulta inicial;<br>
                    # Configurações especificas de notificação por e-mail;<br>
                    # Solicitante Cliente especificar para quando quer pronto um chamado;<br>
                    # Solicitante Tenant especificar para quando quer pronto um chamado;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Redirecionar para senha de depois de cadastrar credencial portal;<br>
                    # Não aparecer para selecionar perfil se usuario não é do tipo smart;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-2" aria-expanded="false" aria-controls="collapse8-2">
                    Versão 8.2 - 06/07/2023
                  </button>
                </h2>
                <div id="collapse8-2" class="accordion-collapse collapse" aria-labelledby="heading8-2" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado permissões personalizadas de envio de e-mail para usuário;<br>
                    # Não permitir mais de uma equipe por usuário;<br>
                    # BUG ao vincular POP a Empresa;<br>
                    # Link para chamados na dashboard;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a coluna "notify_email_abertura" na tabela usuarios;<br>
                    # Criado a coluna "notify_email_encaminhamento" na tabela usuarios;<br>
                    # Criado a coluna "notify_email_relatos" na tabela usuarios;<br>
                    # Criado a coluna "notify_email_apropriacao" na tabela usuarios;<br>

                    <br><strong>Backlog</strong><br>
                    # Cancelar um relato em execução;<br>
                    # Fechar o modal cadastro de pessoa após cadastrar nova pessoa;<br>
                    # Envio de sugestões;<br>

                    # Em credenciais, aparecer inclusive os inativados na consulta inicial;<br>
                    # Configurações especificas de notificação por e-mail;<br>
                    # Solicitante Cliente especificar para quando quer pronto um chamado;<br>
                    # Solicitante Tenant especificar para quando quer pronto um chamado;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Redirecionar para senha de depois de cadastrar credencial portal;<br>
                    # Não aparecer para selecionar perfil se usuario não é do tipo smart;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 8.1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-1" aria-expanded="false" aria-controls="collapse8-1">
                    Versão 8.1 - 04/07/2023
                  </button>
                </h2>
                <div id="collapse8-1" class="accordion-collapse collapse" aria-labelledby="heading8-1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Melhoria na cor do relógio dos chamados;<br>
                    # Melhoria na cor da data prevista de normalização;<br>
                    # Melhoria na apresentação do nome do atendente;<br>
                    # Correção na geração de invite para novos usuários;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Backlog</strong><br>
                    # Não permitir mais de uma equipe por usuário;<br>
                    # Cancelar um relato em execução;<br>
                    # Fechar o modal cadastro de pessoa após cadastrar nova pessoa;<br>
                    # BUG ao vincular POP a Empresa;<br>
                    # Envio de sugestões;<br>
                    # Link para meus chamados na dashboard;<br>
                    # Em credenciais, aparecer inclusive os inativados na consulta inicial;<br>
                    # Configurações especificas de notificação por e-mail;<br>
                    # Solicitante Cliente especificar para quando quer pronto um chamado;<br>
                    # Solicitante Tenant especificar para quando quer pronto um chamado;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Redirecionar para senha de depois de cadastrar credencial portal;<br>
                    # Não aparecer para selecionar perfil se usuario não é do tipo smart;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 8.0 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8-0" aria-expanded="false" aria-controls="collapse8-0">
                    Versão 8.0 - 04/07/2023
                  </button>
                </h2>
                <div id="collapse8-0" class="accordion-collapse collapse" aria-labelledby="heading8-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # BUG Cor chamados abertos;<br>
                    # Data e hora no relato;<br>
                    # Usuário smart pode ou não se apropriar de chamado;<br>
                    # Usuário smart pode ou não encaminhar chamados;<br>
                    # Usuário smart pode ou não incluir/remover interessados ao chamado;<br>
                    # Usuário smart pode ou não abrir chamados para outras empresas;<br>
                    # Usuário smart pode ou não marcar competencias;<br>
                    # Mostrar data de conclusão esperada;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado as colunas "permissao_selecionar_competencias", "permissao_abrir_chamado", "permissao_apropriar_chamado", "permissao_encaminhar_chamado", "permissao_interessados_chamados" na tabela "usuarios";

                    <br><strong>Backlog</strong><br>
                    # Não permitir mais de uma equipe por usuário;<br>
                    # Solicitante Cliente especificar para quando quer pronto um chamado;<br>
                    # Solicitante Tenant especificar para quando quer pronto um chamado;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Redirecionar para senha de depois de cadastrar credencial portal;<br>
                    # Não aparecer para selecionar perfil se usuario não é do tipo smart;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 7.9 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-9" aria-expanded="false" aria-controls="collapse7-9">
                    Versão 7.9 - 03/07/2023
                  </button>
                </h2>
                <div id="collapse7-9" class="accordion-collapse collapse" aria-labelledby="heading7-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Solicitante Smart especificar para quando quer pronto um chamado;<br>
                    # Usuário smart pode marcar atendente na abertura de um chamado;<br>
                    # Dashboard personalizada de acordo com permissões de chamados;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criada a coluna data_prevista_conclusao na tabela chamados;<br>

                    <br><strong>Backlog</strong><br>
                    # Perfil errado na criação de usuario via invite;<br>
                    # Usuário smart pode ou não se apropriar de chamado;<br>
                    # Usuário smart pode ou não abrir chamados para outras empresas;<br>
                    # Usuário smart pode ou não encaminhar chamados;<br>
                    # BUG Cor chamados abertos;<br>
                    # Solicitante Cliente especificar para quando quer pronto um chamado;<br>
                    # Solicitante Tenant especificar para quando quer pronto um chamado;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Redirecionar para senha de depois de cadastrar credencial portal;<br>
                    # Não aparecer para selecionar perfil se usuario não é do tipo smart;<br>
                    # Selecionar publico ou privado no relato avulso;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>


              <!-- Versão 7.8 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-8" aria-expanded="false" aria-controls="collapse7-8">
                    Versão 7.8 - 30/06/2023
                  </button>
                </h2>
                <div id="collapse7-8" class="accordion-collapse collapse" aria-labelledby="heading7-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Ativar/Desativar notificação E-mail pelo 'Meu Profile';<br>
                    # Não aparecer para gerenciar interessados se o chamado estiver encerrado;<br>
                    # Aparecer "Sem Atendente" no filtro de listagem de chamados;<br>
                    # Visualizações de chamados por empresa ou por equipe;<br>
                    # Abertura de chamados por empresa ou por equipe;<br>
                    # Relatar no chamado mesmo sem estar apropriado;<br>
                    # Permissão no tipo de protocolo para selecionar atendente na abertura e colocar data de entrega;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a coluna 'permissao_visualiza_chamado' na tabela 'usuarios';<br>
                    # Criado as colunas 'permite_atendente_abertura', 'permite_data_entrega' e 'horas_prazo_entrega' na tabela 'tipos_chamados';<br>

                    <br><strong>Backlog</strong><br>
                    # Perfil errado na criação de usuario via invite;<br>
                    # Solicitante especificar para quando quer pronto um chamado;<br>
                    # Marcar atendente na abertura de um chamado;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Dashboard personalizada de acordo com permissões de chamados;<br>
                    # Redirecionar para senha de depois de cadastrar credencial portal;<br>

                    # Editar consulta sql e excluir/inativar;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>


              <!-- Versão 7.7 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-7" aria-expanded="false" aria-controls="collapse7-7">
                    Versão 7.7 - 29/06/2023
                  </button>
                </h2>
                <div id="collapse7-7" class="accordion-collapse collapse" aria-labelledby="heading7-7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Invite para novos usuários;<br>
                    # Interessado receber email quando for adicionado a um chamado;<br>
                    # Redirecionar para chamado após abertura;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Adicionado coluna permissao_chamado na tabela usuarios;<br>
                    # Criado a tabela usuario_invite;<br>
                    # Criado a tabela usuario_invite_accept;<br>
                    # Criado o servermail default com id 1000;<br>

                    <br><strong>Backlog</strong><br>
                    # Perfil errado na criação de usuario via invite;<br>
                    # Seleção no cadastro de usuario de tipos de chamados que pode abrir "apenas por equipe", "apenas por empresa", "todos".
                    # Solicitante especificar para quando quer pronto um chamado;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do cliente/tenent:<br>

                    # Aparecer "Sem Atendente" no filtro de listagem de chamados;<br>
                    # Não aparecer para gerenciar interessados se o chamado estiver encerrado;<br>
                    # Editar consulta sql e excluir/inativar;<br>
                    # Relatar no chamado mesmo sem estar apropriado;<br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Energia POP;<br>
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Dependencia de chamados;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 7.6 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-6" aria-expanded="false" aria-controls="collapse7-6">
                    Versão 7.6 - 26/06/2023
                  </button>
                </h2>
                <div id="collapse7-6" class="accordion-collapse collapse" aria-labelledby="heading7-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado cadastro de bateria;<br>
                    # Remodelado cadastro de equipamentos;<br>
                    # Removido uploads de equipamentos;<br>
                    # Cadastro de Transceiver;<br>
                    # Envio de email para interessados de chamados;<br>
                    # Cadastro de unidades de baterias, componentes e transceiver;<br>
                    # Cadastro de Componentes;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Excluido a coluna rack e tamanho da tabela equipamentos;<br>
                    # Criado a tabela produtos_bateria;<br>
                    # Criado a tabela produtos_transceiver;<br>
                    # Criado a tabela produtos_componentes;<br>
                    # Criado tabela chamados_interessados;<br>
                    # Criado tabela produtos_transceiver_units;<br>
                    # Criado tabela produtos_bateria_units;<br>
                    # Criado tabela produtos_componente_units;<br>

                    <br><strong>Backlog</strong><br>
                    # Editar unidades de produtos e ver histórico de uso;<br>
                    # Invite para criação de usuário;<br>
                    # Energia POP;<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Interessado receber email quando for adicionado a um chamado;<br>
                    # Seleção no cadastro de usuario de tipos de chamados que pode abrir "apenas por equipe", "apenas por empresa", "todos".
                    # Atributos de equipamentos;<br>
                    # Cadastro de PONs;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>
                    # Cadastro de rotas de rede de fibra;<br>
                    # Solicitante especificar para quando quer pronto um chamado;<br>
                    # Check-list chamados;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do cliente/tenent:<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 7.5 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-5" aria-expanded="false" aria-controls="collapse7-5">
                    Versão 7.5 - 22/06/2023
                  </button>
                </h2>
                <div id="collapse7-5" class="accordion-collapse collapse" aria-labelledby="heading7-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Ajuste para não enviar e-mail para usuarios com notificação desabilitada;<br>
                    # Cadastro consultas SQL;<br>
                    # Download resultado de consultas SQL;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a tabela "consultas_sql";<br>
                    # Criado o id 19 na tabela menu;<br>
                    # Criado o submenu 28 e 29 na tabela submenu;<br>

                    <br><strong>Backlog</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do cliente/tenent:<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Atributos de equipamentos;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 7.4 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-4" aria-expanded="false" aria-controls="collapse7-4">
                    Versão 7.4 - 18/06/2023
                  </button>
                </h2>
                <div id="collapse7-4" class="accordion-collapse collapse" aria-labelledby="heading7-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Corrigido BUG para editar credenciais de portal;<br>
                    # Criação de documentação;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a tabela "documentation";<br>
                    # Criado o id 18 na tabela "url_menu";

                    <br><strong>Backlog</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Permissões em documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do cliente/tenent:<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 7.3 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-3" aria-expanded="false" aria-controls="collapse7-3">
                    Versão 7.3 - 13/06/2023
                  </button>
                </h2>
                <div id="collapse7-3" class="accordion-collapse collapse" aria-labelledby="heading7-3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Envio de e-mail quando cliente realiza um relato;<br>
                    # Envio de e-mail quando tenant realiza um relato;<br>
                    # Envio de e-mail quando um tenant ou cliente abre um chamado;<br>
                    # Solicitação plantão pelo acesso colaborador;<br>
                    # Info Funcionário (Horário de trabalho, gestor);<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a tabela "colaborador_request_plantao";<br>
                    # Criado a tabela "colaborador_horario";<br>
                    # Criado a tabela "colaborador_gerencia";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do cliente/tenent:<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Requisições de expediente atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 7.2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-2" aria-expanded="false" aria-controls="collapse7-2">
                    Versão 7.2 - 09/06/2023
                  </button>
                </h2>
                <div id="collapse7-2" class="accordion-collapse collapse" aria-labelledby="heading7-2" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Integração com Zabbix para abertura de chamados;<br>
                    # Botão para capturar summary-info de um incidente;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do usuário:<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Relatar em chamado já existente ao invés de abrir outro via integração Zabbix;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Info Funcionário (Horário de trabalho, disponibilidade férias, gestor, disponibilidade banco de horas, plantão);<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Solicitação de hora extra, férias, atestado, folga, ausencia atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 7.1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-1" aria-expanded="false" aria-controls="collapse7-1">
                    Versão 7.1 - 07/06/2023
                  </button>
                </h2>
                <div id="collapse7-1" class="accordion-collapse collapse" aria-labelledby="heading7-1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado documentação de API;<br>
                    # Adequado script's de envio de e-mail para POST;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado o submenu API com o id 27 na tabela submenu;<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do usuário:<br>
                    # Resetar senha pelo acesso usuário;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Info Funcionário (Horário de trabalho, disponibilidade férias, gestor, disponibilidade banco de horas, plantão);<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Solicitação de hora extra, férias, atestado, folga, ausencia atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 7.0 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7-0" aria-expanded="false" aria-controls="collapse7-0">
                    Versão 7.0 - 06/06/2023
                  </button>
                </h2>
                <div id="collapse7-0" class="accordion-collapse collapse" aria-labelledby="heading7-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Envio de e-mail na apropriação de chamado;<br>
                    # Ajuste no envio de email de ralato, alterado de GET para POST;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado notificação ID "4";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do usuário:<br>
                    # Resetar senha pelo acesso usuário;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Info Funcionário (Horário de trabalho, disponibilidade férias, gestor, disponibilidade banco de horas, plantão);<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Solicitação de hora extra, férias, atestado, folga, ausencia atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 6.9 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-9" aria-expanded="false" aria-controls="collapse6-9">
                    Versão 6.9 - 02/06/2023
                  </button>
                </h2>
                <div id="collapse6-9" class="accordion-collapse collapse" aria-labelledby="heading6-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Envio de e-mail no relato de chamado;<br>
                    # Envio de e-mail no encaminhamento de chamado;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Adicionado id "3" na tabela "notificacao_email";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do usuário:<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Envio de e-mail na apropriação de chamado;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Info Funcionário (Horário de trabalho, disponibilidade férias, gestor, disponibilidade banco de horas, plantão);<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Solicitação de hora extra, férias, atestado, folga, ausencia atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 6.8 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-8" aria-expanded="false" aria-controls="collapse6-8">
                    Versão 6.8 - 28/05/2023
                  </button>
                </h2>
                <div id="collapse6-8" class="accordion-collapse collapse" aria-labelledby="heading6-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Envio de e-mail na abertura de protocolo p/ usuarios com competencia de eecução;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a tabela "servermail";<br>
                    # Criado a tabela "notificacao_email";<br>
                    # Adicionado coluna "notify_email" na tabela "usuarios";<br>
                    # Adicionado o submenu "configurações" na tabela submenu;<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>
                    # Ativar/Desativar notificação E-mail pelo acesso do usuário:<br>
                    # Resetar senha pelo acesso usuário;<br>
                    # Envio de e-mail no encaminhamento de chamado;<br>
                    # Envio de e-mail na apropriação de chamado;<br>
                    # Envio de e-mail no relato de chamado;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Info Funcionário (Horário de trabalho, disponibilidade férias, gestor, disponibilidade banco de horas, plantão);<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Solicitação de hora extra, férias, atestado, folga, ausencia atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 6.7 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-6" aria-expanded="false" aria-controls="collapse6-6">
                    Versão 6.7 - 25/05/2023
                  </button>
                </h2>
                <div id="collapse6-6" class="accordion-collapse collapse" aria-labelledby="heading6-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Botão adicionar competência no chamado;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Info Funcionário (Horário de trabalho, disponibilidade férias, gestor, disponibilidade banco de horas, plantão);<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Solicitação de hora extra, férias, atestado, folga, ausencia atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 6.6 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-6" aria-expanded="false" aria-controls="collapse6-6">
                    Versão 6.6 - 25/05/2023
                  </button>
                </h2>
                <div id="collapse6-6" class="accordion-collapse collapse" aria-labelledby="heading6-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Competencia na abertura de chamado;<br>
                    # Cruzamento competencia de chamado com competencia de usuario;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado a tabela "chamados_competencias";

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Adequação incidentes cliente;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Info Funcionário (Horário de trabalho, disponibilidade férias, gestor, disponibilidade banco de horas, plantão);<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Solicitação de hora extra, férias, atestado, folga, ausencia atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>



              <!-- Versão 6.5 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-5" aria-expanded="false" aria-controls="collapse6-5">
                    Versão 6.5 - 24/05/2023
                  </button>
                </h2>
                <div id="collapse6-5" class="accordion-collapse collapse" aria-labelledby="heading6-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Cadastro de competencia;<br>
                    # Competencia por usuários;<br>
                    # Corrigido listagem de parceiros em ativação de Rede Neutra;<br>
                    # Competencia default de chamados;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado o submenu competencias na tabela "url_submenu";<br>
                    # Criado tabela "competencias";<br>
                    # Criado tabela "usuario_competencia";<br>
                    # Criado tabela "tipo_chamado_competencia";<br>
                    # Alterado o nome da tabela "chamados_autorizados" para "chamados_autorizados_by_equipe";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Adequação incidentes cliente.;<br>
                    # Adequação incidentes tenant;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Competencia na abertura de chamado;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Menu documentações;<br>
                    # Cruzamento competencia de chamado com competencia de usuario;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>
                    # Info Funcionário (Horário de trabalho, disponibilidade férias, gestor, disponibilidade banco de horas, plantão);<br>
                    # Alerta de contato com plantão na abertura de chamado quando chamado aberto fora de horário;<br>
                    # Solicitação de hora extra, férias, atestado, folga, ausencia atraves do acesso colaborador;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 6.4 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-4" aria-expanded="false" aria-controls="collapse6-4">
                    Versão 6.4 - 23/05/2023
                  </button>
                </h2>
                <div id="collapse6-4" class="accordion-collapse collapse" aria-labelledby="heading6-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Alterar senha após primeiro login;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Separar incidentes smart, cliente e tenant. Smart esta pronto;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Cadastro de competencia;<br>
                    # Competencia por usuários;<br>
                    # Competencia por protocolo;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 6.3 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-3" aria-expanded="false" aria-controls="collapse6-3">
                    Versão 6.3 - 22/05/2023
                  </button>
                </h2>
                <div id="collapse6-3" class="accordion-collapse collapse" aria-labelledby="heading6-3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Alertas de erro de login;<br>
                    # Incidentes Normalizados Tenant;<br>
                    # Selecão de tipos de chamados para Tenant;<br>
                    # Selecão de tipos de chamados para Cliente;<br>
                    # Tipos de Chamados vinculados a empresa;<br>
                    # Não limpar dados form em novo chamado caso o usuario esqueceu de preencher algum campo;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Excluido os id da tabela sub-menu (12); <br>
                    # Excluido os id's da tabela menu (5, 7, 8);<br>
                    # Criado tabela "chamados_autorizados_by_company";<br>
                    # Criado a coluna "reset_password" na tabela "usuarios";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Separar incidentes smart, cliente e tenant. Smart esta pronto;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Cadastro de competencia;<br>
                    # Competencia por usuários;<br>
                    # Competencia por protocolo;<br>
                    # Anexo arquivos em chamados;<br>
                    # Anexo arquivos em vistorias;<br>
                    # Alterar senha após primeiro login;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>
                    # Pautas e ATAs de Reunião;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 6.2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-2" aria-expanded="false" aria-controls="collapse6-2">
                    Versão 6.2 - 21/05/2023
                  </button>
                </h2>
                <div id="collapse6-2" class="accordion-collapse collapse" aria-labelledby="heading6-2" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Type 3 - Testar relato publico;<br>
                    # Type 3 - Testar relato privado;<br>
                    # Type 3 - Testar relato cliente;<br>
                    # Type 2 - Testar relato publico;<br>
                    # Type 2 - Testar relato privado;<br>
                    # Type 2 - Testar relato cliente;<br>
                    # Type 2 - Construir dashboard;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Separar incidentes smart, cliente e tenant. Smart esta pronto;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Cadastro competencias;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 6.1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-1" aria-expanded="false" aria-controls="collapse6-1">
                    Versão 6.1 - 20/05/2023
                  </button>
                </h2>
                <div id="collapse6-1" class="accordion-collapse collapse" aria-labelledby="heading6-1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Removido o submenu "incidentes" de dentro do menu "Rede Neutra";<br>
                    # Ajustes para salvar rascunho;<br>
                    # Ajustado adicionar e editar senhas de VMs;<br>
                    # Ajustado consultas sql que dependiam da coluna "parceiroRN_id";<br>
                    # Ajustado cadastro de usuarios;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado coluna "empresa_id" na tabela "usuarios";<br>
                    # Excluido coluna "parceiroRN_id" na tabela "usuarios";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Construção dashboard, chamados e incidentes para usuario type2;<br>
                    # Separar incidentes smart, cliente e tenant;<br>
                    # Testar chamados e incidentes atraves dos acessos cliente e tenant;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Cadastro competencias;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>


              <!-- Versão 6.0 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6-0" aria-expanded="false" aria-controls="collapse6-0">
                    Versão 6.0 - 19/05/2023
                  </button>
                </h2>
                <div id="collapse6-0" class="accordion-collapse collapse" aria-labelledby="heading6-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Abertura manual de incidentes;<br>
                    # BUG só edita primeiro serviço "/cadastros/produtos/servicos/index.php";<br>
                    # Ajustado o editar Item de Serviço;<br>
                    # Aumento de caracteres para 10000 em relato de chamados; <br>
                    # Salvar temporariamente o relato;<br>
                    # BUG onde permite executar 2 chamados ao mesmo tempo;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Excluido tabela "bairros";<br>
                    # Excluido tabela "cidades";<br>
                    # Excluido tabela "empresas_endereco";<br>
                    # Excluido tabela "estado";<br>
                    # Excluido tabela "pais";<br>
                    # Excluido tabela "pessoas_endereco";<br>
                    # Alterado nome de tabela "redeneutra_incidentes`" para "inicidentes";<br>
                    # Alterado nome de tabela "redeneutra_incidentes_relatos" para "incidentes_relatos";<br>
                    # Excluido coluna "redeneutra_incidentescol" da tabela "incidentes";<br>
                    # Definida colula "equipamento_id" para não obigatório na tabela "incidentes";<br>
                    # Aumentado para 10000 caracteres a coluna relatos na tabela "chamados_relatos";<br>
                    # Criado a tabela "chamados_relatos_rascunho";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Abertura de Chamados por Clientes ISP e Setores;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Cadastro competencias;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.9 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-9" aria-expanded="false" aria-controls="collapse5-9">
                    Versão 5.9 - 17/05/2023
                  </button>
                </h2>
                <div id="collapse5-9" class="accordion-collapse collapse" aria-labelledby="heading5-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Melhorias no cadastro de empresas;<br>
                    # Melhorias no cadastro de pessoas;<br>
                    # Melhorias no cadastro de pops;<br>
                    # Removido o submenu "localidades" da navbar;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criada a tabela "company_address";<br>
                    # Criada a tabela "people_address";<br>
                    # Criada a tabela "pop_address";<br>
                    # Alterado tamanho do varchar das colunas "telefone" e "celular" na tabela "empresas";<br>
                    # Alterado tamanho do varchar das colunas "telefone" e "celular" na tabela "pessoas";<br>
                    # Excluido colunas "logradouro_id, numero e complemento" da tabela "pop";<br>
                    # Removida a linha de localidade da tabela de menu;<br>
                    # Removida as linhas de localidade da tabela de submenu;<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Abertura manual de incidentes;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Abertura de Chamados por Clientes ISP e Setores;<br>
                    # Vinculo de chamado a incidente;<br>
                    # BUG só edita primeiro serviço "/cadastros/produtos/servicos/index.php";<br>
                    # Cadastro competencias;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Segurança individual;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.8 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-8" aria-expanded="false" aria-controls="collapse5-8">
                    Versão 5.8 - 16/05/2023
                  </button>
                </h2>
                <div id="collapse5-8" class="accordion-collapse collapse" aria-labelledby="heading5-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Melhorias nos botões de copiar credenciais;<br>
                    # Melhorias no menu de vistoria;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criada a tabela "vistoria_equipamentos";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Abertura manual de incidentes;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Abertura de Chamados por Clientes ISP e Setores;<br>
                    # Vinculo de chamado a incidente;<br>
                    # BUG só edita primeiro serviço "/cadastros/produtos/servicos/index.php";<br>
                    # Cadastro competencias;<br>

                    <br><strong>Backlog</strong><br>
                    # Update tabela version após atualização aplicação;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.7 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-7" aria-expanded="false" aria-controls="collapse5-7">
                    Versão 5.7 - 15/05/2023
                  </button>
                </h2>
                <div id="collapse5-7" class="accordion-collapse collapse" aria-labelledby="heading5-7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Melhorias em POP/Site e opção de vistoria;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado tabela "vistoria";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Abertura manual de incidentes;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Abertura de Chamados por Clientes ISP e Setores;<br>
                    # Vinculo de chamado a incidente;<br>
                    # BUG só edita primeiro serviço "/cadastros/produtos/servicos/index.php";<br>
                    # Cadastro competencias;<br>

                    <br><strong>Backlog</strong><br>
                    # Update tabela version após atualização aplicação;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.6 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-6" aria-expanded="false" aria-controls="collapse5-6">
                    Versão 5.6 - 08/05/2023
                  </button>
                </h2>
                <div id="collapse5-6" class="accordion-collapse collapse" aria-labelledby="heading5-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Organização de incidentes e filtros;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Editado o id 17 da tabela "url_menu" para "Informativos";<br>
                    # Excluido o id 23 da tabela "url_submenu";<br>
                    # Editado o id 22 da tabela "url_submenu";<br>
                    # Criado classificação de incidente "Não Classificado" com id "0";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Abertura manual de incidentes;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Abertura de Chamados por Clientes ISP e Setores;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Menu vistoria POP;<br>
                    # BUG só edita primeiro serviço "/cadastros/produtos/servicos/index.php";<br>

                    <br><strong>Backlog</strong><br>
                    # Update tabela version após atualização aplicação;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.5 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-5" aria-expanded="false" aria-controls="collapse5-5">
                    Versão 5.5 - 08/05/2023
                  </button>
                </h2>
                <div id="collapse5-5" class="accordion-collapse collapse" aria-labelledby="heading5-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Cadastros de itens de serviço e vinculo a contrato;<br>
                    # Seleção de contrato e serviço na abertura de chamado;<br>
                    # Ajuste criar credencial portal e email;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado tabela "item_service";<br>
                    # Criado tabela "contract_iten_service";<br>
                    # Criado coluna "service_id" na tabela "chamados";<br>
                    # Criado coluna "iten_service_id" na tabela "chamados";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Abertura manual de incidentes;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Abertura de Chamados por Clientes ISP e Setores;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Alerta para previsão de normalização excedida;<br>
                    # Menu vistoria POP;<br>
                    # BUG só edita primeiro serviço "/cadastros/produtos/servicos/index.php";<br>

                    <br><strong>Backlog</strong><br>
                    # Update tabela version após atualização aplicação;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.4 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-4" aria-expanded="false" aria-controls="collapse5-4">
                    Versão 5.4 - 06/05/2023
                  </button>
                </h2>
                <div id="collapse5-4" class="accordion-collapse collapse" aria-labelledby="heading5-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Não aparecer botão "Inserir Relato" para chamados encerrados;<br>
                    # Privacidade de chamados;<br>
                    # Cadastro de classificações de incidentes;<br>
                    # Cadastro de serviços;<br>
                    # Cadastro de contratos;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Adicionado a coluna "private" na tabela "chamados_relatos"; <br>
                    # Inserido o submenu "Configurações de Incidentes" na tabela de submenu;<br>
                    # Criado a tabela "incidentes_classificacao";<br>
                    # Criado a tabela "service";<br>
                    # Criado a tabela "contract_service";<br>
                    # Criado a tabela "contract";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Abertura manual de incidentes;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>
                    # Abertura de Chamados por Clientes ISP e Setores;<br>
                    # Vinculo de chamado a incidente;<br>
                    # Itens do Serviço;<br>
                    # Seleção de contrato e serviço na abertura de chamado;<br>
                    # Alerta para previsão de normalização excedida;<br>

                    <br><strong>Backlog</strong><br>
                    # Update tabela version após atualização aplicação;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.3 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-3" aria-expanded="false" aria-controls="collapse5-3">
                    Versão 5.3 - 02/05/2023
                  </button>
                </h2>
                <div id="collapse5-3" class="accordion-collapse collapse" aria-labelledby="heading5-3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Tenant abrir chamado;<br>
                    # Tenant relatar em chamado;<br>
                    # Tenant visualizar somente chamados atribuitos a sua empresa;<br>
                    # Limitar tipos de chamados que podem ser abertos por Tenant;<br>
                    # Filtro chamados para Tenant;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado tabela "chamados_autorizados";<br>

                    <br><strong>Previsto para próximas atualizaçõs</strong><br>
                    # Abertura manual de incidentes;<br>
                    # Integração para abrir chamado no Voalle;<br>
                    # Notificaçãoes de novos incidentes e relatos;<br>
                    # Busca automatica de info-summary ao identificar incidente;<br>

                    <br><strong>Backlog</strong><br>
                    # Update tabela version após atualização aplicação;<br>
                    # Abertura de chamados de clientes;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>

                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-2" aria-expanded="false" aria-controls="collapse5-2">
                    Versão 5.2 - 28/04/2023
                  </button>
                </h2>
                <div id="collapse5-2" class="accordion-collapse collapse" aria-labelledby="heading5-2" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Criado menus de incidentes;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Inserido o menu "Incidentes" na tabela url_menu;<br>
                    # Inserido o submenu "Incidentes Abertos" na tabela url_submenu;<br>
                    # Inserido o submenu "Incidentes Fechados" na tabela url_submenu;<br>
                    # Inserido a coluna "previsaoNormalizacao" na tabela redeneutra_incidentes;<br>
                    # Inserido a coluna "classificacao" na tabela redeneutra_incidentes;<br>
                    # Inserido a coluna "relato_autor" na tabela redeneutra_incidentes_relatos;<br>


                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Adequações para o nome SmartControl;<br>
                    # Botão de encerrar incidente manualmente;<br>

                    <br><strong>Backlog</strong><br>
                    # Update tabela version após atualização aplicação;<br>
                    # Chamados Clientes/Portal;<br>
                    # Cadastro de PONs;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>


                    <br><strong>Backlog --- Rede Neutra</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Autofind no provisionamento;<br><br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-1" aria-expanded="false" aria-controls="collapse5-1">
                    Versão 5.1 - 02/02/2023
                  </button>
                </h2>
                <div id="collapse5-1" class="accordion-collapse collapse" aria-labelledby="heading5-1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Melhorias na interação com Controller; <br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Update tabela version após atualização aplicação;<br>


                    <br><strong>Backlog</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Chamados RN;<br>
                    # Classificação de incidentes;<br>
                    # Cadastro de PONs;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 5.0 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5-0" aria-expanded="false" aria-controls="collapse5-0">
                    Versão 5.0 - 02/02/2023
                  </button>
                </h2>
                <div id="collapse5-0" class="accordion-collapse collapse" aria-labelledby="heading5-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Ajustes script atualização; <br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Update tabela version após atualização aplicação;<br>


                    <br><strong>Backlog</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Chamados RN;<br>
                    # Classificação de incidentes;<br>
                    # Cadastro de PONs;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 4.9 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-9" aria-expanded="false" aria-controls="collapse4-9">
                    Versão 4.9 - 01/02/2023
                  </button>
                </h2>
                <div id="collapse4-9" class="accordion-collapse collapse" aria-labelledby="heading4-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Melhorias filtro de chamados;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado tabela version;<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Update tabela version após atualização aplicação;<br>

                    <br><strong>Backlog</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Chamados RN;<br>
                    # Classificação de incidentes;<br>
                    # Cadastro de PONs;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 4.8 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-8" aria-expanded="false" aria-controls="collapse4-8">
                    Versão 4.8 - 30/01/2023
                  </button>
                </h2>
                <div id="collapse4-8" class="accordion-collapse collapse" aria-labelledby="heading4-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>

                    <br><strong>Correções de BUG</strong><br>
                    # Correções de BUG em cadastros de senha de equipamentos;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Chamados RN;<br>

                    <br><strong>Backlog</strong><br>
                    # Classificação de incidentes;<br>
                    # Cadastro de PONs;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 4.7 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-7" aria-expanded="false" aria-controls="collapse4-7">
                    Versão 4.7 - 25/01/2023
                  </button>
                </h2>
                <div id="collapse4-7" class="accordion-collapse collapse" aria-labelledby="heading4-7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Melhorias em credenciais;<br>

                    <br><strong>Correções de BUG</strong><br>
                    # Correções de BUGs em credenciais;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # BUG retorna código em resultado do provisionamento;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Chamados RN;<br>


                    <br><strong>Backlog</strong><br>
                    # Classificação de incidentes;<br>
                    # Cadastro de PONs;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>



              <!-- Versão 4.6 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-6" aria-expanded="false" aria-controls="collapse4-6">
                    Versão 4.6 - 20/01/2023
                  </button>
                </h2>
                <div id="collapse4-6" class="accordion-collapse collapse" aria-labelledby="heading4-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Filtro "Chamados Não Fechados";<br>
                    # Manter pagina correta active após filtros de credenciais;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado coluna profile na tabela de rede_neutra_onus_provisionadas;<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Botão troca ONU;<br>
                    # Armazenar LOG sinal do cliente após provisionamento;<br>
                    # Chamados RN;<br>


                    <br><strong>Backlog</strong><br>
                    # Classificação de incidentes;<br>
                    # Cadastro de PONs;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 4.5 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-5" aria-expanded="false" aria-controls="collapse4-5">
                    Versão 4.5 - 06/12/2022
                  </button>
                </h2>
                <div id="collapse4-5" class="accordion-collapse collapse" aria-labelledby="heading4-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # LOG sinal ONU quando abre a página de diagnóstico;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas - Previsão 09/12/2022;<br>
                    # Botão troca ONU - Previsão 09/12/2022;<br>
                    # Armazenar LOG sinal do cliente após provisionamento - Previsão 09/12/2022;<br>
                    # Chamados RN - Previsão 16/12/2022;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 4.4 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-4" aria-expanded="false" aria-controls="collapse4-4">
                    Versão 4.4 - 06/12/2022
                  </button>
                </h2>
                <div id="collapse4-4" class="accordion-collapse collapse" aria-labelledby="heading4-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Corrigido falha que permitia continuar visualizando incidente após OLT não estar mais permitida ao parceiro;<br>
                    # Botão reiniciar ONU;<br>
                    # Registro de nivel de sinal de ONU;<br>
                    # Filtros ONUs Provisionadas;<br>

                    <br><strong>Correções de BUG</strong><br>
                    # BUG Cadastrar credencial Portal;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Editado colunas da tabela "redeneutra_onu_log";<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas - Previsão 09/12/2022;<br>
                    # Botão troca ONU - Previsão 09/12/2022;<br>
                    # Chamados RN - Previsão 16/12/2022;<br>

                    <br><strong>Backlog</strong><br>
                    # Cadastro de PONs;<br>
                    # Validação sinal antes de adicionar serviços;<br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 4.3 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-3" aria-expanded="false" aria-controls="collapse4-3">
                    Versão 4.3 - 01/12/2022
                  </button>
                </h2>
                <div id="collapse4-3" class="accordion-collapse collapse" aria-labelledby="heading4-3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Alterar de pessoa ID para usuario ID nos relatos de chamados;<br>
                    # Alterar de pessoa ID para usuario ID o botão "Apropriar" chamados;<br>
                    # Ajustar dashboard de chamados sem atendentes e meus chamados;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas - Previsão 06/12/2022;<br>
                    # Visualização de incidentes RN após desautorizar OLT do parceiro - Previsão 09/12/2022;<br>
                    # Botão reiniciar ONU - Previsão 09/12/2022;<br>
                    # Registro de nivel de sinal de ONU - Previsão 09/12/2022;<br>
                    # Filtros ONUs Provisionadas - Previsão 09/12/2022;<br>
                    # Chamados RN - Previsão 16/12/2022;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 4.2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-2" aria-expanded="false" aria-controls="collapse4-2">
                    Versão 4.2 - 01/12/2022
                  </button>
                </h2>
                <div id="collapse4-2" class="accordion-collapse collapse" aria-labelledby="heading4-2" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Encaminhamento de responsável por chamado<br>
                    # Alterado identificador de id de pessoa para id de usuário em registro de chamados. Isso pode afetar informações de solicitantes e atendentes;<br>

                    <br><strong>Correções de BUG</strong><br>
                    # Corrigido contagem de ONUs provisionadas no último dia;<br>
                    # Corrigido contagem de ONUs provisionadas na última semana;<br>
                    # BUG Credenciais Portal;<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas - Previsão 06/12/2022;<br>
                    # Visualização de incidentes RN após desautorizar OLT do parceiro - Previsão 09/12/2022;<br>
                    # Botão reiniciar ONU - Previsão 09/12/2022;<br>
                    # Registro de nivel de sinal de ONU - Previsão 09/12/2022;<br>
                    # Filtros ONUs Provisionadas - Previsão 09/12/2022;<br>
                    # Chamados RN - Previsão 16/12/2022;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                    # Autofind no provisionamento;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 4.1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-1" aria-expanded="false" aria-controls="collapse4-1">
                    Versão 4.1 - 01/12/2022
                  </button>
                </h2>
                <div id="collapse4-1" class="accordion-collapse collapse" aria-labelledby="heading4-1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>

                    <br><strong>Correções de BUG</strong><br>
                    # Correção BUG service-port;<br>
                    # Correção de formato data/hora (BUG em minutos);<br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Encaminhamento de responsável por chamado - Previsão 02/12/2022;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas - Previsão 06/12/2022;<br>
                    # Visualização de incidentes RN após desautorizar OLT do parceiro - Previsão 09/12/2022;<br>
                    # Botão reiniciar ONU - Previsão 09/12/2022;<br>
                    # Registro de nivel de sinal de ONU - Previsão 09/12/2022;<br>
                    # Filtros ONUs Provisionadas - Previsão 09/12/2022;<br>
                    # Chamados RN - Previsão 16/12/2022;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 4.0 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4-0" aria-expanded="false" aria-controls="collapse4-0">
                    Versão 4.0 - 30/11/2022
                  </button>
                </h2>
                <div id="collapse4-0" class="accordion-collapse collapse" aria-labelledby="heading4-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Mensagem ao fim do reset de ONU;<br>
                    # Botão excluir ONU sem desprovisionar;<br>
                    # Criado menu auditoria para validar seriais e códigos duplicados;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Inserido submenu "Auditoria" na tabela de sub-menu;<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Correção BUG service-port - Previsão 01/12/2022;<br>
                    # Encaminhamento de responsável por chamado - Previsão 02/12/2022;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas - Previsão 06/12/2022;<br>
                    # Visualização de incidentes RN após desautorizar OLT do parceiro - Previsão 09/12/2022;<br>
                    # Botão reiniciar ONU - Previsão 09/12/2022;<br>
                    # Registro de nivel de sinal de ONU - Previsão 09/12/2022;<br>
                    # Chamados RN - Previsão 16/12/2022;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamado;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 3.9 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-9" aria-expanded="false" aria-controls="collapse3-9">
                    Versão 3.9 - 30/11/2022
                  </button>
                </h2>
                <div id="collapse3-9" class="accordion-collapse collapse" aria-labelledby="heading3-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                    <br><strong>Melhorias</strong><br>
                    # Páginação na visualização de chamados;<br>
                    # Páginação na visualização de incidentes;<br>
                    # Nome do usuário que esta apropriado do chamado;<br>
                    # Configurado o email do cadastro como email de login;<br>
                    # Agrupamento das credenciais no formato de TAB (Pode gerar BUGs na rotina, informar administrador para correção);<br>
                    # Ordenação por ordem alfabetica a seleção de tipo de chamado na abertura de chamado;<br>
                    # Informação de usuário provisionador;<br>
                    # Filtro de chamados encerrados, abertos na consulta de chamados;<br>
                    # LOGs de acesso no view do usuário;<br>
                    # Botão resetar ONU; (Em testes)<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Excluido coluna email da tabela de usuarios;<br>
                    # Inserido registro do menu Credenciais na tabela "url_menu";<br>
                    # Criado tabela "redeneutra_onu_log";<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Chamados RN;<br>
                    # Visualização de incidentes RN após desautorizar OLT do parceiro;<br>
                    # Botão excluir provisionamento sem desprovisionar;<br>
                    # Botão reiniciar ONU;<br>
                    # Registro de nivel de sinal de ONU;<br>
                    # Encaminhamento de responsável por chamado;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual
                  </div>
                </div>
              </div>



              <!-- Versão 3.8 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-8" aria-expanded="false" aria-controls="collapse3-8">
                    Versão 3.8 - 21/11/2022
                  </button>
                </h2>
                <div id="collapse3-8" class="accordion-collapse collapse" aria-labelledby="heading3-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>

                    <br><strong>Melhorias</strong><br>
                    # Últimos 10 provisionados na dashboard de parceiro RN;<br>
                    # Quantidade de ONUs provisionadas por OLT na dashboard de parceiro RN;<br>
                    # Registro do úsuario que realizou provisionamento;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado coluna "criado_por" na tabela "redeneutra_onu_provisionadas";<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Chamados RN;<br>
                    # Visualização de incidentes RN após desautorizar OLT do parceiro;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual;<br>
                    # Agendamento de chamados;<br>
                  </div>
                </div>
              </div>



              <!-- Versão 3.7 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-7" aria-expanded="false" aria-controls="collapse3-7">
                    Versão 3.7 - 20/11/2022
                  </button>
                </h2>
                <div id="collapse3-7" class="accordion-collapse collapse" aria-labelledby="heading3-7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>

                    <br><strong>Melhorias</strong><br>
                    # Dashboard de parceiro de RN;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Melhorias em dashboard;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Chamados RN;<br>
                    # Visualização de incidentes RN após desautorizar OLT do parceiro;<br>
                    # Melhorias para editar usuário;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual
                  </div>
                </div>
              </div>


              <!-- Versão 3.6 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-6" aria-expanded="false" aria-controls="collapse3-6">
                    Versão 3.6 - 18/11/2022
                  </button>
                </h2>
                <div id="collapse3-6" class="accordion-collapse collapse" aria-labelledby="heading3-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>

                    <br><strong>Melhorias</strong><br>
                    # Melhorias ao cadastrar usuario de parceiro de RN;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Excluido coluna dashboard da tabela "usuarios";<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Variedade de dashboards (Rede Neutra e Provedor);<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Chamados RN;<br>
                    # Visualização de incidentes RN após desautorizar OLT do parceiro;<br>
                    # Melhorias para editar usuário;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual
                  </div>
                </div>
              </div>


              <!-- Versão 3.5 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-5" aria-expanded="false" aria-controls="collapse3-5">
                    Versão 3.5 - 17/11/2022
                  </button>
                </h2>
                <div id="collapse3-5" class="accordion-collapse collapse" aria-labelledby="heading3-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>

                    <br><strong>Melhorias</strong><br>
                    # Form de editar o profile OLT;<br>
                    # Travamento parceiro ao ativar ONU;<br>

                    <br><strong>Correções de BUG</strong><br>
                    # Correção do modal editar senha no admin;<br>
                    # Corrigido edição dos dados de OLT;<br>
                    # Ajuste dos checkbox tipo de equipamento no cadastro de produto;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Excluir registros com active 0 na tabela "equipamentos_atributos";<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Variedade de dashboards;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual
                  </div>
                </div>
              </div>

              <!-- Versão 3.4 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-4" aria-expanded="false" aria-controls="collapse3-4">
                    Versão 3.4 - 16/11/2022
                  </button>
                </h2>
                <div id="collapse3-4" class="accordion-collapse collapse" aria-labelledby="heading3-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>

                    <br><strong>Melhorias</strong><br>
                    # Vinculado cadastro de OLT a equipamento;<br>
                    # Seleção de profile no momento do provisionamento;<br>
                    # Removido as informações de OLT e Profile no index de ativação;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Variedade de dashboards;<br>
                    # Correção do modal editar senha no admin;<br>
                    # Travamento parceiro ao ativar ONU;<br>
                    # Form de editar o profile OLT;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>
                    # Ajuste dos checkbox tipo de equipamento no cadastro de produto;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual
                  </div>
                </div>
              </div>

              <!-- Versão 3.3 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-3" aria-expanded="false" aria-controls="collapse3-3">
                    Versão 3.3 - 16/11/2022
                  </button>
                </h2>
                <div id="collapse3-3" class="accordion-collapse collapse" aria-labelledby="heading3-3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>

                    <br><strong>Melhorias</strong><br>
                    # Separado a criação do profile da criação dos serviços do profile;<br>

                    <br><strong>Correções de BUG</strong><br>
                    # Corrigido query de cadastro de novo usuário quando não esta vinculado a parceiro de rede neutra;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Excluido colunas da tabela redeneutra_profile_parceiro;<br>
                    # Criado tabela redeneutra_profile_serviço;<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Variedade de dashboards;<br>
                    # Correção do modal editar senha no admin;<br>
                    # Travamento parceiro ao ativar ONU;<br>
                    # Seleção de profile no momento do provisionamento;<br>
                    # Remover as informações de OLT e Profile no index de ativação;<br>
                    # Form de editar o profile OLT;<br>
                    # Ativar os serviços do profile dentro do menu de ONUs Provisionadas;<br>


                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual
                  </div>
                </div>
              </div>

              <!-- Versão 3.2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-2" aria-expanded="false" aria-controls="collapse3-2">
                    Versão 3.2 - 31/10/2022
                  </button>
                </h2>
                <div id="collapse3-2" class="accordion-collapse collapse" aria-labelledby="heading3-2" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>

                    <br><strong>Melhorias</strong><br>
                    # Travamento para parceiro RN ter acesso somente a suas ONUs;<br>
                    # Travamento para parceiro RN ver somente incidentes que corresponde as OLTs que estão liberadas para ele;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado coluna equipamento_id na tabela redeneutra_olts;<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Variedade de dashboards;<br>
                    # Melhorias no cadastro de profiles;<br>
                    # Correção do modal editar senha no admin;<br>
                    # Travamento parceiro ao ativar ONU;<br>


                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual por páginas;<br>
                    # Ferramenta de calculo de potencia DWDM;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 3.1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-1" aria-expanded="false" aria-controls="collapse3-1">
                    Versão 3.1 - 26/10/2022
                  </button>
                </h2>
                <div id="collapse3-1" class="accordion-collapse collapse" aria-labelledby="heading3-1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    # Menu "Meu perfil";<br>

                    <br><strong>Melhorias</strong><br>
                    # Ajustes internos no javascript de coleta de dados da OLT em Ativação de Rede Neutra;<br>
                    # Editar usuário;<br>
                    # Armazenagem da data de provisionamento de ONU;<br>

                    <br><strong>Correções de BUG</strong><br>
                    # Correção de vincular integrantes à equipes;<br>
                    # Correção modal de permissões de privacidade;<br>
                    # Correção dashboard inicial;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Adicionado coluna data_provisionamento na tabela redeneutra_onu_provisionadas;<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Travamento para parceiro RN ter acesso somente a suas ONUs;<br>
                    # Travamento para parceiro RN ver somente incidentes que corresponde as OLTs que estão liberadas para ele;<br>
                    # Variedade de dashboards;<br>
                    # Melhorias no cadastro de profiles;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual por páginas;<br>
                    # Ferramenta de calculo de potencia DWDM;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 3.0 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3-0" aria-expanded="false" aria-controls="collapse3-0">
                    Versão 3.0 - 20/10/2022
                  </button>
                </h2>
                <div id="collapse3-0" class="accordion-collapse collapse" aria-labelledby="heading3-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    # Criado página de cadastro de perfil;<br>

                    <br><strong>Melhorias</strong><br>
                    # Reformulação no cadastro de usuários;<br>
                    # Permissões de acesso por perfil;<br>
                    # Correções nos formatos de data e hora;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    # Criado tabela url_menu;<br>
                    # Criado tabela url_submenu;<br>
                    # Criado tabela perfil;<br>
                    # Criado tabela perfil_permissoes_menu;<br>
                    # Criado tabela perfil_permissoes_submenu;<br>
                    # Alterado tabela usuarios;<br>
                    # Excluido tabela usuarios_perfil;<br>
                    # Excluido tabela perfil_permissoes;<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    # Menu "Meu perfil";<br>
                    # Editar usuário;<br>
                    # Ajustes internos no javascript de coleta de dados da OLT em Ativação de Rede Neutra;<br>
                    # Travamento para parceiro RN ter acesso somente a suas ONUs;<br>
                    # Travamento para parceiro RN ver somente incidentes que corresponde as OLTs que estão liberadas para ele;<br>
                    # Variedade de dashboards;<br>
                    # Correção de vincular integrantes à equipes;<br>
                    # Melhorias no cadastro de profiles;<br>

                    <br><strong>Backlog</strong><br>
                    # Relatórios;<br>
                    # Mostrar LOG de alteração e criação de registros por usuário;<br>
                    # Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    # Criação de contratos;<br>
                    # Componentes de equipamentos;<br>
                    # Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                    # Integração com API's de CEP;<br>
                    # Segurança individual por páginas;<br>
                    # Ferramenta de calculo de potencia DWDM;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 2.9 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-9" aria-expanded="false" aria-controls="collapse2-9">
                    Versão 2.9 - 14/10/2022
                  </button>
                </h2>
                <div id="collapse2-9" class="accordion-collapse collapse" aria-labelledby="heading2-9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Módulo Rede Neutra<br>

                    <br><strong>Melhorias</strong><br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado tabelas de Rede Neutra<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Iniciar página de relatórios;<br>
                    2. Mostrar LOG de alteração e criação de registros por usuário;<br>
                    3. Correções nos formatos de data e hora;<br>
                    4. Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    5. Criação de contratos;<br>
                    6. Componentes de equipamentos;<br>
                    7. Criar perfil personalizado para Consultores;<br>
                    8. Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 2.8 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-8" aria-expanded="false" aria-controls="collapse2-8">
                    Versão 2.8 - 23/09/2022
                  </button>
                </h2>
                <div id="collapse2-8" class="accordion-collapse collapse" aria-labelledby="heading2-8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Chamados agendados; <br>

                    <br><strong>Melhorias</strong><br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado tabela event_scheduler;<br>
                    2. Criado coluna relato_inicial na tabela chamados;<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Iniciar página de relatórios;<br>
                    2. Mostrar LOG de alteração e criação de registros por usuário;<br>
                    3. Correções nos formatos de data e hora;<br>
                    4. Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    5. Criação de contratos;<br>
                    6. Componentes de equipamentos;<br>
                    7. Criar perfil personalizado para Consultores;<br>
                    8. Redirecionar pagina para o cadastro da senha após cadastrar senha nova em equipamento e vm;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 2.7 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-7" aria-expanded="false" aria-controls="collapse2-7">
                    Versão 2.7 - 16/09/2022
                  </button>
                </h2>
                <div id="collapse2-7" class="accordion-collapse collapse" aria-labelledby="heading2-7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>

                    <br><strong>Melhorias</strong><br>
                    1. Personalização dashboard inicial;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Iniciar página de relatórios;<br>
                    2. Mostrar LOG de alteração e criação de registros por usuário;<br>
                    3. Correções nos formatos de data e hora;<br>
                    4. Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    5. Criação de contratos;<br>
                    6. Chamados agendados; <br>
                    7. Componentes de equipamentos;<br>
                    8. Criar perfil personalizado para Consultores;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 2.6 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-6" aria-expanded="false" aria-controls="collapse2-6">
                    Versão 2.6 - 11/09/2022
                  </button>
                </h2>
                <div id="collapse2-6" class="accordion-collapse collapse" aria-labelledby="heading2-6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Cadastro de Serviços;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Melhorias em layout de tabelas;<br>
                    2. Padronização de diretórios;<br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado tabela servico;<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Iniciar página de relatórios;<br>
                    2. Mostrar LOG de alteração e criação de registros por usuário;<br>
                    3. Correções nos formatos de data e hora;<br>
                    4. Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    5. Analisar espaçamento que esta ficando após a senha;<br>
                    6. Criação de contratos;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 2.5 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-5" aria-expanded="false" aria-controls="collapse2-5">
                    Versão 2.5 - 09/09/2022
                  </button>
                </h2>
                <div id="collapse2-5" class="accordion-collapse collapse" aria-labelledby="heading2-5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Criado as politicas de restrições para ver credenciais;<br>

                    <br><strong>Melhorias</strong><br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Renomeado tabela credenciais_privacidade_equipe;<br>
                    2. Adicionado coluna tipo na tabela credenciais_privacidade_equipe;<br>
                    3. Renomeado tabela credenciais_privacidade_usuario;<br>
                    4. Adicionado coluna tipo na tabela credenciais_privacidade_usuario;<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Iniciar página de relatórios;<br>
                    2. Mostrar LOG de alteração e criação de registros por usuário;<br>
                    3. Correções nos formatos de data e hora;<br>
                    4. Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    5. Analisar espaçamento que esta ficando após a senha;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 2.4 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-4" aria-expanded="false" aria-controls="collapse2-4">
                    Versão 2.4 - 04/09/2022
                  </button>
                </h2>
                <div id="collapse2-4" class="accordion-collapse collapse" aria-labelledby="heading2-4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Anexo de imagens em equipamentos (Necessário criar diretório);<br>
                    2. Cadastro de equipes;<br>
                    3. Confiruguração de permissão nas credenciais de equipamentos;<br>

                    <br><strong>Melhorias</strong><br>

                    <br><strong>Correções de BUG</strong><br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado tabela upload;<br>
                    2. Criado tabela equipes;<br>
                    3. Criado tabela equipes_integrantes;<br>
                    4. Criado tabela credenciais_equipamento_privacidade_equipe;<br>
                    5. Criado tabela credenciais_equipamento_privacidade_usuario;<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Iniciar página de relatórios;<br>
                    2. Mostrar LOG de alteração e criação de registros por usuário;<br>
                    3. Correções nos formatos de data e hora;<br>
                    4. Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    5. Analisar espaçamento que esta ficando após a senha;<br>
                    6. Politica de restrição na visualização de credenciais; <br>
                  </div>
                </div>
              </div>


              <!-- Versão 2.3 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-3" aria-expanded="false" aria-controls="collapse2-3">
                    Versão 2.3 - 07/08/2022
                  </button>
                </h2>
                <div id="collapse2-3" class="accordion-collapse collapse" aria-labelledby="heading2-3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Contador de tempo chamado e ralato;

                    <br><strong>Melhorias</strong><br>
                    1. Destacar na barra superior quando um chamado esta em execução;<br>
                    2. Botão para adicionar, inativar e editar senhas junto a equipamento e VM;<br>
                    3. Removido visualização de senhas de vms e equipamentos através de credenciais;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. Corrigido cadastro de VM que estava quebrando quando não preenchido VLAN;<br>
                    2. Ajustar quebra de linha dos relatos dos chamados;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Alterado tipo de campo VLAN na tabela vms para varchar(4)<br>;
                    2. Alterado tipo de campo VLAN na tabela vms para null:<br>
                    3. Criado coluna active na tabela credenciais_vms;<br>
                    4. Criado coluna active na tabela credenciais_equipamentos;<br>
                    5. Criado coluna seconds_worked na tabela chamado_relato;<br>
                    6. Criado coluna seconds_worked na tabela chamados;<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Cadastro de equipes;<br>
                    2. Iniciar página de relatórios;<br>
                    3. Mostrar LOG de alteração e criação de registros por usuário;<br>
                    5. Correções nos formatos de data e hora;<br>
                    6. Possibilidade de cadastrar uma VM a uma hospedagem; <br>
                    7. Analisar espaçamento que esta ficando após a senha;<br>
                  </div>
                </div>
              </div>




              <!-- Versão 2.2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-2">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-2" aria-expanded="false" aria-controls="collapse2-2">
                    Versão 2.2 - 29/07/2022
                  </button>
                </h2>
                <div id="collapse2-2" class="accordion-collapse collapse" aria-labelledby="heading2-2" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Cadastro de usuários de portal;<br>
                    2. Criado cadastro de tipo de chamado;<br>
                    3. Criado pagina para ver chamados, relatar e abrir chamado;<br>
                    4. Botao apropriar na visualização do chamado;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Melhorias na visualização das senhas dos equipamentos;<br>
                    2. Preenchimento rack e serial no cadastro do equimento no pop;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. <br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado coluna atendende_id na tabela chamados;<br>
                    2. Criado coluna relator_id na tabela chamado_relato;<br>
                    3. Criado coluna in_execution na tabela chamados;<br>
                    4. Criado coluna in_execution_atd_id na tabela chamados;<br>
                    5. Criado coluna in_execution_start na tabela chamados;<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Cadastro de equipes;<br>
                    2. Iniciar página de relatórios;<br>
                    3. Mostrar LOG de alteração e criação de registros por usuário;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 2.1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-1" aria-expanded="false" aria-controls="collapse2-1">
                    Versão 2.1 - 25/07/2022
                  </button>
                </h2>
                <div id="collapse2-1" class="accordion-collapse collapse" aria-labelledby="heading2-1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. <br>

                    <br><strong>Melhorias</strong><br>
                    1. Atribuido opção de dizer se equipamento é ou não de rack;<br>
                    2. Atribuido opção de vincular equipamento ao rack quando equipamento for do tipo de rack;<br>
                    3. Atribuido opção de portas de acesso (SSH, WEB, Telnet) em equipamentos;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. <br>


                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado a coluna rack na tabela equipamentos;<br>
                    2. Criado a coluna rack_id na tabela equipamentospop;<br>
                    3. Criado a coluna serialEquipamento na tabela equipamentospop;<br>
                    4. Criado a coluna portaWeb na tabela equipamentospop;<br>
                    5. Criado a coluna portaTelnet na tabela equipamentospop;<br>
                    6. Criado a coluna portaSSH na tabela equipamentospop;<br>
                    7. Criado a coluna portaWinbox na tabela equipamentospop;<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Cadastro de regiões;<br>
                    2. Cadastro de equipes;<br>
                    3. Iniciar página de relatórios;<br>
                    4. Mostrar LOG de alteração e criação de registros por usuário;<br>

                  </div>
                </div>
              </div>


              <!-- Versão 2.0 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading2-0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2-0" aria-expanded="false" aria-controls="collapse2-0">
                    Versão 2.0 - 23/07/2022
                  </button>
                </h2>
                <div id="collapse2-0" class="accordion-collapse collapse" aria-labelledby="heading2-0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Botão de atualizar frontend;<br>
                    2. LOG de acesso;<br>

                    <br><strong>Melhorias</strong><br>
                    1. ;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. Corrigido o cadastro de novo POP;<br>
                    1. Corrigido o salvamento de anotação em credenciais de email;<br>


                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado tabela atualizacao;<br>
                    2. Criado tabela log_Acesso;<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Colocar opção se equipamento é rack ou não e vincular equipamento com rack quando for de rack;<br>
                    2. Campo serial no cadastro de equipamento;<br>
                    3. Cadastro de regiões;<br>
                    4. Cadastro de equipes;<br>
                    5. Iniciar página de relatórios;<br>
                    6. Colocar opção de portas de acesso (SSH, WEB, Telnet) em equipamentos;<br>
                    7. Mostrar LOG de alteração e criação de registros por usuário;<br>

                  </div>
                </div>
              </div>


              <!-- Versão 1.9 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading10">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                    Versão 1.9 - 22-07/2022
                  </button>
                </h2>
                <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. ;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Criado campo para anotação no cadastro de credenciais tipo email;<br>
                    2. Criado campo para anotação no cadastro de credenciais tipo portal;<br>
                    3. Aumentado tamanho dos campos email e senha no cadastro tipo email;<br>
                    4. Aumentado tamanho dos campos usuario e senha no cadastro tipo portal;<br>
                    5. Adicionado campo de pesquisa por equipamento na tela de credenciais;<br>
                    6. Diminuido campo de anotação na visualização de equipamentos;<br>
                    7. Diminuido campo de anotação na visualização de vms;<br>
                    8. Adicionado tamanho 11U no cadastro de produtos;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. Corrigido o tipo de cadastro de credenciais que estava vindo preenchido automaticamente como E-mail;<br>
                    2. Corrigido alguns erros de filtros ao pesquisar credenciais

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado a coluna anotacao na tabela "credenciais_email";<br>
                    2. Criado a coluna anotacao na tabela "credenciais_portal";<br>

                    <br><strong>Previsto para próximas atualizações</strong><br>
                    1. Colocar opção se equipamento é rack ou não e vincular equipamento com rack quando for de rack;<br>
                    2. Campo serial no cadastro de equipamento;<br>
                    3. Cadastro de regiões;<br>
                    4. Cadastro de equipes;<br>
                    5. Iniciar página de relatórios;<br>
                    6. Colocar opção de portas de acesso (SSH, WEB, Telnet) em equipamentos;<br>
                    7. Mostrar LOG de alteração e criação de registros por usuário;<br>

                  </div>
                </div>
              </div>


              <!-- Versão 1.8 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading9">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                    Versão 1.8 - 20/07/2022
                  </button>
                </h2>
                <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Adicionado botão key em VMs e Equipamentos onde direciona para tela de credenciais;<br>
                    2. Incluido cluna Equipamento/VM na tela de credenciais;<br>
                    3. Adicionado campo IP na visualização de credenciais;<br>
                    4. Adicionado campo "Visualizar credenciais" na visualização de equipamentos e VMs;<br>
                    5. Adicionado botão Excluir permanente em cadastro de POP;<br>
                    6. Adicionado cadastro de rack no POP;<br>

                    <br><strong>Melhorias</strong><br>
                    1. ;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. Corrigido filtro de credenciais, substituido clausa de contém para exato na busca do id equipamento e vm;<br>
                    2. Corrigido obrigatoriedade em alguns preenchimentos no cadastro de POP;<br>
                    3. Corrigido obrigatoriedade em alguns preenchimentos no editar equipamentos;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Alterado a coluna deleted na tabela pop para tipo boolean, e alterado nome para active;<br>
                    2. Criado a tabela pop_rack;<br>

                    <br><strong>Previsto para próxima atualização</strong><br>
                    1. Vinculo de equipamento com rack;<br>
                    2. Campo serial no cadastro de equipamento;<br>
                    3. Cadastro de regiões;<br>
                    4. Cadastro de equipes;<br>
                    5. Iniciar página de relatórios;<br>
                  </div>
                </div>
              </div>




              <!-- Versão 1.7 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading8">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                    Versão 1.7 - 18/07/2022
                  </button>
                </h2>
                <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Criado tela de credenciais, pendente implementação de politicas de privacidade;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Ordenado empresas por ordem alfabética no campo de pesquisa em VMs e Equipamentos;<br>
                    2. Removido os campos de comunidade SNMP e usuario integração no cadastro de equipamento por POP; <br>
                    3. Removido limite de caracteres do campo dominio em /telecom/vms/view.php; <br>
                    4. Corrigido o caminho para retornar a página de login quando o usuário tenta acessar alguma página sem estar logado; <br>
                    5. Configurado no modal de pesquisa em Equipamentos e VMs para ficar nos campos de pesquisa as opções selecionadas; <br>
                    6. Ajustado a obrigatóriedade de preenchimendo de alguns campos; <br>
                    7. Deixado apenas o campo Anotaçãoes em cadastro de equipamento no pop;<br>

                    <br><strong>Correções de BUG</strong><br>
                    Sem correções de BUGs nesta versão;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Removido as colunas de comunidade SNMP e usuario de integragração na tabela equipamentospop;<br>
                    2. Criado tabela credenciais_email;<br>
                    3. Criado tabela credenciais_portal;<br>
                    4. Adicionado coluna anotacaoEquipamento na tabela equipamentospop;<br>
                    5. Excluido a tabela anotacaopublicaequipamento, migrar o que tem dela para a coluna criada no item 4;<br>
                    6. Criado a coluna anotacaoVM na tabela vms;<br>
                    7. Excluido a tabela anotacaopublica_vm, migrar o que tem dela para a coluna criada no item 6;<br>
                    8. Criado tabela credenciais_equipamento;<br>
                    9. Criado tabela credenciais_vms;<br>

                  </div>
                </div>
              </div>

              <!-- Versão 1.6 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading7">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                    Versão 1.6 - 12-07/2022
                  </button>
                </h2>
                <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    Sem novas funcionalidades nesta versão;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Adicionado campo de pesquisa Tipo de Equipamento no cadastro de equipamento pop POP;<br>
                    2. Alterado type para number no campo de VLAN no cadastro de VM;<br>
                    3. Adicionado href no botão voltar na página de view de VMs e Equipamentos;<br>
                    4. Ao cadastrar Equipamentos e VMs, vai direto para o view do cadastro;<br>
                    5. Ordenado a listagem de sistema operacional por ordem alfabética;<br>
                    6. Aumentado limite de busca para 100 na listagem de VMs;<br>
                    7. Alterado a busca por "contém" quando buscado digitando hostname na busca por VMs e Equipamentos;<br>
                    8. Ajustado para listar apenas os servidores com status Ativado no cadastro de novas VMs;<br>
                    9. Ajustado ordem de colunas na listagem de Equipamentos e VMs;<br>

                    <br><strong>Correções de BUG</strong><br>
                    Sem correções de BUGs nesta versão;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    Sem novas alterações;<br>
                  </div>
                </div>
              </div>



              <!-- Versão 1.5 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading6">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                    Versão 1.5 - 11/07/2022
                  </button>
                </h2>
                <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Criado a função de anotação pública no cadastro de VMs;<br>
                    2. Criado a função de editar VMs;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Ajustado campo de fabricante no cadastro de equipamento para ordenar por nome;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. ;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado tabela anotacaopublica_vm;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 1.4 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading5">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                    Versão 1.4 - 08/07/2022
                  </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Colocado checkbox dinâmico de tipo de equipametno no cadastro de equipamento;<br>
                    2. Adicionado campo de tamanho no cadastro de equipamento;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Ajuste design visualização de produtos;<br>
                    2. Adequado cadastro de produtos para o formato de diretórios;<br>
                    3. Ajustado filtro no cadastro de equipamentos por POP para aparecer somente os tipos corretos para o modelo de equipamento selecionado;<br>
                    4. Alterado limite de busca default para o valor 100 nA tela de equipamentos pop POP;<br>
                    5. Permitido copiar, colar, deletear, selecionar tudo nos campos IP onde tinha máscara permitindo apenas números;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. ;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado tabela equipamentos_atributos;<br>
                    2. Adicionado columa tamanho na tabela equipamentos;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 1.3 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading4">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                    Versão 1.3 - 06/07/2022
                  </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Cadastro Sistema Operacional;<br>
                    2. Cadastro VMs;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Ajuste para não listar usuário super admin no cadastro de usuários;<br>
                    2. Retirado temporariamente de produção para ajustes os menus de relatar BUG e relatar problema;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. Ajuste no cadastro de empresa;<br>
                    2. Ajuste na exclusão de empresa;<br>
                    3. Ajuste caminho botão dashboard;<br>
                    4. Ajuste href no editar empresa;<br>

                    <br><strong>Alterações banco de dados</strong><br>
                    1. Criado a tabela vms;<br>
                    2. Criado a tabela sistemaoperacional;<br>
                  </div>
                </div>
              </div>


              <!-- Versão 1.2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading3">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                    Versão 1.2 - 04/07/2022
                  </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Opção de pesquina no cadastro de equipamento por pop;<br>

                    <br><strong>Melhorias</strong><br>
                    1. Ajustes de identidade visual da marca;<br>
                    2. Ajuste mascara de IP no cadastro de equipamento por pop;<br>
                    3. Novas funções e melhorias na tela de cadastro de equipamento por pop;<br>
                    4. Adicionado botão voltar em algumas páginas;<br>
                    5. Vinculado a criação de usuário com o cadastro de pessoa;<br>
                    5. Removido a possibilidade de exclusão de cadastros default;<br>

                    <br><strong>Correções de BUG</strong><br>
                    1. Ajuste abertura página changelog;<br>
                    2. Ajuste abertura de páginas con enderaçemento errado;<br>
                  </div>
                </div>
              </div>

              <!-- Versão 1.1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading1.1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Versão 1.1 - 30/06/2022
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="heading1.1" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Tela de relato de BUG;<br>
                    2. Cadastro de logradouros<br>
                    3. Cadastro de empresas<br>
                    4. Cadastro de pessoas<br>
                    5. Cadastro de usuários<br>
                    6. Cadastro de POPs<br>
                    7. Cadastro equipamento POPs<br>

                    <br><strong>Melhorias</strong><br>
                    1. Correção de máscaras<br>
                    2. Ajuste select dinâmico no cadastro de cidades<br>
                    3. Ajuste select dinâmico no cadastro de bairros<br>
                    4. Ajustado icones do menu<br>

                    <br><strong>Correções de BUG</strong><br>
                    Sem correções lançadas<br>
                  </div>
                </div>
              </div>

              <!-- Versão 1.0 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading1.0">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Versão 1.0 - 11/06/2022
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="heading1.0" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>Novas funcionalidades</strong><br>
                    1. Tela de login;<br>
                    2. Cadastro de País;<br>
                    3. Cadastro de Estado;<br>
                    4. Cadastro de Usuários;<br>
                    5. Cadastro de Cidades;<br>
                    6. Cadastro de Bairro;<br>
                    7. Cadastro Tipo de Equipamentos;<br>
                    8. Cadastro Fabricante;<br>
                    9. Cadastro Equipamento;<br>

                    <br><strong>Correções de BUG</strong><br>
                    Sem correções lançadas
                  </div>
                </div>
              </div>
            </div><!-- End Default Accordion Example -->

          </div>
        </div>

      </div>

    </div>
  </section>

</main><!-- End #main -->

<?php
require "../includes/footer.php";
?>
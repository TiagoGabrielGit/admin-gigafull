#!/bin/bash

#Cria usuario Admin
INSERT INTO `usuarios` (`id`, `pessoa_id`, `email`, `senha`, `cadastroDefault`, `deleted`, `criado`, `modificado`) VALUES 
(1, NULL, 'Admin@gigafull.com.br', '9e8d5ee9711cbab9bad09d5890ce5f3e', 1, 1, '2022-06-05 21:56:20', NULL);

#Cria o perfil do usuario Admin
INSERT INTO `usuarios_perfil` (`id`, `usuario_id`, `permissao_id`, `deleted`, `criado`, `modificado`) VALUES
(1, 1, 1, 1, '2022-06-20 03:44:32', NULL),

#Cria as permissões default
INSERT INTO `perfil_permissoes` (`id`, `perfil`, `cadastroDefault`) VALUES
(1, 'Super Administrador', 1),
(2, 'Administrador', 1),
(3, 'Usuario', 1);

#Cria os fabricantes default
INSERT INTO `fabricante` (`id`, `fabricante`, `cadastroDefault`, `deleted`, `criado`, `modificado`) VALUES
(1, 'Huawei', 1, 1, '2022-06-06 02:14:13', NULL),
(2, 'Cisco', 1, 1, '2022-06-05 23:20:06', NULL),
(3, 'Fiberhome', 1, 1, '2022-06-30 01:58:57', NULL),
(4, 'Mikrotik', 1, 1, '2022-07-04 11:46:13', NULL);

#Cria os tipos de equipamentos
INSERT INTO `tipoequipamento` (`id`, `tipo`, `cadastroDefault`, `deleted`, `criado`, `modificado`) VALUES
(1, 'Switch', 1, 1, '2022-06-05 22:48:40', NULL),
(2, 'Roteador de Borda', 1, 1, '2022-06-05 22:49:23', NULL),
(3, 'Autenticador - BRAS', 1, 1, '2022-06-06 16:25:33', NULL),
(4, 'Servidor virtualizador', 1, 1, '2022-06-29 02:23:26', NULL),
(5, 'OLT', 1, 1, '2022-06-30 01:44:23', NULL);
(6, 'Firewall', 1, 1, '2022-06-30 01:44:23', NULL);
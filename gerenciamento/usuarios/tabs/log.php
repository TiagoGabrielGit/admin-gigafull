<div class="row g-3">
                                                <div class="col-lg-12">
                                                    <span><b>Últimos 10 Acessos</b></span>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="row">

                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Sessão</th>
                                                                    <th scope="col">IP</th>
                                                                    <th scope="col">Horário</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $log_acesso =
                                                                    "SELECT
                                                                        ip_address,
                                                                        horario,
                                                                        id
                                                                        FROM
                                                                        log_acesso
                                                                        WHERE
                                                                        usuario_id = $idUsuario
                                                                        ORDER BY
                                                                        horario DESC
                                                                        LIMIT 10";

                                                                $r_log = mysqli_query($mysqli, $log_acesso);


                                                                while ($campos_log = $r_log->fetch_array()) { ?>
                                                                    <tr>
                                                                        <td><?= $campos_log['id'] ?></td>
                                                                        <td><?= $campos_log['ip_address'] ?></td>
                                                                        <td><?= $campos_log['horario'] ?></td>
                                                                    </tr>
                                                                <?php } ?>



                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <hr class="sidebar-divider">
                                            </div>
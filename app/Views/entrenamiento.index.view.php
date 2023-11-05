<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header card-header-asneves">
                <h1 class="card-title card-title-h1">Entrenamiento</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="search-input-1" name="nombre"
                                placeholder="Nombre de Entrenamiento" value="" />
                        </div>
                    </div>
                </div>
            </div>
            <table id="table-1" class="table table-bordered table-striped  dataTable">
                <thead>
                    <tr>
                        <th>Nombre de Entrenamiento</th>
                        <th>Dia</th>
                        <th>Numero de ejercicios</th>
                        <th>Ver</th>
                        <?php if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) { ?>
                            <th>Asignar entrenamiento</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($datos as $entrenamiento) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $entrenamiento->nombre; ?>
                            </td>
                            <td>
                                <?php echo $entrenamiento->dia; ?>
                            </td>
                            <td>
                                <?php echo $entrenamiento->numEjercicios; ?>
                            </td>
                            <td><a class="btn btn-green"
                                    href="./?controller=<?php echo $_GET['controller']; ?>&action=ver&idEntrenamiento=<?php echo $entrenamiento->idEntrenamiento; ?>">ver</a>
                            </td>
                            <?php if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'entrenador')) { ?>
                                <td><a class="btn btn-blue"
                                        href="./?controller=<?php echo $_GET['controller']; ?>&action=asignarEntrenamiento&idEntrenamiento=<?php echo urlencode($entrenamiento->idEntrenamiento); ?>">Asignar
                                        clientes</a></td>
                                <td><a class="btn btn-yellow"
                                        href="./?controller=<?php echo $_GET['controller']; ?>&action=edit&idEntrenamiento=<?php echo $entrenamiento->idEntrenamiento; ?>">Editar</a>
                                </td>

                                <td><a class="btn btn-red"
                                        href="./?controller=<?php echo $_GET['controller']; ?>&action=delete&idEntrenamiento=<?php echo urlencode($entrenamiento->idEntrenamiento); ?>">Eliminar</a>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
</div>
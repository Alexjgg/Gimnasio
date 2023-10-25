<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card-success shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h3 class="card-title">Nuevo Entrenamiento</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2>Entrenamientos</h2>
                            <form
                                action="./?controller=<?php echo $_GET['controller']; ?>&action=<?php echo $_GET['action']; ?>"
                                method="POST" id="formulario">
                                <div class="form-group row">

                                    <input type="hidden" name="idEntrenamiento"
                                        value="<?php echo isset($sanitized) ? $sanitized->getIdEntrenamiento() : ''; ?>" />

                                    <label for="nombre">Nombre de Entrenamiento:</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="nombre" id="nombre" class="form-control"
                                            value="<?php echo isset($sanitized) ? $sanitized->getNombre() : ''; ?>"
                                            placeholder="Nombre" />
                                        <?php
                                        if (isset($errors['nombre'])) {
                                            ?>
                                            <p class="text-danger"><small>
                                                    <?php echo $errors['nombre']; ?>
                                                </small></p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="dia">Selecciona un día de la semana:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="dia" id="dia">
                                            <option value="lunes" <?php if (isset($sanitized) && $sanitized->getDia() == "lunes") {
                                                echo "selected";
                                            } ?>>Lunes</option>
                                            <option value="martes" <?php if (isset($sanitized) && $sanitized->getDia() == "martes") {
                                                echo "selected";
                                            } ?>>Martes</option>
                                            <option value="miercoles" <?php if (isset($sanitized) && $sanitized->getDia() == "miercoles") {
                                                echo "selected";
                                            } ?>>Miércoles</option>
                                            <option value="jueves" <?php if (isset($sanitized) && $sanitized->getDia() == "jueves") {
                                                echo "selected";
                                            } ?>>Jueves</option>
                                            <option value="viernes" <?php if (isset($sanitized) && $sanitized->getDia() == "viernes") {
                                                echo "selected";
                                            } ?>>Viernes</option>
                                            <option value="sabado" <?php if (isset($sanitized) && $sanitized->getDia() == "sabado") {
                                                echo "selected";
                                            } ?>>Sábado</option>
                                            <option value="domingo" <?php if (isset($sanitized) && $sanitized->getDia() == "domingo") {
                                                echo "selected";
                                            } ?>>Domingo</option>
                                        </select>
                                        <?php
                                        if (isset($errors['dia'])) {
                                            ?>
                                            <p class="text-danger"><small>
                                                    <?php echo $errors['dia']; ?>
                                                </small></p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <input type="hidden" name="tabla" value="tabla1">
                                <input type="hidden" id="datosTabla" name="datosTabla" value="">
                                <button type="submit" name="action" class="btn btn-primary mr-3" value="guardar">Guardar
                                    Entrenamiento</button>
                            </form>
                            <div class="row">
                                <div class="col-6">
                                    <h2>Entrenamiento</h2>
                                    <label for="search-input-1">Buscar:</label>
                                    <input type="search" id="search-input-1" name="search"
                                        placeholder="busqueda de ejercicio">
                                    <table id="table1" class="table table-bordered table-striped  dataTable">
                                        <thead>
                                            <tr>
                                                <th>Ejercicio</th>
                                                <th>Duración</th>
                                                <th>Repeticiones</th>
                                                <th>Descripcion</th>
                                                <th>id</th>
                                                <th>Quitar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($entrenamiento)) {
                                                foreach ($entrenamiento as $ejercicio) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $ejercicio->getNombre(); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $ejercicio->getDuracion(); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $ejercicio->getRepeticiones(); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $ejercicio->getDescripcion(); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $ejercicio->getIdEjercicio(); ?>
                                                        </td>
                                                        <td><button onclick="eliminarFila(this)">quitar</button></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            if (isset($errors['ejercicio'])) {
                                                ?>
                                                <p class="text-danger"><small>
                                                        <?php echo $errors['ejercicio']; ?>
                                                    </small></p>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <h2>Ejercicios</h2>
                                    <label for="search-input-2">Buscar:</label>
                                    <input type="search" id="search-input-2" name="search"
                                        placeholder="busqueda de ejercicio">

                                    <table id="table2" class="table table-bordered table-striped  dataTable">
                                        <thead>
                                            <tr>
                                                <th>Ejercicio</th>
                                                <th>Duración</th>
                                                <th>Repeticiones</th>
                                                <th>Descripcion</th>
                                                <th>id</th>
                                                <th>Añadir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($datos as $ejercicio) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $ejercicio->nombre; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $ejercicio->duracion; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $ejercicio->repeticiones; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $ejercicio->descripcion; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $ejercicio->idEjercicio; ?>
                                                    </td>
                                                    <td><button onclick="anadir(this)">Añadir</button></td>
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
            </div>
        </div>
    </div>
</div>
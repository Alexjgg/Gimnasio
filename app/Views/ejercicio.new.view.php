<div class="row justify-content-center ">
    <div class="col-8 p-5 ">
        <div class="card shadow mb-4">
            <div class="card-header card-header-asneves">
                <h1 class="card-title card-title-h1">
                    <?php echo $titulo; ?>
                </h1>
            </div>
            <form action="./?controller=<?php echo $_GET['controller']; ?>&action=<?php echo $_GET['action']; ?>"
                method="post">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="idEjercicio"
                            value="<?php echo isset($ejercicio) ? $ejercicio->getidEjercicio() : ''; ?>" />
                        <div class="col-md-6 p-3">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
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
                        <div class="col-md-6 p-3">
                            <div class="form-group">
                                <label for="repeticiones">Repeticiones:</label>
                                <input type="number" name="repeticiones" id="repeticiones" class="form-control"
                                    value="<?php echo isset($sanitized) ? $sanitized->getRepeticiones() : ''; ?>"
                                    placeholder="repeticiones" />
                                <?php
                                if (isset($errors['repeticiones'])) {
                                    ?>
                                    <p class="text-danger"><small>
                                            <?php echo $errors['repeticiones']; ?>
                                        </small></p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-7 p-3">
                            <div class="form-group">
                                <label for="duracion">Duración:</label>
                                <input type="text" name="duracion" id="duracion" class="form-control"
                                    value="<?php echo isset($sanitized) ? $sanitized->getDuracion() : ''; ?>"
                                    placeholder="Duración" />
                                <?php
                                if (isset($errors['duracion'])) {
                                    ?>
                                    <p class="text-danger"><small>
                                            <?php echo $errors['duracion']; ?>
                                        </small></p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 p-3">
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <textarea class="form-control" name="descripcion" id="descripcion"
                                    placeholder="Descripcíon..."
                                    class="form-control"><?php echo isset($sanitized) ? $sanitized->getDescripcion() : ''; ?></textarea>
                                <?php
                                if (isset($errors['descripcion'])) {
                                    ?>
                                    <p class="text-danger"><small>
                                            <?php echo $errors['descripcion']; ?>
                                        </small></p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-3">
                    <div class="row justify-content-between">
                        <div class="col-3 pb-3">
                            <button type="submit" name="action" class="btn btn-blue " value="guardar">Guardar</button>
                        </div>
                        <div class="col-2 pb-3">
                            <a href="./" class="btn btn-red float-rigth " value="cancelar">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
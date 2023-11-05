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
                        <input type="hidden" name="idUsuario"
                            value="<?php echo isset($usuario) ? $usuario->getidUsuario() : "" ?>" />
                        <div class="col-md-6 p-3">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control"
                                    value="<?php echo isset($sanitized) ? $sanitized->getNombre() : ""; ?>"
                                    placeholder="nombre" />
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
                        <div class="col-md-7 p-3">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    value="<?php echo isset($sanitized) ? $sanitized->getEmail() : "" ?>"
                                    placeholder="user@domain.org" />
                                <?php
                                if (isset($errors['email'])) {
                                    ?>
                                    <p class="text-danger"><small>
                                            <?php echo $errors['email']; ?>
                                        </small></p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php if (isset($_SESSION['usuario']) && ($_SESSION['usuario']['rol'] == 'admin')) { ?>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="rol">RoL:</label>
                                    <select class="form-control" name="rol" id="rol">
                                        <option value="cliente" <?php echo (isset($sanitized) && $sanitized->getRol() == 'cliente') ? 'selected' : ''; ?>>cliente</option>
                                        <option value="entrenador" <?php echo (isset($sanitized) && $sanitized->getRol() == 'entrenador') ? 'selected' : ''; ?>>entrenador
                                        </option>
                                        <option value="admin" <?php echo (isset($sanitized) && $sanitized->getRol() == 'admin') ? 'selected' : ''; ?>>admin</option>
                                    </select>
                                    <?php
                                    if (isset($errors['rol'])) {
                                        ?>
                                        <p class="text-danger"><small>
                                                <?php echo $errors['rol']; ?>
                                            </small></p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-6 p-3">
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" name="password" id="password" class="form-control" value=""
                                    placeholder="*********" />
                                <?php
                                if (isset($errors['password'])) {
                                    ?>
                                    <p class="text-danger"><small>
                                            <?php echo $errors['password']; ?>
                                        </small></p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 p-3">
                            <div class="form-group">
                                <label for="password2">Reescriba la contraseña:</label>
                                <input type="password" name="password2" id="password2" class="form-control" value=""
                                    placeholder="*********" />
                                <?php
                                if (isset($errors['password2'])) {
                                    ?>
                                    <p class="text-danger"><small>
                                            <?php echo $errors['password2']; ?>
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
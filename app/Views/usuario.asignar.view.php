<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header card-header-asneves">
                <h1 class="card-title card-title-h1">Asignar Clientes</h1>
            </div>
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-6">
                        <h2>Mis clientes</h2>
                        <form
                            action="./?controller=<?php echo $_GET['controller']; ?>&action=<?php echo $_GET['action']; ?>"
                            method="POST" id="formulario">
                            <div class="form-group row p-2">
                                <input type="hidden" name="tabla" value="tabla1">
                                <div clas="col-4 ">
                                    <label for="search-input-1">Buscar:</label>
                                    <input type="search" id="search-input-1" name="search"
                                        placeholder="Búsqueda de clientes">
                                </div>
                                <div class="col-4">
                                    <input type="hidden" id="datosTabla" name="datosTabla" value="">
                                    <button type="submit" name="action" class="btn btn-blue mr-3"
                                        value="guardar">Guardar Clientes</button>
                                </div>
                            </div>
                        </form>
                        <?php if (isset($errors['nombre'])) { ?>
                            <label>
                                <?php echo $errors['nombre']; ?>
                            </label>
                        <?php } ?>
                        <table id="table1" class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>Nombre de Cliente</th>
                                    <th>Email</th>
                                    <th>Quitar</th>
                                    <th>Referencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($misClientes)) {
                                    foreach ($misClientes as $cliente) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $cliente->getNombre(); ?>
                                            </td>
                                            <td>
                                                <?php echo $cliente->getEmail(); ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-red" onclick="eliminarFila(this)">Quitar</button>
                                            </td>
                                            <td>
                                                <?php echo $cliente->getidUsuario(); ?>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                }
                                if (isset($errors['cliente'])) {
                                    ?>
                                    <p class="text-danger"><small>
                                            <?php echo $errors['cliente']; ?>
                                        </small></p>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <h2>Clientes sin entrenador</h2>
                        <div class="row p-3">
                            <div class="col-12">
                                <label for="search-input-2">Buscar:</label>
                                <input type="search" id="search-input-2" name="search"
                                    placeholder="Búsqueda de clientes">
                            </div>
                        </div>
                        <table id="table2" class="table table-bordered table-striped  dataTable">
                            <thead>
                                <tr>
                                    <th>Nombre de Cliente</th>
                                    <th>Email</th>
                                    <th>Mover</th>
                                    <th>Referencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($allClientes)) {
                                    foreach ($allClientes as $cliente) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $cliente->getNombre(); ?>
                                            </td>
                                            <td>
                                                <?php echo $cliente->getEmail(); ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-green" onclick="anadir(this)">Añadir</button>
                                            </td>
                                            <td>
                                                <?php echo $cliente->getidUsuario(); ?>
                                            </td>

                                        </tr>
                                        <?php
                                    }
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
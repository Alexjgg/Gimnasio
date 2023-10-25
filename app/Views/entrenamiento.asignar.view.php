<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h2>Clientes con Entrenamiento</h2>
                            <form
                                action="./?controller=<?php echo $_GET['controller']; ?>&action=<?php echo $_GET['action']; ?>"
                                method="POST" id="formulario">
                                <input type="hidden" name="tabla" value="tabla1">
                                <input type="hidden" id="datosTabla" name="datosTabla" value="">
                                <input type="hidden" name="idEntrenamiento"
                                    value="<?php echo $_GET['idEntrenamiento'] ?>">
                                <button type="submit" name="action" class="btn btn-primary mr-3" value="guardar">Guardar
                                    Clientes</button>
                            </form>
                            <label for="search-input-1">Buscar:</label>
                            <input type="search" id="search-input-1" name="search" placeholder="busqueda de clientes">
                            <table id="table1" class="table table-bordered table-striped  dataTable">
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

                                    if (isset($misClientesConEntrenamiento)) {
                                        foreach ($misClientesConEntrenamiento as $cliente) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $cliente->getnombre(); ?>
                                                </td>
                                                <td>
                                                    <?php echo $cliente->getEmail(); ?>
                                                </td>
                                                <td>
                                                    <button onclick="eliminarFila(this)">Quitar</button>
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
                            <h2>Clientes sin Entrenamiento</h2>
                            <label for="search-input-2">Buscar:</label>
                            <input type="search" id="search-input-2" name="search" placeholder="busqueda de ejercicio">

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
                                                    <button onclick="anadir(this)">Añadir</button>
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
</div>
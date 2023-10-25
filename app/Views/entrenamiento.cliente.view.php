<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter"></i> Filtros</h6>                                    
            </div>
            <form action="./?controller=<?php echo $_GET['controller'];?>&action=<?php echo $_GET['action']; ?>" method="post">
                <div class="card-body"> 
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombre">nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de usuario" value="<?php echo isset($_GET['nombre']) ? filter_var($_GET['nombre'], FILTER_SANITIZE_SPECIAL_CHARS) : ''; ?>" />
                            </div>
                        </div>
                    </div>    
                </div>       
                <button type="submit" name="action" class="btn btn-primary mr-3 float-right" >buscar</button>
            </form>
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Entrenamientos de <?php echo $_SESSION["usuario"]["nombre"]; ?></h6>                                    
                </div>
                <div class="card-body">  
                    <table id="usuariosTable" class="table table-bordered table-striped  dataTable">                    
                        <thead>
                            <tr>
                                <th>Nombre de Entrenamiento</th>
                                <th>Dia</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>                                                
                            <?php
                            foreach ($datos as $entrenamiento) {
                                ?>
                                <tr>
                                    <td><?php echo $entrenamiento->nombre; ?></td>
                                    <td><?php echo $entrenamiento->dia; ?></td>
                                    <td></td>
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
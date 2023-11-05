<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header card-header-asneves">
                <h1 class="card-title card-title-h1">Usuarios</h1>                                    
            </div>
            <form action="./?controller=<?php echo $_GET['controller'];?>&action=<?php echo $_GET['action']; ?>" method="post">
                <div class="card-body"> 
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de usuario" value="<?php echo isset($_GET['nombre']) ? filter_var($_GET['nombre'], FILTER_SANITIZE_SPECIAL_CHARS) : ''; ?>" />
                                <button type="submit" name="action" class="btn btn-primary mt-2" >buscar</button>
                            </div>
                        </div>
                    </div>    
                </div>       
            </form>
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $div_title; ?></h6>                                    
                </div>
                <div class="card-body">  
                    <table id="usuariosTable" class="table table-bordered table-striped  dataTable">                    
                        <thead>
                            <tr>
                                <th>Nombre de usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Editar</th>
                                <th>Eleminar</th>
                            </tr>
                        </thead>
                        <tbody>                                                
                            <?php
                            foreach ($datos as $usuario) {
                                ?>
                                <tr>
                                    <td><?php echo $usuario->nombre; ?></td>
                                    <td><?php echo $usuario->email; ?></td>
                                    <td><?php echo $usuario->rol; ?></td>
                                    <td><a class="btn btn-yellow" href="./?controller=<?php echo $_GET['controller'];?>&action=edit&idUsuario=<?php echo $usuario->idDatosUsuario;?>">Editar</a></td>
                                    <td><a class="btn btn-red" href="./?controller=<?php echo $_GET['controller'];?>&action=deleUser&id=<?php echo $usuario->idDatosUsuario;?>">Eliminar</a></td>
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
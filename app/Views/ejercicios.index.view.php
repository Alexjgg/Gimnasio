<div class="row">
    <div class="col-12">
        <div class="card-success shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold">Ejercicios</h6>                                    
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>nombre</label>
                            <input type="text" class="form-control" id="search-input-1" name="nombre"
                                placeholder="Nombre de ejercicio" value="" />
                        </div>
                    </div>
                </div>
            </div>
                <div class="card-body">  
                    <table id="table-1" class="table table-bordered table-striped  dataTable">                    
                        <thead>
                            <tr>
                                <th>Nombre de Ejercicio</th>
                                <th>Duración</th>
                                <th>Repeticiones</th>
                                <th>Descripcion</th>
                                <th>Editar</th>
                                <th>Eleminar</th>
                            </tr>
                        </thead>
                        <tbody>                                                
                            <?php
                            foreach ($datos as $ejercicio) {
                                ?>
                                <tr>
                                    <td><?php echo $ejercicio->nombre; ?></td>
                                    <td><?php echo $ejercicio->duracion; ?></td>
                                    <td><?php echo $ejercicio->repeticiones; ?></td>
                                    <td><?php echo $ejercicio->descripcion; ?></td>
                                    <td><a href="./?controller=<?php echo $_GET['controller'];?>&action=edit&idEjercicio=<?php echo $ejercicio->idEjercicio;?>">Editar</a></td>
                                    <td><a href="./?controller=<?php echo $_GET['controller'];?>&action=delete&id=<?php echo $ejercicio->idEjercicio;?>">Eliminar</a></td>
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
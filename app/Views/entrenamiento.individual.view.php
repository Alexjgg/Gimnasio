<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header card-header-asneves">
                <h1 class="card-title card-title-h1">Ejercicios</h1>
            </div>
            <div class="card-body p-5">
                <?php foreach ($ejercicios as $ejercicio) { ?>
                    <div class="card m-3 border-cards">
                        <div class=" card-header bg-transparent border-cards">
                            <h2>
                                <?php echo $ejercicio->getNombre(); ?>
                                <h2>
                        </div>
                        <div class="card-body">
                            <h3 class="">Duración:</h5>
                                <p class="card-text">
                                    <?php echo $ejercicio->getDuracion(); ?>
                                </p>
                                <h3 class="">Descripción:</h3>
                                <p class="card-text">
                                    <?php echo $ejercicio->getDescripcion(); ?>
                                </p>
                                <h3>Repeticiones:</h3>
                                <p class="card-text">
                                    <?php echo $ejercicio->getRepeticiones(); ?>
                                </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
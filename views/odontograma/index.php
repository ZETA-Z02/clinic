<?php require('views/navbar.php'); ?> 
<link rel="stylesheet" href="<?php css('odontograma'); ?>">
<div class="grid-container fluid">
    <div class="grid-x">
        <div class="cell text-center">
            <h1>Odontograma</h1>
        </div>
        <div class="cell grid-x">
            <div class="cell large-6 grid-x">
                <div class="cell grid-x text-center">
                    <div class="cell large-2">
                        <button class="button btn-info">1.3</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info">1.2</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info">1.1</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info">2.1</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info">2.2</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info">2.3</button>
                    </div>
                </div>
                <div class="cell grid-x">
                    <div class="cell large-2 text-center">
                        <div class="cell">
                            <button class="button btn-info">1.4</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info">1.5</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info">1.6</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info">1.7</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info">1.8</button>
                        </div>
                    </div>
                    <div class="cell large-8">
                        <img src="<?php image('paladar.png')?>" alt="">
                    </div>
                    <div class="cell large-2 text-center">
                        <div class="cell">
                            <button class="button btn-info">2.4</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info">2.5</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info">2.6</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info">2.7</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info">2.8</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cell large-6 grid-x">
                <div class="cell grid-x">
                    <div class="cell large-2 text-center">
                        <div class="cell">
                            <button class="button btn-primary">4.8</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary">4.7</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary">4.6</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary">4.5</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary">4.4</button>
                        </div>
                    </div>
                    <div class="cell large-8">
                        <img src="<?php image('lengua.png')?>" alt="">
                    </div>
                    <div class="cell large-2 text-center">
                        <div class="cell">
                            <button class="button btn-primary">3.8</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary">3.7</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary">3.6</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary">3.5</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary">3.4</button>
                        </div>
                    </div>
                </div>
                <div class="cell grid-x text-center margin-top-1">
                    <div class="cell large-2">
                        <button class="button btn-primary">4.3</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary">4.2</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary">4.1</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary">3.1</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary">3.2</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary">3.3</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-x margin-top-2 info-diente-seleccionado" id="info-diente">
        <div class="cell large-1 text-center">
            <button class="button btn" id="diente-seleccionado">1.1</button>
        </div>
        <div class="cell large-2">
            <div class="procedimiento">
                <strong class="lead" id="procedimiento">Ortodoncia</strong>
            </div>
        </div>
        <div class="cell grid-x large-3">
            <div class="cell box-img" id="box-img">
                <img src="<?php image('diente.png')?>" alt="Sin imagen subida">
            </div>
            <div class="cell file-upload">
                <label for="file" class="file-label">📂 Subir Imagen</label>
                <input type="file" id="file" accept="image/*">
                <div class="file-name" id="file-name">Ningun Archivo Seleccionado</div>
            </div>
        </div>
        <div class="cell large-6 grid-x">
            <div class="cell large-6">
                <h4>Observaciones: </h4>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatibus temporibus sapiente labore doloremque fugiat voluptatem pariatur reiciendis, tempora natus possimus quos repellat corporis, et vel nostrum, quasi amet inventore quod?</p>
            </div>
            <div class="cell large-6">
                <div class="cell">
                    <select name="" id="">
                        <option value="">ZOE</option>
                        <option value="">DICAL+IONOMERO</option>
                        <option value="">DIR</option>
                    </select>
                </div>
                <div class="cell">
                    <select name="" id="">
                        <option value="">Proceso</option>
                        <option value="">Intermedio</option>
                        <option value="">Finalizado</option>
                    </select>
                </div>
                <div class="cell">
                    <select name="" id="">
                        <option value="">Sano</option>
                        <option value="">Cariado</option>
                        <option value="">Ausente</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php js('odontograma'); ?>"></script>
<?php require('views/footer.php'); ?>
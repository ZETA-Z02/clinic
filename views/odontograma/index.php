<?php require('views/navbar.php'); ?> 
<link rel="stylesheet" href="<?php css('odontograma'); ?>">
<div class="grid-container fluid">
    <div class="grid-x">
        <div class="cell text-center">
            <h2>Odontograma de: <?php echo @$this->data['nombre'].' '.@$this->data['apellido']?></h2>
            <input type="hidden" id="idcliente" class="idcliente" value="<?php echo @$this->data['idcliente']; ?>">
        </div>
        <div class="cell grid-x">
            <div class="cell large-6 grid-x">
                <div class="cell grid-x text-center">
                    <div class="cell large-2">
                        <button class="button btn-info btn-pieza" data-pieza="13">1.3</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info btn-pieza" data-pieza="12">1.2</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info btn-pieza" data-pieza="11">1.1</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info btn-pieza" data-pieza="21">2.1</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info btn-pieza" data-pieza="22">2.2</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-info btn-pieza" data-pieza="23">2.3</button>
                    </div>
                </div>
                <div class="cell grid-x">
                    <div class="cell large-2 text-center">
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="14">1.4</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="15">1.5</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="16">1.6</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="17">1.7</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="18">1.8</button>
                        </div>
                    </div>
                    <div class="cell large-8 img-odontograma superior">
                        <img src="<?php image('superior1.png')?>" alt="">
                    </div>
                    <div class="cell large-2 text-center">
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="24">2.4</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="25">2.5</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="26">2.6</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="27">2.7</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-info btn-pieza" data-pieza="28">2.8</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cell large-6 grid-x">
                <div class="cell grid-x">
                    <div class="cell large-2 text-center">
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="48">4.8</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="47">4.7</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="46">4.6</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="45">4.5</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="44">4.4</button>
                        </div>
                    </div>
                    <div class="cell large-8 img-odontograma inferior">
                        <img src="<?php image('inferior1.png')?>" alt="">
                    </div>
                    <div class="cell large-2 text-center">
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="38">3.8</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="37">3.7</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="36">3.6</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="35">3.5</button>
                        </div>
                        <div class="cell">
                            <button class="button btn-primary btn-pieza" data-pieza="34">3.4</button>
                        </div>
                    </div>
                </div>
                <div class="cell grid-x text-center margin-top-1">
                    <div class="cell large-2">
                        <button class="button btn-primary btn-pieza" data-pieza="43">4.3</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary btn-pieza" data-pieza="42">4.2</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary btn-pieza" data-pieza="41">4.1</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary btn-pieza" data-pieza="31">3.1</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary btn-pieza" data-pieza="32">3.2</button>
                    </div>
                    <div class="cell large-2">
                        <button class="button btn-primary btn-pieza" data-pieza="33">3.3</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-x margin-top-2 info-diente-seleccionado" id="info-diente">
        <div class="cell large-2 text-center">
            <div class="cell">
                <span class="lead">Diente: </span><strong class="diente-seleccionado" id="diente-seleccionado">0.0</strong>
                <input type="hidden" name="diente" id="diente-input">
            </div>
            <div class="cell margin-top-1">
                <select name="procedimientos-select" id="procedimientos-select" class="procedimientos-select"></select>
            </div>
        </div>
        <div class="cell grid-x large-3">
            <div class="cell box-img" id="box-img">
                <img id="imagen-pieza" src="" alt="Sin imagen subida">
            </div>
            <div class="cell file-upload">
                <label for="file" class="file-label">📂 Subir Imagen</label>
                <input type="file" name="file" id="file" accept="image/*">
                <div class="file-name" id="file-name">Ningun Archivo Seleccionado</div>
            </div>
        </div>
        <div class="cell large-7 grid-x grid-margin-x">
            <div class="cell large-8">
                <h4>Observaciones: </h4>
                <textarea name="observaciones" id="observaciones" class="observaciones"></textarea>
            </div>
            <div class="cell large-4">
                <div class="cell">
                    <select name="estado" id="estado">
                        <option value="1">ZOE</option>
                        <option value="2">DICAL+IONOMERO</option>
                        <option value="3">DIR</option>
                    </select>
                </div>
                <div class="cell">
                    <select name="condicion" id="condicion">
                        <option value="1">Sano</option>
                        <option value="2">Cariado</option>
                        <option value="3">Ausente</option>
                    </select>
                </div>
                <div class="cell text-center">
                    <button class="button btn-success" id="guardar">Guardar Todo</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php js('odontograma'); ?>"></script>
<?php require('views/footer.php'); ?>
<?php require 'views/navbar.php'; ?>
<!-- <link rel="stylesheet" href="<?php css('clientesDetalles') ?>"> -->
<div class="grid-container full margin-horizontal-3 padding-horizontal-3" id="clientes-detalles">
    <div class="grid-x">
        <div class="cell text-center">
            <h1>Cliente: <?php echo $this->data['nombre'].' '.$this->data['apellido'] ?></h1>
        </div>
    </div>
    <form action="<?php getrute('clientes/actualizarCliente');?>" method="POST" id="form-cliente">
    <div class="grid-x grid-margin-x">
        <div class="grid-x grid-margin-x cell large-6">
            <div class="cell large-6">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $this->data['nombre']?>">
            </div>
            <div class="cell large-6">
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" value="<?php echo $this->data['apellido']?>">
            </div>
            <div class="cell large-6">
                <label for="dni">DNI</label>
                <input type="text" name="dni" id="dni" value="<?php echo $this->data['dni']?>">
            </div>
            <div class="cell large-6">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" id="telefono" value="<?php echo $this->data['telefono']?>">
            </div>
            <div class="cell large-6">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="<?php echo $this->data['email']?>">
            </div>
            <div class="cell large-6">
                <label for="genero">Genero</label>
                <input type="text" name="sexo" id="genero" value="<?php echo $this->data['sexo']?>">
            </div>
            <div class="cell large-6">
                <label for="ciudad">Ciudad</label>
                <input type="text" name="ciudad" id="ciudad" value="<?php echo $this->data['ciudad']?>">
            </div>
            <div class="cell large-6">
                <label for="direccion">Direccion</label>
                <input type="text" name="direccion" id="direccion" value="<?php echo $this->data['direccion']?>">
            </div>
            <div class="cell large-6">
                <label for="fecreate">Fecha de Creacion</label>
                <input type="text" name="fecreate" id="fecreate" value="<?php echo $this->data['feCreate']?>">
            </div>
            <div class="cell large-6">
                <label for="feupdate">Ultima Actualizacoin</label>
                <input type="date" name="feupdate" id="feupdate" value="<?php echo $this->data['feUpdate']?>">
            </div>
        </div>
        <div class="cell large-6 grid-x grid-margin-x">
            <div class="cell">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>SI</th>
                            <th>NO</th>
                            <th>NO SABE</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-detalles">
                        <tr>
                            <td>Antecedente de alguna Enfermedad</td>
                            <td><input type="radio" name="antecedente" id="antecedente" value="1" <?php echo ($this->response['antecedente_enfermedad'] == 1) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="antecedente" id="antecedente" value="2" <?php echo ($this->response['antecedente_enfermedad'] == 2) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="antecedente" id="antecedente" value="3" <?php echo ($this->response['antecedente_enfermedad'] == 3) ? 'checked' : '';?>></td>
                        </tr>
                        <tr>
                            <td>¿Toma actualmente un medicamento?</td>
                            <td><input type="radio" name="medicamento" id="medicamento" value="1" <?php echo ($this->response['medicado'] == 1) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="medicamento" id="medicamento" value="2" <?php echo ($this->response['medicado'] == 2) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="medicamento" id="medicamento" value="3" <?php echo ($this->response['medicado'] == 3) ? 'checked' : '';?>></td>
                        </tr>
                        <tr>
                            <td>¿Ha tenido alguna complicacion por anestesia?</td>
                            <td><input type="radio" name="anestesia" id="anestesia" value="1" <?php echo ($this->response['complicacion_anestesia'] == 1) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="anestesia" id="anestesia" value="2" <?php echo ($this->response['complicacion_anestesia'] == 2) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="anestesia" id="anestesia" value="3" <?php echo ($this->response['complicacion_anestesia'] == 3) ? 'checked' : '';?>></td>
                        </tr>
                        <tr>
                            <td>¿Es alergico a algun medicamento?</td>
                            <td><input type="radio" name="alergiamedicamento" id="medicamento" value="1" <?php echo ($this->response['alergia_medicamento'] == 1) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="alergiamedicamento" id="medicamento" value="2" <?php echo ($this->response['alergia_medicamento'] == 2) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="alergiamedicamento" id="medicamento" value="3" <?php echo ($this->response['alergia_medicamento'] == 3) ? 'checked' : '';?>></td>
                        </tr>
                        <tr>
                            <td>¿Es Propenso a hemorragias?</td>
                            <td><input type="radio" name="hemorragias" id="hemorragias" value="1" <?php echo ($this->response['hemorragias'] == 1) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="hemorragias" id="hemorragias" value="2" <?php echo ($this->response['hemorragias'] == 2) ? 'checked' : '';?>></td>
                            <td><input type="radio" name="hemorragias" id="hemorragias" value="3" <?php echo ($this->response['hemorragias'] == 3) ? 'checked' : '';?>></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cell large-5">
                <label for="email">Enfermedad</label>
                <input type="text" name="enfermedad" id="enfermedad" value="<?php echo $this->response['enfermedad']?>">
            </div>
            <div class="cell large-7">
                <label for="email">Observaciones</label>
                <textarea name="observaciones" id="observaciones"><?php echo $this->response['observaciones']?></textarea>
            </div>
        </div>
    </div>
    <div class="grid-x buttons">
        <div class="cell text-center">
            <input type="hidden" name="idcliente" id="idcliente" value="<?php echo $this->data['idcliente']?>">
            <button class="button btn-success" type="submit">Actualizar</button>
        </div>
    </div>
    </form>
</div>


<!-- scripts -->
<script src="<?php js('clientesDetalles') ?>"></script>
<?php require 'views/footer.php'; ?>

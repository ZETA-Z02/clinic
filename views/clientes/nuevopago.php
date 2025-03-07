<?php require 'views/navbar.php'; ?>
<link rel="stylesheet" href="<?php css('clientes') ?>">
<div class="grid-container" id="nuevopago-view">
    <form id="form-nuevo-pago" method="POST" class="">
        <div class="grid-x align-center">
            <h2>Nuevo Pago de:<h2 id="cliente-nombre"><?php echo @$this->data['idcliente'];?></h2></h2>
        </div>
        <div class="grid-x grid-margin-x">
            <div class="cell large-4">
                <h3>Tratamiento: </h3>
            </div>
            <div class="cell large-8">
                <!-- ESTE TIENE EL ID DEL PAGO, NO DEL CLIENTE NI DEL TRATAMIENTO->SOLO MUESTRA QUE TRATAMIENTO TIENE LOS PAGOS DEL CLIENTE -->
                 <!-- PSDT: TODO TIENE UN MOTIVO, NO ESTOY LOCO -->
                <select name="idpago" id="tratamiento"></select>
            </div>
        </div>
        <div class="grid-x">
            <table class="table-scroll" id="tabla-nuevo-pago">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Monto Total</th>
                        <th>Importe</th>
                        <th>Deuda</th>
                        <th>Concepto</th>
                    </tr>
                </thead>
                <tbody id="nuevopago-data">
                </tbody>
                <tfoot id="nuevopago-footer">
                    <tr>
                        <td>Nuevo Registro:</td>
                        <td id="mostrar-total">0</td>
                        <td><input type="text" name="monto" id="input-pago" placeholder="Nuevo Pago" required></td>
                        <td id="mostrar-deuda">0</td>
                        <td><input type="text" name="nuevoconcepto" id="input-concepto" placeholder="Concepto" required></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="grid-x">
            <div class="cell large-6">
                <div class="cell grid-x grid-margin-x large-up-3">
                    <div class="cell">
                        <label for="" class="lead">Total a Pagar:</label>
                        <input type="text" name="pago-total" id="mostrar-totalpagar" readonly>
                    </div>
                    <div class="cell">
                        <label for="" class="lead">Pagos:</label>
                        <input type="text" name="pago-monto" id="mostrar-pagos" readonly>
                    </div>
                    <div class="cell">
                        <label for="" class="lead">Deuda:</label>
                        <input type="text" name="pago-deuda" id="mostrar-totaldeuda" readonly>
                    </div>
                </div>
                <a class="button" type="button" id="btn-nuevopago-volver">Volver</a>
                <button class="button btn-success" type="button" id="btn-nuevotratamiento">Nuevo Tratamiento</button>
            </div>
            <div class="cell large-6">
                <!-- ESTE TIENE EL ID DEL PROCEDIMIENTO -->
                <input type="hidden" name="idprocedimiento" id="idprocedimiento">
                <!-- ESTE TIENE EL ID DE CLIENTE -->
                <input type="hidden" name="idcliente" id="id-nuevopago-cliente" value="<?php echo @$this->data['idcliente'];?>">
                <!-- <input type="text" name="idcliente" id="id-nuevopago-cliente">
                <input type="text" name="idprocedimiento" id="idprocedimiento"> -->
                <!-- BOTONES ACCIONES -->
                <div class="grid-x align-spaced">
                    <button class="button btn-info" type="button">Enviar</button>
                    <button class="button btn-warning" type="button" id="btn-boleta-todo">Imprimir Todo</button>
                    <button class="button btn-success" type="submit">Guardar y emitir boleta</button>
            </div>
            </div>
        </div>
    </form>
</div>

<!-- NUEVO PROCEDIMIENTO DE UN MISMO CLIENTE -->
<div class="overlay"></div>
<div class="grid-container nuevocliente">
    <div class="grid-x align-center">
        <h2>Nuevo Procedimiento</h2>
    </div>
    <form method="POST" id="form-nuevocliente">
    <input type="hidden" name="dni" id="dni" value="<?php echo @$this->data['dni'];?>">
    <div class="grid-x grid-margin-x nuevocliente__box nuevocliente--inputs">
        <div class="cell large-6 nuevocliente__item">
            <label for="totalpagar">Total a Pagar</label>
            <input type="text" id="totalpagar" name="totalpagar" required>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="procedimiento">Procedimiento</label>
            <select name="procedimiento" id="procedimiento"></select>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="primerpago">Primer Pago</label>
            <input type="text" id="primerpago" name="primerpago" required>
        </div>
        <div class="cell large-6 nuevocliente__item">
            <label for="concepto">Concepto</label>
            <input type="text" id="concepto" name="concepto" placeholder="Primer Pago" required>
        </div>
    </div>
    <div class="grid-x nuevocliente__box nuevocliente--buttons">
        <div class="cell large-6">
            <button class="button" id="btn-cerrar-nuevocliente" type="button">Cancelar</button>
        </div>
        <div class="cell large-6 text-right">
            <button class="button" type="submit">GUARDAR</button>
        </div>
    </div>
    </form>
</div>
<!-- NUEVO PROCEDIMIENTO DE UN MISMO CLIENTE END -->
 
<script src="<?php js('nuevopago') ?>"></script>
<?php require 'views/footer.php'; ?>
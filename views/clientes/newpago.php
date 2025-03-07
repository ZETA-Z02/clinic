<?php require 'views/navbar.php'; ?>
<link rel="stylesheet" href="<?php css('clientes') ?>">
<div class="grid-container" id="">
    <div class="grid-x grid-margin-x">
        <div class="cell large-4">
            <div class="callout shadow">
                <h3>Presupuesto General</h3>
            </div>
        </div>
        <div class="cell large-4">
            <div class="callout shadow">
                <h3>Presupuesto Ortodoncia</h3>
            </div>
        </div>
        <div class="cell large-4">
            <div class="callout shadow">
                <h3>Presupuesto Otros</h3>
            </div>
        </div>
    </div>
    <div class="grid-x">
        <div class="cell">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Monto Total</th>
                        <th>Importe</th>
                        <th>Deuda</th>
                        <th>Concepto</th>
                        <th>Pieza</th>
                        <th>Doctor</th>
                    </tr>
                </thead>
                <tbody id="nuevopago-data">
                    <tr>
                        <td>2024-12-16</td>
                        <td>
                            COnsulta 200
                        </td>
                        <td>100</td>
                        <td>400</td>
                        <td>Mensualidad</td>
                        <td>24</td>
                        <td>URVI</td>
                    </tr>
                </tbody>
                <tfoot id="nuevopago-footer">
                    <tr>
                        <td>Nuevo Registro:</td>
                        <td id="mostrar-total"><select name="" id="">
                                <option value="">Consulta Dental 500</option>
                                <option value="">Ortodoncia 400</option>
                                <option value="">Blanqueamiento 300</option>
                                <option value="">Sellantes 600</option>
                                <option value="">Consulta Dental 800</option>
                            </select>
                        </td>
                        <td><input type="text" name="monto" id="input-pago" placeholder="Nuevo Pago" required></td>
                        <td id="mostrar-deuda"><input type="text"></td>
                        <td><input type="text" name="nuevoconcepto" id="input-concepto" placeholder="Concepto" required></td>
                        <td>
                            <select name="" id="">
                                <option value="">13</option>
                                <option value="">11</option>
                            </select>
                        </td>
                        <td><select name="" id="">
                            <option value="">Edwin</option>
                            <option value="">Ruben</option>
                        </select></td>
                    </tr>
                </tfoot>
            </table>
        </div>
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
</div>
<?php require 'views/footer.php'; ?>

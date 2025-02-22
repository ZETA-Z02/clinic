<?php require('views/navbar.php'); ?>
<link rel="stylesheet" href="<?php css('pagos'); ?>">
<div class="grid-container fluid">
    <div class="grid-x align-center">
        <h2>Cliente: <?php echo @$this->data['nombre'] . ' ' . @$this->data['apellido']; ?></h2>
        <input type="hidden" id="idcliente" class="idcliente" value="<?php echo @$this->data['idcliente']; ?>">
    </div>
    <hr>
    <div class="grid-x grid-margin-x">
        <button class="cell large-4 callout shadow pagos--titulos activate" id="btn-general" data-id="general">
            <h3>Presupuesto General</h3>
        </button>
        <button class="cell large-4 callout shadow pagos--titulos activate" id="btn-ortodoncia" data-id="ortodoncia">
            <h3>Presupuesto Ortodoncia</h3>
        </button>
        <button class="cell large-4 callout shadow pagos--titulos activate" id="btn-otros" data-id="otros">
            <h3>Presupuesto Otros</h3>
        </button>
    </div>
    <div class="grid-x modal" id="tabla-general">
        <div class="cell">
            <table class="stack">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Pieza</th>
                        <th>Tratamiento</th>
                        <th>Monto</th>
                        <th>Importe</th>
                        <th>Deuda</th>
                        <th>Doctor</th>
                    </tr>
                </thead>
                <tbody id="tbody-general">
                </tbody>
                <tfoot>
                    <tr>
                        <td id="mostrar-fecha" class="mostrar-fecha"></td>
                        <td>
                            <select name="pieza" id="pieza-otros" class="pieza">
                                <option value="1.1">1.1</option>
                                <option value="1.2">1.2</option>
                                <option value="1.3">1.3</option>
                                <option value="1.4">1.4</option>
                                <option value="1.5">1.5</option>
                                <option value="1.6">1.6</option>
                                <option value="1.7">1.7</option>
                                <option value="1.8">1.8</option>
                                <option value="2.1">2.1</option>
                                <option value="2.2">2.2</option>
                                <option value="2.3">2.3</option>
                                <option value="2.4">2.4</option>
                                <option value="2.5">2.5</option>
                                <option value="2.6">2.6</option>
                                <option value="2.7">2.7</option>
                                <option value="2.8">2.8</option>
                                <option value="3.1">3.1</option>
                                <option value="3.2">3.2</option>
                                <option value="3.3">3.3</option>
                                <option value="3.4">3.4</option>
                                <option value="3.5">3.5</option>
                                <option value="3.6">3.6</option>
                                <option value="3.7">3.7</option>
                                <option value="3.8">3.8</option>
                                <option value="4.1">4.1</option>
                                <option value="4.2">4.2</option>
                                <option value="4.3">4.3</option>
                                <option value="4.4">4.4</option>
                                <option value="4.5">4.5</option>
                                <option value="4.6">4.6</option>
                                <option value="4.7">4.7</option>
                                <option value="4.8">4.8</option>
                            </select>
                        </td>
                        <td>
                            <select name="procedimiento" id="procedimiento-general" class="procedimiento"></select>
                        </td>
                        <td>
                            <input type="text" placeholder="Monto a Pagar" name="monto-pagar" id="monto-pagar-general" class="monto-a-pagar" value="50">
                        </td>
                        <td>
                            <input type="text" placeholder="Importe" name="importe" id="importe" class="importe">
                        </td>
                        <td id="mostrar-deuda-general" class="mostrar-deuda">-</td>
                        <td><select name="doctor" id="doctor" class="doctor"></select></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="cell botones-tabla-general margin-1">
            <button class="button btn-edit btn-editar" id="btn-editar">Editar</button>
            <button class="button btn-danger btn-eliminar" id="btn-eliminar">Eliminar <i class="fa fa-trash"></i></button>
        </div>
    </div>
    <div class="grid-x modal" id="tabla-ortodoncia">
        <!-- tabla Ortodoncia -->
         <div class="cell">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Pieza</th>
                        <th>Tratamiento</th>
                        <th>Monto</th>
                        <th>Importe</th>
                        <th>Deuda</th>
                        <th>Doctor</th>
                    </tr>
                </thead>
                <tbody id="tbody-ortodoncia">

                </tbody>
                <tfoot>
                    <tr>
                        <td id="mostrar-fecha" class="mostrar-fecha"></td>
                        <td>
                            <select name="pieza" id="pieza-otros" class="pieza">
                                <option value="1.1">1.1</option>
                                <option value="1.2">1.2</option>
                                <option value="1.3">1.3</option>
                                <option value="1.4">1.4</option>
                                <option value="1.5">1.5</option>
                                <option value="1.6">1.6</option>
                                <option value="1.7">1.7</option>
                                <option value="1.8">1.8</option>
                                <option value="2.1">2.1</option>
                                <option value="2.2">2.2</option>
                                <option value="2.3">2.3</option>
                                <option value="2.4">2.4</option>
                                <option value="2.5">2.5</option>
                                <option value="2.6">2.6</option>
                                <option value="2.7">2.7</option>
                                <option value="2.8">2.8</option>
                                <option value="3.1">3.1</option>
                                <option value="3.2">3.2</option>
                                <option value="3.3">3.3</option>
                                <option value="3.4">3.4</option>
                                <option value="3.5">3.5</option>
                                <option value="3.6">3.6</option>
                                <option value="3.7">3.7</option>
                                <option value="3.8">3.8</option>
                                <option value="4.1">4.1</option>
                                <option value="4.2">4.2</option>
                                <option value="4.3">4.3</option>
                                <option value="4.4">4.4</option>
                                <option value="4.5">4.5</option>
                                <option value="4.6">4.6</option>
                                <option value="4.7">4.7</option>
                                <option value="4.8">4.8</option>
                            </select>
                        </td>
                        <td>
                            <select name="procedimiento" id="procedimiento-ortodoncia" class="procedimiento">
                                <option value="ortodoncia">Ortodoncia</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" placeholder="Monto a Pagar" name="monto-pagar" id="monto-pagar-ortodoncia" class="monto-a-pagar" value="3500">
                        </td>
                        <td>
                            <input type="text" placeholder="Importe" name="importe" id="importe-ortodoncia" class="importe">
                        </td>
                        <td id="mostrar-deuda-ortodoncia" class="mostrar-deuda">-</td>
                        <td>
                            <select name="doctor" id="doctor" class="doctor"></select>
                        </td>
                    </tr>
                </tfoot>
            </table>
         </div>
         <div class="cell">
            <button class="button btn-edit btn-editar" id="btn-editar-ortodoncia">Editar</button>
            <button class="button btn-danger btn-eliminar" id="btn-eliminar-ortodoncia">Eliminar <i class="fa fa-trash"></i></button>
         </div>
    </div>
    <div class="grid-x modal" id="tabla-otros">
        <!-- tabla otros -->
        <div class="cell">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Pieza</th>
                        <th>Tratamiento</th>
                        <th>Monto</th>
                        <th>Importe</th>
                        <th>Deuda</th>
                        <th>Doctor</th>
                    </tr>
                </thead>
                <tbody id="tbody-otros">

                </tbody>
                <tfoot>
                    <tr>
                        <td id="mostrar-fecha-otros" class="mostrar-fecha"></td>
                        <td>
                            <select name="pieza" id="pieza-otros" class="pieza">
                                <option value="1.1">1.1</option>
                                <option value="1.2">1.2</option>
                                <option value="1.3">1.3</option>
                                <option value="1.4">1.4</option>
                                <option value="1.5">1.5</option>
                                <option value="1.6">1.6</option>
                                <option value="1.7">1.7</option>
                                <option value="1.8">1.8</option>
                                <option value="2.1">2.1</option>
                                <option value="2.2">2.2</option>
                                <option value="2.3">2.3</option>
                                <option value="2.4">2.4</option>
                                <option value="2.5">2.5</option>
                                <option value="2.6">2.6</option>
                                <option value="2.7">2.7</option>
                                <option value="2.8">2.8</option>
                                <option value="3.1">3.1</option>
                                <option value="3.2">3.2</option>
                                <option value="3.3">3.3</option>
                                <option value="3.4">3.4</option>
                                <option value="3.5">3.5</option>
                                <option value="3.6">3.6</option>
                                <option value="3.7">3.7</option>
                                <option value="3.8">3.8</option>
                                <option value="4.1">4.1</option>
                                <option value="4.2">4.2</option>
                                <option value="4.3">4.3</option>
                                <option value="4.4">4.4</option>
                                <option value="4.5">4.5</option>
                                <option value="4.6">4.6</option>
                                <option value="4.7">4.7</option>
                                <option value="4.8">4.8</option>
                            </select>
                        </td>
                        <td>
                            <select name="procedimiento" id="procedimiento-otros" class="procedimiento">
                                <!-- <option value="ortodoncia">Ortodoncia</option> -->
                            </select>
                        </td>
                        <td>
                            <input type="text" placeholder="Monto a Pagar" name="monto-pagar" id="monto-pagar-otros" class="monto-a-pagar" value="500">
                        </td>
                        <td>
                            <input type="text" placeholder="Importe" name="importe" id="importe-otros" class="importe">
                        </td>
                        <td id="mostrar-deuda-otros" class="mostrar-deuda">-</td>
                        
                        <td>
                            <select name="doctor" id="doctor" class="doctor"></select>
                        </td>
                    </tr>
                </tfoot>
            </table>
         </div>
         <div class="cell">
            <button class="button btn-edit btn-editar" id="btn-editar-ortodoncia">Editar</button>
            <button class="button btn-danger btn-eliminar" id="btn-eliminar-ortodoncia">Eliminar <i class="fa fa-trash"></i></button>
         </div>
    </div>
</div>
<script src="<?php js('pagos'); ?>"></script>
<?php require('views/footer.php'); ?>
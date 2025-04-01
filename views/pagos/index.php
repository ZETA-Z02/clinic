<?php require('views/navbar.php'); ?>
<link rel="stylesheet" href="<?php css('pagos'); ?>">
<div class="grid-container fluid">
    <div class="grid-x grid-margin-x align-center">
        <div class="cell large-6">
            <h2><?php echo @$this->data['nombre'] . ' ' . @$this->data['apellido']; ?></h2>
            <input type="hidden" id="idcliente" class="idcliente" value="<?php echo @$this->data['idcliente']; ?>">
            <span class="lead" id="mensaje"></span>
        </div>
        <div class="cell large-6 grid-x align-right">
            <table>
                <thead>
                    <tr>
                        <th>Deuda</th>
                        <th>Pagado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td id="deuda_total">s/. 00.00</td>
                        <td id="importe_total">s/. 00.00</td>
                        <td id="total_total">s/. 00.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="grid-x grid-margin-x">
        <button class="cell large-3 callout shadow pagos--titulos activate" id="btn-general" data-id="general">
            <h4>Presupuesto Detallado</h4>
        </button>
        <button class="cell large-3 callout shadow pagos--titulos activate" id="btn-otros" data-id="otros">
            <h4>Presupuesto Nuevos</h4>
        </button>
        <button class="cell large-3 callout shadow pagos--titulos activate" id="btn-ortodoncia" data-id="ortodoncia">
            <h4>Presupuesto Ortodoncia</h4>
        </button>
        <button class="cell large-3 callout shadow pagos--titulos activate" id="btn-presupuesto-total"
            data-id="presupuesto-total">
            <h4>Presupuesto Total</h4>
        </button>
    </div>
    <div class="grid-x modal margin-horizontal-3 padding-horizontal-3" id="tabla-general">
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
                            <input type="text" placeholder="Monto a Pagar" name="monto-pagar" id="monto-pagar-general"
                                class="monto-a-pagar" value="50">
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
        <div class="cell">
            <table>
                <tbody>
                    <tr>
                        <td>Total: </td>
                        <td id="general-total">-</td>
                        <td>Pagado: </td>
                        <td id="general-pagado">-</td>
                        <td>Deuda: </td>
                        <td id="general-deuda">-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="cell grid-x align-spaced botones-tabla-general margin-1">
            <button class="button btn-edit btn-editar" id="btn-editar">Editar</button>
            <a id="iragenda" class="iragenda button btn-success" href="<?php getrute('agenda') ?>">Ir a Agenda</a>
            <a id="irodontograma" class="irodontograma button btn-warning"
                href="<?php getrute('odontograma/render/' . @$this->data['idcliente']) ?>">Ir a Odontograma</a>
            <button class="button btn-danger btn-eliminar" id="btn-eliminar">Eliminar <i
                    class="fa fa-trash"></i></button>
        </div>
    </div>
    <div class="grid-x modal margin-horizontal-3 padding-horizontal-3" id="tabla-ortodoncia">
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
                            <input type="text" placeholder="Monto a Pagar" name="monto-pagar"
                                id="monto-pagar-ortodoncia" class="monto-a-pagar" value="3500">
                        </td>
                        <td>
                            <input type="text" placeholder="Importe" name="importe" id="importe-ortodoncia"
                                class="importe">
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
            <table>
                <tbody>
                    <tr>
                        <td>Total: </td>
                        <td id="ortodoncia-total">-</td>
                        <td>Pagado: </td>
                        <td id="ortodoncia-pagado">-</td>
                        <td>Deuda: </td>
                        <td id="ortodoncia-deuda">-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="cell grid-x align-spaced margin-1">
            <button class="button btn-edit btn-editar" id="btn-editar-ortodoncia">Editar</button>
            <a id="iragenda" class="iragenda button btn-success" href="<?php getrute('agenda') ?>">Ir a Agenda</a>
            <a id="irodontograma" class="irodontograma button btn-warning"
                href="<?php getrute('odontograma/render/' . @$this->data['idcliente']) ?>">Ir a Odontograma</a>
            <button class="button btn-danger btn-eliminar" id="btn-eliminar-ortodoncia">Eliminar <i
                    class="fa fa-trash"></i></button>
        </div>
    </div>
    <div class="grid-x modal margin-horizontal-3 padding-horizontal-3" id="tabla-otros">
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
            <table>
                <tbody>
                    <tr>
                        <td>Total: </td>
                        <td id="otros-total">-</td>
                        <td>Pagado: </td>
                        <td id="otros-pagado">-</td>
                        <td>Deuda: </td>
                        <td id="otros-deuda">-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="cell grid-x align-spaced margin-1">
            <button class="button btn-edit btn-editar" id="btn-editar-ortodoncia">Editar</button>
            <a id="iragenda" class="iragenda button btn-success" href="<?php getrute('agenda') ?>">Ir a Agenda</a>
            <a id="irodontograma" class="irodontograma button btn-warning"
                href="<?php getrute('odontograma/render/' . @$this->data['idcliente']) ?>">Ir a Odontograma</a>
            <button class="button btn-danger btn-eliminar" id="btn-eliminar-ortodoncia">Eliminar <i
                    class="fa fa-trash"></i></button>
        </div>
    </div>
    <div class="grid-x modal margin-horizontal-3 padding-horizontal-3" id="tabla-presupuesto-total">
        <!-- tabla presupuesto total -->
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
                    </tr>
                </thead>
                <tbody id="tbody-presupuesto-total">

                </tbody>
                <tfoot>
                    <tr>
                        <td id="mostrar-fecha-otros" class="mostrar-fecha"></td>
                        <td>
                            <select name="pieza" id="pieza-otros" class="pieza-total">
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
                            <select name="procedimiento" id="procedimiento-presupuesto" class="procedimiento-total">
                                <!-- <option value="ortodoncia">Ortodoncia</option> -->
                            </select>
                        </td>
                        <td>
                            <input type="text" placeholder="Monto a Pagar" name="monto-pagar" id="monto-pagar-presupuesto" class="monto-a-pagar" value="">
                        </td>
                        <td>
                            <input type="text" placeholder="Importe" name="importe" id="importe-presupuesto" class="importe">
                        </td>
                        <td id="mostrar-deuda-presupuesto" class="mostrar-deuda">-</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="cell grid-x align-spaced botones-tabla-general margin-1">
            <button class="button btn-edit btn-editar" id="btn-editar">Editar</button>
            <a id="iragenda" class="iragenda button btn-success" href="<?php getrute('agenda') ?>">Ir a Agenda</a>
            <button class="button btn-danger btn-eliminar" id="btn-eliminar">Eliminar <i class="fa fa-trash"></i></button>
        </div>
    </div>
</div>
<script src="<?php js('pagos'); ?>"></script>
<?php require('views/footer.php'); ?>
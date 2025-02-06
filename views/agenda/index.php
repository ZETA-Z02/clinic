<?php require('views/navbar.php'); ?>
<link rel="stylesheet" href="<?php css('agenda'); ?>">
<div class="grid-container full">
	<div class="grid-x">
		<div class="cell calendario-container" id="calendario">
			<div class="calendar" id="calendar"></div>
		</div>
		<!-- cld == calendario -->
		<div class="cell calendar-forms modales" id="calendar-forms">
			<form method="POST" id="calendario-formulario">
				<div class="grid-x cld__form">
					<div class="cell cld__box cld--title">
						<div class="grid-x grid-margin-x">
							<div class="cell large-2">
								<select name="personal-procedimiento" id="personal-procedimiento"></select>
								<span>-</span>
							</div>
							<div class="cell large-4">
								<div class="cell cliente-search">
									<input type="text" name="cliente" id="cliente" placeholder="Nombre o DNI del cliente" required>
									<ul class="sugerencias" id="cliente-sugerencias"></ul>
									<input type="hidden" name="idcliente" id="cliente_id" required>
								</div>
								<span>-</span>
							</div>
							<div class="cell large-2">
								<select name="procedimientos" id="procedimientos"></select>
								<span>-</span>
							</div>
							<div class="cell large-2">
								<select name="duracion" id="duracion">
									<option value="30M">30M</option>
									<option value="1H">1H</option>
									<option value="1H30M">1H30M</option>
									<option value="2H">2H</option>
								</select>
								<span>-</span>
							</div>
							<div class="cell large-2">
								<select name="personal-creador" id="personal-creador"></select>
							</div>
						</div>
					</div>
					<div class="cell cld__box">
						<div class="cld__box--item">
							<label class="text-info">Inicio: </label>
							<select name="hora-inicio" id="hora-inicio">
								<option value="07:00">07:00 AM</option>
								<option value="07:30">07:30 AM</option>
								<option value="08:00">08:00 AM</option>
								<option value="08:30">08:30 AM</option>
								<option value="09:00">09:00 AM</option>
								<option value="09:30">09:30 AM</option>
								<option value="10:00">10:00 AM</option>
								<option value="10:30">10:30 AM</option>
								<option value="11:00">11:00 AM</option>
								<option value="11:30">11:30 AM</option>
								<option value="12:00">12:00 PM</option>
								<option value="12:30">12:30 PM</option>
								<option value="13:00">01:00 PM</option>
								<option value="13:30">01:30 PM</option>
								<option value="14:00">02:00 PM</option>
								<option value="14:30">02:30 PM</option>
								<option value="15:00">03:00 PM</option>
								<option value="15:30">03:30 PM</option>
								<option value="16:00">04:00 PM</option>
								<option value="16:30">04:30 PM</option>
								<option value="17:00">05:00 PM</option>
								<option value="17:30">05:30 PM</option>
								<option value="18:00">06:00 PM</option>
								<option value="18:30">06:30 PM</option>
								<option value="19:00">07:00 PM</option>
								<option value="19:30">07:30 PM</option>
								<option value="20:00">08:00 PM</option>
							</select>
							<input type="date" class="input-date" name="fecha-inicio" id="fecha-inicio" required>
						</div>
						<div class="cld__box--item">
							<label class="text-info">Fin: </label>
							<select name="hora-fin" id="hora-fin">
								<option value="07:00">07:00 AM</option>
								<option value="07:30">07:30 AM</option>
								<option value="08:00">08:00 AM</option>
								<option value="08:30">08:30 AM</option>
								<option value="09:00">09:00 AM</option>
								<option value="09:30">09:30 AM</option>
								<option value="10:00">10:00 AM</option>
								<option value="10:30">10:30 AM</option>
								<option value="11:00">11:00 AM</option>
								<option value="11:30">11:30 AM</option>
								<option value="12:00">12:00 PM</option>
								<option value="12:30">12:30 PM</option>
								<option value="13:00">01:00 PM</option>
								<option value="13:30">01:30 PM</option>
								<option value="14:00">02:00 PM</option>
								<option value="14:30">02:30 PM</option>
								<option value="15:00">03:00 PM</option>
								<option value="15:30">03:30 PM</option>
								<option value="16:00">04:00 PM</option>
								<option value="16:30">04:30 PM</option>
								<option value="17:00">05:00 PM</option>
								<option value="17:30">05:30 PM</option>
								<option value="18:00">06:00 PM</option>
								<option value="18:30">06:30 PM</option>
								<option value="19:00">07:00 PM</option>
								<option value="19:30">07:30 PM</option>
								<option value="20:00">08:00 PM</option>
							</select>
							<input type="date" class="input-date" name="fecha-fin" id="fecha-inicio" required>
						</div>
					</div>
					<div class="cell cld__box">
						<!-- <div class="cld__box--etiqueta">
							<i class="fa-solid fa-tags" id="etiqueta-icon"></i>
							<select name="etiqueta" id="etiqueta">
								<option value="verde">Verde</option>
								<option value="rojo">Rojo</option>
								<option value="azul">Azul</option>
							</select>
						</div> -->
						<div class="cld__box--mensaje">
							<label for="">Notas</label>
							<textarea name="mensaje" id="mensaje"></textarea>
						</div>
					</div>
				</div>
				<div class="grid-x">
					<div class="cell grid-x align-spaced margin-top-1">
						<button type="button" class="button btn-cancelar" id="btn-cerrar-agenda">Cancelar</button>
						<button type="submit" class="button btn-success">Guardar</button>
					</div>
				</div>
			</form>
		</div>
		<!-- INFO CITA-UPDATE AND DELETE -->
		<div class="cell info-citas modales" id="info-citas">
			<div class="grid-x info">
				<div class="cell cld__box info__box info--title text-center">
					<h3 id="cita-title">Información de la cita</h3>
					<h5 id="cita-nombre">Nombre del Cliente</h5>
				</div>
				<div class="cell cld__box info__box info--date">
					<div class="grid-x">
						<div class="cell large-4">
							<div class="info__date--fecha" id="cita-fecha-inicio">
								2024-01-01
							</div>
							<div class="info__date--hora" id="cita-hora-inicio">
								9:00 AM
							</div>
						</div>
						<div class="cell large-4 text-center">
							<i class="fa-solid fa-chevron-right" id="cita-flecha-icon"></i>
						</div>
						<div class="cell large-4">
							<div class="info__date--fecha" id="cita-fecha-fin">
								2024-01-01
							</div>
							<div class="info__date--hora" id="cita-hora-fin">
								9:00 AM
							</div>
						</div>
					</div>
				</div>
				<div class="cell cld__box info__box info--message">
					<p id="cita-mensaje">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
				</div>
				<div class="cell cld__box grid-x align-spaced">
					<button class="button btn-danger" id="btn-cerrar-info-cita">Cerrar</button>
					<button class="button btn-danger" id="btn-eliminar-cita">Eliminar Cita</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal-citas modales" id="modal">
	<div class="modal-title">
		<h3 id="modal-title"></h3>
	</div>
	<div class="box-citas" id="modal-content">
		<div class="box--cita" id="">
			<!-- CONTENIDO DE LAS CITAS -->
			<span class="box--cita--title lead">Jueves, 4 de Enero, 2025 12:00 PM</span>
			<p>Ed-Zaida-control-30min-ED</p>
		</div>
		<div class="box--cita" id="">
			<!-- CONTENIDO DE LAS CITAS -->
			<span class="box--cita--title lead">Jueves, 4 de Enero, 2025 12:00 PM</span>
			<p>Ed-Zaida-control-30min-ED</p>
		</div>
	</div>
	<button class="button btn-danger" id="btn-cerrar-modal">Cerrar</button>
</div>
<script src="<?php js('agenda'); ?>"></script>
<?php require('views/footer.php'); ?>
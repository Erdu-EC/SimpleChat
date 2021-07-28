<?php
	/*TODO: APLICAR PERMISOS PARA LA SEGURIDAD DE LA INFORMACION MOSTRADA.*/

	namespace HS\app\view;

	use DateTime;
	use Exception;
	use HS\config\APP_URL;
	use HS\libs\collection\Collection;
	use HS\libs\core\Session;

	/** @var Collection $_VIEW */

	$SESSION = new Session();

	/** @throws Exception */
	function ObtenerHora($fecha) {
		return date_format(new DateTime($fecha), 'h:i a');
	}

	function ObtenerFecha($fecha): string {
		$fechaActual = date('Y-m-d');
		$f = date_create($fecha)->setTime(0, 0);
		$hoy = date_create($fechaActual);
		$contador = date_diff($f, $hoy);
		$dias = $contador->days;

		if ($dias == 0) {
			return "Hoy";
		} else if ($dias == 1) {
			return "Ayer";
		} else if ($dias < 6) {
			$dias = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
			return $dias[(date('N', strtotime($f->format('Y-m-d'))) - 1)];
		} else if ($contador->y == 0) {
			$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
			$result = $meses[(date("n", strtotime($f->format('Y-m-d'))) - 1)];
			return $f->format('d') . " de " . $result;
		} else {
			return $f->format("d-m-Y");
		}
	}


?>

<section class="contact-profile no-seleccionable">
	<?php if (!empty($_VIEW->profile_img)) : ?>
        <img src="<?= APP_URL::OfImageProfile($_VIEW->profile_img) ?>?w=40&h=40" alt="">
	<?php else: ?>
        <i class="material-icons">person</i>
	<?php endif; ?>

    <div class="chat-conexion">
        <span class="nombre-chat"> <?= $_VIEW->full_name ?></span>
		<?php if (!empty($_VIEW->state)) : ?>
            <span class="ult-conex">
                <?= $_VIEW->state ?>
            </span>
		<?php endif; ?>
        <!--
                <span class="ult-conex">últ. conex. 18 de may 2021 a la(s) 4:05 p.m.</span>
        -->
    </div>
	<?php if (is_null($_VIEW->is_contact) || !$_VIEW->is_contact) : ?>

        <div class="opciones-contacto">
            <div class="btn-agregar-contacto" title="Agregar a contactos"><span class="material-icons">person_add</span>
                Agregar contacto
            </div>
            <hr class="separador-vertical">
            <div class="btn-bloquear-contacto" title="Bloquear">
                <span class="material-icons">block</span>
                Bloquear

            </div>
        </div>

	<?php endif; ?>
    <div class="icon-info-contacto" title="Información del contacto" id="btn-info-contacto">
        <span class="material-icons">info</span>
    </div>
</section>

<div class="messages" data-usuario="<?= $_VIEW->id ?>">
	<?php if (!is_null($_VIEW->has_invitation) && $_VIEW->has_invitation): ?>
        <div class="notificacion">
            <div id="mensaje-invitacion" class="row border-bottom">
                <p><?= $_VIEW->full_name ?> no está en tus contactos y te ha enviado un mensaje, ¿Quieres aceptarlo?
                </p>
                <div class="botones">
                    <button class="btn btn-si"><span class="material-icons">done</span>Si</button>
                    <button class="btn btn-no"><span class="material-icons">close</span>No</button>
                </div>
            </div>
        </div>


	<?php endif; ?>

    <ul id="lista-mensajes">


		<?php
			$fecha_anterior = '';
			if (!is_null($_VIEW->messages)):
				foreach ($_VIEW->messages as $msg):
					if (!is_null($msg->send_date)) { ?>

						<?php
						$f = new DateTime($msg->send_date);
						if ($fecha_anterior == '' || ($fecha_anterior->format('Y-m-d') !== $f->format('Y-m-d'))) {
							$fecha_anterior = new DateTime($msg->send_date);
							echo '<li class="marcador"><div class="marcador-fecha">' . ObtenerFecha($msg->send_date) . '</div></li>';
						}
					} ?>
					<?php if ($msg->id_source === $SESSION->user_id): ?>
                    <li class="enviado">

                        <img src="<?= $SESSION->user_profile_img ?>?w=37&h=37" alt="" class="no-seleccionable"/>
                        <div class="dir"></div>
                        <div class="cont-msj"><p><?= $msg->content ?></p></div>

                        <div class="extra-mensaje no-seleccionable">
							<?php if (!is_null($msg->read_date)): ?>
                                <div class="extra">
                                    <span><?= ObtenerHora($msg->read_date); ?></span>
                                </div>
                                <div class="extra icon"><i class="fas fa-check-circle"></i></div>
							<?php elseif (!is_null($msg->rcv_date)): ?>
                                <div class="extra">
                                    <span><?= ObtenerHora($msg->rcv_date); ?></span>
                                </div>
                                <div class="extra icon"><i class="far fa-check-circle"></i></div>
							<?php else: ?>
                                <div class="extra">
                                    <span><?= ObtenerHora($msg->send_date); ?></span>
                                </div>
                                <div class="extra icon"><i class="far fa-check-circle"></i></div>
							<?php endif; ?>
                        </div>
                    </li>
				<?php else: ?>

                    <li class="recibido">
                        <img src="<?= APP_URL::OfImageProfile($_VIEW->profile_img) ?>?w=37&h=37" alt=""
                             class="no-seleccionable"/>
                        <div class="dir"></div>
                        <div class="cont-msj"><p><?= $msg->content ?></p></div>
                        <div class="extra-mensaje no-seleccionable">
							<?php if (!is_null($msg->send_date)): ?>
                                <div class="extra">
                                    <span><?= ObtenerHora($msg->send_date); ?></span>
                                </div>
							<?php endif; ?>
                        </div>
                    </li>

				<?php endif;

				endforeach;
			endif;
		?>

        <script> $("#espacio-de-chat .messages").scrollTop($(".messages").prop("scrollHeight")); </script>
    </ul>

</div>
<div class="message-input" id="espacio-de-escritura">
    <div class="utiles">
        <div class="emojis">
            <span class="material-icons" id="btn-emojis">sentiment_satisfied_alt</span>

        </div>

    </div>
    <div class="wrap">
        <label for="contenido-mensaje" style="display: none"></label>
        <input id="contenido-mensaje" type="text" placeholder="Escribe un mensage aquí..."/>
        <button class=" btn" id="btn-enviar-mensaje"><span class="material-icons me-2">send</span></button>
    </div>
</div>
<script type="application/javascript" src="/files/js/emojis.min.js"></script>
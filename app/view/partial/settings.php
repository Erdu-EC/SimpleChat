<?php
	/*TODO: APLICAR PERMISOS PARA LA SEGURIDAD DE LA INFORMACION MOSTRADA.*/

	namespace HS\app\view;

	use HS\libs\collection\Collection;
	use HS\libs\core\Session;

	$SESSION = new Session();
	$USERNAME = $SESSION->user_name;

	/** @var Collection $_VIEW */

	//Obtener Fecha de nacimiento
	function Obtener_fecha($fecha) {
		$meses = array("En.", "Febr.", "Mzo.", "Abr.", "May.", "Jun.", "Jul.", "Agto.", "Sept.", "Oct.", "Nov.", "Dic.");
		$time = strtotime($fecha);
		$res = date("d", $time) . " de " . $meses[(date("n", $time) - 1)] . " de " . date("Y", $time);
		return $res;
	}

?>
<div class="guardar" id="btn-guardar-perfil" title="Guardar cambios">
            <span class="material-icons">
            save
            </span>
</div>

<div class="contenedor-info-cuenta no-seleccionable">
    <div class="row">
        <div class="card">
            <div class="titulo">
                <div class="sm-visible" id="btn-cerrar-configuraciones">
                <span class="material-icons">arrow_back</span>
                </div>
                <span>Perfil</span>
            </div>

            <div class="editar" id="btn-editar-perfil">
                <span class="material-icons" title="Editar">edit</span>
            </div>
            <form action="" id="">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
                        <div class="img-perfil-cuenta">
                            <img id="foto-perfil-cuenta" src="/files/profile/<?= $_VIEW->profile_img ?>?w=200&h=200"
                                 class="" alt=""/>
                            <div class="opciones" id="btn-opciones-perfil">
                                  <span class="material-icons">
                                photo_camera
                                </span>

                            </div>

                            <form action="#" method="post" enctype="multipart/form-data">
                                <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png"
                                       id="nueva-foto-perfil">
                            </form>
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-12 col-lg-7 col-xl-7 columna">
                        <div class="item-perfil-cuenta">
                            <label for="nombres" class="etiqueta-campo contraida">Nombres</label>
                            <input type="text" id="nombres" class="atributo-perfil" readonly minlength="1"
                                   value="<?= $_VIEW->first_name ?>" data-src="<?= $_VIEW->first_name ?>">
                        </div>

                        <div class="item-perfil-cuenta">
                            <label for="apellidos" class="etiqueta-campo contraida">Apellidos</label>
                            <input type="text" id="apellidos" class="atributo-perfil " value="<?= $_VIEW->last_name ?>"
                                   minlength="1"
                                   readonly data-src="<?= $_VIEW->last_name ?>">

                        </div>
                        <div class="item-perfil-cuenta">
                            <label for="fecha_nac" class="etiqueta-campo contraida">Fecha de Nacimiento</label>
                            <div id="valor-fecha_nac" class="atributo-perfil">
								<?= Obtener_fecha($_VIEW->birth_date) ?>
                            </div>

                            <input type="date" id="fecha_nac" class="atributo-perfil ocultar"
                                   value="<?= $_VIEW->birth_date ?>"
                                   readonly <?php echo 'max="', date('Y-m-d'), '"'; ?> min="1900-01-01"
                                   data-src="<?= $_VIEW->birth_date ?>">
                        </div>

                        <div class="item-perfil-cuenta">
                            <label for="genero" class="etiqueta-campo contraida">Género</label>
							<?php
								$g = "";
								switch ($_VIEW->gender) {
									case "F":
										$g = "Femenino";
										break;
									case "M":
										$g = "Masculino";
										break;
									case "O":
										$g = "Otro";
										break;
									case "D":
										$g = "Sin especificar";
										break;
								}
								echo '<div id="valor-genero" class="atributo-perfil">' . $g . ' </div>';
							?>


                            <select name="genero" id="genero" class="atributo-perfil ocultar"
                                    data-src="<?= $_VIEW->gender ?>">
                                <option value="M" <?= ($_VIEW->gender == 'M') ? "selected" : "" ?> >Masculino</option>
                                <option value="F" <?= ($_VIEW->gender == 'F') ? "selected" : "" ?> >Femenino</option>
                                <option value="O" <?= ($_VIEW->gender == 'O') ? "selected" : "" ?> >Otro</option>
                                <option value="D" <?= ($_VIEW->gender == 'D') ? "selected" : "" ?> >Sin especificar
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 columna">
                        <div class="item-perfil-cuenta">
                            <label for="correo_usuario" class="etiqueta-campo contraida">Correo</label>
                            <input type="text" id="correo_usuario" class="atributo-perfil "
                                   value="<?= $_VIEW->email ?>" data-src="<?= $_VIEW->email ?>"
                                   readonly maxlength="255">

                        </div>
                        <div class="item-perfil-cuenta contenedor-telefono-cuenta">
                            <label for="telefono_usuario" class="etiqueta-campo contraida">Teléfono</label>
                            <input type="text" id="telefono_usuario" class="atributo-perfil "
                                   value="<?= $_VIEW->phone ?>"
                                   readonly maxlength="15" data-src="<?= $_VIEW->phone ?>">

                        </div>
                    </div>
            </form>
        </div>
    </div>

</div>
<div class="row">
    <div class="card conf-acceso">

        <form class="form-conf-acceso">
            <input type="text" value="<?= $USERNAME ?>" autocomplete="username" class="visually-hidden">

            <div class="encabezado">
                <span>Configuraciones de  la cuenta</span>
            </div>
            <div class="checkbox-cambio-clave">
                <input type="checkbox" name="check-cambiar-clave" id="check-cambiar-clave">
                <label for="check-cambiar-clave">Cambiar contraseña</label>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="item-cuenta">
                        <label for="clave-ant" class="etiqueta-campo ">Contraseña actual</label>
                        <input type="password" id="clave-ant" class="campo-cuenta" autocomplete="current-password"
                               readonly>
                    </div>
                </div>
                <div class="col-12">
                    <div class="item-cuenta">
                        <label for="clave-nuev" class="etiqueta-campo ">Nueva contraseña</label>
                        <input type="password" id="clave-nuev" class="campo-cuenta" autocomplete="new-password"
                               readonly>
                    </div>
                </div>
                <div class="col-12">
                    <div class="item-cuenta" id="cont-clave-nuev-rep">
                        <label for="clave-nuev-rep" class="etiqueta-campo">Repita la nueva contraseña</label>
                        <input type="password" id="clave-nuev-rep" class="campo-cuenta" autocomplete="new-password"
                               readonly>

                    </div>
                </div>
            </div>
        </form>
    </div>

</div>

</div>

<!-- Script para el espacio de Configuraciones-->

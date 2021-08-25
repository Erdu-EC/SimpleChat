<?php
/*TODO: APLICAR PERMISOS PARA LA SEGURIDAD DE LA INFORMACION MOSTRADA.*/

namespace HS\app\view;
use HS\libs\core\Session;
use const HS\config\APP_NAME;
$SESSION = new Session();
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
                <span >Perfil</span>
            </div>


            <div class="editar" id="btn-editar-perfil" >
                <span class="material-icons" title="Editar">edit</span>
            </div>
            <form action="" id="">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
                        <div class="img-perfil-cuenta">
                            <img id="foto-perfil-cuenta" src="/files/profile/mikeross.png?w=200&h=200" class="" alt="" data-fuente="/files/profile/mikeross.png"/>
                            <div class="opciones" id="btn-opciones-perfil">
                                  <span class="material-icons">
                                photo_camera
                                </span>

                            </div>


                            <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" id="nueva-foto-perfil">


                        </div>

                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-7 col-xl-7 columna">
                        <div class="item-perfil-cuenta">
                            <span class="etiqueta-campo contraida">Nombres</span>
                            <input type="text" id="nombres" class="atributo-perfil"  readonly minlength="1" value="Michael">


                        </div>

                        <div class="item-perfil-cuenta">
                            <span class="etiqueta-campo contraida">Apellidos</span>
                            <input type="text" id="apellidos" class="atributo-perfil " value="Ross" minlength="1" readonly>

                        </div>
                        <div class="item-perfil-cuenta">
                            <span class="etiqueta-campo contraida">Fecha de Nacimiento</span>
                            <div id="valor-fecha_nac" class="atributo-perfil">
                                16 de May. 1986
                            </div>
                            <input type="date" id="fecha_nac" class="atributo-perfil ocultar" value="1986-05-16" readonly <?php echo 'max="',date('Y-m-d'),'"';?>>

                        </div>

                        <div class="item-perfil-cuenta">
                            <span class="etiqueta-campo contraida">Género</span>
                            <div id="valor-genero" class="atributo-perfil">
                                Masculino
                            </div>
                            <select name="genero" id="genero" class="atributo-perfil ocultar">
                                <option value="M" selected >Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="O">Otro</option>
                                <option value="D">Sin especificar</option>
                            </select>
                        </div>
                    </div>
<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 columna">
    <div class="item-perfil-cuenta">
        <span class="etiqueta-campo contraida">Correo</span>
        <input type="text" id="correo_usuario" class="atributo-perfil " value="mikeross@gmail.com"  readonly maxlength="255" >

    </div>
    <div class="item-perfil-cuenta contenedor-telefono-cuenta">
        <span class="etiqueta-campo contraida">Teléfono</span>
        <input type="text" id="telefono_usuario" class="atributo-perfil " value="88888888"  readonly maxlength="15">

    </div>


</div>


                </div>
                  </form>
        </div>

    </div>
   <div class="row">
       <div class="card conf-acceso">

           <form class="form-conf-acceso">
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
                       <span class="etiqueta-campo ">Contraseña anterior</span>
                       <input type="password" id="clave-ant" class="campo-cuenta" readonly>

                   </div>
               </div>
               <div class="col-12">
                   <div class="item-cuenta">
                       <span class="etiqueta-campo ">Nueva contraseña</span>
                       <input type="password" id="clave-nuev" class="campo-cuenta" readonly>
                   </div>
               </div>
               <div class="col-12">
                   <div class="item-cuenta" id="cont-clave-nuev-rep">
                       <span class="etiqueta-campo ">Repita la nueva Contraseña</span>
                       <input type="password" id="clave-nuev-rep" class="campo-cuenta" readonly>

                   </div>
               </div>
           </div>
           </form>
       </div>

   </div>

</div>
<!-- Script para el espacio de Configuraciones-->
<script type="application/javascript" src="/files/js/Settings.js"></script>
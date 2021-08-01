<?php
/*TODO: APLICAR PERMISOS PARA LA SEGURIDAD DE LA INFORMACION MOSTRADA.*/

namespace HS\app\view;
use HS\libs\core\Session;
use const HS\config\APP_NAME;
$SESSION = new Session();
?>
<div class="contenedor-info-cuenta no-seleccionable">
    <div class="row">
        <div class="card">
            <div class="titulo">
                <span >Perfil</span>
            </div>

            <div class="guardar" id="btn-guardar-perfil" title="Guardar cambios">
            <span class="material-icons">
            save
            </span>
            </div>
            <div class="editar" id="btn-editar-perfil" >
                <span class="material-icons" title="Editar">edit</span>
            </div>
            <form action="">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-5 col-xl-5">
                        <div class="img-perfil-cuenta">
                            <img id="foto-perfil-cuenta" src="/files/profile/mikeross.png?w=200&h=200" class="" alt="" />
                            <div class="opciones">
  <span class="material-icons">
photo_camera
</span>
                            </div>
                            <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png">


                        </div>

                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
                        <div class="item-perfil-cuenta">
                            <span class="etiqueta-campo contraida">Nombres</span>
                            <div id="nombres" class="atributo-perfil">
                                Michael James
                            </div>

                        </div>
                        <div class="item-perfil-cuenta">
                            <span class="etiqueta-campo contraida">Apellidos</span>
                            <div id="apellidos" class="atributo-perfil ">
                                Ross
                            </div>

                        </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="item-perfil-cuenta"></div>
                        <div class="item-perfil-cuenta"></div></div>
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
                       <div id="clave-ant" class="campo-cuenta">

                       </div>

                   </div>
               </div>
               <div class="col-12">
                   <div class="item-cuenta">
                       <span class="etiqueta-campo ">Nueva contraseña</span>
                       <div id="clave-nuev" class="campo-cuenta">

                       </div>

                   </div>
               </div>
               <div class="col-12">
                   <div class="item-cuenta">
                       <span class="etiqueta-campo ">Repita la nueva Contraseña</span>
                       <div id="clave-nuev-rep" class="campo-cuenta">

                       </div>

                   </div>
               </div>
           </div>
           </form>
       </div>

   </div>

</div>

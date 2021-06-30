<?php
    /*TODO: APLICAR PERMISOS PARA LA SEGURIDAD DE LA INFORMACION MOSTRADA.*/

    namespace HS\app\view;

    use HS\libs\collection\Collection;
    use HS\libs\core\Session;

    /** @var Collection $_VIEW */

    $SESSION = new Session();
?>
<!--
<div class="card-header">
    <h5 class="row d-flex align-items-center mb-0 user-select-none">
        <div class="col-8">
            <i class="material-icons me-2">person</i>
            <b><?= $_VIEW->full_name ?></b>

            <?php if (!empty($_VIEW->state)) : ?>
                <span class="badge alert-success border-3 ms-2">
                        <?= $_VIEW->state ?>
                    </span>
            <?php endif; ?>
        </div>
        <?php if (is_null($_VIEW->is_contact) || !$_VIEW->is_contact) : ?>
            <div class="col-4 text-end">
                <button class="btn btn-outline-primary btn-agregar-contacto">Agregar contacto</button>
            </div>
        <?php endif; ?>
    </h5>
</div>
-->
<!-- Chat actual y ultima conexión-->
<section class="contact-profile no-seleccionable">
    <img src="/files/profile/harveyspecter.png?w=40&h=40" alt="" />
    <div class="chat-conexion">
        <span class="nombre-chat"><?= $_VIEW->full_name ?></span>
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
            <div class="btn-agregar-contacto" title="Agregar a contactos" ><span class="material-icons">person_add</span>
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


    <div class="card-body">
        <ul id="lista-mensajes">
        <?php if (!is_null($_VIEW->has_invitation) && $_VIEW->has_invitation): ?>
            <div id="mensaje-invitacion" class="row border-bottom">
                <div class="col-10">Alguien que no esta en tus contactos te ha enviado un mensaje, ¿Quieres aceptarlo?
                </div>
                <div class="col-2">
                    <button class="btn btn-outline-primary">Si</button>
                    <button class="btn btn-outline-secondary">No</button>
                </div>
            </div>
        <?php endif; ?>

        <?php
            if (!is_null($_VIEW->messages)):
                foreach ($_VIEW->messages as $msg):
                    if ($msg->id_source === $SESSION->user_id): ?>

                        <li class="enviado">
                            <img src="/files/profile/mikeross.png?w=40&h=40" alt="" />
                            <p><?= $msg->content ?></p>
                            <div class="extra-mensaje">


                            </div>
                        </li>

                    <?php else: ?>
            <li class="recibido">
                <img src="/files/profile/harveyspecter.png?w=40&h=40" alt="" />
                <p><?= $msg->content ?></p>
            </li>
                 <?php endif;
                endforeach;
            endif;

        ?>

        </ul>
    </div>


</div>
<div class="message-input" id="espacio-de-escritura">
    <div class="wrap">
        <input type="text" placeholder="Escribe un mensage aquí..." />
        <button class=" btn" id="btn-enviar-mensaje"><span class="material-icons me-2">send</span></button>
    </div>
</div>
<?php
    /*TODO: APLICAR PERMISOS PARA LA SEGURIDAD DE LA INFORMACION MOSTRADA.*/

    namespace HS\app\view;

    use HS\libs\collection\Collection;
    use HS\libs\core\Session;

    /** @var Collection $_VIEW */
?>

<div class="card h-100 mh-100" data-usuario="<?= $_VIEW->id ?>">
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
    <div class="card-body">
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
                    if ($msg->id_source === (new Session())->user_id): ?>
                        <div class="popover bs-popover-end" style="position: relative; max-width: none">
                            <div class="popover-arrow"
                                 style="position: absolute; transform: translate(0px, 17px);"></div>
                            <!--<h3 class="popover-header">Popover title</h3>-->
                            <div class="popover-body"><?= $msg->content ?></div>
                        </div>
                    <?php else: ?>
                        <div class="popover bs-popover-start" style="position: relative; max-width: none">
                            <div class="popover-arrow"
                                 style="position: absolute; transform: translate(0px, 47px);"></div>
                            <!--<h3 class="popover-header">Popover title</h3>-->
                            <div class="popover-body"><?= $msg->content ?></div>
                        </div>
                    <?php endif;
                endforeach;
            endif;

        ?>


    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col">
                <div id="espacio-de-escritura" class="input-group">
                    <textarea class="form-control border-primary" rows="2"
                              placeholder="Escriba un mensaje..."></textarea>
                    <button class="btn btn-outline-primary d-flex align-items-center input-group-text">
                        <b>Enviar</b>
                        <i class="material-icons ms-2">send</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
function ObtenerElementoMensajeContacto(mensaje) {
    <li className="recibido">
        <img src="<?= APP_URL::OfImageProfile($_VIEW->profile_img) ?>?w=40&h=40" alt="Yo"
             className="no-seleccionable" width="37px" height="37px"/>
        <div className="dir"></div>
        <div className="cont-msj"><p><?= $msg->content ?></p></div>
        <div className="extra-mensaje no-seleccionable">
            <?php if (!is_null($msg->send_date)): ?>
            <div className="extra">
                <span><?= ObtenerHora($msg->send_date); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </li>
}
<?php

namespace HS\app\view;

use const HS\config\APP_NAME;

?>
<div class="content" id="contenido">
    <div class="contact-profile">
        <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
        <p>Harvey Specter</p>
        <div class="social-media">
            <i class="fa fa-facebook" aria-hidden="true"></i>
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <i class="fa fa-instagram" aria-hidden="true"></i>
        </div>
    </div>
    <div class="messages">
        <ul id="lista-mensajes">

            <li class="sent">
                <img src="/files/upload/profile/mikeross.png?w=100&h=100" alt="" />
                <p>How the hell am I supposed to get a jury to believe you when I am not even sure that I do?!</p>
            </li>
            <li class="replies">
                <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                <p>When you're backed against the wall, break the god damn thing down.</p>
            </li>
            <li class="replies">
                <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                <p>Excuses don't win championships.</p>
            </li>
            <li class="sent">
                <img src="/files/upload/profile/mikeross.png?w=100&h=100" alt="" />
                <p>Oh yeah, did Michael Jordan tell you that?</p>
            </li>
            <li class="replies">
                <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                <p>No, I told him that.</p>
            </li>
            <li class="replies">
                <img src="/files/upload/profile/harveyspecter.png?w=100&h=100" alt="" />
                <p>What are your choices when someone puts a gun to your head?</p>
            </li>
            <li class="sent">
                <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                <p>What are you talking about? You do what they say or they shoot you.</p>
            </li>
            <li class="replies">
                <img src="/files/upload/profile/harveyspecter.png" alt="" />
                <p>Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
            </li>
        </ul>
    </div>
    <div class="message-input">
        <div class="wrap">
            <input type="text" placeholder="Escribe un mensage aquí..." />
            <button class=" btn"><i class="fa fa-paper-plane" aria-hidden="true"></i><span class="material-icons me-2">send</span></button>
        </div>
    </div>
</div>
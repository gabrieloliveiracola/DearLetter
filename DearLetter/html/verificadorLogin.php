<?php
    if (!parametrosValidos($_SESSION, ["idUser"])) {
        header("Location: login.php");
    }
?>
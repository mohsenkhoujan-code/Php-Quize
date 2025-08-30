<?php
session_start();

if (isset($_POST["FileBinaryData"])) {
    $_SESSION["fbinary"] = $_POST["FileBinaryData"];
}

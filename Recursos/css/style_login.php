
<?php 
if($_SESSION['empresa'][0]->boton_login <> null || $_SESSION['empresa'][0]->boton_login <> ""){
  $botonLogin = '#'.$_SESSION['empresa'][0]->boton_login;  
}else{
  $fondoNav = '#713a7b';  
}
if($_SESSION['empresa'][0]->fuente_boton_login <> null || $_SESSION['empresa'][0]->fuente_boton_login <> ""){
  $fontButton = '#'.$_SESSION['empresa'][0]->fuente_boton_login;
}else{
  $fontButton = '#white';
}

?>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .flotante {
        display: scroll;
        position: fixed;
        bottom: 90px;
        right: 0px;
    }

    .flotante:hover {
        transform: translateY(-7px);
    }

    body {
        font-family: 'Poppins', sans-serif;
        overflow: hidden;
    }

    .contenedor {
        text-align: center;
        justify-content: center;
        width: 100vw;
        height: 100vh;
        display: grid;
        grid-gap: 7rem;
        padding: 0 2rem;
        align-items: center;
    }

    h3 {
        color: #102405;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    .contenido-login {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        text-align: center;
    }

    .img img {
        width: 500px;
    }

    form {
        width: 360px;
    }

    .contenido-login img {
        height: 100px;
    }

    .contenido-login h2 {
        /*titulo*/
        margin: 15px 0;
        color: #333;
        text-transform: uppercase;
        /*mayusculas*/
        font-size: 2.9rem;
    }

    .contenido-login .input-div {
        position: relative;
        display: grid;
        grid-template-columns: 7% 93%;
        margin: 25px 0;
        padding: 5px 0;
        border-bottom: 2px solid #d4bebe;
    }

    .contenido-login .input-div.dni {
        margin-top: 0;
    }

    .i {
        color: #d4bebe;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .i i {
        transition: .3s;
    }

    .input-div>div {
        position: relative;
        height: 45px;
    }

    .input-div>div>h5 {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #999999;
        font-size: 18px;
        transition: .3s;
    }

    .input-div.focus>div>h5 {
        top: -5px;
        font-size: 15px;
    }

    .input-div:before,
    .input-div:after {
        content: '';
        position: absolute;
        bottom: -2px;
        width: 0%;
        height: 2px;
        background-color: #102405;
        transition: .4s;
    }

    .input-div::before {
        right: 50%;
    }

    .input-div:after {
        left: 50%;
    }

    .input-div.focus:before,
    .input-div.focus:after {
        width: 50%;
    }

    .input-div.focus>.i>i {
        color: #102405;
    }

    .input-div>div>input {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        border: none;
        outline: none;
        background: none;
        padding: 0.5rem 0.7rem;
        font-size: 1.2rem;
        color: #555;
        font-family: 'Poppins', sans-serif;
    }

    .input-div.pass {
        margin-bottom: 4px;
    }

    a {
        display: block;
        text-align: right;
        text-decoration: none;
        color: #999;
        font-size: 0.9rem;
    }

    a:hover {
        color: rgb(16, 231, 203);
    }

    .btn {
        display: block;
        width: 100%;
        height: 50px;
        border-radius: 25px;
        outline: none;
        border: none;
        background-image: linear-gradient(to right, <?= $botonLogin?>, <?= $botonLogin?>, #022b20);
        background-size: 200%;
        font-size: 1.2rem;
        color: <?= $fontButton?>,;
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        margin: 1rem 0;
        cursor: pointer;
        transition: .5s;
    }

    .btn:hover {
        background-position: right;
        color: #fff;
    }
</style>
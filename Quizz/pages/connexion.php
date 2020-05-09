<?php
    if (isset($_POST['btn_submit'])) {
        $login = $_POST['login'];
        $pwd = $_POST['pwd'];
        $result = connexion($login,$pwd);
        if ($result == "error") {
            $error = "login ou mot de passe incorrect";
        }
        else{
            header("location: index.php?lien=".$result);
        }
        
    }
?>
<style>
    @media screen and (max-width: 479px){
        .container {
            position: relative;
            top: 10%;
            left: 15%;
            height: 60%;
            width: 65%;
            background-color: white;
        }
        .btn-form {
            margin-top: 40px;
            border-radius: 5px;
            border: 1px solid #3addd6;
            padding: 5px;
            color: white;
            background-color: #3addd6;
            font-size: 12px;
            font-weight: bold;
        }
        .link-form {
            margin-left: 15px;
            text-decoration: none;
            color: silver;
            font-size: 12px;
            font-weight: bold;
        }
        .header-text {
            color: white;
            position: absolute;
            top: 25px;
            left: 30%;
            font-size: 25px;
            font-weight: bold;
        }
    }
</style>

<div class="container">
    <div class="container-header">
        <div class="title">Login Form</div>
    </div>
    <div class="container-body">
        <form action="" method="post" id="form-connexion">
            <div class="input-form">
                <div class="icon-form icon-form-login"></div>
                <input type="text" class="form-control" error="error-1" name="login" id="" placeholder="Login" >
                <div class="error-form" id="error-1"></div>
            </div>
            <div class="input-form">
                <div class="icon-form icon-form-pwd"></div>
                <input type="password" class="form-control" error="error-2" name="pwd" id="" placeholder="Password">
                <div class="error-form" id="error-2"> <?php if (!empty($error)) {
                    echo $error;
                } ?> </div>
            </div>

            <div class="input-form">
                <button type="submit" name="btn_submit" class="btn-form">Connexion</button>
                <a href="index.php?lien=admin_inscription" class="link-form">Sinscrire pour jouer ?</a>
            </div>
        </form>
    </div>
</div>

<script>
    const inputs = document.getElementsByTagName("input");
    for(input of inputs){
        input.addEventListener("keyup", function(e){
            if (e.target.hasAttribute("error")) {
                var idDivError = e.target.getAttribute("error");
                document.getElementById(idDivError).innerHTML=""
            }
        })
    }
    document.getElementById("form-connexion").addEventListener("submit", function(e){
        const inputs = document.getElementsByTagName("input");
        var error = false;
        for(input of inputs){
            if (input.hasAttribute("error")) {
                var idDivError = input.getAttribute("error");
                if (!input.value) {
                    document.getElementById(idDivError).innerText = "Ce champs est obligatoire"
                    error = true
                }
                
            }
        }
    if (error) {
        e.preventDefault();
        return false;
    }
    })
</script>
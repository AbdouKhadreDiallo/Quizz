<!--  -->

<?php
$loginErro = "";
$passwordError  = "";
$errorformat = "";
$prenom = "";
$nom = "";
$login = "";
if (isset($_POST['btn_submit'])) {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $pwd = $_POST['pwd'];
    $login = $_POST['login'];
    if (isset($_SESSION['user'])) {
        $profil = "admin";
    } else {
        $profil = 'joueur';
    }

    $file = "./data/utilisateur.json";
    $mainjson = file_get_contents($file);
    $data = json_decode($mainjson, true);
    $format_autorises = [
        'image/png',
        'image/jpg',
        'image/jpeg'
    ];
    if (in_array($_FILES['photo']['type'], $format_autorises)) {
        $array = explode('.', $_FILES['photo']['name']);
        $filename = date('YmdHis') . "." . $array[sizeof($array) - 1];
        if (move_uploaded_file($_FILES['photo']['tmp_name'], '.\/public\/images\/' . $filename)) {
            $photo = '.\/public\/images\/' . $filename;
        } else {
            $errorformat = "format incorrect";
        }
    }

    if ((is_in($_POST['login']) || ($_POST['pwd'] != $_POST['pwd_confirm']))) {
        if (is_in($_POST['login'])) {
            $loginErro = "ce login existe déjà";
        }
        if (($_POST['pwd'] != $_POST['pwd_confirm'])) {
            $passwordError = "les deux mots de passe doivent etre identique";
        }
    } else {
        $data[] = array(
            "prenom" => $prenom,
            "nom" => $nom,
            "login" => $login,
            "password" => $pwd,
            "profil" => $profil,
            "photo" => $photo,
            "score" => 0
        );
        $jsonfile = json_encode($data, JSON_PRETTY_PRINT);
        $save = file_put_contents($file, $jsonfile);
        if ($save) {
            $result = connexion($login, $pwd);
            header("location: index.php?lien=" . $result);
        }
    }
}
?>
<?php
if (isset($_SESSION['user'])) {
?>
    <link rel="stylesheet" href="./public/css/admin.css">
<?php
} else {
?>
    <link rel="stylesheet" href="./public/css/user.css">
<?php
}
?>

<div class="inscription-container-admin inscription-container">
    <div class="inscription-header">
        <span id="inscription">S'inscrire</span> <br>
        <span>Pour proposer des quizz</span>
        <hr>
    </div>
    <div class="form-container-admin form-container">
        <form action="" method="post" id="form-connexion" enctype="multipart/form-data">
            <div class="input-form-admin input-form-user">
                <label for="">Prénom</label><br>
                <input type="text" class="form-control-admin form-control-user" error="error-1" name="prenom" id="" placeholder="Prénom" value="<?php echo $prenom ?>">
                <div class="error-form" id="error-1"></div>
            </div>
            <div class="input-form-admin input-form-user">
                <label for="">Nom</label><br>
                <input type="text" class="form-control-admin form-control-user" error="error-2" name="nom" id="" placeholder="Nom" value="<?php echo $nom ?>">
                <div class="error-form" id="error-2"></div>
            </div>
            <div class="input-form-admin input-form-user">
                <label for="">Login</label><br>
                <input type="text" class="form-control-admin form-control-user" error="error-4" name="login" id="" placeholder="Login" value="<?php echo $login ?>">
                <div class="error-form" id="error-4"></div>
            </div>
            <div class="input-form-admin input-form-user">
                <label for="">Password</label><br>
                <input type="password" class="form-control-admin form-control-user" error="error-5" name="pwd" id="" placeholder="Password">
                <div class="error-form" id="error-5"></div>
            </div>
            <div class="input-form-admin input-form-user">
                <label for="">Confirmer Password</label><br>
                <input type="password" class="form-control-admin form-control-user" error="error-6" name="pwd_confirm" id="" placeholder="Password">
                <div class="error-form" id="error-6"><?php if (!empty($passwordError)) {
                    echo $passwordError;
                } ?></div>
            </div>
            <label for="" id="labell">Avatar</label>
            <div class="parent-div-admin input-form-user input-form-admin parent-div">

                <button class="btn-upload-admin btn-upload">Choisir le fichier</button>
                <input type='file' id='getval' name="photo" error="error-7" onchange="readURL(event)" /><br /><br />
                <div class="error-form" id="error-7"></div>
            </div>
            <div class="input-form-admin input-form-user">
                <button type="submit" name="btn_submit" class="btn-form-admin btn-form-user">Créer compte</button>

            </div>
        </form>
    </div>
    <div class="admin-avatar-container user-avatar-container">
        <div class="admin-avatar user-avatar" id="output"></div>
    </div>

</div>

<script>
    const inputs = document.getElementsByTagName("input");
    for (input of inputs) {
        input.addEventListener("keyup", function(e) {
            if (e.target.hasAttribute("error")) {
                var idDivError = e.target.getAttribute("error");
                document.getElementById(idDivError).innerHTML = ""
            }
        })
    }
    document.getElementById("form-connexion").addEventListener("submit", function(e) {
        const inputs = document.getElementsByTagName("input");
        var error = false;
        for (input of inputs) {
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    var check = function() {
        if (document.getElementById('pwd').value != document.getElementById('pwd_confirm').value) {
            document.getElementById('pwd_confirm').style.borderColor = 'red';
        } else {
            document.getElementById('pwd_confirm').style.borderColor = '#3addd6';
        }
    }

    function readURL(event) {
        var getImagePath = URL.createObjectURL(event.target.files[0]);
        $('#output').css('background-image', 'url(' + getImagePath + ')');
    }
</script>
<?php
$libelleError = '';
$libelle = '';
$nomdePointError = '';
$questionType = '';
$reponsePossible = '';
if (isset($_POST['btn_submit'])) {

    $tabError = [];

    // traque des erreurs
    if (empty($_POST['libelle'])) {
        $libelleError = "ce champs est obligatiore";
        $tabError[] = $libelleError;
    } else {
        $libelle = $_POST['libelle'];
    }
    if (empty($_POST['nombrePoint']) || $_POST['nombrePoint'] < 1) {
        $nomdePointError = 'ce champs est obligatiore et doit etre superieur à 1';
        $tabError[] = $nomdePointError;
    } else {
        $nombrePoint = $_POST['nombrePoint'];
    }
    if (empty($_POST['QuestionType'])) {
        $questionTypeError = 'ce champs est obligatoire';
        $tabError[] = $questionTypeError;
    } else {
        $questionType = $_POST['QuestionType'];
    }
    if (empty($_POST['ReponseMultiple'])) {
        $reponsePossibleError = 'ce champs est obligatoire';
        $tabError[] = $reponsePossibleError;
    } else {
        $reponsePossible = $_POST['ReponseMultiple'];
    }
    

    // si ya d'erreurs on ajoute le tout dans le fichier json
    if (empty($tabError)) {
        $n = count($reponsePossible);
        if ($questionType == "multiple") {
            for ($i = 1; $i <= $n; $i++) {
                if (!empty($_POST['multipleChoice' . $i])) {
                    $tabReponse[] = $reponsePossible[$i - 1];
                }
            }
        } elseif ($questionType == "text") {

            $tabReponse = strtolower($reponsePossible[0]);
        } elseif ($questionType == "simple") {
            for ($i = 1; $i <= $n; $i++) {
                if ($_POST['reponse'] == $i) {
                    $tabReponse = $reponsePossible[$i - 1];
                }
            }
        }
        $file = "./data/question.json";
        $data = getData('question');
        $data[] =  array(
            "libelle" => $libelle,
            "score" => $nombrePoint,
            "type" => $questionType,
            "reponsePossible" => $reponsePossible,
            "bonneReponse" => $tabReponse
        );
        $jsonfile = json_encode($data, JSON_PRETTY_PRINT);
        $save = file_put_contents($file, $jsonfile);
    }
}
?>

<div class="right">
    <div class="question-indication">
        <h1>Paramétrer votre question</h1>
    </div>
    <div class="creationQuestion-body">
        <form method="post" id="form-connexion">
            <div class="input-form-question">
                <label for="">Question</label>
                <input type="text" name="libelle" id="like-textarea" class="form-control-question" error='error-12' value="<?php echo $libelle ?>">
                <div class="error-form" id="error-12"> <?php if (empty($_POST['libelle'])) {
                                                            echo $libelleError;
                                                        } ?> </div>
            </div>
            <div class="input-form-question" id="input-form-second-question">
                <label for="">Nbre de points</label>
                <input type="number" name="nombrePoint" id="number-specificies" class="form-control-question" error='error-13'>
                <div class="error-form" id="error-13"> <?php if (isset($nombrePoint) && $nombrePoint < 1) {
                                                            echo $nomdePointError;
                                                        } ?></div>
            </div>
            <div class="input-form-question" id="input-form-second-question">
                <label for="">Type de Question</label>
                <select name="QuestionType" id="selection-dropdown" class="form-control-question">
                    <option value="">Donnez le type de réponse</option>
                    <option value="text">Text</option>
                    <option value="simple">Choix Simple</option>
                    <option value="multiple">Choix multiple</option>
                </select>

                <a href="javascript:void(0);" id="add-question" title="Add field">
                    <div id="fg"></div>
                </a>


                <div class="error-form" id="error-1"></div>
            </div>
            <div id="type-reponse">

            </div>
            <div class="input-form-admin input-form-user">
                <button type="submit" name="btn_submit" class="btn-form-admin btn-form-user" id="btcheck">Enregistrer</button>

            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script>
    // mettre le premier select en display none
    let selectionDropdown = document.getElementById("selection-dropdown");
    let selectionOptions = selectionDropdown.getElementsByTagName("option");
    selectionOptions[0].disabled = true;

    // generation des inputs

    (function() {
        var selectionDropdown = document.getElementById("selection-dropdown");
        var typeQuestion = document.getElementById('selection-dropdown');
        var counter = 0;
        var counterOne = 0;
        var counterTwo = 0;
        var btn = document.getElementById('add-question');
        var question = document.getElementById('type-reponse');

        // fonction à display si le choix est multiple
        var choixMultiple = function() {
            counter++;
            var div = document.createElement("div");
            var label = document.createElement("label");
            var newtexte = document.createTextNode("Réponse " + counter);
            var input = document.createElement("input");
            var img = document.createElement('img');
            var divError = document.createElement('div');
            divError.setAttribute('class', 'error-form');
            divError.id = 'error-' + counter;
            var checkbox = document.createElement('input');
            div.id = 'todelete' + counter;
            div.setAttribute('class', 'input-form-question');
            label.appendChild(newtexte);
            input.id = 'generated-input';
            input.type = 'text';
            input.setAttribute('error', 'error-' + counter);
            checkbox.type = 'checkbox';
            checkbox.name = 'multipleChoice' + counter;
            input.name = 'ReponseMultiple[]';
            img.src = './public/icones/ic-supprimer.png';
            img.setAttribute("onclick", "document.getElementById('todelete" + counter + "').innerHTML=''");
            img.id = "sup";
            div.appendChild(label);
            div.appendChild(input);
            div.appendChild(checkbox);
            div.appendChild(img);
            div.appendChild(divError);
            question.appendChild(div);

            //validation checkbox
            $(function () {
            $("#btcheck").click(function () {
            var checked = $("input[type=checkbox]:checked").length;
            if (checked < 1) {
                alert("veuillez entrer une reponse.");
                return false;
            }
        });
        });
        };


        // fonction à display si le choix est simple
        // var counter = 0;
        var choixSimple = function() {
            counterTwo++;
            var div = document.createElement("div");
            var label = document.createElement("label");
            var newtexte = document.createTextNode("Réponse " + counterTwo);
            var input = document.createElement("input");
            var img = document.createElement('img');
            var radio = document.createElement('input');

            var divError = document.createElement('div');
            divError.setAttribute('class', 'error-form');
            divError.id = 'error-' + counterTwo;

            div.id = 'todelete' + counterTwo;
            label.appendChild(newtexte);
            input.id = 'generated-input';
            div.setAttribute('class', 'input-form-question');
            input.setAttribute('error', 'error-' + counterTwo);
            input.type = 'text';
            radio.type = 'radio';
            radio.name = "reponse";
            radio.value = counterTwo;
            input.name = 'ReponseMultiple[]';
            img.src = './public/icones/ic-supprimer.png';
            img.setAttribute("onclick", "document.getElementById('todelete" + counterTwo + "').innerHTML=''");
            div.appendChild(label);
            div.appendChild(input);
            div.appendChild(radio);
            div.appendChild(img);
            div.appendChild(divError);
            question.appendChild(div);

            // validatio radio
            $(document).ready(function(){
                $("#btcheck").click(function(){
                    var radioValue = $("input[type='radio']:checked").val();
                    if(!radioValue){
                        alert("veuillez entrer une reponse");
                        return false;
                    }
                });
            });

        };
        // fonction à display si le choix est texte


        var choixTexte = function() {
            counterOne++;
            var div = document.createElement("div");
            var label = document.createElement("label");
            var newtexte = document.createTextNode("Reponse");
            var input = document.createElement("input");
            var divError = document.createElement('div');
            divError.setAttribute('class', 'error-form');
            input.setAttribute('error', 'error-25');
            divError.id = 'error-25';
            div.setAttribute('class', 'input-form-question');
            label.appendChild(newtexte);
            input.id = 'generated-input';
            input.type = 'text';
            input.name = 'ReponseMultiple[]';
            div.appendChild(label);
            div.appendChild(input);
            div.appendChild(divError);
            question.appendChild(div);
        };


        // l'evenement sur le bouton clik
        btn.addEventListener('click', function() {
            if (selectionDropdown.value == 'multiple') {
                choixMultiple();


            } else if (selectionDropdown.value == 'simple') {
                choixSimple();

            } else if (selectionDropdown.value == 'text') {
                choixTexte();
                // document.getElementById('fg').style.display = "none";
                btn.style.display = "none";

            }

        }.bind(this));
        selectionDropdown.addEventListener('change', function() {
            document.getElementById('type-reponse').innerHTML = '';
            document.getElementById('add-question').style.display = 'inline';
        });

        return false
    })();


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

<style>
    .input-form-question {
        margin-top: 5px;
        margin-left: 10px;
    }

    #input-form-question {
        margin-top: 5px;
        margin-left: 10px;
    }

    #generated-input {
        background-color: #f0eeee;
        border: none;
        box-shadow: 1px 1px 1px #3addd6;
        position: relative;
        left: 10px;
        height: 30px;
        width: 70%;
    }

    input[type=radio] {
        border: 0px;
        width: 20px;
        height: 20px;
        position: relative;
        left: 10px;
        top: 5px;
    }

    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.5);
        /* IE */
        -moz-transform: scale(1.5);
        /* FF */
        -webkit-transform: scale(1.5);
        /* Safari and Chrome */
        -o-transform: scale(1.5);
        /* Opera */
        transform: scale(1.5);
        padding: 5px;
        border: none;
        box-shadow: 1px 1px 1px #3addd6;
        position: relative;
        left: 15px;
    }

    .btn-form-admin {
        margin-top: 20px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #3addd6;
        padding: 10px;
        color: white;
        background-color: #3addd6;
        font-size: 15px;
        font-weight: bold;
        position: relative;
        left: 83%
    }

    .input-form-question>img {
        position: relative;
        left: 25px;
        top: 4px;
    }
</style>
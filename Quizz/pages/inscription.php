<?php
is_connect();

?>
<?php


$liste = getData();
$liste = array_sort($liste, 'score', SORT_DESC);
foreach ($liste as $key => $value) {
    if ($value['profil'] == 'joueur') {
        $tab[] = $value;
    }
}


//melangeons les donnees de la liste



$npage = 5;
if (!isset($_GET['pages'])) {
    $pages = 1;
} else {
    $pages = $_GET['pages'];
}
$min = ($pages - 1) * 1;
$max = $min + 1;
if ($pages <= 1) {
    $pages = 1;
    $prev = 'none';
} elseif ($pages > $npage) {
    $pages = $npage;
}
if ($pages < $npage) {
    $end = 'none';
}
if ($pages == $npage) {
    $max = $max = $min + 1;
    $next = 'none';
    $end = 'block';
}

// traitement back
// var_dump($_SESSION['user']['score']);



for ($i = $min; $i < $max; $i++) {
    
    $tabReponse = '';
    $check = '';
    $cocher = [];

    if (isset($_POST['btn'])) {
        $point = 0;

        $_SESSION['point'] = 0;
        if ($_POST['btn'] == "next") {

            if (isset($_SESSION['question'][$i - 1]['type'])) {
                $_SESSION['scoreT'] += $_SESSION['question'][$i - 1]['score'];
                if ($_SESSION['question'][$i - 1]['type'] == 'text') {
                    if (isset($_POST['reps'])) {
                        $_SESSION['usersReps'][] = $_POST['reps'];
                        $_SESSION['text'][]= $_POST['reps'];
                        var_dump($_SESSION['text']);
                       
                    } else {
                        echo 'choix text faux';
                    }
                } elseif ($_SESSION['question'][$i - 1]['type'] == 'multiple') {
                    $reponse = $_SESSION['question'][$i - 1]['reponsePossible'];
                    $n = count($reponse);
                    for ($j = 0; $j < $n; $j++) {
                        if (!empty($_POST['checkboxes' . $j])) {
                            $cocher[] = $reponse[$j];
                        }
                    }
                    $_SESSION['usersReps'][] = $cocher;
                    $_SESSION['multiple'][] = $cocher;
                    // var_dump($_SESSION['usersReps']);
                    var_dump($_SESSION['multiple']);
                } else {
                    $reponse = $_SESSION['question'][$i - 1]['reponsePossible'];
                    $n = count($reponse);
                    for ($j = 0; $j < $n; $j++) {
                        if (isset($_POST['choix']) &&  $_POST['choix'] == $j) {
                            $_SESSION['usersReps'][] = $reponse[$j];
                            $_SESSION['simple'][] = $reponse[$j];
                        }
                    }
                    var_dump($_SESSION['simple']);
                }
            }
            
        } elseif ($_POST['btn'] == "end") {
            // var_dump($_SESSION['question'][$i]['score']);
            if (isset($_SESSION['question'][$i]['type'])) {
                $_SESSION['scoreT'] += $_SESSION['question'][$i]['score'];
                if ($_SESSION['question'][$i]['type'] == 'text') {
                    if (isset($_POST['reps'])) {
                        $_SESSION['usersReps'][] = $_POST['reps'];
                        $_SESSION['text'][]= $_POST['reps'];
                        var_dump($_SESSION['text']);
                    } else {
                        echo 'wronngg';
                    }
                } elseif ($_SESSION['question'][$i]['type'] == 'multiple') {
                    $reponse = $_SESSION['question'][$i]['reponsePossible'];
                    $n = count($reponse);
                    for ($j = 0; $j < $n; $j++) {
                        if (!empty($_POST['checkboxes' . $j])) {
                            // $check = 'checked';
                            $cocher[] = $reponse[$j];
                        }
                    }
                    $_SESSION['usersReps'][] = $cocher;
                    $_SESSION['multiple'][] = $cocher;
                    // var_dump($_SESSION['usersReps']);
                    var_dump($_SESSION['multiple']);
                } else {
                    $reponse = $_SESSION['question'][$i]['reponsePossible'];
                    $n = count($reponse);

                    for ($j = 0; $j < $n; $j++) {
                        if (isset($_POST['choix']) &&  $j == ($_POST['choix'])) {
                            $_SESSION['usersReps'][] = $reponse[$j];
                            $_SESSION['simple'][] = $reponse[$j];
                        }
                    }
                    var_dump($_SESSION['simple']);
                }
                // var_dump($_SESSION['Good']);
                // var_dump($_SESSION['usersReps']);
                for ($i = 0; $i < count($_SESSION['usersReps']); $i++) {
                    if (in_array($_SESSION['usersReps'][$i], $_SESSION['Good'])) {
                        $_SESSION['userPoints'] += $_SESSION['points'][$i];
                    }
                }
                echo 'score'.$_SESSION['userPoints'].'/'.$_SESSION['scoreT'];
                
                // var_dump($_SESSION['userPoints']);
                // $file = './data/utilisateur.json';
                // $mainjson = file_get_contents($file);
                // $data = json_decode($mainjson, true);

                // foreach ($data as $key => $value) {
                //     if ($value['login'] === $_SESSION['user']['login']) {
                //         $data[$key]['score'] = $_SESSION['userPoints'];
                //     }   
                // }
                // $jsonfile = json_encode($data, JSON_PRETTY_PRINT);
                // file_put_contents($file,$jsonfile);
            }
        }
    }
    

    // if (isset($_POST['prev'])) {
    //     if ($_SESSION['question'][$i]['type'] == 'multiple') {
    //         unset($_SESSION['multiple']);
    //     }
    // }


}



// var_dump($_SESSION['question'][$i]['type']);





?>
<style>
    .prev {
        display: <?= $prev ?>;
        align-self: flex-start;
        color: white;
        background-color: #3addd6;
        margin-top: 30px;
        border-radius: 5px;
        border: none;
        width: 120px;
        height: 35px;
        margin-left: 5px;
        margin-bottom: 5px
    }

    .next {
        display: <?= $next ?>;
        float: right;

        margin-right: 10px;
        color: white;
        background-color: #3addd6;
        margin-top: 30px;
        border-radius: 5px;
        border: none;
        width: 120px;
        height: 35px;
        margin-bottom: 5px
            /* position: relative;
            top: 10px;
            left: 60%; */

    }

    .end {
        display: <?= $end ?>;
        margin-right: 10px;
        float: right;
        color: white;
        background-color: #3addd6;
        margin-top: 30px;
        border-radius: 5px;
        border: none;
        width: 120px;
        height: 35px;
        margin-bottom: 5px
    }

    table {
        border-radius: 1em;
        width: 100%;
        font-size: 1em
    }

    .question-show {
        display: inline-block;
    }

    th,
    td {
        color: grey;
        padding: .25em 1em;
        text-align: left
    }

    * {
        margin: 0;
        padding: 0;
    }

    .texte {
        margin-top: 20px;
        margin-left: 40px;

    }

    input[type="text"] {
        height: 40px;
        width: 60%;
        border: none;
        box-shadow: 1px 1px 1px #3addd6;
        font-size: 1.2em;
        background-color: #dddddd;
        /* border-radius: 10px; */
    }

    .multiple,
    .simple {
        position: relative;
        top: 10px;
        margin-left: 40px;

    }

    input[type="radio"] {
        height: 20px;
        width: 20px;
        border: none;
        /* box-shadow: 1px 1px 1px #3addd6; */
        font-size: 1.1em;
        /* border-radius: 10px; */
    }

    input[type="checkbox"] {
        height: 25px;
        width: 25px;
        border: none;
        color: white;
        box-shadow: 0px 0px 0px 1px #3addd6;
        /* box-shadow: 1px 1px 1px #3addd6; */
        font-size: 1.2em;
        /* border-radius: 10px; */
    }

    #rad,
    #check {
        position: relative;
        top: -5px;
        left: 5px;
    }
</style>
<div class="header-joueur">

    <div class="avatar-container">
        <div class="avatar-joueur" style="background-image: url(<?php echo $_SESSION['user']['photo'];  ?> ); background-size: cover"></div>
        <div class="joueur-informations">
            <?php echo $_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom'] ?>
        </div>
    </div>
    <div class="header-joueur-text">
        BIENVENUE SUR LA PLATEFORME DE JEU DE QUIZZ <br>
        JOUER ET TESTER VOTRE NIVEAU DE CULTURE GÉNÉRAL
    </div>
    <button> <a href="index.php?statut=logout">Déconnexion</a></button>

</div>
<div class="joueur-body">
    <div class="game_back">

        <div class="questiondisplay">
            <?php for ($i = $min; $i < $max; $i++) {

                $j = 0;
                $king= [];
                $response = $_SESSION['question'][$i]["bonneReponse"];
                $choixMultiple = $_SESSION['question'][$i]["reponsePossible"];
                $type = $_SESSION['question'][$i]["type"];  ?>
                <div class="questiondisplay-libelle">
                    <div class="questiondisplay-libelleContent">
                        <u><?php echo 'Question ' . ($i+1) . '/' . '5'; ?></u><br>
                        <p id="quiz"><?php echo $_SESSION['question'][$i]['libelle'] ?></p>
                    </div>

                </div>
                <div class="nbrePoint">
                    <?php echo $_SESSION['question'][$i]['score'] . 'pts'; ?>
                </div>
                <div>
                    <form action="" method="post">
                    <?php
                    foreach ($choixMultiple as $key => $value) {
                        
                        if ($type == 'text') {
                            echo '<div class="texte">';
                            if (isset($_SESSION['text'][$i])) {
                                echo '<input type="text" class="text" name="reps" value="' . $_SESSION['text'][$i] . '">';
                            } else {
                                echo '<input type="text" class="text" name="reps">';
                            }

                            echo '</div>';
                        } elseif ($type == 'multiple') {
                            
                            echo '<div class="multiple">';
                            // if (isset($_POST['prev'])) {
                            //     $i--;
                            // }
                            if (isset($_SESSION['multiple'][$i]) && in_array($value, $_SESSION['multiple'][$i])) {
                                echo '<input type="checkbox"  checked name="checkboxes' . $j . '"> <label class="question-show" id="txt" name="reponse[]">', $value, '</label><br/>';
                            } else {
                                echo '<input type="checkbox" name="checkboxes' . $j . '"> <label class="question-show" id="check" name="reponse[]">', $value, '</label><br/>';
                            }

                            echo '</div>';
                            $j++;
                        } elseif ($type == 'simple') {
                            echo '<div class="simple">';
                            if (isset($_SESSION['simple'][$i]) && ($value == $_SESSION['simple'][$i])) {
                                echo '<input type="radio" checked name="choix" value="' . $j . '"> <label class="question-show" id="rad" name="reponse[]">', $value, '</label><br/>';
                            }
                            else {
                                echo '<input type="radio" name="choix" value="' . $j . '"> <label class="question-show" id="rad" name="reponse[]">', $value, '</label><br/>';
                            }
                           
                            echo '</div>';
                            $j++;
                        }
                    }
                } ?>
                    <br>
                    <button class="prev" id="prev" name="prev" formaction="index.php?lien=jeux&pages=<?= $pages - 1 ?>">Precedent</button>
                    <button class="next" value="next" name="btn" type="submit" formaction="index.php?lien=jeux&pages=<?= $pages += 1 ?>">suivant</button>
                    <button class="end" value="end" name="btn" type="submit" id="end" >Terminer</button>
                    <div id="final-score">
                        Bonjourrrrr
                    </div>
                    </form>
                    
                </div>



        </div>

        <div class="meilleur-score">
            <div class="tab">
                <button class="tablinks" onclick="showInfos(event,'top-score')" id="defaultOpen"> Top score </button>
                <button class="tablinks" onclick="showInfos(event, 'meilleurScore')"> Mon meilleur Score</button>
            </div>
            <div id="top-score" class="tabcontent">
                <table>
                    <tbody>
                        <?php
                        for ($cpt = 0; $cpt < 5; $cpt++) {

                        ?>
                            <tr>
                                <td> <?php echo $tab[$cpt]['nom'] . ' ' . $tab[$cpt]['prenom'] ?> </td>
                                <td> <?php echo $tab[$cpt]['score'] ?> </td>
                            </tr>
                        <?php
                        }

                        ?>

                    </tbody>
                </table>
            </div>
            <div id="meilleurScore" class="tabcontent">
                <?php echo $_SESSION['user']['score'] ?>
            </div>

        </div>
    </div>
</div>
<script>
    function showInfos(evt, affiche) {
        var i, tabcontent, tablinks;
        

        tabcontent = document.getElementsByClassName("tabcontent");
        for (let i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tablinks");
        for (let i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace("active", "");

        }
        document.getElementById(affiche).style.display = "block";
        evt.currentTarget.className += "active";
        evt.currentTarget.style.color = "#3addd6"
    }
    document.getElementById("defaultOpen").click();
    document.getElementById('final-score').style.display = "none";
    document.getElementById('end').addEventListener('click', function(){
        document.getElementById('end').style.display = "none";
        document.getElementById('prev').style.display = "none";
        document.getElementById('final-score').style.display = "block";
    });
    
</script>
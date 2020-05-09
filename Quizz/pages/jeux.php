<?php
is_connect();

?>
<?php

$joueur = getData();
$liste = getData();
$liste = array_sort($liste, 'score', SORT_DESC);
foreach ($liste as $key => $value) {
    if ($value['profil'] == 'joueur') {
        $tab[] = $value;
    }
}

$nombre = getData('nombreQuestion');
$questionParPage = 1;
$totalquestions = $nombre['nombre'];
$nombrePages = ceil($totalquestions / $questionParPage);
if (isset($_POST['btn'])) {
    if (isset($_POST['position'])) {
        
        $position = intval($_POST['position']);
        $_SESSION['question'][$position]['answer'] = answerPlayer($position);
        $_SESSION['tab'][] = $_SESSION['question'][$position]['answer'];
        $position++;
        if ($position == $nombre['nombre']) {
            $position = $nombre['nombre'] - 1;
            foreach ($joueur as $key => $value) {
                if ($value['login'] === $_SESSION['user']['login']) {
                    if ($joueur[$key]['score'] < score($_SESSION['question'])) {
                        $joueur[$key]['score'] = score($_SESSION['question']);
                    }
                }
            }
            saveData($joueur);
            header('location: index.php?lien=resultat');
        }
        
    }
} else {
    $position = 0;
}
if (isset($_POST['end'])) {
    $position = intval($_POST['position']);
    $_SESSION['question'][$position]['answer'] = answerPlayer($position);
    foreach ($joueur as $key => $value) {
        if ($value['login'] === $_SESSION['user']['login']) {
            if ($joueur[$key]['score'] < score($_SESSION['question'])) {
                $joueur[$key]['score'] = score($_SESSION['question']);
            }
        }
    }
    saveData($joueur);
    header('location: index.php?lien=resultat');
}


$debut = ($position - 1) * $questionParPage;
if (isset($_POST['btn-precedent'])) {
    $position = intval($_POST['position']);
    if ($position) {
        $position--;
        if ($position < 0) {
            $position = 0;
            $prev = 'none';
        }
    }
}
function answerPlayer($position)
{
    $answerPlayer = array();
    if (!empty($_POST['result'])) {
        $answerPlayer = $_POST['result'];
    }
    return $answerPlayer;
}


?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
        background-color: red;
        margin-top: 30px;
        border-radius: 5px;
        border: none;
        width: 90px;
        height: 30px;
        margin-bottom: 5px;
        position: absolute;
        left: 86%;
        top: 53%;
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
    li{
        list-style: none;
        margin-left: 10px
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
    @media screen and (max-width: 479px){
        #meilleur-score{
            display: none
        }
        .header-joueur-text{
            display: none;
        }
        .header-text {
            color: white;
            position: absolute;
            top: 25px;
            left: 30%;
            font-size: 25px;
            font-weight: bold;
        }
        .end{
            display: none;
        }
        .header-joueur>button{
            display: none;
            float: right;
            margin-right: 40px;
            color: white;
            background-color: #3addd6;
            margin-top: 30px;
            border-radius: 5px;
            border: none;
            width: 100px;
            height: 30px;
        }
        .questiondisplay {
            /* float: left; */
            position: relative;
            left: 2%;
            top: 2%;
            width: 95%;
            /* height: 400px; */
            border: 1px solid black;
            border-radius: 10px/20px;
        }
        .bs-example{
            float: right;
            display: block;
            margin-right: 80px;
            margin-top: 30px;
            color: white;
        }
        .dropdown-toggle{
            color: white;
        }
        a{
            text-decoration: none
        }
        .nbrePoint {
            position: relative;
            left: 75%;
            top: 10px;
            width: 65px;
            height: 35px;
            background-color: #dddddd;
            box-shadow: 1px 1px 1px #3addd6;
            text-align: center;
            line-height: 2;
        }

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
    <div class="bs-example">
        <div class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu</a>
            <div class="dropdown-menu">
                <a href="index.php?statut=logout" class="dropdown-item">Déconnexion</a>
                <a href="#meilleur-score"><button class="tablinks dropdown-item" onclick="showScore()"> Top score </button></a>
            </div>
        </div>
    </div>
    <button> <a href="index.php?statut=logout">Déconnexion</a></button>

</div>
<div class="joueur-body">
    <div class="game_back">

        <div class="questiondisplay">

            <?php
            $j = 0;
            $cocher = [];
            ?>
            <div class="questiondisplay-libelle">
                <div class="questiondisplay-libelleContent">
                    <strong>QUESTIONS <?php echo $position + 1 . '/' . $nombre['nombre']; ?></strong>
                    <p id="quiz"><?php echo $_SESSION['question'][$position]['libelle']; ?></p>
                </div>

            </div>
            <div class="nbrePoint">
                    <?php echo $_SESSION['question'][$position]['score'] . 'pts'; ?>
            </div>
            <div>
                <form method="POST" action="" id="form">
                    <input type="hidden" name="" value="<?php echo $nombre['nombre']; ?>" id="limit">
                    <input type="hidden" value="<?php echo $_SESSION['question'][$position]['type'] ?>" id="type">
                    <input type="hidden" name="position" value="<?php echo $position; ?>" id="position">
                    
                    <div class="affiche-reponse">
                        <?php
                        for ($i = $debut; $i < ($debut + $questionParPage); $i++) {
                            if ($_SESSION['question'][$position]['type'] == 'multiple') {
                                for ($j = 0; $j < (count($_SESSION['question'][$position]['reponsePossible'])); $j++) {
                                    if (!empty($_SESSION['question'][$position]['answer']) && in_array('result' . $j, $_SESSION['question'][$position]['answer'])) { ?>
                                        
                                        <li>
                                            <input type="checkbox" checked name="result[]" value="result<?= $j ?>">
                                            <?php echo $_SESSION['question'][$position]['reponsePossible'][$j]; ?>
                                        </li><?php
                                            } else { ?>

                                        <li>
                                            <input type="checkbox" name="result[]" value="result<?= $j ?>">
                                            <?php echo $_SESSION['question'][$position]['reponsePossible'][$j]; ?>
                                        </li><?php
                                            }
                                            
                                        }
                                    } else if ($_SESSION['question'][$position]['type'] == 'simple') {
                                        for ($j = 0; $j < (count($_SESSION['question'][$position]['reponsePossible'])); $j++) {
                                            if (!empty($_SESSION['question'][$position]['answer']) && in_array($j, $_SESSION['question'][$position]['answer'])) { ?>
                                            
                                        <li>
                                            <input type="radio" checked name="result[]" value="<?php echo $j ?>">
                                            <?php echo $_SESSION['question'][$position]['reponsePossible'][$j]; ?>
                                        </li><?php
                                        
                                            } else { ?>

                                        <li>
                                            <input type="radio" name="result[]" value="<?php echo $j ?>">
                                            <?php echo $_SESSION['question'][$position]['reponsePossible'][$j]; ?>
                                        </li><?php
                                            }
                                        }
                                    } else {
                                        for ($j = 0; $j < (count($_SESSION['question'][$position]['reponsePossible'])); $j++) {
                                            if (!empty($_SESSION['question'][$position]['answer'])) {
                                                strtolower($_SESSION['question'][$position]['answer']);
                                                ?>
                                        <li>
                                            <input type="text" class="form-rep" name="result" value="<?php echo strtolower($_SESSION['question'][$position]['answer']); ?>">
                                        </li><?php
                                            } else {
                                                ?>
                                        <li>
                                            <input type="text" name="result" error="error">
                                            <span id="error"></span>
                                        </li><?php
                                        
                                            }
                                        }
                                    }
                                }
                            ?>
                                                
                    </div>
                    
                    <input type="submit" name="btn-precedent" class="prev" id="prev" value="precedent" >
                    <input type="submit" class="next" name="btn" class="btn-suiv-joueur" value="next" id="next">
                    <input type="submit" class="next" name="btn" class="btn-suiv-joueur" value="Terminer" id="end">
                    <input type="submit" value="Quitter" name="end" class="end">
                    
                </form>
                <?php
                    
                ?>

            </div>



        </div>

        <div class="meilleur-score" id="meilleur-score">
            <div class="tab">
                <button class="tablinks" onclick="showInfos(event,'top-score')" id="defaultOpen"> Top score </button>
                <button class="tablinks" onclick="showInfos(event, 'meilleurScore')"> Mon meilleur Score</button>
            </div>
            <div id="top-score" class="tabcontent">
                <table>
                <thead>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Score</th>
                </thead>
                    <tbody>
                        <?php
                        for ($cpt = 0; $cpt < 5; $cpt++) {

                        ?>
                            <tr>
                                <td> <?php echo $tab[$cpt]['prenom']?> </td>
                                <td><?php echo $tab[$cpt]['nom']?></td>
                                <td> <?php echo $tab[$cpt]['score'].'pts' ?> </td>
                            </tr>
                        <?php
                        }

                        ?>

                    </tbody>
                </table>
            </div>
            <div id="meilleurScore" class="tabcontent">
                <table>
                <thead>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Score</th>
                </thead>
                <tbody>
                    <td> <?php echo $_SESSION['user']['prenom'] ?> </td>
                    <td> <?php echo $_SESSION['user']['nom'] ?> </td>
                    <td> <?php echo $_SESSION['user']['score'] ?> </td>
                </tbody>
                </table>
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

    document.getElementById('checked');
var position = document.getElementById('position').value;
var limit = document.getElementById('limit').value;
if (position == 0) {
    document.getElementById('prev').disabled="true";
    document.getElementById('prev').style.backgroundColor ='#636363';
}

document.getElementById('end').style.display = "none";
// alert(position);
 
if (position == limit-1) {
    document.getElementById('end').style.display = "inline";
    document.getElementById('next').style.display = "none";
}
function showScore(){
    document.getElementById('meilleur-score').style.display = "block"
}
</script>
<?php
is_connect();

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
        height: 30px;
        width: 50%;
        border: none;
        box-shadow: 1px 1px 1px #3addd6;
        font-size: 1em;
        background-color: #dddddd;
        /* border-radius: 10px; */
    }
    li{
        list-style: none;
        position: relative;
        left: 90px;
    }

    .multiple,
    .simple {
        position: relative;
        top: 10px;
        margin-left: 40px;

    }

    input[type="radio"] {
        height: 15px;
        width: 15px;
        border: none;
        /* box-shadow: 1px 1px 1px #3addd6; */
        font-size: 1em;
        /* border-radius: 10px; */
    }
    span{
        width: 50px;
        height: 20px;
        display: block;
        /* float: left; */
        position: relative;
        top: -15%;
    }
    input[type="checkbox"] {
        height: 15px;
        width: 15px;
        border: none;
        color: white;
        box-shadow: 0px 0px 0px 1px #3addd6;
        /* box-shadow: 1px 1px 1px #3addd6; */
        font-size: 1em;
        /* border-radius: 10px; */
    }
    .result{
        text-align: center;
        font-size: 1.2em;
        width: 300px;
        margin-left: 35%;
        height: 30px;
        border-radius: 10px;
        line-height: 1.5;
    }

    #rad,
    #check {
        position: relative;
        top: -5px;
        left: 5px;
    }
    #reps{
        width: 100%;
        /* height: 200px */
    }
    img{
        position: relative;
        top: -15%;
    }
    .header-joueur-text{
        text-align: center;
        margin-left: 20%;
        line-height: 2
    }
    @media screen and (max-width: 479px){
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
        .result{
            text-align: center;
            font-size: 1.2em;
            width: 250px;
            margin-left: 20%;
            height: 30px;
            border-radius: 10px;
            line-height: 1.5;
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
        Récapitulatif
    </div>
    <button><a href="index.php?lien=jeux">Retour</a></button>
    <button> <a href="index.php?statut=logout">Déconnexion</a></button>

</div>
<div class="joueur-body">
    <div class="game_back1">
        <input type="hidden" name="" id="scoreObtenu" value="<?php echo score($_SESSION['question'])  ?>">
        <input type="hidden" name="" id="scoreTotal" value="<?php echo scoreTotal($_SESSION['question'])  ?>">
        <div>
            <form action="">
            
            <?php
            
            $cocher = [];
            $simple = '';
            
                for ($i=0; $i < count($_SESSION['question']); $i++) {
                    $ok = "<img src='./public/images/ok.jpg' height='20px' width='20px'>";
                    $faux = "<img src='./public/images/faux.jpg' height='20px' width='20px'>";?>
                     
                    <div id="reps">
                        <h4> <?php echo ($i+1).'.'.$_SESSION['question'][$i]['libelle'] ?> </h4>
                        
                    
                        <?php
                        if ($_SESSION['question'][$i]['type'] == 'multiple') {
                            for ($j=0; $j < count($_SESSION['question'][$i]['reponsePossible']); $j++) {
                                if (empty($_SESSION['question'][$i]['answer'])) {
                                    $sortie = $faux;
                                }
                                if (isset($_SESSION['question'][$i]['answer']) && in_array('result' . $j, $_SESSION['question'][$i]['answer'])) {
                                    $cocher[] = $_SESSION['question'][$i]['reponsePossible'][$j];
                                     if (($cocher ===  $_SESSION['question'][$i]['bonneReponse'])) {
                                        $sortie =$ok;
                                    }
                                    else {
                                        $sortie = $faux;
                                    }?>
                                    <li>
                                        <input type="checkbox" disabled checked name="result[]" value="result<?= $j ?>">
                                        <?php echo $_SESSION['question'][$i]['reponsePossible'][$j]; ?>
                                    </li>  <?php
                                
                                }else { ?>
                                    <li>
                                        <input type="checkbox" disabled name="result[]" value="result<?= $j ?>">
                                        <?php echo $_SESSION['question'][$i]['reponsePossible'][$j]; ?>
                                    </li>
                                    <?php
                                }
                            }
                             
                        }
                        elseif ($_SESSION['question'][$i]['type'] == 'simple') {
                            
                            for ($j=0; $j < count($_SESSION['question'][$i]['reponsePossible']); $j++) { 
                                if (empty($_SESSION['question'][$i]['answer'])) {
                                    $sortie = $faux;
                                }
                                if (isset($_SESSION['question'][$i]['answer']) && in_array($j, $_SESSION['question'][$i]['answer'])) {
                                    $simple = $_SESSION['question'][$i]['reponsePossible'][$j];
                                    ?>
                                    <li>
                                        <input type="radio" disabled checked value="<?=$j ?>">
                                        <?php echo $_SESSION['question'][$i]['reponsePossible'][$j]; ?>
                                    </li> <?php
                                }
                                else{ ?>
                                    <li>
                                        <input type="radio" disabled  value="<?=$j ?>">
                                        <?php echo $_SESSION['question'][$i]['reponsePossible'][$j]; ?>
                                    </li>
                                    <?php
                                }
                            }
                            if ($simple === $_SESSION['question'][$i]['bonneReponse']) {
                                $sortie =$ok;
                            }
                            else {
                                $sortie = $faux;
                            }
                        }
                        else {
                            for ($j=0; $j < count($_SESSION['question'][$i]['reponsePossible']); $j++) {
                                if (!empty($_SESSION['question'][$i]['answer'])) {
                                    if (strtolower($_SESSION['question'][$i]['answer']) === $_SESSION['question'][$i]['bonneReponse']) {
                                        $sortie =$ok;
                                    }
                                    else {
                                        $sortie = $faux;
                                    }
                                    ?>
                                    <li>
                                        <input disabled type="text" class="form-rep" name="result" value="<?php echo strtolower($_SESSION['question'][$i]['answer']); ?>">
                                    </li> <?php 
                                } else {$sortie = $faux;?>
                                    <li>
                                        <input type="text" disabled name="result" error="error">
                                        
                                    </li><?php
                                }
                            }
                            ?>
                                
                                 <?php
                            
                        }
                       
                    ?>

                    
                    </div>
                   <div>
                   <span id="tof"> <?php if (!empty($sortie)) {
                            echo $sortie;
                        } ?> </span>
                        <hr>
                   </div>
                    <?php
                    $cocher = [];
                }
            ?>
            </form>
        </div>
        <div class="result" id="view">
            <?php echo 'Score '. score($_SESSION['question']) .'/'.scoreTotal($_SESSION['question']); ?>
        </div>
    </div>
    

</div>
<script>
    if (document.getElementById('scoreObtenu').value < (document.getElementById('scoreTotal').value)/2) {
        document.getElementById('view').style.backgroundColor='red';
    }
    else{
        document.getElementById('view').style.backgroundColor='green';
    }
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
</script>
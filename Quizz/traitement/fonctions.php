<?php

function is_in($login)
{
    $users = getData();
    foreach ($users as $key => $user) {
        if ($user['login'] === $login) {
            return true;
        }
    }
    return false;
}
function decconection()
{
    unset($_SESSION['user']);
    unset($_SESSION['statut']);
    session_destroy();
}
function is_connect()
{
    if (!isset($_SESSION['statut'])) {
        header("location:index.php");
    }
}


function getData($file = "utilisateur")
{
    $data = file_get_contents("./data/" . $file . ".json");
    $data = json_decode($data, true);
    return $data;
}




function array_sort($array, $on, $order = SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}


// function saveData($prenom,$nom,$login,$pwd,$profil,$photo){
//     $data[] = array(
//         "prenom"=> $prenom,
//         "nom"=> $nom,
//         "login"=> $login,
//         "password"=> $pwd,
//         "profil"=> $profil,
//         "photo"=>$photo
//     );
//     $jsonfile = json_encode($data, JSON_PRETTY_PRINT);
//     $save = file_put_contents($file, $jsonfile);
//     if ($save) {
//         $result = connexion($login,$pwd);
//         header("location: index.php?lien=".$result);
//     }
// }



    function saveData($data,$file ="utilisateur"){
        $data = json_encode($data);
        file_put_contents('data'.'/'.$file.'.json', $data);
    }

    function connexion($login, $pwd)
{
    $users = getData();
    foreach ($users as $key => $user) {
        if ($user['login'] === $login && $user['password'] === $pwd) {
            $_SESSION['user'] = $user;
            $_SESSION['statut'] = "login";
            if ($user['profil'] === 'admin') {
                return "accueil";
            } else {
                $question = getData('question');
                $_SESSION['question']=nbreQuestionParJeu($question);
                return 'jeux';

            }
        }
    }
    return "error";
}

function nbreQuestionParJeu($tableauQuestion) {
    $nombre = getData("nombreQuestion");
    $tableau = array();
    while (count($tableau) < $nombre['nombre']) {
      $aleatoire = rand(0,(count($tableauQuestion)-1));
      if (!in_array($tableauQuestion[$aleatoire], $tableau)) {
        $tableau[] = $tableauQuestion[$aleatoire];
      }
    }
    return $tableau;
  }



function scoreTotal($tableau){
    $total = 0;
    for ($i=0; $i < count($tableau) ; $i++) { 
      $total = $total + $tableau[$i]['score'];
    }
    return $total;
  }


  function score($question){
    $score = 0;
    $cocher= '';
    $multiple = [];
    $radio = '';
    for ($i=0; $i < count($question); $i++) { 
        if ($question[$i]['type'] == 'simple') {
            for ($j=0; $j < count($question[$i]['reponsePossible']); $j++) { 
                if ((!empty($question[$i]['answer'])) && in_array($j, $question[$i]['answer'])) {
                    $cocher = $question[$i]['reponsePossible'][$j];
                }
            }
            if ($cocher === $question[$i]['bonneReponse']) {
                $score = $score + $question[$i]['score'];
            }
        }
        elseif ($question[$i]['type'] == 'text') {
            if ((!empty($question[$i]['answer'])) && strtolower($question[$i]['answer']) === $question[$i]['bonneReponse']) 
            {
                $score = $score + $question[$i]['score'];
            } 
        }
        else{
            for ($j=0; $j < count($question[$i]['reponsePossible']); $j++) { 
                if (!empty($question[$i]['answer']) && in_array('result'.$j, $question[$i]['answer'])) {
                    $multiple[] = $question[$i]['reponsePossible'][$j];
                }
            }
            if ($multiple === $question[$i]['bonneReponse']) {
                $score = $score + $question[$i]['score'];
            }
            $multiple = [];
        }
        
        
    }
    return $score;
}
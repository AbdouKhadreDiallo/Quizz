<?php
    function getData($file = "question")
    {
        $data = file_get_contents("../data/" . $file . ".json");
        $data = json_decode($data, true);
        return $data;
    }
    $data = getData();
    $data = json_encode($data);
    echo $data;
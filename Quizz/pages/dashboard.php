<?php

?>
<style>
    .dashboardContainer {
        position: relative;
        left: 30%;

    }

    .graph {
        width: 35%;

    }
</style>
<div class="right">
    <div class="dashboardContainer">
        <div class="graph">
            <canvas id="users"></canvas>
        </div>
        <div class="graph">
            <canvas id="question"></canvas>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
    const getJsonFileContent = (url) => {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", url, false);
        xhr.send(null);
        return JSON.parse(xhr.responseText);
    }
    const users = getJsonFileContent("./pages/user.php");
    const quizz = getJsonFileContent("./pages/quizz.php");

    let nombreQuizz = quizz.length;

    let_type_of = {
        radio: 0,
        checkbox: 0,
        text: 0
    }
    for (const quiz of quizz) {
        if (quiz['type'] === "multiple") {
            let_type_of['checkbox']++;
        } else if(quiz['type'] === "simple") {
            let_type_of['radio']++;
        }
        else{
            let_type_of['text']++;
        }
    }

    const question_config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    let_type_of["checkbox"],
                    let_type_of["radio"],
                    let_type_of["text"]
                ],
                backgroundColor: [
                    "rgb(255,125,64)",
                    "rgb(125,100,185)",
                    'rgb(54, 162, 235)'
                ]
            }],
            labels: [
                'Type checkbox',
                'Type radio',
                'Type text'
            ]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Representation graphique des differents type de reponse.'
            }
        }
    };

    let nbre_of = {
        admin: 0,
        user: 0
    };

    let nbre_user = users.length;
    for (const user of users) {
        if (user['profil'] === "admin") {
            nbre_of['admin']++;
        } else {
            nbre_of['user']++;
        }
    }
    const user_config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    nbre_of['admin'],
                    nbre_of['user']
                ],
                backgroundColor: [
                    "rgb(255,125,64)",
                    "rgb(125,100,185)"
                ]
            }],
            labels: [
                'Admins',
                'Players'
            ]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Representation graphique des utilisateurs'
            }
        }
    };
    window.onload = function() {
        const ctx = document.querySelector('#users').getContext('2d');
        const pie = document.querySelector('#question').getContext('2d');
        const myCtx = new Chart(ctx, user_config);
        const myPie = new Chart(pie, question_config);
    };
</script>
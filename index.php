<head>
    <title>CPQuiz</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
</head>

<style>
    * {
        font-family: 'Poppins', sans-serif;
    }

    .title {
        text-align: center;
        font-size: 6vh;
    }

    .respostas {
        width: 70%;
        height: 70%;
        position: absolute;
        left: 50%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        transform: translateX(-50%);
    }

    .opening {
        text-align: center;
        text-shadow: 0 0 2px #fff;
        font-size: 30px;
        background-color: rgba(255, 255, 255, 0.8);
        padding: 5px;
        border-radius: 10px;
    }

    .resposta {
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45%;
        height: 45%;
        background-color: white;
        margin: 10px;
        border-radius: 20px;
    }

    .locked {
        animation: lock 0.2s;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hide {
        display: none;
    }

    @media only screen and (max-width: 600px) {
        .respostas {
            width: 100%;
        }

        .resposta {
            width: 100%;
        }

        .title {
            font-size: 4vh;
        }


    }

    @keyframes lock {
        0% {
            transform: scale(0);
        }

        100% {
            transform: scale(1);
        }
    }
</style>

<body>
    <div class="title" id="title">Que opening está a soar?</div>
    <div class="respostas">
        <?php
        include("database.php");
        function generateop($correcto)
        {
            include("database.php");
            $openings = [];
            $sql = "SELECT * FROM openings WHERE NOT id = '$correcto' ORDER BY rand() LIMIT 3";
            $do = mysqli_query($link, $sql);
            while($op = mysqli_fetch_assoc($do)){
                $openings[] = ["nombre" => $op["nombre"], "miniatura" => $op["miniatura"]];
            }
            $sql = "SELECT * FROM openings WHERE id = '$correcto'";
            $do2 = mysqli_query($link, $sql);
            $arr2 = mysqli_fetch_assoc($do2);
            $openings[] = ["nombre" => $arr2["nombre"], "miniatura" => $arr2["miniatura"]];
            shuffle($openings);
            return $openings;
        }
        $sql = "SELECT * FROM correctos ORDER BY id DESC LIMIT 1";
        $do = mysqli_query($link, $sql);
        $correcto = mysqli_fetch_assoc($do);
        $correcto = $correcto["id_opening"];

        $i = 1;
        $o = 0;
        $do = generateop($correcto);
        while ($o < count($do)) {;
            $op = $do[$o];
        ?>
            <div onclick="select(this)" id="resp-<?php echo $i ?>" class="resposta" style="background-image: url('<?php echo $op["miniatura"] ?>'); background-size:cover">
                <div class="locked hide">Click para cambiar a selección</div>
                <div class="opening"><?php echo $op["nombre"] ?></div>
            </div>
        <?php
            $i++;
            $o++;
        }
        ?>
    </div>
</body>

<script>
    var selected = false;

    function select(resposta) {
        if (selected == false) {
            for (var i = 1; i != 5; i++) {
                if ("resp-" + i != resposta.id) {
                    document.getElementById("resp-" + i).getElementsByTagName("div")[1].classList.add("hide")
                    document.getElementById("resp-" + i).getElementsByTagName("div")[0].classList.remove("hide")
                } else {
                    document.getElementById("resp-" + i).getElementsByTagName("div")[1].classList.remove("hide")
                    document.getElementById("resp-" + i).getElementsByTagName("div")[0].classList.add("hide")
                }

            }
        }

    }
</script>
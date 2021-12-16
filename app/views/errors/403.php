<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oops! Доступ запрещён...</title><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Press+Start+2P');

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-family: 'Press Start 2P', cursive;
        }

        body {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }

        #forbidden {
            position: relative;
            height: 100vh;
            background: #030005;
            text-shadow: 0px 0px 10px;
        }

        #forbidden .forbidden {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .forbidden {
            max-width: 767px;
            width: 100%;
            line-height: 1.4;
            text-align: center;
        }

        .forbidden .forbidden-403 {
            position: relative;
            height: 180px;
            margin-bottom: 20px;
            z-index: -1;
        }

        .forbidden .forbidden-403 h1 {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            font-size: 7rem;
            font-weight: 900;
            margin-top: 0px;
            color: #54FE55;
            text-transform: uppercase;
        }


        .forbidden .forbidden-403 h2 {
            position: absolute;
            left: 0;
            right: 0;
            top: 140px;
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 8px;
            margin: 0;
        }

        .forbidden a {
            display: inline-block;
            text-transform: uppercase;
            color: #54FE55;
            text-decoration: none;
            border: 2px solid;
            background: transparent;
            padding: 10px 40px;
            font-size: 14px;
            font-weight: 700;
            -webkit-transition: 0.2s all;
            transition: 0.2s all;
        }

        .forbidden a:hover {
            color: #fff;
        }

        @media only screen and (max-width: 767px) {
            .forbidden .forbidden-403 h2 {
                font-size: 1.5rem;
            }
        }

        @media only screen and (max-width: 480px) {
            .forbidden .forbidden-403 h1 {
                font-size: 6rem;
            }
        }

        @keyframes blink {
            0% {
                opacity: 0
            }
            49% {
                opacity: 0
            }
            50% {
                opacity: 1
            }
            100% {
                opacity: 1
            }
        }

        .blink {
            animation-name: blink;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }
    </style>
</head>
<body>
<div id="forbidden">
    <div class="forbidden">
        <div class="forbidden-403">
            <h1>403</h1>
            <h2>запрещено<span class="blink">_</span></h2>
        </div>
        <a href="/">На главную</a>
    </div>
</div>
</body>
</html>

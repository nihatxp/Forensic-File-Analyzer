<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/app.js"></script>
    <style>
 
        * {
           
            box-sizing: border-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }

        textarea {
            -moz-user-select: none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
            width: 96%;
            height: 150px;
            padding: 12px 20px 0px 20px;
            margin: 0 0 8px 0;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            font-size: 16px;
            resize: none;
        }

        .textarea::-webkit-scrollbar {
            display: none;
        }

        body {
            background: #eee;
            font-family: monospace;
            font-size: 12pt;
            color: #333;
            margin: 0;
            padding: 0;
        }

        #grid {
            margin: 20px auto;
            width: 100%;
            max-width: 750px;
            line-height: 1.96;
        }

      
    </style>
</head>
<body>
<center><h1><?= TITLE ?></h1></center>
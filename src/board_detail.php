<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    include_once( URL_DB );
    // var_dump($_SERVER, $_GET, $_POST);

    // Request Method를 습득
    $http_method = $_SERVER["REQUEST_METHOD"];

    // print_r($http_method);
    // GET 체크
    if( $http_method === "GET" )
    {
        $board_no = 1;
        if( array_key_exists("board_no", $_GET) )
        {
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );
    }
    // POST일 때
    else
    {
        $arr_post = $_POST;
        $arr_info =
            array(
                "board_no" => $arr_post["board_no"]
                ,"board_title" => $arr_post["board_title"]
                ,"board_content" => $arr_post["board_content"]
                ,"board_wdate"  => $arr_post["board_wdate"]
            );
        
        // update
        $result_cnt = update_board_info_no( $arr_info );

        // select
        $result_info = select_board_info_no( $arr_post["board_no"] );
    }

    // print_r($result_info);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>글 수정</title>
    <style>
        @font-face{
            font-family:'bitbit';
            src:url('//cdn.df.nexon.com/img/common/font/DNFBitBit-Regular.woff'),url('//cdn.df.nexon.com/img/common/font/DNFBitBit-Regular.woff2') ;
        }
        @font-face {
            font-family: 'NeoDunggeunmoPro-Regular';
            src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2302@1.0/NeoDunggeunmoPro-Regular.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'EF_hyunygothic';
            src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2206-01@1.0/EF_hyunygothic.woff2') format('woff2');
            font-weight: normal;
            font-style: normal;
        }
        * {
            margin: 0;
            padding: 0;
            font-family: 'NeoDunggeunmoPro-Regular';
        }
        body {
            background-image: url('./common/pattern.png');
            background-size: 600px 600px;
            background-repeat: repeat;
        }
        a {
            text-decoration: none;
            color: black;
        }
        a:hover {
            text-decoration: none;
            color: black;
        }
        .container {
            width: 800px;
        }
        .title {
            text-decoration: none;
            display: flex;
            justify-content: center;
            margin-top: 50px;
            margin-bottome: 10px;
        }
        .title>img {
            width: 400px;
        }
        .backdrop {
            margin-top: 50px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.7);
            width: 100%;
            height: 400px;
            backdrop-filter: blur(5px);
            border: 2px solid #6E3EC0;
            border-radius: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        input {
            margin-top: 20px;
            width: 90%;
            height: 32px;
            border: 0;
            outline: none;
            padding-left: 10px;
            background-color: rgba(255, 255, 255, 0);
        }
        input[id="board_title"] {
            font-size: 1.8rem;
        }
        input[id="board_wdate"] {
            width: 75%;
            color: #6E3EC0;
        }
        label {
            color: #6E3EC0;
        }
        input[id="board_no"] {
            color: #6E3EC0;
        }
        textarea {
            margin-top: 20px;
            width: 90%;
            height: 160px;
            border: 0;
            outline: none;
            padding-left: 10px;
            background-color: rgba(255, 255, 255, 0);
            resize: none;
        }
        label[for="board_content"] {
            margin-top: 10px;
            vertical-align: top;
        }
        .update_btn {
            display: inline-block;
            text-decoration: none;
            margin: 5px;
            width: 50px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            color: #6E3EC0;
        }
        .update_btn:hover {
            text-decoration: none;
            background-color: #6E3EC0;
            color: white;
            transition-duration: 0.3s;
        }
        .update_btn:not(:hover) {
            transition: 0.1s ease-out;
        }
        hr {
            border: 1px solid #6E3EC0;
        }
    </style>
</head>
<body>
<div class="container">
    <a class='title' href='board_list.php'><img src='./common/title.gif' alt='title'></a>
    <div class="backdrop">
    <form method="post" action="board_update.php">
        <input id="board_title" name="board_title" type="text" value="<? echo $result_info["board_title"] ?>" readonly>
        <label for="board_wdate">작성일자 : </label>
        <input id="board_wdate" name="board_wdate" type="text" value="<? echo $result_info["board_wdate"] ?>">
        <hr>
        <textarea cols=60 rows=8 id="board_content" name="board_content" readonly><? echo $result_info["board_content"] ?></textarea>
        <br>
        <a class="update_btn" href="board_update.php?board_no=<? echo $result_info["board_no"] ?>">수정</button>
    </form>
    </div>
</div>
</body>
</html>
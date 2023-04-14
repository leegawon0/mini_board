<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    define( "URL_HEADER", DOC_ROOT."mini_board/src/board_header.php" );
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

    // print_r($result_info);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title><? echo $result_info["board_title"] ?></title>
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
            display: grid;
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
        .detailpage {
            margin-top: 50px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.7);
            width: 100%;
            height: 500px;
            backdrop-filter: blur(5px);
            border: 2px solid #6E3EC0;
            border-radius: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        p {
            text-align: left;
            display: inline-block;
            width: 85%;
        }
        p[id="board_title"] {
            font-family: 'EF_hyunygothic';
            font-size: 1.8rem;
            margin-top: 15px;
        }
        p[id="board_wdate"] {
            color: #6E3EC0;
        }
        p[id="board_content"] {
            margin-top: 15px;
        }
        label {
            color: #6E3EC0;
        }
        textarea {
            margin-top: 20px;
            width: 90%;
            height: 280px;
            border: 0;
            outline: none;
            padding-left: 10px;
            background-color: rgba(255, 255, 255, 0);
            resize: none;
        }
        .btnlist {
            display: flex;
            justify-content: flex-end;
        }
        .update_btn, .delete_btn {
            display: inline-block;
            background:#6E3EC0;
            color:#fff;
            border:none;
            line-height: 40px;
            width: 70px;
            height:40px;
            position: relative;
            text-align: center;
            padding:0 1em;
            cursor:pointer;
            transition:500ms ease all;
            outline:none;
            margin-right: 10px;
        }
        .update_btn:hover, .delete_btn:hover {
            background:#fff;
            color:#6E3EC0;
        }
        .update_btn:before, .update_btn:after, .delete_btn:before, .delete_btn:after {
            content:'';
            position:absolute;
            top:0;
            right:0;
            height:2px;
            width:0;
            background: #6E3EC0;
            transition:300ms ease all;
        }
        .update_btn:after, .delete_btn:after {
            right:inherit;
            top:inherit;
            left:0;
            bottom:0;
        }
        .update_btn:hover:before, .update_btn:hover:after, .delete_btn:hover:before, .delete_btn:hover:after {
            width:100%;
            transition:500ms ease all;
        }
        hr {
            border: 1px solid #6E3EC0;
        }
    </style>
</head>
<body>
<div class="container">
    <? include_once( URL_HEADER ); ?>
    <br>
    <div class="detailpage">
        <p id="board_title"><? echo $result_info["board_title"] ?></p>
        <p id="board_wdate">글 번호 : <? echo $result_info["board_no"] ?>  |  작성일자 : <? echo $result_info["board_wdate"] ?></p>
        <hr>
        <textarea cols=60 rows=8 id="board_content" name="board_content" readonly><? echo $result_info["board_content"] ?></textarea>
    </div>
    <br>
    <div class="btnlist">
        <a class="update_btn" href="board_update.php?board_no=<? echo $result_info["board_no"] ?>">수정</a>
        <a class="delete_btn" href="board_delete.php?board_no=<? echo $result_info["board_no"] ?>" onclick="if(!confirm('정말 삭제하시겠습니까?')){return false;}">삭제</a>
    </div>
</div>
</body>
</html>
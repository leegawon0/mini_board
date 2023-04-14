<?php
    // 상수 정의하고 DB 연결
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."board_header.php" );
    include_once( URL_DB );

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
            );
        
        // update
        $result_cnt = update_board_info_no( $arr_info );

        // select
        // $result_info = select_board_info_no( $arr_post["board_no"] );

        header( "Location: board_detail.php?board_no=".$arr_post["board_no"]);
        exit();
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
            margin: 10px;
            width: 80%;
            height: 32px;
            border: 0;
            outline: none;
            padding-left: 10px;
            background-color: #f0ebfc;
        }
        input:focus {
            border: 1px solid #b4a1e3;
        }
        label {
            color: #6E3EC0;
        }
        input[id="board_no"] {
            background-color: rgba(255, 255, 255, 0);
            color: #6E3EC0;
        }
        input[id="board_no"]:focus {
            border: 0;
        }
        textarea {
            margin: 10px;
            width: 80%;
            height: 180px;
            border: 0;
            outline: none;
            padding-left: 10px;
            background-color: #f0ebfc;
            resize: none;
        }
        textarea:focus {
            border: 1.5px solid #b4a1e3;
        }
        label[for="board_content"] {
            margin-top: 10px;
            vertical-align: top;
        }
        button{
            background:#6E3EC0;
            color:#fff;
            border:none;
            position:relative;
            height:40px;
            padding:0 1em;
            cursor:pointer;
            transition:500ms ease all;
            outline:none;
        }
        button:hover{
            background:#fff;
            color:#6E3EC0;
        }
        button:before,button:after{
            content:'';
            position:absolute;
            top:0;
            right:0;
            height:2px;
            width:0;
            background: #6E3EC0;
            transition:300ms ease all;
        }
        button:after{
            right:inherit;
            top:inherit;
            left:0;
            bottom:0;
        }
        button:hover:before,button:hover:after{
            width:100%;
            transition:500ms ease all;
        }
        .cancel_btn{
            display: inline-block;
            background:#6E3EC0;
            color:#fff;
            border:none;
            position:relative;
            line-height: 40px;
            height:40px;
            padding:0 1em;
            cursor:pointer;
            transition:500ms ease all;
            outline:none;
            justify-self: end;
            margin-right: 10px;
        }
        .cancel_btn:hover{
            background:#fff;
            color:#6E3EC0;
        }
        .cancel_btn:before, .cancel_btn:after{
            content:'';
            position:absolute;
            top:0;
            right:0;
            height:2px;
            width:0;
            background: #6E3EC0;
            transition:300ms ease all;
        }
        .cancel_btn:after{
            right:inherit;
            top:inherit;
            left:0;
            bottom:0;
        }
        .cancel_btn:hover:before, .cancel_btn:hover:after{
            width:100%;
            transition:500ms ease all;
        }
    </style>
</head>
<body>
<div class="container">
    <? include_once( URL_HEADER ); ?>
    <div class="backdrop">
    <form method="post" action="board_update.php">
        <label for="board_no">번호 : </label>
        <input id="board_no" name="board_no" type="text" value="<? echo $result_info["board_no"] ?>" readonly>
        <br>
        <label for="board_title">제목 : </label>
        <input id="board_title" name="board_title" type="text" value="<? echo $result_info["board_title"] ?>">
        <br>
        <label for="board_content">내용 : </label>
        <textarea cols=60 rows=8 id="board_content" name="board_content"><? echo $result_info["board_content"] ?></textarea>
        <br>
        <a class="cancel_btn" href="board_detail.php?board_no=<? echo $result_info["board_no"] ?>">취소</a>
        <button type="submit">수정</button>
    </form>
    </div>
</div>
</body>
</html>
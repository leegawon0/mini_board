<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    define( "URL_HEADER", DOC_ROOT."mini_board/src/board_header.php" );
    include_once( URL_DB );

    $arr_get = $_GET;

    $result_cnt = delete_board_info_no( $arr_get["board_no"]);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>글 삭제</title>
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
        .backdrop>span {
            display: inline-block;
            font-size: 1.5rem;
            margin-top: 20%;
            margin-bottom: 15%;
        }
    </style>
</head>
<body>
<div class="container">
    <? include_once( URL_HEADER ); ?>
    <div class="backdrop">
        <span>게시글이 삭제되었습니다.</span>
        <br>
        <a class="cancel_btn" href="board_list.php">돌아가기</a>
    </div>
</div>
</body>
</html>
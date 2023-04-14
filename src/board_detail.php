<?php
    // 상수 정의하고 DB 연결
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    define( "URL_HEADER", SRC_ROOT."board_header.php" );
    include_once( URL_DB );

    // Request Method를 습득
    $http_method = $_SERVER["REQUEST_METHOD"];

    // GET 체크해서 $board_no 값 설정하고 $result_info에 해당 게시글 정보 저장
    if( $http_method === "GET" )
    {
        $board_no = 1;
        if( array_key_exists("board_no", $_GET) )
        {
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );
    }

    // GET 체크해서 $page_num 값 설정
    if( array_key_exists("page_num", $_GET) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }

    // GET 체크해서 $range, $search 값 설정
    if( array_key_exists("range", $_GET))
    {
        if( $_GET["range"] === '1' )
        {
            $range = $_GET["range"];
            $search1 = $_GET["search"];
            $search2 = null;
            $search = $search1;
        }
        else if( $_GET["range"] === '2' )
        {
            $range = $_GET["range"];
            $search1 = null;
            $search2 = $_GET["search"];
            $search = $search2;
        }
        else
        {
            $range = $_GET["range"];
            $search1 = $_GET["search"];
            $search2 = $_GET["search"];
            $search = $search1;
        }
    }
    else
    {
        $range = "";
        $search1 = "";
        $search2 = "";
        $search = $search1;
    }

    // $limit_num과 $offset에 초기값 설정
    $limit_num = 7;
    $offset = ( $page_num - 1 ) * $limit_num;

    // $arr_prepare0에 위에서 입력한 검색어 $search1과 $search2 저장
    $arr_prepare0 = 
    array(
        "search1" => $search1
        ,"search2" => $search2
    );

    // $result_cnt에 전체 리스트 수 저장
    $result_cnt = search_board_info_cnt( $arr_prepare0 );

    // $max_page_num에 전체 페이지 수 저장
    $max_page_num = ceil( $result_cnt[0]["cnt"] / $limit_num );

    // $arr_prepare에 위에서 입력한 $search1, $search2, $limit_num, $offset 값 저장
    $arr_prepare = 
        array(
            "search1" => $search1
            ,"search2" => $search2
            ,"limit_num" => $limit_num
            ,"offset"   => $offset
        );
    
    // $result_paging에 리스트에서 보여줄 게시글 정보 저장
    $result_paging = select_search_info_paging( $arr_prepare );
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>게시판</title>
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
            display: grid;
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
            backdrop-filter: blur(5px);
            display: grid;
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
            width: 165px;
            justify-self: end;
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
        table {
            width: 100%;
            margin-bottom: 15px;
        }
        th {
            font-family: 'EF_hyunygothic';
            font-weight: 400;
            color: #6E3EC0;
            font-size: 20px;
        }
        .page_no {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            margin-bottom: 50px;
        }
        .page_btn, .first_btn, .last_btn {
            text-decoration: none;
            margin: 5px;
            width: 35px;
            height: 35px;
            text-align: center;
            line-height: 35px;
            color: #6E3EC0;
        }
        .page_btn:hover {
            text-decoration: none;
            background-color: #6E3EC0;
            color: white;
            transition-duration: 0.3s;
        }
        .first_btn:hover, .last_btn:hover {
            text-decoration: none;
            color: #6E3EC0;
        }
        .page_btn:not(:hover) {
            transition: 0.1s ease-out;
        }
        .page_btn<?php echo $page_num ?> {
            background-color: #6E3EC0;
            color: white;
        }
        .col1 {
            width: 20%;
        }
        .col2 {
            width: 45%;
        }
        .col3 {
            width: 35%;
        }
        .board_title {
            text-align: left;
            padding-left: 10px;
            padding-right: 10px;
        }
        th {
            height: 50px;
            border-bottom: 2px solid #6E3EC0;
        }
        td {
            height: 50px;
            border-bottom: 1.5px solid #b4a1e3;
        }
        .board_line:hover {
            background-color: #f0ebfc;
            transition-duration: 0.3s;
        }
        .board_line:not(:hover) {
            transition: 0.1s ease-out;
        }
        .board_line<? echo $board_no ?> {
            background-color: #f0ebfc;
        }
        .board_no, .board_wdate {
            color: #6E3EC0;
        }
        .insert_btn{
            display: inline-block;
            background:#6E3EC0;
            color:#fff;
            border:none;
            position:relative;
            line-height: 40px;
            width: 80px;
            height:40px;
            padding:0 1em;
            cursor:pointer;
            transition:500ms ease all;
            outline:none;
            margin-right: 10px;
            justify-self: end;
        }
        .insert_btn:hover{
            background:#fff;
            color:#6E3EC0;
        }
        .insert_btn:before, .insert_btn:after{
            content:'';
            position:absolute;
            top:0;
            right:0;
            height:2px;
            width:0;
            background: #6E3EC0;
            transition:300ms ease all;
        }
        .insert_btn:after{
            right:inherit;
            top:inherit;
            left:0;
            bottom:0;
        }
        .insert_btn:hover:before, .insert_btn:hover:after{
            width:100%;
            transition:500ms ease all;
        }
        .numarea, .titlearea, .datearea {
            height: 100%;
            display: flex;
            align-items: center;
        }
        .numarea, .datearea {
            justify-content: center;
        }
        input {
            margin: 10px;
            width: 250px;
            height: 35px;
            border: 0;
            outline: none;
            padding-left: 10px;
            background-color: #f0ebfc;
        }
        input:focus {
            border: 1px solid #b4a1e3;
        }
        form {
            float: center;
            margin-bottom: 15px;
            justify-self: center;
        }
        button {
            text-decoration: none;
            border: none;
            background-color: #6E3EC0;
            color: white;
            width: 50px;
            height: 35px;
        }
        select {
            width: 75px;
            border: 1px solid #b4a1e3;
            box-sizing: border-box;
            border-radius: 10px;
            padding: 8px 8px;
            line-height: 16px;
        }

        select:focus {
            border: 1px solid #6E3EC0;
            box-sizing: border-box;
            border-radius: 10px;
            outline: 3px solid #F8E4FF;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <? include_once( URL_HEADER ); ?>
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
    <div class="backdrop">
    <div class="tablecontainer">
    <table>
        <colgroup>
            <col class="col1">
            <col class="col2">
            <col class="col3">
        </colgroup>
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성일자</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($result_paging as $recode)
                {
            ?>
                <tr class='board_line board_line<? echo $recode["board_no"] ?>'>
                    <td class='board_no'><a href='board_detail.php?board_no=<? echo $recode["board_no"] ?>&page_num=<? echo $page_num ?>&range=<? echo $range ?>&search=<? echo $search ?>'><div class=numarea><?php echo $recode["board_no"] ?></div></a></td>
                    <td class='board_title'><a href='board_detail.php?board_no=<? echo $recode["board_no"] ?>&page_num=<? echo $page_num ?>&range=<? echo $range ?>&search=<? echo $search ?>'><div class=titlearea><?php echo $recode["board_title"] ?></div></a></td>
                    <td class='board_wdate'><a href='board_detail.php?board_no=<? echo $recode["board_no"] ?>&page_num=<? echo $page_num ?>&range=<? echo $range ?>&search=<? echo $search ?>'><div class=datearea><?php echo $recode["board_wdate"] ?></div></a></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    </div>
    </div>
    <form method=get action="board_list.php">
        <select name="range">
            <? if($range === '0') { ?>
            <option value="0" selected>전체</option>
            <option value="1">제목</option>
            <option value="2">내용</option> <? }
            else if($range === '1') { ?>
            <option value="0">전체</option>
            <option value="1" selected>제목</option>
            <option value="2">내용</option> <? }
            else if($range === '2') { ?>
            <option value="0">전체</option>
            <option value="1">제목</option>
            <option value="2" selected>내용</option> <? }
            else { ?>
            <option value="0">전체</option>
            <option value="1">제목</option>
            <option value="2">내용</option> <? } ?>
        </select>
        <input type="search" name="search" id="search" value="<? echo $search ?>">
        <button type="submit">검색</button>
    </form>
    <a class="insert_btn" href="board_insert.php">글쓰기</a>
    <br>
    <div class="page_no">
    <a class='first_btn' href='board_detail.php?board_no=<? echo $board_no ?>&page_num=1&range=<? echo $range ?>&search=<? echo $search ?>'>┃◀</a>
    <a class='first_btn' href='board_detail.php?board_no=<? echo $board_no ?>&page_num=<?
        if($page_num <= 1)
        {
            echo 1;
        }
        else
        {
            echo $page_num-1;
        }
    ?>&range=<? echo $range ?>&search=<? echo $search ?>'>◀</a>
        <?php
        if($max_page_num <= 5)
        {
            for ($i=1; $i <= $max_page_num; $i++) { 
                ?>
                <a class='page_btn page_btn<?php echo $i ?>' href='board_detail.php?board_no=<? echo $board_no ?>&page_num=<?php echo $i ?>&range=<? echo $range ?>&search=<? echo $search ?>' ><?php echo $i; ?></a>
                <?php
                    }
        }
        else
        {
            if($page_num < 4) {
                for ($i=1; $i <= 5; $i++) { 
            ?>
            <a class='page_btn page_btn<?php echo $i ?>' href='board_detail.php?board_no=<? echo $board_no ?>&page_num=<?php echo $i ?>&range=<? echo $range ?>&search=<? echo $search ?>' ><?php echo $i; ?></a>
            <?php
                }
            }
            else if($page_num < $max_page_num - 1) {
                for ($i=$page_num-2; $i <= $page_num+2; $i++) { 
                ?>
                <a class='page_btn page_btn<?php echo $i ?>' href='board_detail.php?board_no=<? echo $board_no ?>&page_num=<?php echo $i ?>&range=<? echo $range ?>&search=<? echo $search ?>' ><?php echo $i; ?></a>
                <?php
                }
            }
            else {
                for ($i=$max_page_num-4; $i <= $max_page_num; $i++) { 
                    ?>
                    <a class='page_btn page_btn<?php echo $i ?>' href='board_detail.php?board_no=<? echo $board_no ?>&page_num=<?php echo $i ?>&range=<? echo $range ?>&search=<? echo $search ?>' ><?php echo $i; ?></a>
                    <?php
                    }
            }
        }
        ?>
        <a class='first_btn' href='board_detail.php?board_no=<? echo $board_no ?>&page_num=<?
        if($page_num >= $max_page_num)
        {
            echo $max_page_num;
        }
        else
        {
            echo $page_num+1;
        }
    ?>&range=<? echo $range ?>&search=<? echo $search ?>'>▶</a>
    <a class='first_btn' href='board_detail.php?board_no=<? echo $board_no ?>&page_num=<? echo $max_page_num ?>&range=<? echo $range ?>&search=<? echo $search ?>'>▶┃</a>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
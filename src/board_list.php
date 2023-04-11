<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    include_once( URL_DB );

    // GET 체크
    if( array_key_exists("page_num", $_GET) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }
    
    $limit_num = 7;
    $offset = ( $page_num - 1 ) * $limit_num;

    // 게시판 정보 테이블 전체 카운트 획득
    $result_cnt = select_board_info_cnt();

    // 전체 페이지 번호
    $max_page_num = ceil( $result_cnt[0]["cnt"] / $limit_num );

    $arr_prepare = 
        array(
            "limit_num" => $limit_num
            ,"offset"   => $offset
        );
    $result_paging = select_board_info_paging( $arr_prepare );
    // print_r( $result_paging );
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
            backdrop-filter: blur(5px);
        }
        table {
            width: 100%;
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
            margin-top: 50px;
        }
        .page_btn {
            text-decoration: none;
            margin: 5px;
            width: 35px;
            height: 37px;
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
        .board_no, .board_wdate {
            color: #6E3EC0;
        }
    </style>
</head>
<body>
<div class="container">
    <a class='title' href='board_list.php'><img src='./common/title.gif' alt='title'></a>
    <div class="backdrop">
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
                <tr class='board_line'>
                    <td class='board_no'><?php echo $recode["board_no"] ?></td>
                    <td class='board_title'><?php echo $recode["board_title"] ?></td>
                    <td class='board_wdate'><?php echo $recode["board_wdate"] ?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    </div>
    <div class="page_no">
        <?php
            for ($i=1; $i <= $max_page_num; $i++) { 
        ?>
        <a class='page_btn page_btn<?php echo $i ?>' href='board_list.php?page_num=<?php echo $i ?>' ><?php echo $i; ?></a>
        <?php
            }
        ?>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
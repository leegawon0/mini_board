<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" );
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    include_once( URL_DB );

    if( array_key_exists("page_num", $_GET) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1;
    }
    
    $limit_num = 5;
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
            font-family: 'Pretendard-Regular';
            src: url('https://cdn.jsdelivr.net/gh/Project-Noonnu/noonfonts_2107@1.1/Pretendard-Regular.woff') format('woff');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'GangwonEduPowerExtraBoldA';
            src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2201-2@1.0/GangwonEduPowerExtraBoldA.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        * {
            margin: 0;
            padding: 0;
            font-family: 'Pretendard-Regular';
        }
        h1 {
            font-size: 50px;
            font-family: 'bitbit';
            text-align: center;
            margin: 10px;
            color: #50DAFF;
            text-shadow: -2px 0 #6E3EC0, 0 2px #6E3EC0, 2px 0 #6E3EC0, 0 -2px #6E3EC0;
        }
        th {
            font-family: 'GangwonEduPowerExtraBoldA';
            color: #6E3EC0;
            font-size: 20px;
        }
        .page_no {
            display: flex;
            justify-content: center;
        }
        a {
            margin: 5px;
            width: 35px;
        }
        .col1 {
            width: 10vw;
        }
        .col2 {
            width: 60vw;
        }
        .col3 {
            width: 30vw;
        }
        table {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>✦ MINI BOARD ✦</h1>
    <table class='table table-striped'>
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
                <tr>
                    <td><?php echo $recode["board_no"] ?></td>
                    <td><?php echo $recode["board_title"] ?></td>
                    <td><?php echo $recode["board_wdate"] ?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <div class="page_no">
        <?php
            for ($i=1; $i <= $max_page_num; $i++) { 
        ?>
        <a class='btn btn-outline-secondary' href='board_list.php?page_num=<?php echo $i ?>' ><?php echo $i; ?></a>
        <?php
            }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
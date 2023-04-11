<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/mini_board/src/" );
    define( "URL_DB", SRC_ROOT."common/db_common.php" );
    include_once( URL_DB );
    // var_dump($_SERVER, $_GET, $_POST);

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
        // print_r($_POST);
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
    <title>글 확인</title>
</head>
<body>
    <form method="post" action="board_update.php">
        <label for="board_no">게시글 번호 : </label>
        <input id="board_no" name="board_no" type="text" value="<? echo $result_info["board_no"] ?>" readonly>
        <br>
        <label for="board_title">게시글 제목 : </label>
        <input id="board_title" name="board_title" type="text" value="<? echo $result_info["board_title"] ?>">
        <br>
        <label for="board_content">게시글 내용 : </label>
        <input id="board_content" name="board_content" type="text" value="<? echo $result_info["board_content"] ?>">
    </form>
</body>
</html>
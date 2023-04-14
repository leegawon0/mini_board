<?php

// DB 연결
function db_conn( &$param_conn )
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "board";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option = 
        array(
            PDO::ATTR_EMULATE_PREPARES      => false
            ,PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
        );
    
        try
        {
            $param_conn = new PDO( $dns, $user, $pass, $pdo_option );
        }
        catch( Exception $e )
        {
            $param_conn = null;
            throw new Exception( $e->getMessage() );
        }
}

function select_board_info_no( &$param_no )
{
    $sql = 
    " SELECT "
    ."    board_no "
    ."    ,board_title "
    ."    ,board_content "
    ."    ,board_wdate "
    ." FROM "
    ."    board_info "
    ." WHERE "
    ."    board_no = :board_no "
    ;

    $arr_prepare = 
        array(
            ":board_no"    => $param_no
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result[0];
}

// SELECT
function select_board_info_paging( &$param_arr )
{
    $sql = 
    " SELECT "
    ."    board_no "
    ."    ,board_title "
    ."    ,board_wdate "
    ." FROM "
    ."    board_info "
    ." WHERE "
    ."    board_dflag = '0' "
    ." ORDER BY "
    ."    board_no DESC "
    ." LIMIT :limit_num OFFSET :offset "
    ;

    $arr_prepare = 
        array(
            ":limit_num"    => $param_arr["limit_num"]
            ,":offset"      => $param_arr["offset"]
        );


    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

function select_board_info_cnt()
{
    $sql =
    " SELECT "
    ."  COUNT(board_no) cnt "
    ." FROM "
    ." board_info "
    ." WHERE "
    ." board_dflag = '0' "
    ;

    $arr_prepare = array();

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

function update_board_info_no( &$param_arr )
{
    $sql = 
        " UPDATE "
        ." board_info "
        ." SET "
        ."      board_title = :board_title "
        ."      ,board_content = :board_content "
        ." WHERE "
        ." board_no = :board_no "
        ;

    $arr_prepare =
        array(
            ":board_title"      => $param_arr["board_title"]
            ,":board_content"   => $param_arr["board_content"]
            ,":board_no"        => $param_arr["board_no"]
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    }
    catch( Exception $e )
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result_cnt;
}

function insert_board_info( &$param_arr )
{
    $sql = 
        " INSERT INTO "
        ." board_info "
        ." ( "
        ."      board_title "
        ."      ,board_content "
        ."      ,board_wdate "
        ." ) "
        ." VALUES "
        ." ( "
        ."      :board_title "
        ."      ,:board_content "
        ."      ,NOW() "
        ." ) "
        ;

    $arr_prepare =
        array(
            ":board_title"      => $param_arr["board_title"]
            ,":board_content"   => $param_arr["board_content"]
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_info = $stmt->rowCount();
        $conn->commit();
    }
    catch( Exception $e )
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result_info;
}

function delete_board_info_no( &$param_no )
{
    $sql = 
        " UPDATE "
        ." board_info "
        ." SET "
        ."      board_dflag = '1' "
        ."      ,board_ddate = NOW() "
        ." WHERE "
        ." board_no = :board_no "
        ;

    $arr_prepare =
        array(
            ":board_no" => $param_no
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    }
    catch( Exception $e )
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result_cnt;
}

function select_board_info_maxcnt()
{
    $sql =
    " SELECT "
    ."  COUNT(board_no) cnt "
    ." FROM "
    ." board_info "
    ;

    $arr_prepare = array();

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

function select_search_info_paging( &$param_arr )
{
    $sql = 
    " SELECT "
    ."    board_no "
    ."    ,board_title "
    ."    ,board_wdate "
    ." FROM "
    ."    board_info "
    ." WHERE "
    ." board_dflag = '0' AND ( "
    ." board_title LIKE CONCAT('%', :search1, '%') "
    ." OR board_content LIKE CONCAT('%', :search2, '%') ) "
    ." ORDER BY "
    ."    board_no DESC "
    ." LIMIT :limit_num OFFSET :offset "
    ;

    $arr_prepare = 
        array(
            ":search1"    => $param_arr["search1"]
            ,":search2"    => $param_arr["search2"]
            ,":limit_num"    => $param_arr["limit_num"]
            ,":offset"      => $param_arr["offset"]
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

function search_board_info_cnt( &$param_arr )
{
    $sql =
    " SELECT "
    ."  COUNT(board_no) cnt "
    ." FROM "
    ." board_info "
    ." WHERE "
    ." board_dflag = '0' AND ( "
    ." board_title LIKE CONCAT('%', :search1, '%') "
    ." OR board_content LIKE CONCAT('%', :search2, '%') ) "
    ;

    $arr_prepare = 
    array(
        ":search1"    => $param_arr["search1"]
        ,":search2"    => $param_arr["search2"]
    );

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

// TODO : test Start
// $arr = 
//     array(
//         "limit_num" => 5
//         ,"offset"   => 0
//     );
// $result = select_board_info_paging( $arr );
// print_r( $result );
// TODO : test End

// TODO : start
// $i = 20;
// print_r(select_board_info_no( $i ));
// TODO : end

//  TODO : start
// $arr = 
//     array(
//         "board_no" => 1
//         ,"board_title" => "test_title1"
//         ,"board_content" => "test_content1"
//     );
// echo update_board_info_no( $arr );
// TODO : end

//  TODO : start
// $arr = 
//     array(
//         "board_title" => "test_title1"
//         ,"board_content" => "test_content1"
//     );
// echo insert_board_info( $arr );
// TODO : end

//  TODO : start
// $arr = 55;
// echo delete_board_info_no( $arr );
// TODO : end

// TODO : start
// $arr =  select_board_info_maxcnt();
// print_r($arr);
// TODO : end

// TODO : start
// $arr = 
//     array(
//         "search1" => "테스트"
//         ,"search2" => "테스트"
//     );
// $result = select_search_info_paging( $arr );
// var_dump( $result );
// TODO : end

// TODO : start
// $arr = 
//     array(
//         "search1" => "테스트"
//         ,"search2" => "테스트"
//     );
// $result = search_board_info_cnt( $arr );
// var_dump( $result );
// TODO : end

?>
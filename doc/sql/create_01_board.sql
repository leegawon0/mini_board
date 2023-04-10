-- 데이터베이스 생성
CREATE DATABASE board;

-- 테이블을 생성할 데이터베이스 지정
USE board;

-- 테이블 생성
CREATE TABLE board_info (
	board_no INT PRIMARY KEY AUTO_INCREMENT
	,board_title VARCHAR(100) NOT NULL
	,board_content VARCHAR(1000) NOT NULL
	,board_wdate DATETIME NOT NULL
	,board_dflag CHAR(1) DEFAULT('0') NOT NULL
	,board_ddate DATETIME
);

-- 테이블 확인
DESC board_info;
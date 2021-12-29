-- --------------------------------------------------------
-- 호스트:                          192.168.56.103
-- 서버 버전:                        5.7.36 - MySQL Community Server (GPL)
-- 서버 OS:                        Linux
-- HeidiSQL 버전:                  11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- idus 데이터베이스 구조 내보내기
CREATE DATABASE IF NOT EXISTS `idus` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `idus`;

-- 테이블 idus.Member 구조 내보내기
CREATE TABLE IF NOT EXISTS `Member` (
  `member_idx` int(11) NOT NULL AUTO_INCREMENT COMMENT '회원식별자',
  `member_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원아이디(영문 대소문자,숫자)',
  `member_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원이름(영문 대소문자)',
  `member_nickname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원별명(영문 소문자만)',
  `member_password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원비밀번호',
  `member_tel` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '전화번호(숫자만)',
  `member_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이메일',
  `member_gender` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '성별(M:남성, F:여성)',
  `join_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '회원가입일시',
  `last_login_datetime` timestamp NULL DEFAULT NULL COMMENT '마지막로그인일시',
  PRIMARY KEY (`member_idx`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='회원';

-- 내보낼 데이터가 선택되어 있지 않습니다.

-- 테이블 idus.Orders 구조 내보내기
CREATE TABLE IF NOT EXISTS `Orders` (
  `order_no` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문번호(임의의 영문 대문자,숫자조합)',
  `member_idx` int(11) NOT NULL COMMENT '회원식별자',
  `product_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품명(emoji 포함한 모든문자)',
  `order_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '주문일시',
  `pay_datetime` timestamp NULL DEFAULT NULL COMMENT '결제일시',
  PRIMARY KEY (`order_no`),
  KEY `FK__Member` (`member_idx`),
  CONSTRAINT `FK__Member` FOREIGN KEY (`member_idx`) REFERENCES `Member` (`member_idx`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='주문서';

-- 내보낼 데이터가 선택되어 있지 않습니다.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

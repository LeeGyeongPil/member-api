-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        8.0.27 - MySQL Community Server - GPL
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
CREATE DATABASE IF NOT EXISTS `idus` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `idus`;

-- 테이블 idus.Member 구조 내보내기
CREATE TABLE IF NOT EXISTS `Member` (
  `member_idx` int NOT NULL AUTO_INCREMENT COMMENT '회원식별자',
  `member_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원아이디(영문 대소문자,숫자)',
  `member_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원이름(영문 대소문자)',
  `member_nickname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원별명(영문 소문자만)',
  `member_password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원비밀번호',
  `member_tel` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '전화번호(숫자만)',
  `member_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이메일',
  `member_gender` enum('M','F') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '성별(M:남성, F:여성)',
  `join_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '회원가입일시',
  `login_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '로그인토큰',
  `last_login_datetime` timestamp NULL DEFAULT NULL COMMENT '마지막로그인일시',
  PRIMARY KEY (`member_idx`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='회원';

-- 테이블 데이터 idus.Member:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `Member` DISABLE KEYS */;
INSERT INTO `Member` (`member_idx`, `member_id`, `member_name`, `member_nickname`, `member_password`, `member_tel`, `member_email`, `member_gender`, `join_datetime`, `login_token`, `last_login_datetime`) VALUES
	(1, 'errormeta', '이경필', 'errors', 'e0c4c70dedaa5a9b36f312cd64794d215d00d4a07cc87dcdc87439cde2e4942c', '01020863327', 'errormeta@gmail.com', 'M', '2021-12-29 12:41:57', '', '2021-12-29 14:30:57'),
	(2, 'idus', '아이디어스', 'idus', 'e0c4c70dedaa5a9b36f312cd64794d215d00d4a07cc87dcdc87439cde2e4942c', '01000000000', 'idus@gmail.com', 'M', '2021-12-29 14:33:29', '', '2021-12-29 14:53:29'),
	(3, 'backpacker', '백패커', 'backpacker', 'e0c4c70dedaa5a9b36f312cd64794d215d00d4a07cc87dcdc87439cde2e4942c', '0260223651', 'backpacker@gmail.com', 'F', '2021-12-29 14:35:01', '', '2021-12-29 14:59:01');
/*!40000 ALTER TABLE `Member` ENABLE KEYS */;

-- 테이블 idus.Orders 구조 내보내기
CREATE TABLE IF NOT EXISTS `Orders` (
  `order_no` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문번호(임의의 영문 대문자,숫자조합)',
  `member_idx` int NOT NULL COMMENT '회원식별자',
  `product_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품명(emoji 포함한 모든문자)',
  `order_price` int NOT NULL DEFAULT '0' COMMENT '주문금액',
  `order_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '주문일시',
  `pay_datetime` timestamp NULL DEFAULT NULL COMMENT '결제일시',
  PRIMARY KEY (`order_no`),
  KEY `FK__Member` (`member_idx`),
  CONSTRAINT `FK__Member` FOREIGN KEY (`member_idx`) REFERENCES `Member` (`member_idx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='주문서';

-- 테이블 데이터 idus.Orders:~0 rows (대략적) 내보내기
/*!40000 ALTER TABLE `Orders` DISABLE KEYS */;
INSERT INTO `Orders` (`order_no`, `member_idx`, `product_name`, `order_price`, `order_datetime`, `pay_datetime`) VALUES
	('ACDE15648788', 1, '🔥하반기 조림 빅세일🔥실속 인기 수제 마른반찬 세트', 4980, '2021-12-29 12:55:17', '2021-12-29 12:55:17'),
	('AK35HO78456R', 1, '[감성캔들]베이직 천연 소이 캔들1+1 7oz/9oz', 14500, '2021-12-29 12:51:13', '2021-12-29 12:51:13'),
	('H9E2111O2IWR', 1, '🔥인기작품💜아이리스 크롤러 후크 귀걸이 이어커프', 13900, '2021-12-29 14:42:47', NULL),
	('ST1JH789OAER', 2, '♥️생일선물 커플선물 추천 머랭쿠키♥️', 4000, '2021-12-29 14:43:21', NULL),
	('W8A77ER9G1JO', 2, '[웰컴딜] 5만돌파🔥조향사가만든,향지속최강섬유향수', 1000, '2021-12-29 14:39:04', '2021-12-29 14:39:04');
/*!40000 ALTER TABLE `Orders` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `account` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Name` varchar(255) DEFAULT NULL COMMENT 'Display name.',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `application` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Suite` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: suite',
  `Name` varchar(255) NOT NULL COMMENT 'Display Name',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Applications contained in each suite.';

CREATE TABLE IF NOT EXISTS `environment` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Suite` bigint(20) DEFAULT NULL COMMENT 'Key to: suite',
  `Name` varchar(50) DEFAULT NULL COMMENT 'Display name.',
  `Order` tinyint(4) DEFAULT '0' COMMENT 'Key to sort environments in logical order.',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Environments for each suites.';

CREATE TABLE IF NOT EXISTS `function` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Application` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: application',
  `Name` varchar(255) NOT NULL COMMENT 'Display Name',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Functions for each application.';

CREATE TABLE IF NOT EXISTS `meta` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Key` varchar(50) NOT NULL COMMENT 'Internal qualifier.',
  `ParentLevel` varchar(255) DEFAULT NULL COMMENT 'Table name of the parent item.',
  `ParentID` bigint(20) DEFAULT NULL COMMENT 'ID of the parent in the table (from ParentLevel).',
  `StatNumeric` double DEFAULT NULL COMMENT 'Stores numeric statistic.',
  `DataValue` varchar(50) DEFAULT NULL COMMENT 'Stores value for a data.',
  `DataDisplay` varchar(255) DEFAULT NULL COMMENT 'Stores a display version of a data.',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Various metadata such as statistics and tables.';

CREATE TABLE IF NOT EXISTS `phase` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Suite` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: suite',
  `Version` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: version',
  `Environment` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: environment',
  `Name` varchar(255) NOT NULL COMMENT 'Display name.',
  `Description` text NOT NULL COMMENT 'Description or note about this phase of tests.',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Phases of tests for combination of version-environment for a suite of applications.';

CREATE TABLE IF NOT EXISTS `suite` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID',
  `Account` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: account',
  `Name` varchar(255) NOT NULL COMMENT 'Display name.',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Suites of applications.';

CREATE TABLE IF NOT EXISTS `test` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Function` bigint(20) NOT NULL COMMENT 'Key to: function',
  `Number` varchar(50) NOT NULL COMMENT 'Key to sort tests in the function.',
  `Name` varchar(255) NOT NULL COMMENT 'Test Name.',
  `Description` text NOT NULL COMMENT 'Description or note about the test.',
  `Method` text NOT NULL COMMENT 'How to perform the test.',
  `Result` text NOT NULL COMMENT 'Normal awaited result.',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tests for each functions.';

CREATE TABLE IF NOT EXISTS `user` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Account` bigint(20) NOT NULL COMMENT 'Key to: account',
  `Name` varchar(255) DEFAULT NULL COMMENT 'Display name.',
  `Passwd` varchar(255) DEFAULT NULL COMMENT 'Hashed password.',
  `Email` varchar(255) DEFAULT NULL COMMENT 'Email address.',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='SSTM Users.';

CREATE TABLE IF NOT EXISTS `version` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `Suite` bigint(20) NOT NULL COMMENT 'Key to: suite',
  `Name` varchar(50) NOT NULL COMMENT 'Display name for version.',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Versions of suites for which a phase of tests will be performed.';

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

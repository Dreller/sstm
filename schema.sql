/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `account` (
  `accID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `accName` varchar(255) DEFAULT NULL COMMENT 'Display name.',
  PRIMARY KEY (`accID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `application` (
  `appID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `appSuite` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: suite',
  `appPackage` bigint(20) NOT NULL COMMENT 'Key to: package',
  `appName` varchar(255) NOT NULL COMMENT 'Display Name',
  `appCode` varchar(50) DEFAULT NULL COMMENT 'Short custom ID.',
  `appDesc` text COMMENT 'Description',
  PRIMARY KEY (`appID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Applications contained in each suite.';

CREATE TABLE IF NOT EXISTS `environment` (
  `envID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `envSuite` bigint(20) DEFAULT NULL COMMENT 'Key to: suite',
  `envName` varchar(50) DEFAULT NULL COMMENT 'Display name.',
  `envOrder` tinyint(4) DEFAULT '0' COMMENT 'Key to sort environments in logical order.',
  `envCode` varchar(50) DEFAULT NULL COMMENT 'Short custom ID.',
  `encDesc` text COMMENT 'Description.',
  PRIMARY KEY (`envID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Environments for each suites.';

CREATE TABLE IF NOT EXISTS `function` (
  `fctID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `fctApplication` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: application',
  `fctName` varchar(255) NOT NULL COMMENT 'Display Name',
  PRIMARY KEY (`fctID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Functions for each application.';

CREATE TABLE IF NOT EXISTS `meta` (
  `metaID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `metaKey` varchar(50) NOT NULL COMMENT 'Internal qualifier.',
  `metaParentLevel` varchar(255) DEFAULT NULL COMMENT 'Table name of the parent item.',
  `metaParentID` bigint(20) DEFAULT NULL COMMENT 'ID of the parent in the table (from ParentLevel).',
  `metaStatNumeric` double DEFAULT NULL COMMENT 'Stores numeric statistic.',
  `metaDataValue` varchar(50) DEFAULT NULL COMMENT 'Stores value for a data.',
  `metaDataDisplay` varchar(255) DEFAULT NULL COMMENT 'Stores a display version of a data.',
  PRIMARY KEY (`metaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Various metadata such as statistics and tables.';

CREATE TABLE IF NOT EXISTS `package` (
  `packID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `packSuite` bigint(20) DEFAULT NULL COMMENT 'Key to: suite',
  `packName` varchar(255) DEFAULT NULL COMMENT 'Display name.',
  `packCode` varchar(50) DEFAULT NULL COMMENT 'Short custom ID.',
  `packDesc` text COMMENT 'Description.',
  PRIMARY KEY (`packID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Packages are groups of applications within a suite.';

CREATE TABLE IF NOT EXISTS `phase` (
  `phaID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `phaSuite` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: suite',
  `phaVersion` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: version',
  `phaEnvironment` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: environment',
  `phaName` varchar(255) NOT NULL COMMENT 'Display name.',
  `phaDescription` text NOT NULL COMMENT 'Description or note about this phase of tests.',
  PRIMARY KEY (`phaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Phases of tests for combination of version-environment for a suite of applications.';

CREATE TABLE IF NOT EXISTS `suite` (
  `suiteID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID',
  `suiteAccount` bigint(20) NOT NULL DEFAULT '0' COMMENT 'Key to: account',
  `suiteName` varchar(255) NOT NULL COMMENT 'Display name.',
  `suiteDesc` text COMMENT 'Description.',
  PRIMARY KEY (`suiteID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Suites of applications.';

CREATE TABLE IF NOT EXISTS `test` (
  `testID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `testFunction` bigint(20) NOT NULL COMMENT 'Key to: function',
  `testNumber` varchar(50) NOT NULL COMMENT 'Key to sort tests in the function.',
  `testName` varchar(255) NOT NULL COMMENT 'Test Name.',
  `testDescription` text NOT NULL COMMENT 'Description or note about the test.',
  `testMethod` text NOT NULL COMMENT 'How to perform the test.',
  `testResult` text NOT NULL COMMENT 'Normal awaited result.',
  PRIMARY KEY (`testID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tests for each functions.';

CREATE TABLE IF NOT EXISTS `user` (
  `userID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `userAccount` bigint(20) NOT NULL COMMENT 'Key to: account',
  `userName` varchar(255) DEFAULT NULL COMMENT 'Display name.',
  `userPasswd` varchar(255) DEFAULT NULL COMMENT 'Hashed password.',
  `userPasswdExpired` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Flag for expired password.',
  `userEmail` varchar(255) DEFAULT NULL COMMENT 'Email address.',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='SSTM Users.';

CREATE TABLE IF NOT EXISTS `version` (
  `verID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Internal ID.',
  `verSuite` bigint(20) NOT NULL COMMENT 'Key to: suite',
  `verName` varchar(50) NOT NULL COMMENT 'Display name for version.',
  `verCode` varchar(50) DEFAULT NULL COMMENT 'Short custom ID.',
  `verDesc` text COMMENT 'Description.',
  PRIMARY KEY (`verID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='Versions of suites for which a phase of tests will be performed.';

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

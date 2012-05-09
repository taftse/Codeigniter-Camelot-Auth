SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `Camelot_Auth` DEFAULT CHARACTER SET utf8 ;
USE `Camelot_Auth` ;

-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_Account`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_Account` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_Account` (
  `Account_ID` INT NOT NULL AUTO_INCREMENT ,
  `Account_First_Name` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Last_Name` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Email` VARCHAR(45) NOT NULL ,
  `Account_Address_1` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Address_2` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_City` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Zip_Code` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_State_Code` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Country_ISO` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Status` VARCHAR(45) NULL DEFAULT NULL COMMENT '0 = Deleted\n1 = Active\n2 = Pending\n3 = Suspended\n' ,
  `Account_Last_Login` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Last_IP` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Created_On` VARCHAR(45) NULL DEFAULT NULL ,
  `Account_Last_Modified` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`Account_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_Local_Users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_Local_Users` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_Local_Users` (
  `Local_User_ID` INT NOT NULL ,
  `Local_User_Account_ID` VARCHAR(45) NOT NULL ,
  `Local_User_Username` VARCHAR(45) NOT NULL ,
  `Local_User_Password_Hash` VARCHAR(255) NOT NULL ,
  `Local_User_Password_Salt` VARCHAR(45) NOT NULL ,
  `Local_User_Password_Hint` VARCHAR(45) NULL DEFAULT NULL ,
  `Local_User_Security_Question` VARCHAR(45) NULL DEFAULT NULL ,
  `Local_User_Security_Answer` VARCHAR(45) NULL DEFAULT NULL ,
  `Local_User_Password_Set_Timestamp` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`Local_User_ID`, `Local_User_Account_ID`) ,
  INDEX `fk_Auth_Local_Users_Auth_Account1` (`Local_User_Account_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_Local_Password_History`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_Local_Password_History` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_Local_Password_History` (
  `Password_ID` INT NOT NULL ,
  `Password_Account_ID` VARCHAR(45) NOT NULL ,
  `Password_Hash` VARCHAR(255) NOT NULL ,
  `Password_Salt` VARCHAR(45) NOT NULL ,
  `Password_Hint` VARCHAR(45) NULL DEFAULT NULL ,
  `Password_Security_Question` VARCHAR(45) NULL DEFAULT NULL ,
  `Password_Security_Answer` VARCHAR(45) NULL DEFAULT NULL ,
  `Password_Set_Timestamp` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`Password_ID`, `Password_Account_ID`) ,
  INDEX `fk_Auth_Local_Users_copy1_Auth_Account1` (`Password_Account_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_OAuth_Users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_OAuth_Users` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_OAuth_Users` (
  `OAuth_User_ID` INT NOT NULL AUTO_INCREMENT ,
  `OAuth_User_Account_ID` INT NULL DEFAULT NULL ,
  `OAuth_User_Provider` VARCHAR(45) NULL DEFAULT NULL ,
  `OAuth_User_Auth_ID` VARCHAR(45) NULL DEFAULT NULL ,
  `OAuth_User_Auth_Username` VARCHAR(45) NULL DEFAULT NULL ,
  `OAuth_User_Auth_Token` VARCHAR(45) NULL DEFAULT NULL ,
  `OAuth_User_Auth_Token_Verifier` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`OAuth_User_ID`) ,
  INDEX `fk_OAuth_Users_Auth_Account1` (`OAuth_User_Account_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Attributes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Attributes` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Attributes` (
  `Attribute_ID` INT NOT NULL AUTO_INCREMENT ,
  `Attribute_Name` VARCHAR(255) NULL DEFAULT NULL ,
  `Attribute_FullName` VARCHAR(255) NULL DEFAULT NULL ,
  `Attribute_OID` VARCHAR(128) NULL DEFAULT NULL ,
  `Attribute_URN` VARCHAR(255) NULL DEFAULT NULL ,
  `Attribute_Description` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`Attribute_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Federations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Federations` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Federations` (
  `Federation_ID` INT NOT NULL AUTO_INCREMENT ,
  `Federation_Name` VARCHAR(128) NOT NULL ,
  `Federation_Description` TEXT NULL DEFAULT NULL ,
  `Federation_URL` VARCHAR(255) NULL DEFAULT NULL ,
  `Federation_Active` TINYINT(1) NULL DEFAULT NULL ,
  `Federation_Public` TINYINT(1) NULL DEFAULT NULL ,
  PRIMARY KEY (`Federation_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Attributes_Lookup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Attributes_Lookup` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Attributes_Lookup` (
  `ALookup_ID` INT NOT NULL AUTO_INCREMENT ,
  `ALookup_Attribute_ID` INT NOT NULL ,
  `ALookup_Federation_ID` INT NOT NULL ,
  `ALookup_Status` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`ALookup_ID`, `ALookup_Attribute_ID`, `ALookup_Federation_ID`) ,
  INDEX `fk_Auth_SAML2_Attributes_Lookup_Auth_SAML2_Attributes1` (`ALookup_Attribute_ID` ASC) ,
  INDEX `fk_Auth_SAML2_Attributes_Lookup_Auth_SAML2_Federations1` (`ALookup_Federation_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_Saml2_Metadata`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_Saml2_Metadata` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_Saml2_Metadata` (
  `Saml2_Metadata_ID` INT NOT NULL AUTO_INCREMENT ,
  `Saml2_Metadata_Name` VARCHAR(255) NOT NULL ,
  `Saml2_Metadata_Federation_ID` INT NULL DEFAULT NULL ,
  `Saml2_Metadata_URL` VARCHAR(255) NOT NULL ,
  `Saml2_Metadata_Active` TINYINT(1) NULL DEFAULT NULL ,
  `Saml2_Metadata_Public` TINYINT(1) NULL DEFAULT NULL ,
  `Saml2_Metadata_Created_On` VARCHAR(45) NULL DEFAULT NULL ,
  `Saml2_Metadata_Last_Update` VARCHAR(45) NULL DEFAULT NULL ,
  `Saml2_Metadata_Last_Import` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`Saml2_Metadata_ID`) ,
  INDEX `fk_Auth_Saml2_Metadata_Auth_Saml2_Federations1` (`Saml2_Metadata_Federation_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Entities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Entities` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Entities` (
  `Entity_ID` INT NOT NULL AUTO_INCREMENT ,
  `Entity_Name` VARCHAR(1024) NOT NULL ,
  `Entity_UID` VARCHAR(255) NOT NULL ,
  `Entity_Name_ID_Format` VARCHAR(45) NULL DEFAULT NULL ,
  `Entity_Support_URL` VARCHAR(255) NULL DEFAULT NULL ,
  `Entity_Home_URL` VARCHAR(255) NULL DEFAULT NULL ,
  `Entity_Owner_ID` INT NULL DEFAULT NULL ,
  `Entity_Type` VARCHAR(10) NOT NULL ,
  `Entity_Aproved` TINYINT(1) NOT NULL DEFAULT 0 ,
  `Entity_Active` TINYINT(1) NOT NULL DEFAULT 0 ,
  `Entity_Valid_From` VARCHAR(45) NOT NULL DEFAULT '00000000' ,
  `Entity_Valid_To` VARCHAR(45) NOT NULL DEFAULT '00000000' ,
  `Entity_Description` TEXT NULL DEFAULT NULL ,
  `Entity_Use_Static` TINYINT(1) NOT NULL DEFAULT 0 ,
  `Entity_Created_On` DATETIME NULL DEFAULT NULL ,
  `Entity_Last_Updated` DATETIME NULL DEFAULT NULL ,
  `Entity_Is_Locked` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`Entity_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Contacts` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Contacts` (
  `Contact_ID` INT NOT NULL AUTO_INCREMENT ,
  `Contact_Object_Type` VARCHAR(45) NULL DEFAULT NULL ,
  `Contact_Object_ID` INT NOT NULL ,
  `Contact_Name` VARCHAR(255) NULL DEFAULT NULL ,
  `Contact_Phone_No` INT NULL DEFAULT NULL ,
  `Contact_Email` VARCHAR(255) NULL DEFAULT NULL ,
  `Contact_Type` VARCHAR(45) NULL DEFAULT NULL ,
  `Contact_Created_On` DATETIME NULL DEFAULT NULL ,
  `Contact_Modified_On` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`Contact_ID`, `Contact_Object_ID`) ,
  INDEX `fk_Auth_SAML2_Contacts_Auth_SAML2_Entities1` (`Contact_Object_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Certificates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Certificates` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Certificates` (
  `Cert_ID` INT NOT NULL AUTO_INCREMENT ,
  `Cert_Entity_ID` INT NOT NULL ,
  `Cert_Type` VARCHAR(20) NULL DEFAULT NULL ,
  `Cert_Data` TEXT NULL DEFAULT NULL ,
  `Cert_Default` TINYINT(1) NOT NULL DEFAULT FALSE ,
  `Cert_Fingerprint` VARCHAR(64) NULL DEFAULT NULL ,
  `Cert_Subject` VARCHAR(128) NULL DEFAULT NULL ,
  `Cert_Created_On` INT NULL DEFAULT NULL ,
  `Cert_Modified_On` INT NULL DEFAULT NULL ,
  PRIMARY KEY (`Cert_ID`, `Cert_Entity_ID`) ,
  INDEX `fk_Auth_SAML2_Certificates_Auth_SAML2_Entities1` (`Cert_Entity_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Federation_Members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Federation_Members` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Federation_Members` (
  `FMember_ID` INT NOT NULL AUTO_INCREMENT ,
  `FMember_Federation_ID` INT NOT NULL ,
  `FMember_Entity_ID` INT NOT NULL ,
  `FMember_Type` VARCHAR(12) NOT NULL ,
  `FMember_Status` CHAR NOT NULL ,
  PRIMARY KEY (`FMember_ID`, `FMember_Federation_ID`, `FMember_Entity_ID`) ,
  INDEX `fk_Auth_SAML2_Federation_Members_Auth_SAML2_Federations1` (`FMember_Federation_ID` ASC) ,
  INDEX `fk_Auth_SAML2_Federation_Members_Auth_SAML2_Entities1` (`FMember_Entity_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Sp_Attribute_Settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Sp_Attribute_Settings` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Sp_Attribute_Settings` (
  `ASettings_ID` INT NOT NULL AUTO_INCREMENT ,
  `ASettings_Federation_ID` INT NOT NULL DEFAULT 0 ,
  `ASettings_Entity_ID` INT NOT NULL ,
  `ASettings_Attribute_ID` INT NOT NULL ,
  `ASettings_Status` VARCHAR(45) NOT NULL ,
  `ASettings_Reason` TEXT NULL DEFAULT NULL ,
  `ASettings_Created_On` DATETIME NULL DEFAULT NULL ,
  `ASettings_Modified_On` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`ASettings_ID`, `ASettings_Entity_ID`, `ASettings_Attribute_ID`, `ASettings_Federation_ID`) ,
  INDEX `fk_Auth_SAML2_Sp_Attribute_Settings_Auth_SAML2_Entities1` (`ASettings_Entity_ID` ASC) ,
  INDEX `fk_Auth_SAML2_Sp_Attribute_Settings_Auth_SAML2_Attributes1` (`ASettings_Attribute_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Service_Locations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Service_Locations` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Service_Locations` (
  `Sl_ID` INT NOT NULL AUTO_INCREMENT ,
  `Sl_Entity_ID` INT NOT NULL ,
  `Sl_Service_Type` VARCHAR(128) NULL DEFAULT NULL ,
  `Sl_Service_Binding` VARCHAR(128) NULL DEFAULT NULL ,
  `Sl_Service_Location` VARCHAR(255) NULL DEFAULT NULL ,
  `Sl_Default` CHAR NULL DEFAULT NULL ,
  `Sl_Index` INT(2) NULL DEFAULT NULL ,
  `Sl_Created_On` INT NULL DEFAULT NULL ,
  `Sl_Modified_On` INT NULL DEFAULT NULL ,
  PRIMARY KEY (`Sl_ID`, `Sl_Entity_ID`) ,
  INDEX `fk_Auth_SAML2_Service_Locations_Auth_SAML2_Entities1` (`Sl_Entity_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Entity_Extra_Details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Entity_Extra_Details` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Entity_Extra_Details` (
  `EED_ID` INT NOT NULL AUTO_INCREMENT ,
  `EED_Entity_ID` INT NOT NULL ,
  `EED_Lang` VARCHAR(2) NULL DEFAULT 'en' ,
  `EED_Display_Name` VARCHAR(45) NULL DEFAULT NULL ,
  `EED_Description` TEXT NULL DEFAULT NULL ,
  `EED_Logo` TEXT NULL DEFAULT NULL ,
  `EED_Information_URL` TEXT NULL DEFAULT NULL ,
  `EED_Privacy_Statement_URL` TEXT NULL DEFAULT NULL ,
  `EED_IP_Hints` TEXT NULL DEFAULT NULL ,
  `EED_Domain_Hint` TEXT NULL DEFAULT NULL ,
  `EED_Geo_Locations` TEXT NULL DEFAULT NULL ,
  `EED_Keywords` TEXT NULL DEFAULT NULL ,
  `EED_Created_On` INT NULL DEFAULT NULL ,
  `EED_Modified_On` INT NULL DEFAULT NULL ,
  PRIMARY KEY (`EED_ID`, `EED_Entity_ID`) ,
  INDEX `fk_Auth_SAML2_Entity_Extra_Details_Auth_SAML2_Entities1` (`EED_Entity_ID` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Camelot_Auth`.`Auth_SAML2_Users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Camelot_Auth`.`Auth_SAML2_Users` ;

CREATE  TABLE IF NOT EXISTS `Camelot_Auth`.`Auth_SAML2_Users` (
  `Saml2_User_ID` INT NOT NULL AUTO_INCREMENT ,
  `Saml2_User_Account_ID` VARCHAR(45) NULL ,
  `Saml2_User_Entity_ID` INT NULL ,
  `Saml2_User_Persistent_ID` TEXT NULL ,
  `Saml2_User_Username` VARCHAR(45) NULL ,
  `Saml2_User_Affiliation` TEXT NULL ,
  PRIMARY KEY (`Saml2_User_ID`) ,
  INDEX `fk_Auth_SAML2_Users_Auth_Account1` (`Saml2_User_Account_ID` ASC) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

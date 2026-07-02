<?php
phpinfo();
?>
-- MySQL Workbench Synchronization
-- Generated: 2026-06-25 09:45
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: asela

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER SCHEMA `erav_madawalafarm`  DEFAULT CHARACTER SET utf8mb4  DEFAULT COLLATE utf8mb4_general_ci ;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`amount_configuration` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `pay_amount` DOUBLE NOT NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`assigned_devices` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `device_name` VARCHAR(45) NOT NULL,
  `remarks` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8mb4;

ALTER TABLE `erav_madawalafarm`.`branches` 
ADD COLUMN `company_id` INT(11) NULL DEFAULT '0' AFTER `id`,
ADD COLUMN `code` TEXT NULL DEFAULT NULL AFTER `location`,
ADD COLUMN `latitude` VARCHAR(255) NULL DEFAULT NULL AFTER `etf`,
ADD COLUMN `longitude` VARCHAR(255) NULL DEFAULT NULL AFTER `latitude`,
ADD COLUMN `outside_location` INT(11) NULL DEFAULT NULL AFTER `longitude`;

ALTER TABLE `erav_madawalafarm`.`companies` 
ADD COLUMN `logo` VARCHAR(45) COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL AFTER `code`,
ADD COLUMN `company_type` INT(11) NULL DEFAULT '0' AFTER `svat_no`,
ADD COLUMN `paysheet_language` INT(11) NULL DEFAULT '1' COMMENT '1=English, 2=Sinhala, 3=Tamil' AFTER `company_type`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`company_bank_details` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `company_id` INT(11) NOT NULL,
  `bank_code` VARCHAR(10) NOT NULL,
  `branch_code` VARCHAR(10) NOT NULL,
  `bank_account_number` VARCHAR(20) NOT NULL,
  `bank_account_name` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`company_hierarchies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `position` VARCHAR(45) NOT NULL,
  `order_number` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`custom_leaves` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `type` INT(11) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `idsalary_adjustments` INT(11) NOT NULL,
  `deduction` DOUBLE NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`department_sections` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `department_id` INT(11) NOT NULL,
  `section_head_emp_id` INT(11) NULL DEFAULT NULL,
  `section` VARCHAR(45) NOT NULL,
  `remark` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

ALTER TABLE `erav_madawalafarm`.`departments` 
ADD COLUMN `dep_head_emp_id` INT(11) NULL DEFAULT '0' AFTER `name`;

ALTER TABLE `erav_madawalafarm`.`emp_product_allocation` 
ADD COLUMN `machine_id` INT(11) NOT NULL AFTER `date`,
ADD COLUMN `product_id` INT(11) NOT NULL AFTER `machine_id`,
ADD COLUMN `shift_id` INT(11) NULL DEFAULT NULL AFTER `product_id`,
ADD COLUMN `product_type` VARCHAR(255) NULL DEFAULT NULL AFTER `shift_id`,
ADD COLUMN `semi_amount` DOUBLE NULL DEFAULT NULL AFTER `product_type`,
ADD COLUMN `full_amount` DOUBLE NULL DEFAULT NULL AFTER `semi_amount`,
ADD COLUMN `cancel_description` VARCHAR(255) NULL DEFAULT NULL AFTER `full_amount`,
ADD COLUMN `production_status` INT(11) NOT NULL AFTER `cancel_description`,
ADD COLUMN `complete_status` INT(11) NULL DEFAULT NULL AFTER `status`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`emp_production_allocation` (
  `id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `department_id` INT(11) NOT NULL,
  `section_id` INT(11) NOT NULL,
  `emp_id` INT(11) NOT NULL,
  `status` INT(11) NULL DEFAULT '0',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`emp_production_details` (
  `id` INT(11) NOT NULL,
  `department_id` INT(11) NOT NULL,
  `section_id` INT(11) NOT NULL,
  `men_incentive` DECIMAL(15,2) NOT NULL,
  `women_incentive` DECIMAL(15,2) NOT NULL,
  `remark` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`emp_task_allocation` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `task_id` INT(11) NOT NULL,
  `cancel_description` VARCHAR(255) NULL DEFAULT NULL,
  `task_status` INT(11) NOT NULL,
  `status` INT(11) NOT NULL DEFAULT '0',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`emp_task_allocation_details` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` INT(11) NOT NULL,
  `emp_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `status` INT(11) NOT NULL DEFAULT '0',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`employee_backup_records` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_auto_id` INT(11) NULL DEFAULT NULL,
  `emp_id` INT(11) NULL DEFAULT NULL,
  `emp_fp_id` INT(11) NULL DEFAULT NULL,
  `emp_etfno` VARCHAR(45) NULL DEFAULT NULL,
  `service_no` VARCHAR(45) NULL DEFAULT NULL,
  `emp_name_with_initial` VARCHAR(100) NULL DEFAULT NULL,
  `calling_name` VARCHAR(45) NULL DEFAULT NULL,
  `emp_status` VARCHAR(45) NULL DEFAULT NULL,
  `emp_birthday` DATE NULL DEFAULT NULL,
  `emp_nationality` VARCHAR(45) NULL DEFAULT NULL,
  `emp_join_date` DATE NULL DEFAULT NULL,
  `emp_permanent_date` VARCHAR(45) NULL DEFAULT NULL,
  `emp_assign_date` VARCHAR(45) NULL DEFAULT NULL,
  `emp_address` VARCHAR(200) NULL DEFAULT NULL,
  `emp_department` INT(11) NULL DEFAULT NULL,
  `no_of_casual_leaves` DOUBLE NULL DEFAULT NULL,
  `no_of_annual_leaves` DOUBLE NULL DEFAULT NULL,
  `emp_email` VARCHAR(45) NULL DEFAULT NULL,
  `emp_location` INT(11) NULL DEFAULT NULL,
  `emp_shift` INT(11) NULL DEFAULT NULL,
  `emp_job_code` INT(11) NULL DEFAULT NULL,
  `emp_company` INT(11) NULL DEFAULT NULL,
  `job_category_id` INT(11) NULL DEFAULT NULL,
  `work_category_id` INT(11) NULL DEFAULT NULL,
  `leave_approve_person` INT(11) NULL DEFAULT NULL,
  `outstation_payment` INT(11) NULL DEFAULT NULL,
  `hierarchy_id` INT(11) NULL DEFAULT NULL,
  `financial_id` INT(11) NULL DEFAULT NULL,
  `payroll_process_type_id` INT(11) NULL DEFAULT NULL,
  `payroll_act_id` INT(11) NULL DEFAULT NULL,
  `employee_bank_id` INT(11) NULL DEFAULT NULL,
  `employee_executive_level` VARCHAR(45) NULL DEFAULT NULL,
  `basic_salary` DOUBLE NULL DEFAULT NULL,
  `day_salary` DOUBLE NULL DEFAULT NULL,
  `epfetf_contribution` VARCHAR(10) NULL DEFAULT NULL,
  `employee_payday_id` INT(11) NULL DEFAULT NULL,
  `bank_code` VARCHAR(45) NULL DEFAULT NULL,
  `branch_code` VARCHAR(45) NULL DEFAULT NULL,
  `bank_ac_no` VARCHAR(45) NULL DEFAULT NULL,
  `device_type` VARCHAR(45) NULL DEFAULT NULL,
  `model_number` VARCHAR(45) NULL DEFAULT NULL,
  `serial_number` VARCHAR(45) NULL DEFAULT NULL,
  `other_ref_number` VARCHAR(45) NULL DEFAULT NULL,
  `assigned_date` DATE NULL DEFAULT NULL,
  `returned_date` DATE NULL DEFAULT NULL,
  `created_by` VARCHAR(45) NOT NULL,
  `updated_by` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

ALTER TABLE `erav_madawalafarm`.`employee_banks` 
ADD COLUMN `status` INT(11) NULL DEFAULT '1' AFTER `bank_ac_no`;

ALTER TABLE `erav_madawalafarm`.`employee_loan_installments` 
ADD COLUMN `collect_opt` TINYINT(4) NOT NULL DEFAULT '1' COMMENT 'values must be limited to 1-Salary, 2-Prepaid' AFTER `installment_value`,
ADD COLUMN `collect_remarks` VARCHAR(250) NULL DEFAULT NULL AFTER `collect_opt`;

ALTER TABLE `erav_madawalafarm`.`employee_paid_rates` 
ADD COLUMN `emp_late_hours` DOUBLE NOT NULL DEFAULT '0' AFTER `work_days_exclusions`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`employee_paydays` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `payday_name` VARCHAR(30) NOT NULL,
  `payroll_process_type_id` INT(11) NOT NULL DEFAULT '0',
  `payday_cancel` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;

ALTER TABLE `erav_madawalafarm`.`employee_payslips` 
ADD COLUMN `paye_model` TINYINT(4) NOT NULL DEFAULT '1' AFTER `day_salary`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`employee_production` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` INT(11) NOT NULL,
  `emp_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `machine_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `Produce_qty` DOUBLE NULL DEFAULT NULL,
  `unit_price` DOUBLE NULL DEFAULT NULL,
  `amount` DOUBLE NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT NULL,
  `status` INT(11) NOT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`employee_roster_approve` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `month` DATE NOT NULL,
  `shift_id` INT(11) NOT NULL,
  `max_work_days` DOUBLE NOT NULL,
  `count` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`employee_roster_details` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `shift_id` BIGINT(20) UNSIGNED NOT NULL,
  `emp_id` BIGINT(20) UNSIGNED NOT NULL,
  `work_date` DATE NOT NULL,
  `scheduling_status` VARCHAR(50) COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `remark` TEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4160
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`employee_salary_particular_details` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `employee_payslip_id` INT(11) NOT NULL,
  `remuneration_id` INT(11) NOT NULL,
  `eligible_amount` DOUBLE NOT NULL,
  `particular_fig_group_title` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

ALTER TABLE `erav_madawalafarm`.`employee_salary_payments` 
ADD COLUMN `payment_period_salary_year` INT(11) NOT NULL DEFAULT '0' AFTER `payment_period_id`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`employee_task` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `task_allocation_id` INT(11) NOT NULL,
  `emp_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `task_id` INT(11) NOT NULL,
  `amount` DOUBLE NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT NULL,
  `status` INT(11) NOT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`employee_term_payment_extras` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `employee_term_payment_id` INT(11) NOT NULL,
  `remuneration_extra_id` INT(11) NOT NULL,
  `payroll_profile_extra_id` INT(11) NOT NULL,
  `payment_period_id` INT(11) NOT NULL,
  `employee_work_rate_id` INT(11) NOT NULL COMMENT 'keep-last-payslip-id-instead',
  `term_extra_entitle_amount` DOUBLE NOT NULL,
  `employee_term_payment_extra_cancel` TINYINT(4) NOT NULL DEFAULT '0',
  `created_by` INT(11) NOT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `employee_term_payment_id` (`employee_term_payment_id` ASC, `remuneration_extra_id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

ALTER TABLE `erav_madawalafarm`.`employee_work_rates` 
ADD COLUMN `emp_late_hours` DOUBLE NOT NULL DEFAULT '0' COMMENT 'employee-monthly-late-hours-for-next-month-advance-deduction' AFTER `nopay_days`;

ALTER TABLE `erav_madawalafarm`.`employees` 
ADD COLUMN `outstation_payment` INT(11) NULL DEFAULT NULL AFTER `leave_approve_person`,
ADD COLUMN `hierarchy_id` INT(11) NULL DEFAULT NULL AFTER `outstation_payment`,
ADD COLUMN `financial_id` INT(11) NULL DEFAULT NULL AFTER `hierarchy_id`;

ALTER TABLE `erav_madawalafarm`.`employeeshiftdetails` 
DROP COLUMN `date_to`,
ADD COLUMN `until_time` DATETIME NULL AFTER `date_from`,
ADD COLUMN `off_next_day` INT(11) NULL DEFAULT '0' COMMENT '1=Yes, 0=No' AFTER `until_time`;

ALTER TABLE `erav_madawalafarm`.`employeeshifts` 
ADD COLUMN `remark` VARCHAR(255) NULL DEFAULT NULL AFTER `date_to`,
ADD COLUMN `approval_status` INT(11) NULL DEFAULT '0' AFTER `status`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`financial_categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(45) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`hrm_general_settings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `key_id` INT(11) NOT NULL,
  `config_value` INT(11) NOT NULL,
  `company_id` INT(11) NOT NULL,
  `branch_id` INT(11) NULL DEFAULT NULL,
  `status` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`hrm_general_settings_key_list` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `config_key` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`issued_letters` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `letter_type_id` INT(11) NULL DEFAULT NULL,
  `template_id` VARCHAR(45) NULL DEFAULT NULL,
  `employee_id` INT(11) NULL DEFAULT NULL,
  `content` LONGTEXT NULL DEFAULT NULL,
  `issued_date` DATE NULL DEFAULT NULL,
  `issued_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;

ALTER TABLE `erav_madawalafarm`.`job_attendance` 
ADD COLUMN `reason` VARCHAR(255) NULL DEFAULT NULL AFTER `off_time`,
ADD COLUMN `location_status` INT(11) NOT NULL AFTER `status`,
ADD COLUMN `approve_status` INT(11) NOT NULL AFTER `location_status`;

ALTER TABLE `erav_madawalafarm`.`job_categories` 
ADD COLUMN `flex_ot` INT(11) NOT NULL COMMENT '1 = Yes, 0 = No ' AFTER `ot_round_time`,
ADD COLUMN `late_deduction_type` VARCHAR(100) NULL DEFAULT '0' AFTER `flex_ot`,
ADD COLUMN `basic_ot_type` INT(11) NULL DEFAULT '1' COMMENT '1=Basic salary, 2=custom' AFTER `late_deduction_type`,
ADD COLUMN `custom_normal_ot_rate` DOUBLE NULL DEFAULT NULL AFTER `basic_ot_type`,
ADD COLUMN `custom_double_ot_rate` DOUBLE NULL DEFAULT NULL AFTER `custom_normal_ot_rate`,
ADD COLUMN `salary_advance_type` INT(11) NULL DEFAULT NULL COMMENT '1=percentage, 2=fixed amount' AFTER `custom_double_ot_rate`,
ADD COLUMN `salary_advance_value` DOUBLE NULL DEFAULT NULL AFTER `salary_advance_type`,
ADD COLUMN `salary_advance_min_date` DOUBLE NULL DEFAULT NULL AFTER `salary_advance_value`,
ADD COLUMN `late_deduct_calculation` INT(11) NULL DEFAULT '1' COMMENT '1=nopay, 2=normalOT, 3=doubleOT' AFTER `salary_advance_min_date`,
ADD COLUMN `full_day_work_hours` DOUBLE NULL DEFAULT NULL AFTER `late_deduct_calculation`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`job_category_leaves` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `job_id` INT(11) NOT NULL,
  `leave_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 33
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`job_confirmation_letter` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `company_id` INT(11) NOT NULL,
  `department_id` INT(11) NOT NULL,
  `employee_id` INT(11) NOT NULL,
  `jobtitle` INT(11) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `confirmation_date` DATE NOT NULL,
  `comment` VARCHAR(255) NULL DEFAULT NULL,
  `status` INT(11) NOT NULL DEFAULT '0',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_customer` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `contact_number` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `remarks` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_inquiries` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_id` INT(11) NOT NULL,
  `date` DATE NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT '0',
  `remarks` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_inquiry_details` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `inquiry_id` VARCHAR(45) NOT NULL,
  `inquiry` VARCHAR(45) NOT NULL,
  `quotation` DOUBLE NULL DEFAULT NULL,
  `approve_status` INT(11) NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_job_details` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `job_id` INT(11) NOT NULL,
  `emp_id` INT(11) NULL DEFAULT NULL,
  `job_title` VARCHAR(45) NULL DEFAULT NULL,
  `machine_id` INT(11) NULL DEFAULT NULL,
  `approve_status` INT(11) NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_job_inquiry` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `customer_id` INT(11) NOT NULL,
  `inquiry_id` INT(11) NOT NULL,
  `start_from` DATETIME NULL DEFAULT NULL,
  `end_at` DATETIME NULL DEFAULT NULL,
  `reading_hours` DOUBLE NULL DEFAULT NULL,
  `job_description` VARCHAR(45) NULL DEFAULT NULL,
  `remarks` VARCHAR(45) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_machine_helpers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `machine_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_machine_operators` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `machine_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_machines` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `machine_name` VARCHAR(45) NOT NULL,
  `machine_type` VARCHAR(45) NULL DEFAULT NULL,
  `helper_rate` DOUBLE NULL DEFAULT NULL,
  `operator_rate` DOUBLE NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT '0',
  `date` DATE NULL DEFAULT NULL,
  `remarks` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`kt_special_rate` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `job_title` INT(11) NULL DEFAULT NULL,
  `machine_id` INT(11) NULL DEFAULT NULL,
  `emp_id` INT(11) NULL DEFAULT NULL,
  `rate` DOUBLE NULL DEFAULT NULL,
  `remarks` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`late_deduction_amounts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `type` INT(11) NULL DEFAULT NULL,
  `minites` INT(11) NULL DEFAULT NULL,
  `amount` DOUBLE NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

ALTER TABLE `erav_madawalafarm`.`late_types` 
ADD COLUMN `late_early` INT(11) NOT NULL COMMENT '0 = Late, 1 = Early' AFTER `name`;

ALTER TABLE `erav_madawalafarm`.`leave_request` 
ADD COLUMN `leave_type` INT(11) NULL DEFAULT NULL AFTER `reason`,
ADD COLUMN `from_time` TIME NULL DEFAULT NULL AFTER `leave_type`,
ADD COLUMN `to_time` TIME NULL DEFAULT NULL AFTER `from_time`;

ALTER TABLE `erav_madawalafarm`.`leaves` 
ADD COLUMN `approve_01` INT(11) NULL DEFAULT '0' AFTER `request_id`,
ADD COLUMN `approve_01_time` DATETIME NULL DEFAULT NULL AFTER `approve_01`,
ADD COLUMN `approve_01_by` INT(11) NULL DEFAULT NULL AFTER `approve_01_time`,
ADD COLUMN `approve_02` INT(11) NULL DEFAULT '0' AFTER `approve_01_by`,
ADD COLUMN `approve_02_time` DATETIME NULL DEFAULT NULL AFTER `approve_02`,
ADD COLUMN `approve_02_by` INT(11) NULL DEFAULT NULL AFTER `approve_02_time`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`letter_templates` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `letter_type_id` INT(11) NULL DEFAULT NULL,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `content` LONGTEXT NULL DEFAULT NULL,
  `is_active` INT(11) NULL DEFAULT '1',
  `created_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`letter_types` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `letter_type` VARCHAR(45) NULL DEFAULT NULL,
  `remarks` VARCHAR(45) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT '1',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`location _visit_allowances` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `employee_id` INT(11) NOT NULL,
  `from_date` DATE NOT NULL,
  `to_date` DATE NOT NULL,
  `visit_count` INT(11) NOT NULL,
  `amount` DOUBLE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`location_ot_hours` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `location_id` INT(11) NOT NULL,
  `job_id` INT(11) NOT NULL,
  `max_ot_hours` DOUBLE NOT NULL,
  `working_days` DOUBLE NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

ALTER TABLE `erav_madawalafarm`.`machines` 
ADD COLUMN `company_id` INT(11) NOT NULL AFTER `id`,
ADD COLUMN `branch_id` INT(11) NOT NULL AFTER `company_id`,
ADD COLUMN `full_complete` DOUBLE NOT NULL AFTER `description`,
ADD COLUMN `semi_complete` DOUBLE NOT NULL AFTER `full_complete`,
ADD COLUMN `target_count` DOUBLE NULL DEFAULT '0' AFTER `semi_complete`,
ADD COLUMN `status` INT(11) NULL DEFAULT '0' AFTER `target_count`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`meter_reading` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `department_id` INT(11) NOT NULL,
  `reading_limit` DOUBLE NULL DEFAULT '0',
  `multiple_value` DOUBLE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`meter_reading_count` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `count` DOUBLE NOT NULL,
  `status` INT(11) NOT NULL DEFAULT '0',
  `approve_status` INT(11) NULL DEFAULT '0',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`nda_letter` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `company_id` INT(11) NOT NULL,
  `department_id` INT(11) NOT NULL,
  `employee_id` INT(11) NOT NULL,
  `effect_date` DATE NOT NULL,
  `status` INT(11) NOT NULL DEFAULT '0',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_daily_production_summary` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `target` DOUBLE NULL DEFAULT NULL,
  `produce` DOUBLE NULL DEFAULT NULL,
  `difference` DOUBLE NULL DEFAULT NULL,
  `bonus` DOUBLE NULL DEFAULT NULL,
  `damage` DOUBLE NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 211
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_emp_product_allocation` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `machine_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `shift_id` INT(11) NULL DEFAULT NULL,
  `target` DOUBLE NULL DEFAULT NULL,
  `scale` VARCHAR(255) NULL DEFAULT NULL,
  `size` INT(11) NULL DEFAULT NULL,
  `remark` VARCHAR(255) NULL DEFAULT NULL,
  `product_type` VARCHAR(255) NULL DEFAULT NULL,
  `semi_amount` DOUBLE NULL DEFAULT NULL,
  `full_amount` DOUBLE NULL DEFAULT NULL,
  `cancel_description` VARCHAR(255) NULL DEFAULT NULL,
  `production_status` INT(11) NOT NULL,
  `status` INT(11) NOT NULL DEFAULT '0',
  `complete_status` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 689
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_emp_product_allocation_details` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` INT(11) NOT NULL,
  `emp_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `status` INT(11) NOT NULL DEFAULT '0',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1020
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_employee_production` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` INT(11) NOT NULL,
  `emp_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `machine_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `target` DOUBLE NULL DEFAULT NULL,
  `Produce_qty` DOUBLE NULL DEFAULT NULL,
  `difference` DOUBLE NULL DEFAULT NULL,
  `precentage` DOUBLE NULL DEFAULT NULL,
  `amount` DOUBLE NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT NULL,
  `damage_precentage` VARCHAR(100) NULL DEFAULT NULL,
  `damage_qty` DOUBLE NULL DEFAULT NULL,
  `perfomance` DOUBLE NULL DEFAULT NULL,
  `status` INT(11) NOT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 919
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_machine_downtime` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `type_id` INT(11) NOT NULL,
  `machine_id` INT(11) NOT NULL,
  `fromtime` DATETIME NULL DEFAULT NULL,
  `totime` DATETIME NULL DEFAULT NULL,
  `status` INT(11) NOT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_machine_employees` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `opma_machine_id` INT(11) NOT NULL,
  `emp_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 199
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_machines` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `company_id` INT(11) NOT NULL,
  `branch_id` INT(11) NOT NULL,
  `machine` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_performance_amount` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `amount` DOUBLE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_production_amount` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `department_id` INT(11) NOT NULL,
  `jobtitle` INT(11) NULL DEFAULT NULL,
  `end_precentage` DOUBLE NOT NULL,
  `amount` DOUBLE NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_production_emp_attendance` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `production_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `start_timestmp` DATETIME NOT NULL,
  `finish_timestamp` DATETIME NULL DEFAULT NULL,
  `status` INT(11) NOT NULL,
  `created_by` INT(11) NOT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1044
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_production_status_records` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `production_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `employee_count` INT(11) NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `produced_quntity` DOUBLE NOT NULL,
  `production_status` INT(11) NOT NULL,
  `created_by` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1414
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_sizes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `size` VARCHAR(45) NOT NULL,
  `remark` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 98
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_style_sizes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `opma_style_id` INT(11) NOT NULL,
  `opma_size_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 267
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_styles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `code` DOUBLE NULL DEFAULT '0',
  `from_date` DATE NOT NULL,
  `to_date` DATE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 77
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`opma_timechanging_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;

ALTER TABLE `erav_madawalafarm`.`ot_approved` 
ADD COLUMN `status` INT(11) NULL DEFAULT NULL AFTER `is_holiday`;

ALTER TABLE `erav_madawalafarm`.`payment_periods` 
ADD COLUMN `advance_payment_date` DATE NULL DEFAULT NULL AFTER `payment_period_to`,
ADD COLUMN `work_period_total_days` DOUBLE NOT NULL DEFAULT '0' AFTER `advance_payment_date`,
ADD COLUMN `work_period_total_hours` DOUBLE NOT NULL DEFAULT '0' AFTER `work_period_total_days`,
ADD COLUMN `employee_payday_id` INT(11) NOT NULL DEFAULT '0' AFTER `work_period_total_hours`,
ADD COLUMN `salary_year` INT(11) NOT NULL DEFAULT '0' COMMENT 'specify salary year for PAYE' AFTER `employee_payday_id`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`payroll_profile_extras` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `payroll_profile_id` INT(11) NOT NULL,
  `remuneration_id` INT(11) NOT NULL,
  `remuneration_extra_id` INT(11) NOT NULL,
  `extra_entitle_amount` DOUBLE NOT NULL,
  `payroll_profile_extra_signout` TINYINT(4) NOT NULL DEFAULT '0',
  `created_by` INT(11) NOT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

ALTER TABLE `erav_madawalafarm`.`payroll_profiles` 
ADD COLUMN `employee_payday_id` INT(11) NOT NULL DEFAULT '0' COMMENT '0-Genaral' AFTER `epfetf_contribution`,
ADD COLUMN `paye_model` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '0/PAYE free, 1/PAYE monthly, 2/PAYE annually' AFTER `employee_payday_id`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`product_machines` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `product_id` INT(11) NOT NULL,
  `machine_id` INT(11) NOT NULL,
  `semi_price` DOUBLE NULL DEFAULT '0',
  `full_price` DOUBLE NULL DEFAULT '0',
  `status` INT(11) NOT NULL DEFAULT '0',
  `create_by` INT(11) NULL DEFAULT NULL,
  `update_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`production_emp_attendance` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `production_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `start_timestmp` DATETIME NOT NULL,
  `finish_timestamp` DATETIME NULL DEFAULT NULL,
  `status` INT(11) NOT NULL,
  `created_by` INT(11) NOT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`production_status_records` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `production_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `employee_count` INT(11) NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `produced_quntity` DOUBLE NOT NULL,
  `production_status` INT(11) NOT NULL,
  `created_by` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`remuneration_extras` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `remuneration_id` INT(11) NOT NULL,
  `extras_label` VARCHAR(30) NOT NULL,
  `value_group` TINYINT(4) NOT NULL DEFAULT '1',
  `extra_entitlement` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '0-not-visible-on-employee-profile-setup',
  `remuneration_extra_cancel` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = latin1;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`roster_shift_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `work_date` DATE NULL DEFAULT NULL,
  `old_shift_id` INT(11) NULL DEFAULT NULL,
  `new_shift_id` INT(11) NULL DEFAULT NULL,
  `changed_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4416
DEFAULT CHARACTER SET = latin1;

ALTER TABLE `erav_madawalafarm`.`salary_adjustments` 
ADD COLUMN `adjustment_type` INT(11) NOT NULL DEFAULT '0' COMMENT '1=emp, 2=job category' AFTER `remuneration_id`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`salary_advances` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `emp_id` INT(11) NOT NULL,
  `date` DATE NOT NULL,
  `request_amount` DOUBLE NOT NULL,
  `paid_amount` DOUBLE NULL DEFAULT NULL,
  `remark` VARCHAR(45) NULL DEFAULT NULL,
  `status` INT(11) NOT NULL DEFAULT '0',
  `paid_status` INT(11) NULL DEFAULT '0',
  `approve_status` INT(11) NULL DEFAULT '0',
  `approve_by` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

ALTER TABLE `erav_madawalafarm`.`shift_types` 
CHANGE COLUMN `ending_checkin` `ending_checkin` VARCHAR(255) NULL DEFAULT NULL ,
CHANGE COLUMN `ending_checkout` `ending_checkout` VARCHAR(255) NULL DEFAULT NULL ,
CHANGE COLUMN `color` `color` VARCHAR(255) NULL DEFAULT NULL ,
ADD COLUMN `shift_code` VARCHAR(20) NOT NULL AFTER `id`,
ADD COLUMN `on_next_day` INT(11) NOT NULL AFTER `off_next_day`,
ADD COLUMN `max_normal_ot_hrs` DOUBLE NULL DEFAULT NULL AFTER `on_next_day`,
ADD COLUMN `max_double_ot_hrs` DOUBLE NULL DEFAULT NULL AFTER `max_normal_ot_hrs`,
ADD COLUMN `weekend_max_normal_ot_hrs` DOUBLE NULL DEFAULT NULL AFTER `max_double_ot_hrs`,
ADD COLUMN `weekend_max_double_ot_hrs` DOUBLE NULL DEFAULT NULL AFTER `weekend_max_normal_ot_hrs`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`task` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `taskname` VARCHAR(45) NOT NULL,
  `description` VARCHAR(45) NULL DEFAULT NULL,
  `hourly_rate` DOUBLE NULL DEFAULT '0',
  `daily_rate` DOUBLE NULL DEFAULT '0',
  `status` INT(11) NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4;

ALTER TABLE `erav_madawalafarm`.`tax_provisions` 
ADD COLUMN `paye_model` TINYINT(4) NOT NULL DEFAULT '1' COMMENT '1/monthly, 2/annually' AFTER `tax_rate`;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`training_allocations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `training_name` VARCHAR(45) NULL DEFAULT NULL,
  `date` DATE NULL DEFAULT NULL,
  `venue` VARCHAR(45) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT '0',
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`training_defect_points` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` INT(11) NULL DEFAULT NULL,
  `session_id` INT(11) NULL DEFAULT NULL,
  `type_id` INT(11) NULL DEFAULT NULL,
  `emp_id` INT(11) NULL DEFAULT NULL,
  `points` DOUBLE NULL DEFAULT NULL,
  `is_attend` INT(11) NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`training_emp_allocations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` INT(11) NOT NULL,
  `emp_id` INT(11) NOT NULL,
  `status` INT(11) NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`training_sessions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` INT(11) NULL DEFAULT NULL,
  `session_name` VARCHAR(45) NULL DEFAULT NULL,
  `start_time` DATETIME NULL DEFAULT NULL,
  `end_time` DATETIME NULL DEFAULT NULL,
  `trainer_id` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`training_types` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `purpose` VARCHAR(45) NULL DEFAULT NULL,
  `status` INT(11) NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`training_types_map` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `allocation_id` INT(11) NULL DEFAULT NULL,
  `type_id` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`user_has_companies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `company_id` INT(11) NOT NULL,
  `branch_id` INT(11) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`user_has_pay_groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `group_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE TABLE IF NOT EXISTS `erav_madawalafarm`.`user_session_tokens` (
  `token` VARCHAR(64) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` DATETIME NOT NULL,
  PRIMARY KEY (`token`),
  INDEX `idx_expires` (`expires_at` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

ALTER TABLE `erav_madawalafarm`.`work_hours` 
CHANGE COLUMN `comment` `comment` TEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

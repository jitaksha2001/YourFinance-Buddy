-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 24, 2022 at 12:32 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpsc471`
--

-- --------------------------------------------------------


DROP TABLE IF EXISTS GOAL;
DROP TABLE IF EXISTS HAS;
DROP TABLE IF EXISTS ACCESS;
DROP TABLE IF EXISTS EXPENSE_TRANSACTION;
DROP TABLE IF EXISTS INCOME_TRANSACTION;
DROP TABLE IF EXISTS TAX_DOCUMENT;
DROP TABLE IF EXISTS RECEIPT_DOCUMENT;
DROP TABLE IF EXISTS REPORT;
DROP TABLE IF EXISTS REMINDER;
DROP TABLE IF EXISTS BUDGET;
DROP TABLE IF EXISTS HELP_RESOURCE;
DROP TABLE IF EXISTS CATEGORY;
DROP TABLE IF EXISTS MONITOR;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS ADMIN;


CREATE TABLE USER (
    UserID INT NOT NULL AUTO_INCREMENT,
    User_Name CHAR(15) NOT NULL,
    User_Email CHAR(255),
    User_Password CHAR(20) NOT NULL,
    Balance DEC(14,2) DEFAULT 0,
    PRIMARY KEY (UserID)
);


CREATE TABLE REPORT (
    ReportID INT NOT NULL AUTO_INCREMENT,
    UserID INT NOT NULL,
    FilePath CHAR(255) NOT NULL,
    PRIMARY KEY (ReportID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE
);


CREATE TABLE ADMIN (
    AdminID INT NOT NULL AUTO_INCREMENT,
    Admin_Name CHAR(15) NOT NULL,
    Admin_Password CHAR(20) NOT NULL,
    PRIMARY KEY (AdminID)
);


CREATE TABLE REMINDER (
    ReminderID INT NOT NULL AUTO_INCREMENT,
    Reminder_Name CHAR(20) NOT NULL,
    Reminder_Date DATE NOT NULL,
    UserID INT NOT NULL,
    PRIMARY KEY (ReminderID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE
);


CREATE TABLE BUDGET (
    BudgetID INT NOT NULL AUTO_INCREMENT,
    Budget_Name CHAR(20) NOT NULL,
    Budget_Amount DEC(14,2) DEFAULT 0,    -- The amount that the budget aims to have at the begining of the month
    Budget_CurrentAmount DEC(14,2) DEFAULT 0, -- The current amount in this budget object
    UserID INT NOT NULL,
    PRIMARY KEY (BudgetID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE
);


CREATE TABLE HELP_RESOURCE (
    ResourceID INT NOT NULL AUTO_INCREMENT,
    Name CHAR(255) NOT NULL,
    Description CHAR(255) NOT NULL,
    Link CHAR(255) NOT NULL,
    PRIMARY KEY (ResourceID)
);


CREATE TABLE GOAL (
    GoalID INT NOT NULL AUTO_INCREMENT,
    Goal_Name CHAR(20) NOT NULL,
    Amount_Collected DEC(14,2) DEFAULT 0,
    Target_Amount DEC(14,2) NOT NULL,
    Percentage INT DEFAULT 0 NOT NULL,
    UserID INT NOT NULL,
    PRIMARY KEY (GoalID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE
);


CREATE TABLE CATEGORY (
    CategoryID INT NOT NULL AUTO_INCREMENT,
    Name CHAR(20) NOT NULL,
    PRIMARY KEY (CategoryID)
);


CREATE TABLE EXPENSE_TRANSACTION (
    TransactionID INT NOT NULL AUTO_INCREMENT,
    Date DATE NOT NULL,
    Amount DEC(14,2) NOT NULL,
    Recipient CHAR(255),
    UserID INT NOT NULL,
    PRIMARY KEY (TransactionID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE
);


CREATE TABLE INCOME_TRANSACTION (
    TransactionID INT NOT NULL AUTO_INCREMENT,
    Date DATE,
    Amount DEC(14,2) NOT NULL,
    Source CHAR(255),
    UserID INT NOT NULL,
    PRIMARY KEY (TransactionID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE
);


CREATE TABLE TAX_DOCUMENT (
    DocumentID INT NOT NULL AUTO_INCREMENT,
    Date DATE,
    Tax_Type CHAR(20),
    UserID INT NOT NULL,
    FilePath CHAR(255) NOT NULL,
    PRIMARY KEY (DocumentID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE
);


CREATE TABLE RECEIPT_DOCUMENT (
    DocumentID INT NOT NULL AUTO_INCREMENT,
    Date DATE,
    Receipt_Type CHAR(20),
    UserID INT NOT NULL,
    FilePath CHAR(255) NOT NULL,
    PRIMARY KEY (DocumentID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE
);


CREATE TABLE ACCESS (
    UserID INT NOT NULL,
    ResourceID INT NOT NULL,
    PRIMARY KEY(UserID, ResourceID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE,
    FOREIGN KEY (ResourceID) REFERENCES HELP_RESOURCE(ResourceID) ON DELETE CASCADE
);


CREATE TABLE HAS (
    CategoryID INT NOT NULL,
    TransactionID INT NOT NULL,
    PRIMARY KEY (CategoryID, TransactionID),
    FOREIGN KEY (CategoryID) REFERENCES CATEGORY(CategoryID) ON DELETE CASCADE,
    FOREIGN KEY (TransactionID) REFERENCES EXPENSE_TRANSACTION(TransactionID) ON DELETE CASCADE
);


CREATE TABLE MONITOR (
    UserID INT NOT NULL,
    AdminID INT NOT NULL,
    PRIMARY KEY (UserID, AdminID),
    FOREIGN KEY (UserID) REFERENCES USER(UserID) ON DELETE CASCADE,
    FOREIGN KEY (AdminID) REFERENCES ADMIN(AdminID) ON DELETE CASCADE
);


-- CREATE DUMMY DATA
INSERT INTO CATEGORY (Name) VALUES ("Food");
INSERT INTO CATEGORY (Name) VALUES ("Entertainment");
INSERT INTO CATEGORY (Name) VALUES ("Studies");
INSERT INTO CATEGORY (Name) VALUES ("Others");

-- Auto-Increment starts at 1. So Bob has a UserID of 1 and Alice has a UserID of 2
INSERT INTO USER (User_Name, User_Email, User_Password, Balance) VALUES ("Bob", "Bobby@gmail.com",  "12345", 250.00);
INSERT INTO USER (User_Name, User_Email, User_Password, Balance) VALUES ("Alice", "Alice@outlook.ca", "54321", 1250.00);

INSERT INTO ADMIN (Admin_Name, Admin_Password) VALUES ("Jessica", "12345678");
INSERT INTO ADMIN (Admin_Name, Admin_Password) VALUES ("Jitaksha", "12345678");
INSERT INTO ADMIN (Admin_Name, Admin_Password) VALUES ("Samuel", "12345678");

-- Transactions: Income
INSERT INTO INCOME_TRANSACTION (DATE, Amount, Source, UserID) VALUES (Date "2019-02-23", 100.00, "Job", 1);
INSERT INTO INCOME_TRANSACTION (DATE, Amount, Source, UserID) VALUES (Date "2019-02-23", 400.00, "Loans", 1);

INSERT INTO INCOME_TRANSACTION (DATE, Amount, Source, UserID) VALUES (Date "2019-02-24", 1000.00, "Scholarship", 2);
INSERT INTO INCOME_TRANSACTION (DATE, Amount, Source, UserID) VALUES (Date "2019-02-26", 250.00, "Job", 2);
INSERT INTO INCOME_TRANSACTION (DATE, Amount, Source, UserID) VALUES (Date "2019-03-03", 500.00, "Investment", 2);

-- Transactions: Expense 
INSERT INTO EXPENSE_TRANSACTION (DATE, Amount, Recipient, UserID) VALUES (Date "2019-04-21", 250.00, "Dental", 1);
INSERT INTO EXPENSE_TRANSACTION (DATE, Amount, Recipient, UserID) VALUES (Date "2019-04-21", 500.00, "Rent", 2);

-- Has: Category
INSERT INTO HAS (CategoryID, TransactionID) VALUES (4,1);
INSERT INTO HAS (CategoryID, TransactionID) VALUES (4,2);

-- Budgets
INSERT INTO BUDGET (Budget_Name, Budget_Amount, Budget_CurrentAmount, UserID) VALUES ("Food", 200, 25, 1);
INSERT INTO BUDGET (Budget_Name, Budget_Amount, Budget_CurrentAmount, UserID) VALUES ("Entertainment", 200, 150, 1);
INSERT INTO BUDGET (Budget_Name, Budget_Amount, Budget_CurrentAmount, UserID) VALUES ("Cat", 1000, 455, 1);

INSERT INTO BUDGET (Budget_Name, Budget_Amount, Budget_CurrentAmount, UserID) VALUES ("Food", 250, 15, 2);
INSERT INTO BUDGET (Budget_Name, Budget_Amount, Budget_CurrentAmount, UserID) VALUES ("Entertainment", 500, 225, 2);

-- Goals
INSERT INTO GOAL (Goal_Name, Amount_Collected, Target_Amount, Percentage, UserID) VALUES ("PS5", 150, 1000, 10, 1);
INSERT INTO GOAL (Goal_Name, Amount_Collected, Target_Amount, Percentage, UserID) VALUES ("Subaru BRZ", 5, 30000, 5, 1);

INSERT INTO GOAL (Goal_Name, Amount_Collected, Target_Amount, Percentage, UserID) VALUES ("PC", 550, 2500, 10, 2);

-- Reminders
INSERT INTO REMINDER (Reminder_Name, Reminder_Date, UserID) VALUES ("Credit Card", '2020-01-01', 1);
INSERT INTO REMINDER (Reminder_Name, Reminder_Date, UserID) VALUES ("Loans", '2025-01-01', 2);

-- Resource Links
INSERT INTO HELP_RESOURCE (Name, Description, Link) VALUES ("Emergency Financial Assistance", "Financial assistance for unexpected emergencies is available through the Emergency Needs Allowance", "https://www.alberta.ca/emergency-financial-assistance.aspx");
INSERT INTO HELP_RESOURCE (Name, Description, Link) VALUES ("Money and Finances", "Managing your money, debt and investments, planning for retirement and protecting yourself from consumer fraud", "https://www.canada.ca/en/services/finance.html");
INSERT INTO HELP_RESOURCE (Name, Description, Link) VALUES ("The Ultimate Guide to Financial Literacy", "Learn the skills you need for a more financially secure life", "https://www.investopedia.com/guide-to-financial-literacy-4800530");
INSERT INTO HELP_RESOURCE (Name, Description, Link) VALUES ("Life Skills: Personal Finance", "Making financial decisions can be intimidating, especially if you're just starting. Khan Academy lessons can help you make the financial choices that work best for you", "https://www.khanacademy.org/college-careers-more/personal-finance");

INSERT INTO REPORT (UserID, FilePath) VALUES (1, "C:/AppServ/www/CPSC-471/reports/report1.txt");
INSERT INTO REPORT (UserID, FilePath) VALUES (1, "C:/AppServ/www/CPSC-471/reports/report2.txt");

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

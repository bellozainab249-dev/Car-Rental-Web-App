-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2026 at 02:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lonestarrides_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `Branch_ID` int(11) NOT NULL,
  `Branch_Name` varchar(200) NOT NULL,
  `Street_Address` varchar(200) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(2) NOT NULL,
  `Zip_Code` int(11) NOT NULL,
  `Latitude` decimal(10,8) NOT NULL,
  `Longitude` decimal(11,8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`Branch_ID`, `Branch_Name`, `Street_Address`, `City`, `State`, `Zip_Code`, `Latitude`, `Longitude`) VALUES
(1, 'Houston HQ', '1000 Fondren St', 'Houston', 'TX', 77002, 29.76040000, -95.36980000),
(2, 'Dallas Hub', '1201 Main St', 'Dallas', 'TX', 75202, 32.77670000, -96.79700000);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `Reservation_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) NOT NULL,
  `Pickup_Branch_ID` int(11) NOT NULL,
  `Dropoff_Branch_ID` int(11) NOT NULL,
  `Pickup_Date` datetime NOT NULL,
  `Dropoff_Date` datetime NOT NULL,
  `Total_Cost` decimal(8,2) NOT NULL,
  `Booking_Status` enum('Active','Completed','Cancelled') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`Reservation_ID`, `User_ID`, `Vehicle_ID`, `Pickup_Branch_ID`, `Dropoff_Branch_ID`, `Pickup_Date`, `Dropoff_Date`, `Total_Cost`, `Booking_Status`) VALUES
(1, 3, 1, 1, 1, '2026-05-01 10:00:00', '2026-05-04 10:00:00', 225.00, 'Active'),
(2, 1, 1, 1, 1, '2026-04-14 00:00:00', '2026-04-07 00:00:00', 75.00, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password_Hash` varchar(255) NOT NULL,
  `Role` enum('Guest','Customer','Administrator') NOT NULL DEFAULT 'Guest',
  `Driver_License_Number` varchar(50) DEFAULT NULL,
  `Account_Created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `First_Name`, `Last_Name`, `Email`, `Password_Hash`, `Role`, `Driver_License_Number`, `Account_Created`) VALUES
(1, 'Yousef', 'Al Kurdi', 'admin@lonestarrides.com', 'testpass123', 'Administrator', NULL, '2026-04-26 23:21:09'),
(2, 'Zainab', 'Bello', 'admin2@lonestarrides.com', 'testpass123', 'Administrator', NULL, '2026-04-26 23:21:09'),
(3, 'John', 'Doe', 'John@example.com', 'testpass123', 'Customer', 'TX9876543', '2026-04-26 23:21:09');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `Vehicle_ID` int(11) NOT NULL,
  `Make` varchar(50) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `Year` year(4) NOT NULL,
  `Category` enum('SUV','Luxury','Economy','Truck') NOT NULL,
  `Fuel_Type` varchar(30) NOT NULL,
  `Daily_Rate` decimal(6,2) NOT NULL,
  `Current_Status` enum('Available','Rented','Maintenance') NOT NULL DEFAULT 'Available',
  `Current_Branch_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`Vehicle_ID`, `Make`, `Model`, `Year`, `Category`, `Fuel_Type`, `Daily_Rate`, `Current_Status`, `Current_Branch_ID`) VALUES
(1, 'Ford', 'Explorer', '2024', 'SUV', 'Gasoline', 75.00, 'Rented', 1),
(2, 'Toyota', 'Camry', '2025', 'Economy', 'Hybrid', 45.00, 'Available', 1),
(3, 'Toyota', 'Prius', '2025', 'Economy', 'Hybrid', 45.00, 'Available', 1),
(4, 'Ford', 'F-150', '2024', 'Truck', 'Gasoline', 75.00, 'Available', 1),
(5, 'BMW', '5 Series', '2023', 'Luxury', 'Premium', 120.00, 'Available', 2),
(6, 'Mercedes', 'G-Class', '2020', 'Luxury', 'Premium', 120.00, 'Available', 2),
(7, 'Kia', 'K4', '2025', 'Economy', 'Hybrid', 45.00, 'Available', 2),
(8, 'Ram', '2500', '2018', 'Truck', 'Diesel', 45.00, 'Available', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`Branch_ID`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`Reservation_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Vehicle_ID` (`Vehicle_ID`),
  ADD KEY `Pickup_Branch_ID` (`Pickup_Branch_ID`),
  ADD KEY `Dropoff_Branch_ID` (`Dropoff_Branch_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`Vehicle_ID`),
  ADD KEY `Current_Branch_ID` (`Current_Branch_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `Branch_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `Reservation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `Vehicle_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`Vehicle_ID`) REFERENCES `vehicles` (`Vehicle_ID`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`Pickup_Branch_ID`) REFERENCES `branches` (`Branch_ID`),
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`Dropoff_Branch_ID`) REFERENCES `branches` (`Branch_ID`);

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`Current_Branch_ID`) REFERENCES `branches` (`Branch_ID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

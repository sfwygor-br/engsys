-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05-Nov-2018 às 15:07
-- Versão do servidor: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `engsys`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `sequence` (`pn_table` VARCHAR(100)) RETURNS INT(11) BEGIN
	declare id int;
    
    if (pn_table = 'person') then
		select (max(idperson) + 1) into id from person;
    elseif (pn_table = 'phone') then
		select (max(idphone) + 1) into id from phone;
    elseif (pn_table = 'adress') then
		select (max(idadress) + 1) into id from adress;
    end if;
    
    return(id);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `adress`
--

CREATE TABLE `adress` (
  `idadress` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `adress` varchar(100) COLLATE utf8_bin NOT NULL,
  `number` varchar(10) COLLATE utf8_bin NOT NULL,
  `neighborhood` varchar(100) COLLATE utf8_bin NOT NULL,
  `postal_code` varchar(9) COLLATE utf8_bin NOT NULL,
  `city` varchar(100) COLLATE utf8_bin NOT NULL,
  `state` varchar(2) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `attachment`
--

CREATE TABLE `attachment` (
  `idattachment` int(11) NOT NULL,
  `idproject` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `billing`
--

CREATE TABLE `billing` (
  `idbilling` int(11) NOT NULL,
  `iduser_integ` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `id_person` int(11) NOT NULL,
  `idproject` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `processing_date` date NOT NULL,
  `maturity_date` date NOT NULL,
  `value` decimal(10,0) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `value_payed` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `budget`
--

CREATE TABLE `budget` (
  `idbudget` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `inital_date` date NOT NULL,
  `final_date` date NOT NULL,
  `area` int(11) NOT NULL,
  `expected_execution_time` int(11) NOT NULL,
  `dificulty` int(11) NOT NULL,
  `volatility` int(11) NOT NULL,
  `value` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracao`
--

CREATE TABLE `configuracao` (
  `iduser_integ` int(11) NOT NULL,
  `notification_period` int(11) NOT NULL,
  `disponibility` int(11) NOT NULL,
  `meter_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `constant`
--

CREATE TABLE `constant` (
  `iduser_integ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `event`
--

CREATE TABLE `event` (
  `idevent` int(11) NOT NULL,
  `iduser_integ` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8_bin NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `operation`
--

CREATE TABLE `operation` (
  `idoperation` int(11) NOT NULL,
  `idproject` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parameter`
--

CREATE TABLE `parameter` (
  `iduser_integ` int(11) NOT NULL,
  `engineer_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `CREA` varchar(50) COLLATE utf8_bin NOT NULL,
  `city` varchar(100) COLLATE utf8_bin NOT NULL,
  `state` varchar(2) COLLATE utf8_bin NOT NULL,
  `idphone` int(11) NOT NULL,
  `idadress` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `person`
--

CREATE TABLE `person` (
  `idperson` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `fantasy_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `type` int(11) NOT NULL,
  `document` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(200) COLLATE utf8_bin NOT NULL,
  `provider` int(11) NOT NULL,
  `insert_date` date NOT NULL,
  `iduser_integ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `person`
--

INSERT INTO `person` (`idperson`, `name`, `fantasy_name`, `type`, `document`, `email`, `provider`, `insert_date`, `iduser_integ`) VALUES
(2, 'CICLANO DE TAL', NULL, 1, '0', '0', 0, '2018-10-23', 1),
(3, 'WYGOR FELIPE SOUZA', 'WYGOR FELIPE SOUZA ', 1, '439.080.928-84', 'FELIPE@MASTERYIDEA.COM', 0, '2018-10-29', 3),
(4, 'JOÃO BESTÃO', NULL, 1, '1', 'TESTE@c.com', 0, '2018-10-30', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `phone`
--

CREATE TABLE `phone` (
  `idphone` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `ddd` varchar(3) COLLATE utf8_bin NOT NULL,
  `number` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `phone`
--

INSERT INTO `phone` (`idphone`, `idperson`, `ddd`, `number`) VALUES
(1, 3, '18', '99778-3153'),
(2, 1, '1', '1'),
(3, 1, '1', '4'),
(4, 4, '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `project`
--

CREATE TABLE `project` (
  `idproject` int(11) NOT NULL,
  `idbudget` int(11) NOT NULL,
  `expected_inital_date` date NOT NULL,
  `expected_final_date` date NOT NULL,
  `inital_date` date NOT NULL,
  `final_date` date NOT NULL,
  `area` int(11) NOT NULL,
  `value` decimal(10,0) NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `project_stage`
--

CREATE TABLE `project_stage` (
  `idproject_stage` int(11) NOT NULL,
  `idproject` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `expected_initial_date` date NOT NULL,
  `expected_final_date` date NOT NULL,
  `initial_date` date DEFAULT NULL,
  `final_date` date DEFAULT NULL,
  `status` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `idusuario` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `insert_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `iduser_integ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`idusuario`, `username`, `password`, `email`, `insert_date`, `status`, `iduser_integ`) VALUES
(1, 'teste', 'teste', '', '2018-10-23', 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adress`
--
ALTER TABLE `adress`
  ADD PRIMARY KEY (`idadress`);

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`idattachment`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`idbilling`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`idbudget`);

--
-- Indexes for table `configuracao`
--
ALTER TABLE `configuracao`
  ADD PRIMARY KEY (`iduser_integ`);

--
-- Indexes for table `constant`
--
ALTER TABLE `constant`
  ADD PRIMARY KEY (`iduser_integ`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`idevent`);

--
-- Indexes for table `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`idoperation`);

--
-- Indexes for table `parameter`
--
ALTER TABLE `parameter`
  ADD PRIMARY KEY (`iduser_integ`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`idperson`);

--
-- Indexes for table `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`idphone`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`idproject`);

--
-- Indexes for table `project_stage`
--
ALTER TABLE `project_stage`
  ADD PRIMARY KEY (`idproject_stage`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

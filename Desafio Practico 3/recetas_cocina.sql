-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2021 at 09:40 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recetas_cocina`
--

-- --------------------------------------------------------

--
-- Table structure for table `recetas`
--

CREATE TABLE `recetas` (
  `id` int(50) NOT NULL,
  `nombre` text NOT NULL,
  `tipo` text NOT NULL,
  `ingredientes` text NOT NULL,
  `preparacion` text NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recetas`
--

INSERT INTO `recetas` (`id`, `nombre`, `tipo`, `ingredientes`, `preparacion`, `imagen`) VALUES
(54, 'Pollo Asado', 'pollo asado o al horno', '1 pollo de corral (de unos 1.600 g. aproximadamente)\n1 limón\n60 ml. aceite de oliva virgen extra\n1 cucharada sopera de tomillo seco\n3 dientes de ajo\nSal y pimienta negra recién molida (al gusto de cada casa)\n4 patatas medianas', 'Lo primero que hacemos es limpiar el pollo de posibles restos de grasa y vísceras que pueda tener.\nColocamos el pollo en la bandeja de horneado y metemos las mitades de limones en su interior.\nCon el horno previamente caliente a 190º C horneamos durante 1 hora y 15 minutos.', 'imagenes/pollo-asado.jpg'),
(56, 'Sandwich Sencillo', 'Comida Rápida', '1 Paquete pan Bimbo Chico, Queso Manchego, Jamón, al gusto mayonesa, al gusto lechuga, 1 tomate, 1 cucharada de mantequilla.', 'Primero le ponemos la mayonesa al pan después la lechuga y encima el jamón y después el queso manchego y de ultimo una rebanada de tomate. Cuando ya estén los sándwich, ponemos en un comal un poco de mantequilla y cuando esté derretida calentamos los sándwiches. A comer algo ligero.', 'imagenes/pepperoni-pizza-grilled-cheese.jpg.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `created_at`) VALUES
(4, 'Luna', '$2y$10$MAx2r7KBpLf3cFEZFGOpdOyxynKqCmjxT8PkpdKNT/uvFaXto.QYS', '2021-05-02 20:32:49'),
(5, 'Abigail', '$2y$10$gDc44kjuKCeq75W1EtEckuF0JU6.NGcPZdZqiGsMHFO66VZkI0rau', '2021-05-04 21:49:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

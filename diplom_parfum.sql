-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 03 2025 г., 22:56
-- Версия сервера: 8.0.30
-- Версия PHP: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `diplom_parfum`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `amount` int UNSIGNED NOT NULL DEFAULT '0',
  `cost` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `amount`, `cost`) VALUES
(63, 18, 1, '3.00');

-- --------------------------------------------------------

--
-- Структура таблицы `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int UNSIGNED NOT NULL,
  `cart_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `amount` int UNSIGNED NOT NULL DEFAULT '0',
  `cost` decimal(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `title`) VALUES
(6, 'Цветочные'),
(7, 'Древесные'),
(8, 'Цитрусовые'),
(13, 'Фужерные'),
(15, 'Акватические'),
(16, 'Пудровые'),
(17, 'Восточные'),
(19, 'Фруктовые');

-- --------------------------------------------------------

--
-- Структура таблицы `note`
--

CREATE TABLE `note` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `note`
--

INSERT INTO `note` (`id`, `title`) VALUES
(1, 'Жасмин'),
(2, 'Яблоко'),
(7, 'Роза'),
(9, 'Ваниль'),
(10, 'Вишня'),
(11, 'Апельсин'),
(12, 'Сандал'),
(13, 'Абрикос'),
(14, 'Айва'),
(15, 'Акация'),
(16, 'Амбра'),
(17, 'Ананас'),
(18, 'Базилик'),
(19, 'Бамбук'),
(20, 'Банан'),
(21, 'Белая лилия'),
(22, 'Белая роза'),
(23, 'Белладонна'),
(24, 'Белые цветы'),
(25, 'Бергамот'),
(26, 'Бузина'),
(27, 'Вербена'),
(28, 'Вереск'),
(29, 'Взбитые сливки'),
(30, 'Виноград'),
(31, 'Воск'),
(32, 'Гвоздика'),
(33, 'Гибискус'),
(34, 'Гранат'),
(35, 'Грейпфрут'),
(36, 'Груша'),
(37, 'Дуб'),
(38, 'Дыня'),
(39, 'Жженый сахар'),
(40, 'Инжир'),
(41, 'Камелия'),
(42, 'Карамель'),
(43, 'Кардамон'),
(44, 'Каштан'),
(45, 'Кедр'),
(46, 'Киви');

-- --------------------------------------------------------

--
-- Структура таблицы `note_level`
--

CREATE TABLE `note_level` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `note_level`
--

INSERT INTO `note_level` (`id`, `title`) VALUES
(1, 'Верхние ноты'),
(2, 'Средние ноты'),
(3, 'Базовые ноты');

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

CREATE TABLE `order` (
  `id` int UNSIGNED NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `pay_type_id` int UNSIGNED NOT NULL,
  `status_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `amount` int UNSIGNED NOT NULL DEFAULT '0',
  `cost` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `other_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pay_receipt` tinyint UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `address`, `phone`, `created_at`, `date`, `time`, `pay_type_id`, `status_id`, `user_id`, `amount`, `cost`, `other_reason`, `pay_receipt`) VALUES
(25, '1', '+7(111)-111-11-11', '2025-05-15 18:16:12', '0111-11-11', '11:01:00', 3, 10, 16, 2, '6.00', NULL, 1),
(26, '2', '+7(222)-222-22-22', '2025-05-15 18:16:12', '0022-02-22', '22:02:00', 2, 2, 16, 1, '3.00', NULL, 0),
(27, '1', '+7(111)-111-11-11', '2025-05-15 18:16:12', '0111-11-11', '11:01:00', 3, 2, 16, 2, '6.00', NULL, 1),
(28, '2', '+7(222)-222-22-22', '2025-05-15 18:16:12', '0022-02-22', '22:02:00', 2, 6, 16, 1, '3.00', NULL, 0),
(29, '1', '+7(111)-111-11-11', '2025-05-15 18:16:12', '0111-11-11', '11:01:00', 3, 1, 16, 2, '6.00', NULL, 1),
(30, '2', '+7(222)-222-22-22', '2025-05-15 18:16:12', '0022-02-22', '22:02:00', 2, 4, 16, 1, '3.00', '5', 0),
(31, '1', '+7(111)-111-11-11', '2025-05-16 18:16:12', '0111-11-11', '11:01:00', 3, 9, 16, 2, '6.00', NULL, 1),
(32, '2', '+7(222)-222-22-22', '2025-05-16 18:16:12', '0022-02-22', '22:02:00', 2, 2, 16, 1, '3.00', NULL, 0),
(33, '1', '+7(111)-111-11-11', '2025-05-16 18:16:12', '0001-01-11', '11:01:00', 2, 4, 16, 2, '4.00', '1', 0),
(34, '0', '+7(000)-000-00-00', '2025-05-16 18:16:12', '2025-05-04', '14:58:00', 2, 3, 16, 1, '3.00', NULL, 0),
(35, '1', '+7(111)-111-11-11', '2025-05-16 07:19:34', '2025-05-16', '10:19:00', 2, 6, 17, 1, '3.00', NULL, 0),
(36, '1', '+7(111)-111-11-11', '2025-05-16 07:19:34', '2025-05-16', '10:19:00', 2, 3, 17, 1, '3.00', NULL, 0),
(37, '1', '+7(111)-111-11-11', '2025-05-16 07:19:34', '2025-05-16', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(38, '1', '+7(111)-111-11-11', '2025-05-16 07:19:34', '2025-05-16', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(39, '1', '+7(111)-111-11-11', '2025-05-10 07:19:34', '2025-05-16', '10:19:00', 2, 3, 17, 1, '3.00', NULL, 0),
(40, '1', '+7(111)-111-11-11', '2025-05-10 07:19:34', '2025-05-10', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(41, '1', '+7(111)-111-11-11', '2025-05-10 07:19:34', '2025-05-10', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(42, '1', '+7(111)-111-11-11', '2025-05-07 07:19:34', '2025-05-16', '10:19:00', 2, 3, 17, 1, '3.00', NULL, 0),
(43, '1', '+7(111)-111-11-11', '2025-05-07 07:19:34', '2025-05-10', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(44, '1', '+7(111)-111-11-11', '2025-05-04 07:19:34', '2025-05-10', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(45, '1', '+7(111)-111-11-11', '2025-04-10 07:19:34', '2025-04-16', '10:19:00', 2, 3, 17, 1, '3.00', NULL, 0),
(46, '1', '+7(111)-111-11-11', '2025-04-10 07:19:34', '2025-04-10', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(47, '1', '+7(111)-111-11-11', '2025-04-10 07:19:34', '2025-04-10', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(48, '1', '+7(111)-111-11-11', '2025-04-07 07:19:34', '2025-04-16', '10:19:00', 2, 3, 17, 1, '3.00', NULL, 0),
(49, '1', '+7(111)-111-11-11', '2025-04-07 07:19:34', '2025-04-10', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(50, '1', '+7(111)-111-11-11', '2025-04-04 07:19:34', '2025-04-10', '10:19:00', 2, 4, 17, 1, '3.00', 'q', 0),
(51, '1', '+7(111)-111-11-11', '2025-04-10 07:19:34', '2025-04-10', '10:19:00', 1, 4, 17, 1, '3.00', 'q', 1),
(52, '1', '+7(111)-111-11-11', '2025-04-10 07:19:34', '2025-04-10', '10:19:00', 1, 4, 17, 1, '3.00', 'q', 1),
(53, '1', '+7(111)-111-11-11', '2025-04-07 07:19:34', '2025-04-16', '11:19:00', 1, 3, 17, 1, '3.00', NULL, 1),
(54, '1', '+7(111)-111-11-11', '2025-04-07 07:19:34', '2025-04-10', '12:19:00', 1, 4, 17, 1, '3.00', 'q', 1),
(55, '1', '+7(111)-111-11-11', '2025-04-04 07:19:34', '2025-04-10', '10:19:00', 3, 4, 17, 1, '3.00', 'q', 1),
(56, '1', '+7(111)-111-11-11', '2025-04-10 07:19:34', '2025-04-10', '17:19:00', 1, 4, 17, 1, '3.00', 'q', 1),
(57, '1', '+7(111)-111-11-11', '2025-04-10 07:19:34', '2025-04-10', '10:19:00', 1, 4, 17, 1, '3.00', 'q', 1),
(58, '1', '+7(111)-111-11-11', '2025-04-07 07:19:34', '2025-04-16', '20:19:00', 1, 3, 17, 1, '3.00', NULL, 1),
(59, '1', '+7(111)-111-11-11', '2025-04-07 07:19:34', '2025-04-10', '11:19:00', 1, 4, 17, 1, '3.00', 'q', 1),
(60, '1', '+7(111)-111-11-11', '2025-04-04 07:19:34', '2025-04-10', '22:19:00', 3, 4, 17, 1, '3.00', 'q', 1),
(61, '2123', '+7(232)-332-23-32', '2025-05-20 13:15:04', '2025-05-20', '16:14:00', 1, 1, 16, 2, '6.00', NULL, 1),
(62, '2123', '+7(232)-332-23-32', '2025-05-20 13:15:04', '2025-05-20', '16:14:00', 1, 1, 16, 2, '6.00', NULL, 1),
(63, '2123', '+7(232)-332-23-32', '2025-05-20 13:15:04', '2025-05-20', '16:14:00', 1, 9, 16, 2, '6.00', NULL, 1),
(64, '2123', '+7(232)-332-23-32', '2025-05-20 13:15:04', '2025-05-20', '16:14:00', 1, 2, 16, 2, '6.00', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order_item`
--

CREATE TABLE `order_item` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `amount` int UNSIGNED NOT NULL DEFAULT '0',
  `cost` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `pay_type`
--

CREATE TABLE `pay_type` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `online` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `place` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pay_type`
--

INSERT INTO `pay_type` (`id`, `title`, `online`, `place`) VALUES
(1, 'Наличные', 0, 1),
(2, 'Банковская карта', 1, 1),
(3, 'QR код', 1, 1),
(4, 'СБП', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `photo`
--

CREATE TABLE `photo` (
  `id` int UNSIGNED NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `photo`
--

INSERT INTO `photo` (`id`, `photo`, `product_id`) VALUES
(6, '1748937388_N3XPvyvW-fvNAq0QKBVVrcCuAgEDnEks.png', 16),
(7, '1748938774_Iue9Udf2GtXjIoi4hDc-8ZqEpFc1LxLv.png', 17),
(9, '1748941994_wrKklwtMkCQhUsCmCZdPtIJXzK6L691Q.png', 19),
(10, '1748942175_8snWBUVRZwHTNkeA-8Q1kBco8jOmkJR2.png', 20),
(11, '1748942340_K_qEf4eZeYkR9sri7_TRu_ekqfDPDJMo.png', 21),
(12, '1748942732_atmz-HK1Q_DyCc-LslLoU2dC41WaaQtD.png', 22),
(13, '1748942929_y9BDMkh3RHe60eB0sYQokFI_h3pHLX7-.png', 23),
(14, '1748943091_YP71Uizh07B1Of17uKSklXY8U_GiS0Ii.png', 24),
(15, '1748943255_hIVBZy8-IEFCULN5AT8mYfAAJCmAq8_T.png', 25),
(16, '1748943418_lOaSIFDIakk15FsIJQtcTvihd3aV3tSV.png', 26),
(17, '1748943636_GuX--YcMpRjGlBoFinh751AM791DtQJ1.png', 27),
(18, '1748943812_h9OSh8R4kzRCG9-VLbVuMN-fGDZ2f-kg.png', 28);

-- --------------------------------------------------------

--
-- Структура таблицы `photo_category`
--

CREATE TABLE `photo_category` (
  `id` int UNSIGNED NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_german2_ci NOT NULL,
  `category_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_german2_ci;

--
-- Дамп данных таблицы `photo_category`
--

INSERT INTO `photo_category` (`id`, `photo`, `category_id`) VALUES
(2, '1746215149_LqjPpA9_m2sFKun2tR7uK3MeOBS8L18b.png', 13),
(6, '1748939803_V6aKi7-IR1aOv4xqHlh0gg0KEzPWiX_7.png', 15),
(7, '1748939939_Xsw4O5d41N-sweNM5imajosd1vV6Vzdp.png', 7),
(8, '1748939988_D3EwZXd5ZuyNlLNuwWnLLt_WQ1Gqr3MG.png', 6),
(9, '1748940058_uLSSewL7yBFzn6HINWkD99BCl-i43pM1.jpg', 16),
(10, '1748940755_QwmQ1VRRDx6jnzjiqChSrOXsQ2jmjMGg.png', 17),
(11, '1748940919_QmpCiH-1mhMw9XhXu_YY5PBgj9Tj_W-r.jpg', 8),
(15, '1748941473_hWVnTcZ1YnBbj6JEIx8F5Zz8Ck9j4uFP.jpg', 19);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stars` decimal(8,1) UNSIGNED NOT NULL DEFAULT '0.0',
  `price` decimal(10,0) UNSIGNED NOT NULL,
  `sex_id` int UNSIGNED NOT NULL,
  `count` int UNSIGNED NOT NULL,
  `volume` int UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `title`, `stars`, `price`, `sex_id`, `count`, `volume`, `description`) VALUES
(16, 'Luxurious Elixir', '4.0', '25000', 1, 250, 150, '<p>Окунитесь в мир непревзойденной роскоши с Luxurious Elixir, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(17, 'The Golden Legasy', '5.0', '16000', 3, 400, 100, '<p>Окунитесь в мир непревзойденной роскоши с The Golden Legasy, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(19, 'Luxurious Elixir Rough', '3.0', '20200', 3, 200, 200, '<p>Окунитесь в мир непревзойденной роскоши с Luxurious Elixir Rough, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(20, 'Luxurious Essence', '4.5', '16000', 2, 100, 100, '<p>Окунитесь в мир непревзойденной роскоши с Luxurious Essence, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(21, 'Aurum Aura', '1.0', '24300', 1, 50, 100, '<p>Окунитесь в мир непревзойденной роскоши с Aurum Aura, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(22, 'Gleaming Gilt', '5.0', '17500', 1, 222, 150, '<p>Окунитесь в мир непревзойденной роскоши с Gleaming Gilt, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(23, 'Gilded Elixir Rough', '2.0', '24500', 3, 330, 250, '<p>Окунитесь в мир непревзойденной роскоши с Glided Elixir Rough, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(24, 'Golden Luminary', '3.5', '18500', 1, 230, 250, '<p>Окунитесь в мир непревзойденной роскоши с Golden Luminary, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(25, 'Decadent Opal', '5.0', '28000', 2, 290, 150, '<p>Окунитесь в мир непревзойденной роскоши с Decadent Opal, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(26, 'Glided Elixir', '5.0', '19700', 3, 330, 250, '<p>Окунитесь в мир непревзойденной роскоши с Glided Elixir, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(27, 'Glamuourous Glit', '3.5', '21000', 1, 123, 100, '<p>Окунитесь в мир непревзойденной роскоши с Glamuorous Gilt, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n'),
(28, 'Luxury Enigma', '4.0', '14000', 1, 44, 150, '<p>Окунитесь в мир непревзойденной роскоши с Luxury Enigma, изысканным ароматом, который сплетает чарующую симфонию золота и роскоши. Этот позолоченный эликсир - это праздник изысканности, созданный с использованием лучших эссенций и наполненный очарованием драгоценных золотых оттенков.</p>\r\n');

-- --------------------------------------------------------

--
-- Структура таблицы `product_category`
--

CREATE TABLE `product_category` (
  `id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `product_category`
--

INSERT INTO `product_category` (`id`, `product_id`, `category_id`) VALUES
(54, 16, 6),
(55, 16, 13),
(57, 19, 17),
(58, 20, 7),
(59, 21, 17),
(60, 22, 16),
(61, 23, 8),
(62, 23, 17),
(63, 24, 6),
(64, 24, 15),
(65, 25, 7),
(66, 25, 17),
(67, 26, 13),
(68, 26, 19),
(69, 27, 15),
(70, 28, 8),
(71, 28, 17);

-- --------------------------------------------------------

--
-- Структура таблицы `product_note_level`
--

CREATE TABLE `product_note_level` (
  `id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `note_level_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `product_note_level`
--

INSERT INTO `product_note_level` (`id`, `product_id`, `note_level_id`) VALUES
(51, 16, 1),
(52, 16, 2),
(53, 16, 3),
(57, 19, 1),
(58, 19, 2),
(59, 19, 3),
(60, 20, 1),
(61, 20, 2),
(62, 20, 3),
(63, 21, 1),
(64, 21, 2),
(65, 21, 3),
(66, 22, 1),
(67, 22, 2),
(68, 22, 3),
(69, 23, 1),
(70, 23, 2),
(71, 23, 3),
(72, 24, 1),
(73, 24, 2),
(74, 24, 3),
(75, 25, 1),
(76, 25, 2),
(77, 25, 3),
(78, 26, 1),
(79, 26, 2),
(80, 26, 3),
(81, 27, 1),
(82, 27, 2),
(83, 27, 3),
(84, 28, 1),
(85, 28, 2),
(86, 28, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `product_note_level_item`
--

CREATE TABLE `product_note_level_item` (
  `id` int UNSIGNED NOT NULL,
  `product_note_level_id` int UNSIGNED NOT NULL,
  `note_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `product_note_level_item`
--

INSERT INTO `product_note_level_item` (`id`, `product_note_level_id`, `note_id`) VALUES
(179, 51, 1),
(180, 51, 2),
(181, 51, 7),
(182, 52, 9),
(183, 52, 10),
(184, 53, 11),
(185, 53, 12),
(192, 57, 12),
(193, 57, 13),
(194, 58, 43),
(195, 58, 44),
(196, 59, 25),
(197, 59, 33),
(198, 59, 45),
(199, 60, 12),
(200, 60, 19),
(201, 61, 44),
(202, 61, 45),
(203, 62, 31),
(204, 63, 9),
(205, 63, 24),
(206, 64, 39),
(207, 64, 41),
(208, 65, 12),
(209, 65, 13),
(210, 66, 9),
(211, 66, 15),
(212, 67, 36),
(213, 67, 39),
(214, 68, 20),
(215, 68, 38),
(216, 68, 42),
(217, 69, 11),
(218, 69, 12),
(219, 70, 16),
(220, 70, 35),
(221, 70, 39),
(222, 71, 25),
(223, 71, 27),
(224, 72, 1),
(225, 72, 7),
(226, 72, 21),
(227, 73, 23),
(228, 73, 24),
(229, 73, 28),
(230, 74, 32),
(231, 74, 33),
(232, 74, 41),
(233, 75, 15),
(234, 75, 16),
(235, 75, 18),
(236, 76, 25),
(237, 76, 26),
(238, 76, 28),
(239, 77, 43),
(240, 77, 44),
(241, 78, 11),
(242, 78, 13),
(243, 78, 17),
(244, 79, 1),
(245, 79, 2),
(246, 79, 7),
(247, 80, 21),
(248, 80, 23),
(249, 80, 25),
(250, 80, 26),
(251, 80, 27),
(252, 81, 9),
(253, 81, 17),
(254, 82, 30),
(255, 82, 34),
(256, 83, 21),
(257, 83, 22),
(258, 84, 11),
(259, 84, 12),
(260, 85, 25),
(261, 85, 27),
(262, 86, 31),
(263, 86, 35);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `sex`
--

CREATE TABLE `sex` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sex`
--

INSERT INTO `sex` (`id`, `title`) VALUES
(1, 'Женский'),
(2, 'Мужской'),
(3, 'Унисекс');

-- --------------------------------------------------------

--
-- Структура таблицы `stars_user`
--

CREATE TABLE `stars_user` (
  `id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `stars` decimal(8,1) UNSIGNED NOT NULL DEFAULT '0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `stars_user`
--

INSERT INTO `stars_user` (`id`, `product_id`, `user_id`, `stars`) VALUES
(36, 16, 16, '4.0'),
(37, 17, 16, '5.0'),
(38, 19, 16, '3.0'),
(39, 24, 16, '4.0'),
(40, 23, 16, '2.0'),
(41, 22, 16, '5.0'),
(42, 26, 16, '5.0'),
(43, 20, 16, '4.0'),
(44, 21, 16, '1.0'),
(45, 27, 16, '3.0'),
(46, 25, 16, '5.0'),
(47, 28, 16, '4.0'),
(48, 16, 18, '4.0'),
(49, 17, 18, '5.0'),
(50, 24, 18, '3.0'),
(51, 27, 18, '4.0'),
(52, 20, 18, '5.0');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `title`) VALUES
(1, 'Создан'),
(2, 'В сборке'),
(3, 'Доставлен'),
(4, 'Отменен'),
(6, 'Оплачен онлайн'),
(7, 'Ожидает оплаты'),
(8, 'Оплата при получении'),
(9, 'Оплачен оффлайн'),
(10, 'Заказ выдан');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `auth_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `full_name`, `email`, `phone`, `role_id`, `auth_key`) VALUES
(4, 'admin', '$2y$13$urCIM33CEMNSTRM8AsTbuOkLxs.NOIpcbD7YEATJ0iyjt10QFGv/u', 'админ', 'admin@d.d', '+7(323)-323-23-23', 1, 'YxgxrZSN1QLODDraiyq6yLMReO1KWuOl'),
(15, '1', '$2y$13$yLlu4vtgtMGABtbxxmdtRuZrnByt7l4EYGxqOMjbSDmBN.Z9CeVtC', 'ыф', 'q@q.q', '+7(434)-534-55-53', 2, 'ZlJYRJP1CMYYPZARW9a4R-bVlA_ENyoz'),
(16, 'q', '$2y$13$yLlu4vtgtMGABtbxxmdtRuZrnByt7l4EYGxqOMjbSDmBN.Z9CeVtC', 'й', 'parfumstore_info@mail.ru', '+7(323)-233-23-32', 2, 'QEhGFvH6CTM7_dJmwCjF4G6TPXU-37FE'),
(17, 'user', '$2y$13$yLlu4vtgtMGABtbxxmdtRuZrnByt7l4EYGxqOMjbSDmBN.Z9CeVtC', 'у', 'parfumstore_info@mail.ru', '+7(111)-111-11-11', 2, 'QlccMsYbjt4KJVGjnGVyfdrpjsEXMy6A'),
(18, 'qqq', '$2y$13$yLlu4vtgtMGABtbxxmdtRuZrnByt7l4EYGxqOMjbSDmBN.Z9CeVtC', 'ф', 'parfumstore_info@mail.ru', '+7(111)-111-11-11', 2, 't4IQ7wpCvlSfThJCPH8LbG8v_tzsigZ9');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `note_level`
--
ALTER TABLE `note_level`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pay_type_id` (`pay_type_id`);

--
-- Индексы таблицы `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `pay_type`
--
ALTER TABLE `pay_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `photo_category`
--
ALTER TABLE `photo_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sex_id` (`sex_id`);

--
-- Индексы таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_notes_id` (`product_id`);

--
-- Индексы таблицы `product_note_level`
--
ALTER TABLE `product_note_level`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_note_level_ibfk_1` (`product_id`),
  ADD KEY `product_note_level_ibfk_2` (`note_level_id`);

--
-- Индексы таблицы `product_note_level_item`
--
ALTER TABLE `product_note_level_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_note_level_item_ibfk_1` (`product_note_level_id`),
  ADD KEY `product_note_level_item_ibfk_2` (`note_id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sex`
--
ALTER TABLE `sex`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stars_user`
--
ALTER TABLE `stars_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT для таблицы `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `note`
--
ALTER TABLE `note`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `note_level`
--
ALTER TABLE `note_level`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT для таблицы `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `pay_type`
--
ALTER TABLE `pay_type`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `photo_category`
--
ALTER TABLE `photo_category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT для таблицы `product_note_level`
--
ALTER TABLE `product_note_level`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT для таблицы `product_note_level_item`
--
ALTER TABLE `product_note_level_item`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `sex`
--
ALTER TABLE `sex`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `stars_user`
--
ALTER TABLE `stars_user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_4` FOREIGN KEY (`pay_type_id`) REFERENCES `pay_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `photo_category`
--
ALTER TABLE `photo_category`
  ADD CONSTRAINT `photo_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`sex_id`) REFERENCES `sex` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_note_level`
--
ALTER TABLE `product_note_level`
  ADD CONSTRAINT `product_note_level_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_note_level_ibfk_2` FOREIGN KEY (`note_level_id`) REFERENCES `note_level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_note_level_item`
--
ALTER TABLE `product_note_level_item`
  ADD CONSTRAINT `product_note_level_item_ibfk_1` FOREIGN KEY (`product_note_level_id`) REFERENCES `product_note_level` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_note_level_item_ibfk_2` FOREIGN KEY (`note_id`) REFERENCES `note` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `stars_user`
--
ALTER TABLE `stars_user`
  ADD CONSTRAINT `stars_user_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stars_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

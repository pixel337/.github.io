-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 11 2024 г., 10:54
-- Версия сервера: 5.6.51-log
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `your_database`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `order_date`) VALUES
(34, 1, '0.00', '2024-03-10 12:21:20'),
(35, 30, '0.00', '2024-03-10 12:26:04'),
(36, 30, '0.00', '2024-03-10 12:28:25'),
(37, 30, '0.00', '2024-03-10 12:31:14'),
(38, 30, '0.00', '2024-03-10 12:34:43'),
(39, 30, '0.00', '2024-03-10 12:36:51'),
(40, 30, '0.00', '2024-03-10 12:40:04'),
(41, 30, '0.00', '2024-03-10 12:45:15'),
(42, 30, '0.00', '2024-03-10 12:46:40'),
(43, 30, '0.00', '2024-03-10 12:50:39'),
(44, 30, '0.00', '2024-03-10 12:53:16'),
(45, 30, '0.00', '2024-03-10 13:00:23'),
(46, 30, '0.00', '2024-03-10 13:13:36'),
(47, 30, '0.00', '2024-03-10 13:26:24'),
(48, 30, '2800.00', '2024-03-10 13:33:18'),
(49, 30, '3400.00', '2024-03-10 13:34:27'),
(50, 30, '500.00', '2024-03-10 13:38:51');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 34, 22, 1, NULL),
(2, 34, 1, 1, NULL),
(3, 35, 1, 1, NULL),
(4, 36, 1, 1, NULL),
(5, 37, 1, 1, NULL),
(6, 38, 1, 1, NULL),
(7, 39, 1, 1, NULL),
(8, 40, 1, 1, NULL),
(9, 41, 1, 1, NULL),
(10, 42, 1, 1, NULL),
(11, 43, 1, 3, NULL),
(12, 44, 1, 2, NULL),
(13, 44, 16, 2, NULL),
(14, 45, 16, 4, NULL),
(15, 46, 16, 2, NULL),
(16, 47, 16, 14, NULL),
(17, 47, 31, 4, '0.00'),
(18, 48, 31, 2, '1400.00'),
(19, 49, 19, 2, '1700.00'),
(20, 50, 58, 1, '500.00');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category`, `quantity`) VALUES
(1, 'Коврик для фитнеса', '1221.00', 'img/mat-1.png', 'mat', 16),
(14, 'Коврик для фитнеса', '1221.00', 'img/mat-2.png', 'mat', 10),
(15, 'Коврик для фитнеса', '1000.00', 'img/mat-3.png', 'mat', 45),
(16, 'Коврик для фитнеса', '1200.00', 'img/mat-4.png', 'mat', 70),
(17, 'Коврик для фитнеса', '1221.00', 'img/mat-5.png', 'mat', 10),
(18, 'Коврик для фитнеса', '1000.00', 'img/mat-6.png', 'mat', 90),
(19, 'Коврик для фитнеса', '1700.00', 'img/mat-7.png', 'mat', 78),
(20, 'Коврик для фитнеса', '1506.00', 'img/mat-8.png', 'mat', 67),
(21, 'Коврик для фитнеса', '1890.00', 'img/mat-9.png', 'mat', 189),
(22, 'Утяжелители 1.5 кг', '1824.00', 'img/weights-1.png', 'weights', 66),
(23, 'Утяжелители 0.5 кг', '1500.00', 'img/weights-2.png', 'weights', 54),
(24, 'Утяжелители 1.5 кг', '1824.00', 'img/weights-3.png', 'weights', 34),
(25, 'Утяжелители 0.5 кг', '1500.00', 'img/weights-4.png', 'weights', 23),
(26, 'Утяжелители 1.5 кг', '1824.00', 'img/weights-5.png', 'weights', 23),
(28, 'Утяжелители 1.5 кг', '1824.00', 'img/weights-7.png', 'weights', 11),
(29, 'Утяжелители 0.5 кг', '1500.00', 'img/weights-8.png', 'weights', 5),
(30, 'Утяжелители 1.5 кг', '1824.00', 'img/weights-9.png', 'weights', 50),
(31, 'Гантели 1 кг', '1400.00', 'img/dumbell-1.png', 'dumbbells', 23),
(32, 'Гантели 2 кг', '2221.00', 'img/dumbell-2.png', 'dumbbells', 34),
(33, 'Гантели 2 кг', '2221.00', 'img/dumbell-3.png', 'dumbbells', 56),
(34, 'Гантели 1 кг', '1400.00', 'img/dumbell-4.png', 'dumbbells', 67),
(35, 'Гантели 1 кг', '1400.00', 'img/dumbell-5.png', 'dumbbells', 45),
(36, 'Гантели 1 кг', '1400.00', 'img/dumbell-6.png', 'dumbbells', 67),
(37, 'Гантели 5 кг', '2800.00', 'img/dumbell-7.png', 'dumbbells', 76),
(38, 'Гантели 5 кг', '2800.00', 'img/dumbell-8.png', 'dumbbells', 45),
(39, 'Гантели 2 кг', '2221.00', 'img/dumbell-9.png', 'dumbbells', 66),
(40, 'Термобутылка 500 мл', '2000.00', 'img/bottles-1.png', 'bottles', 22),
(41, 'Термобутылка 500 мл', '2000.00', 'img/bottles-2.png', 'bottles', 32),
(42, 'Термобутылка 500 мл', '2000.00', 'img/bottles-3.png', 'bottles', 55),
(43, 'Термобутылка 500 мл', '2000.00', 'img/bottles-4.png', 'bottles', 65),
(44, 'Термобутылка 500 мл', '2000.00', 'img/bottles-5.png', 'bottles', 89),
(45, 'Термобутылка 500 мл', '1400.00', 'img/bottles-6.png', 'bottles', 55),
(46, 'Термобутылка 500 мл', '2500.00', 'img/bottles-7.png', 'bottles', 67),
(47, 'Термобутылка 500 мл', '2000.00', 'img/bottles-8.png', 'bottles', 80),
(48, 'Термобутылка 500 мл', '2000.00', 'img/bottles-9.png', 'bottles', 90),
(49, 'Фитнес резинка 1 шт.', '300.00', 'img/bands-1.png', 'bands', 98),
(50, 'Фитнес резинки 3 шт.', '900.00', 'img/bands-2.png', 'bands', 78),
(51, 'Фитнес резинка 2 шт.', '600.00', 'img/bands-3.png', 'bands', 34),
(52, 'Фитнес резинка 1 шт.', '300.00', 'img/bands-4.png', 'bands', 78),
(53, 'Фитнес резинка 3 шт.', '900.00', 'img/bands-5.png', 'bands', 67),
(54, 'Фитнес резинка 3 шт.', '900.00', 'img/bands-6.png', 'bands', 34),
(55, 'Фитнес резинка 1 шт.', '300.00', 'img/bands-7.png', 'bands', 1),
(56, 'Фитнес резинка 3 шт.', '900.00', 'img/bands-8.png', 'bands', 11),
(57, 'Фитнес резинка 1 шт.', '300.00', 'img/bands-9.png', 'bands', 23),
(58, 'Чехол для коврика', '500.00', 'img/bags-1.png', 'bags', 78),
(59, 'Чехол для коврика', '500.00', 'img/bags-2.png', 'bags', 76),
(60, 'Чехол для коврика', '1250.00', 'img/bags-3.png', 'bags', 65),
(61, 'Чехол для коврика', '1200.00', 'img/bags-4.png', 'bags', 56),
(62, 'Чехол для коврика', '1300.00', 'img/bags-5.png', 'bags', 34),
(63, 'Чехол для коврика', '678.00', 'img/bags-6.png', 'bags', 23),
(64, 'Чехол для коврика', '2340.00', 'img/bags-7.png', 'bags', 76),
(65, 'Чехол для коврика', '500.00', 'img/bags-8.png', 'bags', 56),
(66, 'Чехол для коврика', '500.00', 'img/bags-9.png', 'bags', 345),
(67, 'Блоки для йоги', '1200.00', 'img/yoga-blocks-1.png', 'yoga-blocks', 89),
(68, 'Блоки для йоги', '1200.00', 'img/yoga-blocks-2.png', 'yoga-blocks', 23),
(69, 'Блоки для йоги', '1200.00', 'img/yoga-blocks-3.png', 'yoga-blocks', 34),
(70, 'Блок для йоги', '600.00', 'img/yoga-blocks-4.png', 'yoga-blocks', 56),
(71, 'Блок для йоги', '600.00', 'img/yoga-blocks-5.png', 'yoga-blocks', 43),
(72, 'Блок для йоги', '600.00', 'img/yoga-blocks-6.png', 'yoga-blocks', 54),
(73, 'Массажный ролик', '1300.00', 'img/massage-rollers-1.png', 'massage-rollers', 20),
(74, 'Массажный ролик', '1000.00', 'img/massage-rollers-2.png', 'massage-rollers', 30),
(75, 'Массажный ролик', '1800.00', 'img/massage-rollers-3.png', 'massage-rollers', 56),
(76, 'Массажный ролик', '1000.00', 'img/massage-rollers-4.png', 'massage-rollers', 35),
(77, 'Массажный ролик', '1767.00', 'img/massage-rollers-5.png', 'massage-rollers', 65),
(78, 'Массажный ролик', '1000.00', 'img/massage-rollers-6.png', 'massage-rollers', 78);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `blocked`, `is_admin`) VALUES
(29, 'admin', 'admin@sante', 'admin', 0, 1),
(30, 'buyer', 'buy@sante', 'khm', 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

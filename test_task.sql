-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 29 2024 г., 14:58
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_task`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `product_count` int NOT NULL DEFAULT '1' COMMENT 'Количество товаров в заказе',
  `status` int NOT NULL DEFAULT '0' COMMENT 'Статус заказа. 1 - если сделка совершена, 0 - заказ не оплачен.',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания заказа',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата последнего обновления'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Заказы';

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `product_count`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2024-01-29 13:58:23', '2024-01-29 14:19:18'),
(2, 5, 1, '2024-01-29 13:58:34', '2024-01-29 14:19:18'),
(3, 5, 1, '2024-01-29 14:53:08', '2024-01-29 14:53:08');

-- --------------------------------------------------------

--
-- Структура таблицы `price_history`
--

CREATE TABLE `price_history` (
  `id` int NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `price_history`
--

INSERT INTO `price_history` (`id`, `price`, `created_at`) VALUES
(1, 10.00, '2023-01-05'),
(2, 13.00, '2024-02-17'),
(3, 15.00, '2024-04-17'),
(4, 12.00, '2024-08-01'),
(6, 345.00, '2024-01-29'),
(7, 345.00, '2024-01-29'),
(8, 45.32, '2024-01-29'),
(9, 100.00, '2024-01-29');

-- --------------------------------------------------------

--
-- Структура таблицы `purchases`
--

CREATE TABLE `purchases` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_purchased_count` int NOT NULL COMMENT 'Количество шт. купленных товаров',
  `purchased_sum` decimal(10,0) NOT NULL COMMENT 'В итоге к оплате',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата покупки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Покупки';

--
-- Дамп данных таблицы `purchases`
--

INSERT INTO `purchases` (`id`, `order_id`, `product_purchased_count`, `purchased_sum`, `created_at`) VALUES
(1, 2, 3, '136', '2024-01-29 14:48:51'),
(2, 3, 3, '300', '2024-01-29 14:53:08');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `price_history`
--
ALTER TABLE `price_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_at` (`created_at`);

--
-- Индексы таблицы `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `price_history`
--
ALTER TABLE `price_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

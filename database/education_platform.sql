-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 16 2025 г., 20:42
-- Версия сервера: 5.7.39
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `education_platform`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exist` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `exist`, `created_at`, `updated_at`) VALUES
(1, 'Языки мира', '1', '2024-12-14 06:17:57', '2024-12-21 00:06:04'),
(2, 'Дизайн', '1', NULL, '2024-12-20 19:52:21'),
(3, 'Рисование', '1', NULL, NULL),
(4, 'Программирование', '1', NULL, NULL),
(5, 'Психология', '0', NULL, '2025-04-29 04:40:51');

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` bigint(20) UNSIGNED NOT NULL,
  `student_count` int(11) NOT NULL DEFAULT '0',
  `appl` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `access` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `courses`
--

INSERT INTO `courses` (`id`, `category`, `title`, `description`, `image`, `author`, `student_count`, `appl`, `access`, `created_at`, `updated_at`) VALUES
(1, 1, 'Английский язык #1', 'English is main language in USA, UK, AU.', 'english_language.png', 12, 17, '1', '1', '2024-12-14 06:18:39', '2025-05-15 06:03:20'),
(2, 1, 'Французский язык', 'Donnez-moi une suite au Ritz,\r\nJe n\'en veux pas\r\nDes bijoux de chez Chanel,\r\nJe n\'en veux pas\r\nDonnez moi une limousine,\r\nJ\'en ferais quoi\r\n', 'bonjour.png', 12, 10, '1', '1', '2024-12-14 10:30:05', '2025-05-15 13:53:28'),
(3, 1, 'Корейский язык', '인생의 행복은 여러분이 가지는 생각의 질에 달려있습니다.', 'south-korea.png', 12, 1, '0', '1', '2024-12-14 10:50:05', '2024-12-20 17:26:29'),
(4, 1, 'Испанский язык', 'Todo el mundo sabe lo que tiene, pero nadie sabe lo que eso vale.', 'spain.png', 12, 4, '0', '1', '2024-12-14 10:51:05', '2024-12-21 02:30:52'),
(5, 1, 'Немецкий язык', 'Sieben, Sieben\r\nAi lyu lyu\r\nSieben, Sieben\r\nEin, zwei\r\nSieben, Sieben\r\nAi lyu lyu\r\nEin, zwei, drei', '', 12, 6, '0', '1', '2024-12-14 10:51:05', '2024-12-20 17:29:57'),
(6, 1, 'Татарский язык', 'Что-то на татарском', 'world.png', 12, 0, '0', '1', '2024-12-14 10:51:05', '2024-12-20 19:43:47'),
(7, 1, 'Башкирский язык', 'Башкорт теле', 'world.png', 12, 1, '0', '1', '2024-12-14 10:51:05', '2024-12-20 19:49:05'),
(8, 1, 'Арабский язык', 'Арабиан лангуаге', '', 12, 0, '0', '1', '2024-12-14 10:51:05', '2024-12-14 10:51:05'),
(9, 1, 'Белорусский язык', 'дранікі \r\nса смятанай', '', 12, 0, '0', '1', '2024-12-14 11:58:05', '2024-12-14 10:58:05'),
(10, 1, 'Японсикй язык', 'смотрите аниме без озвучки, оригинале', '', 12, 1, '0', '1', '2024-12-14 11:03:05', '2024-12-21 00:12:41'),
(11, 1, 'Китайский язык', 'ну наши друзья и соседи', '', 12, 0, '0', '1', '2024-12-14 11:02:05', '2024-12-14 10:58:05'),
(12, 1, 'Марийский язык', 'Йуршо йурыш', 'bonjour.png', 12, 3, '0', '1', '2024-12-14 11:01:05', '2024-12-20 09:00:05'),
(13, 1, 'Итальянский язык', 'Ad ogni uccello il suo nido è bello', '', 12, 0, '0', '1', '2024-12-14 10:59:05', '2024-12-14 10:58:05'),
(14, 1, 'Вьетнамский язык', 'Без плохих генералов не было бы хороших.', '', 12, 0, '0', '1', '2024-12-14 10:58:05', '2024-12-14 10:58:05'),
(15, 4, 'C##', 'Основы языка', 'C:\\OSPanel\\userdata\\temp\\upload\\php991F.tmp', 12, 0, '1', '0', NULL, '2024-12-20 12:12:42'),
(16, 4, 'C++', 'Основы ЯП', 'C:\\OSPanel\\userdata\\temp\\upload\\php2780.tmp', 12, 0, '1', '1', NULL, '2024-12-20 20:40:03'),
(17, 4, 'C#', 'Base of C# programming language', 'c-sharp.png', 12, 0, '1', '1', NULL, '2024-12-20 20:40:06'),
(18, 4, 'C#', 'Base of C# programming language', 'c-sharp.png', 12, 0, '1', '1', NULL, '2025-05-15 06:03:28'),
(19, 4, 'C#', 'Base of C# programming language', 'c-sharp.png', 12, 0, '0', '0', NULL, NULL),
(20, 3, 'Маленькие наброски', 'Учимся рисовать быстро небольшие картинки', 'human.png', 12, 0, '0', '0', NULL, NULL),
(21, 4, 'Основы JS', 'Основы javascript', 'fireworks.png', 12, 0, '0', '0', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `course_applications`
--

CREATE TABLE `course_applications` (
  `id` int(11) NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `wish_access` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Отправлена','Принята','Отклонена') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Отправлена',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `course_applications`
--

INSERT INTO `course_applications` (`id`, `course_id`, `wish_access`, `status`, `created_at`, `updated_at`) VALUES
(1, 15, '1', 'Отклонена', '2024-12-20 19:03:29', '2024-12-20 23:34:42'),
(2, 16, '1', 'Принята', '2024-12-21 01:07:57', '2024-12-20 23:40:03'),
(3, 17, '1', 'Принята', '2024-12-21 01:08:44', '2024-12-20 23:40:06'),
(4, 18, '1', 'Принята', '2024-12-21 01:08:59', '2025-05-15 09:03:28'),
(5, 2, '1', 'Принята', '2025-04-26 10:12:47', '2025-05-08 16:55:39');

-- --------------------------------------------------------

--
-- Структура таблицы `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `id_lesson` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `answers` json NOT NULL,
  `score` int(10) UNSIGNED NOT NULL,
  `coef` decimal(10,2) NOT NULL,
  `grade` int(11) NOT NULL,
  `timer` time DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `grades`
--

INSERT INTO `grades` (`id`, `id_lesson`, `id_user`, `answers`, `score`, `coef`, `grade`, `timer`, `created_at`, `updated_at`) VALUES
(99, 31, 16, '{\"1\": {\"one_answer\": \"Слово\"}}', 1, '1.00', 5, NULL, '2025-05-12 04:42:13', '2025-05-12 04:42:13'),
(100, 29, 16, '{\"1\": {\"one_answer\": \"Верный ответ 10\"}, \"2\": {\"some_answer\": [null, \"Аптека\", \"Пальто\"]}, \"3\": {\"subsequence\": [\"Зоркин\", \"Цулыгин\", \"Панин\", \"Вязовой\", \"Пересильд\"]}, \"4\": {\"word\": \"Салават Юлаев\"}}', 3, '1.00', 4, NULL, '2025-05-12 04:43:17', '2025-05-12 04:43:17'),
(101, 30, 16, '{\"1\": {\"word\": \"хоккей\"}}', 1, '1.00', 5, NULL, '2025-05-12 04:43:29', '2025-05-12 04:43:29'),
(102, 31, 16, '{\"1\": {\"one_answer\": \"Слово\"}}', 1, '1.00', 5, NULL, '2025-05-12 04:43:35', '2025-05-12 04:43:35'),
(103, 29, 22, '{\"1\": {\"one_answer\": \"Верный ответ 10\"}, \"2\": {\"some_answer\": [null, \"Аптека\", \"Пальто\"]}, \"3\": {\"subsequence\": [\"Пересильд\", \"Зоркин\", \"Цулыгин\", \"Вязовой\", \"Панин\"]}, \"4\": {\"word\": \"Салават Юлаев\"}}', 3, '0.80', 5, NULL, '2025-05-12 10:23:54', '2025-05-12 10:23:54'),
(104, 29, 23, '{\"1\": {\"one_answer\": \"Верный ответ 10\"}, \"2\": {\"some_answer\": [null, \"Аптека\", \"Андрей\"]}, \"3\": {\"subsequence\": [\"Зоркин\", \"Панин\", \"Вязовой\", \"Пересильд\", \"Цулыгин\"]}, \"4\": {\"word\": \"Салават Юлаев\"}}', 1, '0.30', 2, NULL, '2025-05-12 15:41:47', '2025-05-12 15:41:47'),
(106, 29, 22, '{\"1\": {\"one_answer\": \"Верный ответ 10\"}, \"2\": {\"some_answer\": [null, \"Аптека\", \"Ответ 1\"]}, \"3\": {\"subsequence\": [\"Вязовой\", \"Пересильд\", \"Зоркин\", \"Цулыгин\", \"Панин\"]}, \"4\": {\"word\": \"Салават Юлаев\"}}', 2, '0.50', 3, NULL, '2025-05-13 15:15:46', '2025-05-13 15:15:46'),
(107, 30, 22, '{\"1\": {\"word\": \"хоккей\"}}', 0, '0.00', 3, NULL, '2025-05-15 13:57:10', '2025-05-15 13:57:10'),
(109, 31, 22, '{\"1\": {\"one_answer\": \"Слово\"}}', 1, '1.00', 5, NULL, '2025-05-15 18:39:51', '2025-05-15 18:39:51'),
(110, 31, 22, '{\"1\": {\"one_answer\": \"Слово\"}}', 1, '1.00', 5, NULL, '2025-05-15 19:58:07', '2025-05-15 19:58:07');

-- --------------------------------------------------------

--
-- Структура таблицы `lesson_tests`
--

CREATE TABLE `lesson_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('test','lesson') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` json NOT NULL,
  `comments` json DEFAULT NULL,
  `position` int(10) UNSIGNED DEFAULT NULL,
  `timer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'OFF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `lesson_tests`
--

INSERT INTO `lesson_tests` (`id`, `course_id`, `type`, `title`, `content`, `comments`, `position`, `timer`, `created_at`, `updated_at`) VALUES
(24, 1, 'lesson', 'Название урока', '[{\"txt\": \"Здесь может находится текст любого блока из уроков\"}, {\"img\": \"articles-1024x576.png\"}, {\"txt\": \"Так выглядит еще один блок с контентом урока\"}]', NULL, 1, 'OFF', NULL, NULL),
(25, 5, 'lesson', 'Урок №2', '[{\"txt\": \"Здесь может быть заголовок или параграф\"}, {\"img\": \"imya-syshchestvitelnoe.jpg\"}, {\"txt\": \"Допустим, второй параграф.\"}, {\"img\": \"articles-1024x576.png\"}, {\"txt\": \"И...Еще параграф!!!\"}]', NULL, 1, 'OFF', NULL, NULL),
(26, 1, 'lesson', 'Заголовок №3', '[{\"txt\": \"Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text Some text\"}, {\"img\": \"articles-1024x576.png\"}, {\"img\": \"articles-1024x576.png\"}, {\"img\": \"articles-1024x576.png\"}, {\"txt\": \"Длина текстового поля минимум 10 симвлов\"}]', NULL, 2, 'OFF', NULL, NULL),
(27, 1, 'lesson', 'Лессон №2', '{\"1\": {\"img\": \"articles-1024x576.png\"}, \"2\": {\"txt\": \"йцшормлдлораплдтьилджэ\"}}', NULL, 3, 'OFF', NULL, NULL),
(29, 1, 'test', 'Заголовок тестового тестирования', '{\"timer\": \"5\", \"content\": {\"1\": {\"one_answer\": {\"answers\": [\"Неверный ответ 16\", \"Неверный ответ 19\", \"Верный ответ 10\", \"Неверный ответ 2\"], \"current\": \"Верный ответ 10\", \"question\": \"Задача с одним ответом\"}}, \"2\": {\"some_answer\": {\"correct\": {\"2\": \"Аптека\", \"5\": \"Пальто\"}, \"question\": \"Правильный ответ Пальто и Аптека\", \"incorrect\": {\"1\": \"Ответ 1\", \"3\": \"Андрей\", \"4\": \"Утюг\"}}}, \"3\": {\"subsequence\": {\"answers\": [\"Зоркин\", \"Цулыгин\", \"Панин\", \"Вязовой\", \"Пересильд\"], \"question\": \"Правильная последовательность: Зоркин, Цулыгин, Панин, Вязовой, Пересильд\"}}, \"4\": {\"word\": {\"current\": \"Салават Юлаев\", \"question\": \"Хоккейная команда Уфы\"}}}, \"title_test\": \"Заголовок тестового тестирования\"}', NULL, NULL, 'OFF', NULL, NULL),
(30, 1, 'test', 'Заголовок тестового тестирования №2', '{\"timer\": \"1\", \"content\": {\"1\": {\"word\": {\"current\": \"хоккей\", \"question\": \"Что происходит на льду\"}}}, \"title_test\": \"Заголовок тестового тестирования №2\"}', NULL, NULL, 'OFF', NULL, NULL),
(31, 1, 'test', 'Заголовок тестового тестирования #3', '{\"timer\": \"OFF\", \"content\": {\"1\": {\"one_answer\": {\"answers\": [\"Слово\", \"Логарифм\", \"Константа\"], \"current\": \"Слово\", \"question\": \"Вопрос 1 в 3 тесте Ответ: \\\"Слово\\\"\"}}}, \"title_test\": \"Заголовок тестового тестирования #3\"}', NULL, NULL, 'OFF', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_12_11_135000_create_categories_table', 1),
(4, '2024_12_11_135854_create_courses_table', 1),
(5, '2024_12_11_140522_create_lessons_table', 1),
(6, '2024_12_14_153855_create_users_applications_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','student','author') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `all_courses` json DEFAULT NULL,
  `completed_courses` json DEFAULT NULL,
  `completed_lessons` json DEFAULT NULL,
  `blocked` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `all_courses`, `completed_courses`, `completed_lessons`, `blocked`, `created_at`, `updated_at`) VALUES
(1, 'rori6688', 'rori@mail.ru', 'admin', '$2y$10$DS2pnFw046I.ANpRoIKU3eIw0rN7Z0OykXVInaWxq7KZhFCo3UkMq', NULL, NULL, NULL, '1', '2024-12-11 12:36:25', '2025-05-12 09:34:38'),
(2, 'capricorn', 'capricorn@mail.ru', 'author', '$2a$12$1niF81UCklKbUHQ/o6nhVeHldYRlbOZDJIsV7KmOS5OA51LZFHA/u\n', NULL, NULL, NULL, '0', '2024-12-11 13:33:19', '2024-12-18 04:42:24'),
(3, 'hopecore', 'hopecore@mail.ru', 'author', '$2y$10$UnuudxI6zbBQNnZG4FtCvuSAHccz7bXznhf.N2NvFGeFFe/m4nYYy', NULL, NULL, NULL, '0', '2024-12-11 13:50:40', '2024-12-11 13:50:40'),
(10, 'trapbed', 'trapbed@mail.ru', 'admin', '$2y$10$TBdm0l/L72GdEUlUYhZNm.vJrK6yvOUhX7luV4mTrThPELS9CMimO', NULL, NULL, NULL, '0', '2024-12-13 22:53:42', '2024-12-21 00:54:01'),
(11, 'ivan_d', 'ivan@mail.ru', 'student', '$2y$10$htYI45ZwHj8SbkY8G2cZ6.0Y4ByuJvA6ZiPkDVfAiBseKQ4jufJV6', NULL, NULL, NULL, '1', '2024-12-15 07:01:53', '2025-04-29 04:40:41'),
(12, 'vitaliy', 'vitya@mail.ru', 'author', '$2y$10$Iu.nOQvp.yjYpRTVbdLDaeDmFQY.ua2kjLlOZLJaq3YCVlHqor4bO', NULL, NULL, NULL, '0', '2024-12-16 09:38:51', '2024-12-16 09:38:51'),
(13, 'bob999', 'bob@b.b', 'student', '$2y$10$8jXsKkqVhu7UKgxcMClP0.R9OH.HrYmxVO5O35.u3uviEmM0Oct9q', NULL, NULL, NULL, '0', '2024-12-18 04:48:35', '2024-12-18 04:48:35'),
(14, 'Елизавета', 'elizabet@mail.ru', 'student', '$2y$10$WKMWJMCGY3M5SveZIUx8F.zRziEezjl8j09Y92R4x32GLvrDGa5..', '{\"courses\": [1, 3, 5, 4, 7]}', '{\"courses\": [1, 5]}', NULL, '0', '2024-12-10 13:16:41', '2024-12-20 22:14:07'),
(15, 'normal', 'normal@normal.ru', 'student', '$2y$10$p085l4ZZlGMcGfmZEHRsyOq0TNJVnR04SnSnPrLDYEFcWrX/HMTh6', '{\"courses\": [10, 1, 4]}', '{\"courses\": [\"1\"]}', NULL, '0', '2024-12-21 00:10:57', '2024-12-21 02:30:52'),
(16, 'Ловиви', 'loweve@mail.ru', 'student', '$2y$10$/T8SzNBm8wzNIAbXB.AWcOR0..d24CPo8d6VZxRX.VO1FAErd4RuC', '{\"courses\": [\"1\"]}', '{\"courses\": [1, 1]}', '{\"lessons\": [24, 26, 27, 29, 30]}', '0', '2025-04-08 12:19:41', '2025-05-12 03:29:01'),
(17, 'loweve1', 'loweve1@mail.ru', 'student', '$2y$10$ByQjB7M6w7fp1MAtCRLNyuYBsowB4JyYqpOOv2JuT5KMp9XKvZT2.', '{\"courses\": [\"1\"]}', '{\"courses\": [\"1\"]}', NULL, '0', '2025-04-29 02:53:21', '2025-04-29 03:00:24'),
(18, 'qweqwe', 'qweqwe@mail.ru', 'student', '000', NULL, NULL, NULL, '0', NULL, NULL),
(19, 'lovewe', 'lovewe@mail.ru', 'student', '$2y$10$PPimxj.NERbTIMOt1faXIuMXSXTt5l1SFtSmDJA.5h13JGJm0JFlq', NULL, NULL, NULL, '0', '2025-05-04 09:25:01', '2025-05-04 09:25:01'),
(20, 'Пазиев Саша Игоревич', 'pazalig@gmail.com', 'student', '$2y$10$/sSZK/rXa2vkb1AaFFBrhu5JIDWja3okgf9tiUnTjOwViqjiYnaCy', NULL, NULL, NULL, '0', '2025-05-09 08:59:45', '2025-05-09 08:59:45'),
(21, 'Степанов Алексей Дмитриевич', 'stled@gmail.com', 'student', '$2y$10$1YfUedMpjSxtVs66hPw8U.syN4GeVhy3TtKHW3CyOVjP.D3QT6p1a', NULL, NULL, NULL, '0', '2025-05-09 09:01:19', '2025-05-09 10:16:32'),
(22, 'Китова Дарья Дмириевна', 'dasha@mail.ru', 'student', '$2y$10$pbidMi6HHGc0nemKzGfbheM2o/u5npjKFrBMU0AezBLYq3mnqU/fW', '{\"courses\": [1, 2]}', '{\"courses\": [\"1\"]}', '{\"lessons\": [29, 24, 26, 27, 30, 31, 32, 34]}', '0', '2025-05-12 04:21:12', '2025-05-15 13:58:27'),
(23, 'Лиза45', 'elizabet12@mail.ru', 'student', '$2y$10$3tpGiHWFXtZNGKjqwsKtEu3Rim.8d47yewT9O/39eRQWY7u8ymtOC', '{\"courses\": [\"1\"]}', NULL, '{\"lessons\": [24, 26, 29]}', '0', '2025-05-12 09:39:32', '2025-05-12 09:40:51');

-- --------------------------------------------------------

--
-- Структура таблицы `user_applications`
--

CREATE TABLE `user_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `current_status` enum('student','admin','author') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `status_appl` enum('Отправлена','Принята','Отклонена') COLLATE utf8mb4_unicode_ci NOT NULL,
  `wish_status` enum('admin','author') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_applications`
--

INSERT INTO `user_applications` (`id`, `user_id`, `current_status`, `date`, `status_appl`, `wish_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'student', '2024-12-14 00:00:00', 'Принята', 'admin', NULL, '2024-12-18 04:41:57'),
(2, 2, 'student', '2024-12-14 00:00:00', 'Принята', 'author', NULL, '2024-12-18 04:42:24');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_category_foreign` (`category`),
  ADD KEY `courses_author_foreign` (`author`);

--
-- Индексы таблицы `course_applications`
--
ALTER TABLE `course_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lesson` (`id_lesson`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `lesson_tests`
--
ALTER TABLE `lesson_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lessons_course_id_foreign` (`course_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_applications`
--
ALTER TABLE `user_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_applications_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `course_applications`
--
ALTER TABLE `course_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT для таблицы `lesson_tests`
--
ALTER TABLE `lesson_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `user_applications`
--
ALTER TABLE `user_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_author_foreign` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `courses_category_foreign` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `course_applications`
--
ALTER TABLE `course_applications`
  ADD CONSTRAINT `course_applications_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`id_lesson`) REFERENCES `lesson_tests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `lesson_tests`
--
ALTER TABLE `lesson_tests`
  ADD CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_applications`
--
ALTER TABLE `user_applications`
  ADD CONSTRAINT `user_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

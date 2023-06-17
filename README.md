# keep-moneyApiServer

Figma: https://www.figma.com/file/sAgW6OURRw9U9IE7U37nkX/Untitled?node-id=1%3A784&t=U2GBTKIOlS65i98L-0

## For start enter this commands

# Project start
```
php artisan serve
```
# Project build
```
npm run dev
```
# Nginx refresh
```
sudo /etc/init.d/nginx reload
```

# Banks
```
INSERT INTO `banks` (`id`, `name`, `color`, `text_color`, `created_at`, `updated_at`) VALUES
(1, 'sber', '#00a300', 'white', NULL, NULL),
(2, 'vtb', 'black', 'white', NULL, NULL),
(3, 'alfa', '#ef3124', 'white', NULL, NULL),
(4, 'tinkoff', '#fedd2c', 'black', NULL, NULL);
```

# Categories
```
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Продукты', NULL, NULL),
(2, 'Одежда', NULL, NULL),
(3, 'Спорт', NULL, NULL),
(4, 'Кафе', NULL, NULL),
(5, 'Семья', NULL, NULL),
(6, 'Подарки', NULL, NULL),
(7, 'Образование', NULL, NULL),
(8, 'Дом', NULL, NULL),
(9, 'Досуг', NULL, NULL),
(10, 'Здоровье', NULL, NULL),
(11, 'Транспорт', NULL, NULL),
(12, 'Другое', NULL, NULL);
```


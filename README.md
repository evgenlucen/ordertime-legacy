# Обработка дублей #

## Сделка ##

1. Поиск сделки по deal_id
    1. Сделка найдена - обновить поля
    2. Сделка не найдена:
        1. Поиск контактов по номеру телефона
            1. Не найден
                1. Поиск по email
                    1. Не найден:
                        1. Создать новый контакт
                        2. Создать сделку
                        3. Связать сделку с контактом
                    2. Найден (смотри ниже)
            2. Контакт найден
                1. Получить список открытых сделок контакта
                    1. Если сделки есть 
                       1. это Нулевой Заказ
                          1. Сделка - нулевая? (бюджет = 0)
                             1. Обновить данные сделки
                          2. Сделка ЛМ
                             1. пропустить
                          3. Сделка другая
                             1. добавить тег 
                       2. это ЛМ Заказ
                          1. Сделку нулевая (бюджет = 0)
                             1. пропустить
                          2. Сделка ЛМ
                             1. обновить, добавить тег
                          3. Сделка другая
                             1. пропустить
                       3. это другой заказ
                          1. Сделка Нулевой заказ
                             1. пропустить
                          2. Сделка ЛМ
                             1. пропустить
                          3. Сделка другая
                             1. создать новую
                    2. Если сделок нет
                       1. Создать новую сделку

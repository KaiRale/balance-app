# План реализации (Roadmap)

1. Настройка проекта и окружения: Laravel 12, PostgreSQL, Docker (compose), PHPStan/Pest.
2. Проектирование БД: Миграция для таблицы balance_transactions. Связь с users.
3. Создание базовых моделей и отношений:
   - Модель BalanceTransaction с cast для meta, скоупами для типов.
   - Отношение User::balanceTransactions().
4. Разработка ядра бизнес-логики (Domain/Application):
   - Сервисные классы (Actions/Services): DepositService, WithdrawService, TransferService. Каждый отвечает за одну операцию (S). Инкапсулируют правила (баланс >=0) и работу с транзакциями БД.
   - Исключения (Exceptions): InsufficientFundsException (409 Conflict), UserNotFoundException (404).
5. Создание слоя HTTP:
   - FormRequest'ы для валидации входящих данных.
   - "Тонкие" контроллеры, которые лишь вызывают сервисы и возвращают ответ.
   - JSON-ресурсы для ответов.
6. Тестирование: Пишем Feature-тесты (Pest) для каждого endpoint'а и каждого бизнес-правила (успешные сценарии, ошибки валидации, недостаток средств).
7. Docker-развертывание: Пишем Dockerfile и docker-compose.yml (PHP, Nginx, PostgreSQL, Redis для кэша).
8. Документация и завершение: README.md с инструкцией по запуску, описанием API.

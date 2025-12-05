<!DOCTYPE html>
<html>
<head>
    <title>Test Page</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: #f5f5f5; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
<div class="container">
    <h1>Тестовая страница Laravel</h1>

    <div class="card">
        <h2>Информация о системе:</h2>
        <ul>
            <li>Laravel: {{ app()->version() }}</li>
            <li>PHP: {{ PHP_VERSION }}</li>
            <li>Environment: {{ app()->environment() }}</li>
            <li>Debug: {{ config('app.debug') ? 'Yes' : 'No' }}</li>
        </ul>
    </div>

    <div class="card">
        <h2>Быстрые ссылки:</h2>
        <ul>
            <li><a href="/test">/test (JSON API)</a></li>
            <li><a href="/health">/health (Health Check)</a></li>
            <li><a href="/hello">/hello (Plain text)</a></li>
            <li><a href="/info">/info (System info)</a></li>
            <li><a href="/api/test">/api/test (API version)</a></li>
        </ul>
    </div>

    <div class="card">
        <h2>Тест POST запроса:</h2>
        <form id="testForm">
            <input type="text" name="name" placeholder="Your name" required>
            <textarea name="message" placeholder="Your message"></textarea>
            <button type="submit">Отправить</button>
        </form>
        <div id="result"></div>
    </div>
</div>

<script>
    document.getElementById('testForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);

        try {
            const response = await fetch('/api/test-post', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            document.getElementById('result').innerHTML =
                `<pre class="success">${JSON.stringify(result, null, 2)}</pre>`;
        } catch (error) {
            document.getElementById('result').innerHTML =
                `<pre class="error">Ошибка: ${error.message}</pre>`;
        }
    });
</script>
</body>
</html>

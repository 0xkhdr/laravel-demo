# Tasks — dashboard-auth-articles

| id | role | files | depends-on | verify | acceptance |
|---|---|---|---|---|---|
| T1 | craftsman | `app/Http/Controllers/AuthController.php`<br>`resources/views/auth/login.blade.php`<br>`routes/web.php` | - | curl -s http://127.0.0.1:8000/login \| grep -q "email" | Login page displays form with email/password fields; POST /login accepts credentials |
| T2 | craftsman | `app/Http/Controllers/AuthController.php`<br>`app/Http/Middleware/EnsureAuthenticated.php`<br>`routes/web.php` | T1 | curl -s -X POST -d 'email=test@test.com&password=wrong' http://127.0.0.1:8000/login \| grep -q "Invalid" | Failed login shows error; valid login establishes session |
| T3 | craftsman | `routes/web.php`<br>`app/Http/Middleware/EnsureAuthenticated.php` | T2 | curl -s http://127.0.0.1:8000/articles -H 'Cookie: XSRF-TOKEN=invalid' \| grep -q "401\|redirect" | Unauthenticated requests to /articles redirect to /login |
| T4 | craftsman | `app/Http/Controllers/ArticleDashboardController.php`<br>`resources/views/articles/index.blade.php` | T3 | curl -s http://127.0.0.1:8000/articles -b cookie.txt \| grep -q "article\|New Article" | Authenticated user sees articles dashboard with pagination; logout link present |
| T5 | craftsman | `app/Http/Middleware/ArticleOwnership.php`<br>`app/Http/Controllers/ArticleDashboardController.php` | T4 | curl -s -X DELETE http://127.0.0.1:8000/articles/99999 -b cookie.txt \| grep -q "403\|404" | Users cannot edit/delete articles they don't own |
| T6 | validator | requirements.md<br>design.md<br>tasks.md | T5 | bash -c 'curl -s http://127.0.0.1:8000/login && curl -s -X POST -d "email=demo@test.com&password=password" http://127.0.0.1:8000/login && curl -s http://127.0.0.1:8000/articles | grep -q "article"' | E2E: Login → View Articles → Logout completes successfully |

# Tasks — nothing-portfolio

| id | role | files | depends-on | verify | acceptance |
|---|---|---|---|---|---|
| ✅ T1 | craftsman | resources/css/app.css, resources/views/layouts/app.blade.php, resources/views/components/*, tailwind.config.js | - | printf ok | establish the Nothing-style token set and reusable page shell |
| ✅ T2 | craftsman | app/Http/Controllers/PortfolioController.php, config/portfolio.php, routes/web.php | T1 | printf ok | wire `/` to structured portfolio data from a single source |
| ✅ T3 | craftsman | resources/views/welcome.blade.php, resources/views/components/*, resources/views/sections/* | T2 | printf ok | render hero, about, experience, projects, skills, and contact sections |
| ✅ T4 | craftsman | tests/Feature/PortfolioPageTest.php, tests/Feature/PortfolioSectionsTest.php | T3 | printf ok | cover route rendering, required sections, and core page contract |

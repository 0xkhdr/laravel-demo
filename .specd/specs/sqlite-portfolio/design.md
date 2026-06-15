# Design — SQLite Portfolio and JSON Seeding

## Overview
We will satisfy the requirements by implementing:
1. SQLite Configuration: A SQLite file `database/database.sqlite` will be created if not exists. The default database connection can be configured to use SQLite in the environment configuration (`.env` or PHPUnit setup).
2. Centralized Project Loader Service: Create a service class `App\Services\ProjectLoader` that handles locating, reading, and parsing project JSON files.
3. Seeding logic: Modify `ProjectSeeder` to use `ProjectLoader` to read the JSON file(s) and populate the database.
4. Offline Fallback: Modify `PortfolioController` to handle database exceptions by calling `ProjectLoader`. If `ProjectLoader` also fails (e.g. JSON missing/corrupted), it falls back to the config (`config/portfolio.php`).

## Architecture
We use a simple service pattern to keep seeding and runtime fallback logic DRY:
```
+-------------------------------------------------------------+
|                     PortfolioController                     |
+------------------------------+------------------------------+
                               |
            (Try DB, fall back to JSON / Config)
                               v
+------------------------------+------------------------------+
|                     App\Services\ProjectLoader              |
+------------------------------+------------------------------+
                               |
               (Loads and parses JSON files)
                               v
               [database/data/projects.json]
```

## Components and interfaces
- **`App\Services\ProjectLoader`**:
  - `public function loadProjects(): \Illuminate\Support\Collection`
    - Locates the projects JSON file(s) inside the database directory (e.g., `database/data/projects.json`).
    - Decodes the JSON content into a collection of generic project objects.
    - Validates that essential keys (title, description, technologies) are present in the JSON entries.
    - Throws `RuntimeException` or `FileNotFoundException` on failure.
- **`Database\Seeders\ProjectSeeder`**:
  - `public function run(ProjectLoader $loader): void`
    - Injects `ProjectLoader`.
    - Truncates existing projects and inserts items retrieved from `ProjectLoader::loadProjects()`.
- **`App\Http\Controllers\PortfolioController`**:
  - Tries to fetch all projects via `Project::all()`.
  - On `Exception` (connection error, table missing, etc.), delegates to `ProjectLoader::loadProjects()`.
  - On any `Exception` from `ProjectLoader` (file missing/malformed), falls back to `config('portfolio.fallback_projects')`.

## Data models
- **Database Table (`projects`)**:
  - `id` (primary key)
  - `title` (string)
  - `description` (text)
  - `github_url` (string, nullable)
  - `live_url` (string, nullable)
  - `technologies` (json / array)
- **JSON File Structure (`database/data/projects.json`)**:
  - Root element: JSON array of objects.
  - Object keys: `title` (string), `description` (string), `github_url` (string|null), `live_url` (string|null), `technologies` (array of strings).

## Error handling
- **Database Exception in Controller**:
  - Handled via `try-catch` block inside `PortfolioController@index`.
  - Logs the database failure message and attempts to load from JSON.
- **JSON File Missing / Corrupt**:
  - Inside `ProjectLoader::loadProjects()`, we check if the file exists and is valid JSON.
  - If invalid, throws an exception.
  - Inside the controller, this exception is caught, logged, and we fall back to config settings.
  - Inside the seeder, this exception is bubbled up to abort the seed execution and alert the developer.

## Verification strategy
- **Unit & Integration Tests**:
  - `ProjectLoaderTest`: Verify that `ProjectLoader` correctly reads valid JSON files, throws exception on missing files, and throws exception on malformed JSON.
  - `ProjectSeederTest`: Verify that running the seeder populates the database with the exact projects present in the JSON file.
  - `PortfolioControllerTest`:
    - Case 1: When database is connected and populated, verify database projects are rendered.
    - Case 2: When database is disconnected, verify it reads and renders projects from the JSON file.
    - Case 3: When database is disconnected AND JSON file is missing, verify it renders fallback projects from the config.

## Risks and open questions
- **Risks**:
  - Multi-JSON scaling: If the user requires other sections (e.g. experience, profile metadata) to reside in JSON files, `ProjectLoader` needs to be generic or multiple loader services might be needed.
  - We mitigate this by building a generic loader capability or focusing on a clear, extensible interface for projects first, with the ability to add more files easily.

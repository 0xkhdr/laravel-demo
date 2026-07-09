# Product

## What This Repo Is
This repository is a minimal Laravel demo application.

It currently serves two visible surfaces:
- A default web landing page at `/`.
- An API route at `/api/users` for listing users.

The codebase is intentionally small and test-driven. Most of the functional
signal lives in the route definitions, model/factory/seeders, and Pest tests.

## Product Goal
Keep the demo app easy to run, easy to understand, and easy to extend without
introducing unnecessary architecture.

The main product value is reliability of the Laravel baseline:
- predictable local development with Docker
- clear route and model behavior
- tests that describe the expected user API behavior

## Current Scope
The current project scope is narrow:
- user listing behavior
- default Laravel welcome page
- database factories and seeders for test data
- containerized local execution

## Non-Goals
Do not treat this repository like a place for broad platform work.
Avoid:
- adding unrelated domains or services
- introducing complex abstractions before the behavior exists
- changing project structure without a concrete need

## Current Repo Gap
`routes/api.php` points at `App\Http\Controllers\Api\UserController`, but that
controller is not present in the tree right now. Treat that as an explicit repo
gap when working on API behavior.

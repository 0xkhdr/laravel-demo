# Reasoning

## Default Approach
Prefer the smallest change that makes the behavior correct and testable.

When making a decision:
- verify the existing code before assuming intent
- follow Laravel conventions unless the repo already does something different
- preserve the current folder layout unless there is a clear reason to change it

## Evidence Over Guessing
Use the repository as the source of truth:
- routes define intended entry points
- tests define expected behavior
- models, factories, and seeders define data shape
- Docker and Makefile define local execution

If a file is missing or a route references a missing class, treat that as a real
implementation gap, not as something to paper over in prose.

## Change Strategy
Work in the narrowest possible scope:
- prefer targeted edits over refactors
- keep public behavior stable unless the task explicitly changes it
- add or update tests with the behavior change

## Verification Mindset
Do not rely on reasoning alone.
When behavior changes, verify with the smallest useful test slice first, then run
broader checks if needed.

## Failure Handling
If a check fails, use the exact failure output to guide the fix.
Do not retry blindly or make speculative changes that widen the diff.

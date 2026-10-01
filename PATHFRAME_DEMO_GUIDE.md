# Pathframe Laravel Demo

## Purpose

This Laravel project is a small, disposable test subject for evaluating Pathframe with a coding agent. It is not a production feature backlog.

The evaluation asks whether Pathframe helps an agent:

- understand the current project and next legal action;
- plan small and multi-step changes;
- keep task scope, required reads, checks, and acceptance criteria visible;
- recover cleanly from interruption, failed checks, or requested changes;
- report useful workflow evidence without adding distracting ceremony.

Existing project guidance is in [`BUILD_PROMPT.md`](BUILD_PROMPT.md). The application is intentionally small: users, a web route, an API route, migrations, seeders, and focused tests.

## Files in this evaluation

- [`PATHFRAME_CHANGE_PROMPTS.md`](PATHFRAME_CHANGE_PROMPTS.md): ordered basic and advanced change prompts. Every change starts with a copy-ready prompt.
- [`PATHFRAME_OBSERVATIONS.md`](PATHFRAME_OBSERVATIONS.md): evidence log, rating rubric, and a mock completed entry.
- `.pathframe/`: Pathframe’s generated workflow state. Do not edit it manually or delete it to recover a workflow.

## Agent instructions

When the user asks you to run one of the changes:

1. Read this file, the selected change prompt, `BUILD_PROMPT.md`, and the relevant application files named by the prompt.
2. Confirm the repository is clean enough to identify your own changes. Preserve unrelated user changes.
3. Check Pathframe orientation:

   ```sh
   pathframe status
   pathframe status --json
   ```

4. Create or resume the selected Pathframe change. For a new change:

   ```sh
   pathframe new --change <change-id> --mode quick|standard|high-risk
   pathframe template --mode <mode> --artifact intent
   pathframe template --mode <mode> --artifact task
   ```

   Fill the generated artifacts in `.pathframe/changes/<change-id>/` using the repository-specific facts. Do not invent files, requirements, or test results.

5. Validate and obtain explicit approval before implementation:

   ```sh
   pathframe check --change <change-id>
   pathframe approve --change <change-id>
   pathframe next --change <change-id>
   ```

6. Work only on the selected ready task. Prefer the smallest existing Laravel convention that satisfies the prompt. Do not start later tasks early.
7. Run the task’s approved verification commands and record exact commands, outcomes, and relevant output. Use Pathframe verification when the task contract defines it:

   ```sh
   pathframe verify --change <change-id> --task <task-id> \
     --timeout-ms 120000 --workdir . --max-bytes 200000 \
     --changed-files <comma-separated-project-relative-files>
   ```

8. Make a separate semantic decision after verification:

   ```sh
   pathframe accept-task --change <change-id> --task <task-id> \
     --reason "<why the implementation meets the approved objective>"
   ```

   If it does not meet the objective, use `request-changes` instead. Never accept a task merely because tests pass.
9. Add an observation entry to [`PATHFRAME_OBSERVATIONS.md`](PATHFRAME_OBSERVATIONS.md) before ending the session. Record facts first, then interpretation.

## What to observe

Observe the agent’s workflow, not only the Laravel result:

- Orientation: Did `status` expose the right next action and blockers?
- Planning: Were required reads, write scope, dependencies, and checks useful?
- Native feel: Did the commands and artifacts fit the agent’s normal workflow?
- Friction: Which repeated commands, context limits, approvals, or state transitions added overhead?
- Recovery: Could the agent resume, retry, request changes, or replan without losing evidence?
- Result quality: Did the contract prevent scope drift or make failures easier to diagnose?

Do not claim Pathframe caused a behavior unless the session evidence supports it. Separate:

- `Observed`: directly seen in command output, agent message, or file diff.
- `Interpretation`: likely meaning of the observation.
- `Recommendation`: a proposed workflow or product improvement.

## Stop conditions

Stop after the selected task is accepted, or when a real blocker requires human action. Do not silently broaden a prompt, modify Pathframe itself, delete `.pathframe/`, or turn a demo observation into a product requirement.

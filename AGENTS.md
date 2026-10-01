# Pathframe Laravel Demo

This Laravel project is a small, disposable test subject for evaluating Pathframe with a coding agent. It is not a production feature backlog.

Evaluate whether Pathframe helps an agent:

- understand the project and next legal action;
- plan small and multi-step changes;
- keep scope, context, checks, and acceptance visible;
- recover from interruption, failed checks, and requested changes;
- report useful evidence without distracting ceremony.

Existing Laravel guidance is in [`BUILD_PROMPT.md`](BUILD_PROMPT.md). The application is intentionally small: users, routes, migrations, seeders, and focused tests.

## Evaluation files

- [`PATHFRAME_CHANGE_PROMPTS.md`](PATHFRAME_CHANGE_PROMPTS.md): ordered basic and advanced prompts.
- [`observations/README.md`](observations/README.md): observation rules, ratings, and the per-record template.
- `observations/<record-id>.md`: one record per coding-agent session.
- `.pathframe/`: Pathframe workflow state. Never edit it manually or delete it to recover.

## Required workflow

When asked to run a change:

1. Read this file, the selected prompt, `BUILD_PROMPT.md`, and the prompt’s relevant application files.
2. Preserve unrelated user changes.
3. Orient:

   ```sh
   pathframe status
   pathframe status --json
   ```

4. For a new change, create and fill the Pathframe artifacts:

   ```sh
   pathframe new --change <change-id> --mode quick|standard|high-risk
   pathframe template --mode <mode> --artifact intent
   pathframe template --mode <mode> --artifact task
   ```

   Fill `.pathframe/changes/<change-id>/` from repository facts. Do not invent requirements or results.

5. Validate and obtain approval before editing code:

   ```sh
   pathframe check --change <change-id>
   pathframe approve --change <change-id>
   pathframe next --change <change-id>
   ```

6. Work only on the selected ready task. Reuse existing Laravel conventions and avoid speculative abstractions.
7. Run the approved checks. If the task defines Pathframe verification, use:

   ```sh
   pathframe verify --change <change-id> --task <task-id> \
     --timeout-ms 120000 --workdir . --max-bytes 200000 \
     --changed-files <comma-separated-project-relative-files>
   ```

8. Semantically accept only after verification and review:

   ```sh
   pathframe accept-task --change <change-id> --task <task-id> \
     --reason "<why the implementation meets the approved objective>"
   ```

   Use `request-changes` when the objective is not met. Passing tests alone is not acceptance.
9. Before ending, create exactly one new Markdown record under `observations/`, using a stable filename such as `001-demo-health-endpoint.md`. Never append sessions to another record.

## Observation method

Observe the agent workflow, not only the Laravel result:

- orientation: next action and blockers from `status`;
- planning: usefulness of reads, scope, dependencies, checks, and approval;
- native feel: fit with the agent’s normal workflow;
- friction: repeated commands, context limits, approvals, and state transitions;
- recovery: resume, retry, request changes, or replan without losing evidence;
- result quality: scope control and failure diagnosis.

In each record, separate:

- `Observed`: directly seen in command output, messages, or the diff;
- `Interpretation`: what the evidence likely means;
- `Recommendation`: a proposed workflow or product improvement.

Use the template and rating rubric in [`observations/README.md`](observations/README.md). Record exact commands and concise supporting output, mark missing evidence `unknown`, and never store secrets or private data. The mock file in that directory is not evaluation evidence.

Stop after acceptance or a real blocker requiring human action. Do not broaden the prompt, modify Pathframe, delete `.pathframe/`, or turn one observation into a product requirement.

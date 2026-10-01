---
name: pathframe
description: Use Pathframe when explicitly requested or when continuing an active Pathframe workflow; offer it once for multi-step, durable, agreement-sensitive, or risky development work; never activate it for explanations, read-only review, brainstorming, trivial isolated edits, non-development operations, or explicit direct execution.
---

# Pathframe planning

Use only the typed `pathframe_*` MCP tools. Never construct Pathframe CLI commands.

1. Call `pathframe_orient` when Pathframe is explicitly requested or a workflow may already be active.
2. Brain classifies request facts, then calls `pathframe_assess_request`. Pathframe applies the deterministic activation rules.
3. For `must_use`, continue. For `offer`, ask once and wait. For `must_not_use`, proceed directly without Pathframe.
4. Create a change with `pathframe_create_change` and use `pathframe_get_template` for each required artifact. Brain authors the content; Pathframe validates it.
5. Call `pathframe_validate_plan` with `human_approved: false`. Fix all reported issues.
6. Ask the human to approve the validated plan explicitly. Only after approval, call the same tool with `human_approved: true`.
7. Call `pathframe_get_next` to resume or identify the next legal action. For a ready delegated task, call `pathframe_prepare_delegation` with `host: codex`. Only after its preflight succeeds and returns a lease, launch one native subagent using the packet and Pinky rules. Submit its exact structured result with `pathframe_submit_result`.
8. After a completed submission, call `pathframe_run_verification` with a project-relative workdir and positive timeout. Treat Pinky's verification report as supplemental. Brain then calls `pathframe_accept_task` with its semantic reason, or `pathframe_request_changes` with corrective reason. Scope violations require an explicit keep, revert, or replan decision.
9. Before Brain edits, call `pathframe_check_brain_edit` and obey it. Delegation failure never authorizes Brain fallback. Treat write scope as advisory unless the packet says `host_enforced`.
10. Call `pathframe_doctor` for typed diagnosis and listed safe repairs. Use `pathframe_recover` for pause, resume, replan, or cancel.

Pathframe never launches the host worker itself. Pinky may implement only the leased task and may only submit a result. Pinky cannot verify for Pathframe, approve itself, or alter plan state. Do not invent parallel, expanded Doctor, or compatibility operations.

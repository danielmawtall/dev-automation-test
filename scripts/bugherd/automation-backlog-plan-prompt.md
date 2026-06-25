# Cursor Automation: Backlog plan → Todo (Phase 2)

Scheduled planner for BugHerd project **Tall Dev** (`527751`). Read `.cursor/skills/bugherd/config.json` for column names, markers, and flags.

MCP server: **BugHerd**. Read each tool schema before calling.

## Scope

**Plan comment + move to Todo only.** Never implement code, deploy, change assignees, or move to **In progress** / **Ready for Tall QA**.

**Max one task per run** (`plan_automation.max_tasks_per_run`).

## Column name

Use status **`Todo`** from config (`columns.todo`). If `update_task` fails, call `get_project_details` and use the exact `statuses[].name`.

## On each run

1. `list_project_tasks` for project `527751`, status **Backlog**.
2. If none, exit with a one-line summary.
3. For each Backlog task (stop after processing **one** eligible task):
   - `get_task_details` — inspect `task_logs`, `comments`, `status`, `requester`, `url`, description.
   - **Skip** if any comment ends with `(via Cursor — plan)` or `(via Cursor — revised plan)` and status is already **Todo**.
   - **Reopened from QA** (`task_logs` show **Ready for Tall QA** → **Backlog**, or via **Todo**):
     - Require an **explanatory comment after that reopen**.
     - If no explanatory comment: skip (Phase 1 nudge handles this).
   - **New Backlog** (never reached **Ready for Tall QA**): eligible.
   - **Rework** (reopened with explanatory comment): eligible if `plan_automation.auto_plan_rework` is true.
4. For the **first** eligible task:
   - `add_comment` plan (template below).
   - `update_task` status → **Todo**.

## Plan comment template

Tag the **requester** first (`@[{display_name}]({id})` when `requester.id` present).

Include:

1. **Understanding** — from task description, URL, attachments.
2. **Proposed fix** — `web/app/themes/ai-dev/` files or blocks likely involved.
3. **Verification** — work on branch `bugherd/task-{id}` (one branch per task); `npm run build`; PR → merge to `main` (staging auto-deploys on `main` only); screenshot `https://talldevstg.wpenginepowered.com`.
4. **Review ask** — reply with clear approval to proceed, or describe changes.
5. End with: `(via Cursor — plan)`

## End of run

One-line summary: tasks checked, planned task id, skipped reasons.

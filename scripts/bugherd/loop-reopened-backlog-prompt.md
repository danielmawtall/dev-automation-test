# Loop tick: reopened Backlog comment gate

Use with `/loop 10m` and the [loop skill](file:///Users/danielmaw/.cursor/skills-cursor/loop/SKILL.md). Optional JSON: `{ "task_id": "12" }` to watch one task only.

Follow [automation-reopened-backlog-prompt.md](./automation-reopened-backlog-prompt.md) for BugHerd logic (project `527751`, 10-minute nudge, duplicate-nudge guard, skip new tickets, comments only).

## Loop-specific

- If `task_id` is set, only `get_task_details` for that task.
- If under 10 minutes with no issue comment: report "still waiting for issue comment".
- If explanatory comment exists: report task is ready for rework; user may stop the loop.

Scheduled runs use [automation.md](../../.cursor/skills/bugherd/automation.md) instead.

# BugHerd automation phases (Tall Dev)

## Phase 1 - Active: reopened Backlog nudge

**Status:** enable in Cursor Automations.

| | |
|--|--|
| **Goal** | QA returns a ticket to Backlog without an issue comment → requester gets one nudge after 10 minutes |
| **Workflow** | `.cursor/automations/tall-dev-reopened-backlog.yaml` |
| **Prompt** | `scripts/bugherd/automation-reopened-backlog-prompt.md` |
| **Setup** | [automation.md](automation.md) |

**Does not:** fix code, deploy, change status (except comments), plan, or move to Todo.

---

## Phase 2 - Active: Backlog plan → Todo

**Status:** enable after Phase 1 is stable.

| | |
|--|--|
| **Goal** | Eligible Backlog task gets agent plan comment → **Todo** for team review |
| **Workflow** | `.cursor/automations/tall-dev-backlog-plan.yaml` |
| **Prompt** | `scripts/bugherd/automation-backlog-plan-prompt.md` |

**Does not:** implement code, deploy, In progress, QA handoff.

---

## Phase 3 - Active: Todo semantic review → implement

**Status:** enable when BugHerd MCP + repo workspace work in automation runtime.

| | |
|--|--|
| **Goal** | Read latest human comment after plan; approve → full skill lifecycle |
| **Workflow** | `.cursor/automations/tall-dev-todo-implement.yaml` |
| **Prompt** | `scripts/bugherd/automation-todo-implement-prompt.md` |

**Rollout:** `implement_automation.dry_run: true` in [config.json](config.json) until classification is verified.

---

## Phase 4 - Staged: notifications (optional)

Slack or similar when **Todo** has tasks awaiting review.

---

## Webhooks (optional upgrade)

Cron is the default. See [scripts/bugherd/webhook-setup.md](../../../scripts/bugherd/webhook-setup.md).

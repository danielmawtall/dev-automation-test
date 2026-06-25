# BugHerd webhooks → Cursor Automations (optional)

Phase 2 and Phase 3 ship with **cron** (`*/10 * * * *`). Use this when you want near real-time runs.

## Prerequisites

- Automations saved in Cursor with webhook trigger (optional, alongside cron).
- BugHerd API key from account settings.
- Cursor automation webhook URL and auth secret (from Automations editor after save).

## BugHerd events

```http
POST https://www.bugherd.com/api_v2/webhooks.json
```

New tasks (Phase 2 plan):

```json
{
  "project_id": 527751,
  "target_url": "https://YOUR_CURSOR_AUTOMATION_WEBHOOK_URL",
  "event": "task_create"
}
```

Comments (Phase 3 implement):

```json
{
  "project_id": 527751,
  "target_url": "https://YOUR_CURSOR_IMPLEMENT_AUTOMATION_WEBHOOK_URL",
  "event": "comment"
}
```

Reference: [BugHerd API v2](https://docs.bugherd.com/api).

## Cursor prompt addition

If the trigger payload includes a task id, call `get_task_details` for that task only; otherwise list the column as usual.

## Security

Do not commit webhook URLs or API keys to the repo.

# Progress Log

Date: 2026-02-08

## Current Sprint
- **Sprint**: 2 (Enquiries)
- **Status**: Completed
- **Next Task**: Assessment Flow & Case Notes implementation.

## Accomplishments
### Sprint 1: Foundations (Enquiry)
- [x] Defined `Enquiry` model and migration with core attributes (category, narrative, risk, advice, referral, staff ownership).
- [x] Created `EnquiryCategory` backed enum with color/icon support.
- [x] Implemented `EnquiryPolicy` with Jetstream team role and record ownership checks.
- [x] Added `HasTeam` and `HasCreator` traits to the `Enquiry` model for tenancy and audit support.

### Sprint 2: Enquiries (Resource)
- [x] Implemented `EnquiryResource` with modular schema structure.
- [x] Created comprehensive form with caller identification (create/link `People`), enquiry details, and actions.
- [x] Established table with badge-based categorization, staff sorting, and status icon filters.
- [x] Added `EnquiryInfolist` for standardized viewing of logged enquiries.
- [x] Verified implementation with 17 Pest tests (rendering, validation, creation, and authorization).
- [x] **[Conversion Flow]** Implemented "Promote to Service User" action with modal form for consent and initial assessment.
- [x] **[Seeding Fix]** Resolved SQL `sort_order` error by ensuring integer indexes in `ServiceUserCustomFieldSeeder` and `CreateTeamCustomFields` listener.
- [x] Verified full lifecycle from Enquiry logging to Service User promotion with tests.

## Decisions
| Date | Decision | Rationale | Owner |
| --- | --- | --- | --- |
| 2026-02-08 | Phase 1 MVP defined in `docs/phase-1-handoff.md` | Aligns to brief and weekly sprints | Product |
| 2026-02-08 | Used modular schemas for `EnquiryResource` | Improved maintainability and clarity for complex forms/tables | Antigravity |
| 2026-02-08 | Proposed explicit `EnquiryStatus` and Service User fields for `People` | Ensures compliance with handoff requirements for consent and case management | Antigravity |
| 2026-02-08 | Use `array_values()` in `CreateTeamCustomFields` listener | Resolves package bug where string keys were intermittently used as `sort_order` for custom field options. | Antigravity |

## Risks and Blockers
- **Pending**: Automated high-risk notifications for safeguarding team.

## Notes
- `EnquiryPolicy` uses strict authorization mode, requiring comprehensive ability mapping (e.g., `deleteAny`).
- Filament v4 `Toggle` component uses `onColor()` instead of `color()`.
- Seeding robustness improved by forcing numeric keys for Choice custom field options.

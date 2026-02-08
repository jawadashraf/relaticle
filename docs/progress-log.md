# Progress Log

Date: 2026-02-08

## Current Sprint
- **Sprint**: 2 (Enquiries)
- **Status**: In Progress
- **Owner**: Antigravity

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

## Decisions
| Date | Decision | Rationale | Owner |
| --- | --- | --- | --- |
| 2026-02-05 | Phase 1 MVP defined in `docs/phase-1-handoff.md` | Aligns to brief and weekly sprints | Product |
| 2026-02-08 | Used modular schemas for `EnquiryResource` | Improved maintainability and clarity for complex forms/tables | Antigravity |

## Risks and Blockers
- **Pending**: Conversion flow from Enquiry to Service User (People) needs implementation.
- **Pending**: Automated high-risk notifications for safeguarding team.

## Notes
- `EnquiryPolicy` uses strict authorization mode, requiring comprehensive ability mapping (e.g., `deleteAny`).
- Filament v4 `Toggle` component uses `onColor()` instead of `color()`.

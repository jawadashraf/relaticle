# Blueprint: Enquiry to Service User Conversion Flow (v2 - Refined)

## Overview
This blueprint outlines the implementation of the "Conversion to Service User" flow. Based on a deep-dive into the project architecture, we will leverage the `Relaticle\CustomFields` system for Case File metadata while using core columns for critical indexing and status tracking.

## 1. Database & Schema Updates

### Enums
- **`App\Enums\EnquiryStatus`**: `OPEN`, `CONVERTED`, `CLOSED`.
- **`App\Enums\ServiceTeam`**: `ASSESSMENT`, `DRUG_ALCOHOL`, etc.
- **`App\Enums\EngagementStatus`**: `ACTIVE`, `PENDING`, etc.

### Core Migrations
- **`add_status_to_enquiries`**:
    - `status` (string, default: 'open')
    - `converted_at` (timestamp, nullable)
- **`add_service_user_flag_to_people`**:
    - `is_service_user` (boolean, default: false) - *Crucial for global scoping and high-performance filtering.*

### Custom Fields (Infrastructure-driven)
Update `App\Enums\CustomFields\PeopleField` to include the following Service User fields. These will use the `Relaticle\CustomFields` system for storage and rendering:
- `CONSENT_DATA_STORAGE` (toggle)
- `CONSENT_REFERRALS` (toggle)
- `CONSENT_COMMUNICATIONS` (toggle)
- `PRESENTING_ISSUES` (textarea)
- `RISK_SUMMARY` (textarea)
- `FAITH_CULTURAL_SENSITIVITY` (textarea)
- `SERVICE_TEAM` (select)
- `ENGAGEMENT_STATUS` (select)

## 2. Model & Policy Logic

### `Enquiry` Model
- Cast `status` to `EnquiryStatus`.
- Method `canBeConverted()`: Returns true if status is `open` AND `people_id` is present.

### `People` Model
- Global Scope: Consider adding a `ServiceUserScope` or a `isServiceUser()` local scope.
- Integration: Ensure `UsesCustomFields` correctly handles the new constants.

## 3. Filament Resource: `EnquiryResource`

### Table Action: `ConvertToServiceUserAction`
Add a custom action to the table:
- **Requirement**: Only visible if `status == open` and `people_id` exists.
- **Modal Form**:
    - **Consent**: Integrated fields from `PeopleField`.
    - **Initial Assessment**: Integrated fields from `PeopleField`.
    - **Assignment**: Integrated fields from `PeopleField`.
- **Logic**:
    - Set `people.is_service_user = true`.
    - Save Custom Field values to the linked `People` record.
    - Set `enquiry.status = converted`.
    - Set `enquiry.converted_at = now()`.
    - **Toast**: "Enquiry successfully converted to Service User."
    - **Redirect**: Optionally to the People view page.

## 4. Documentation & Verification

### Tests (Pest)
- `it_cannot_convert_unlinked_enquiry`
- `it_sets_is_service_user_flag_on_people`
- `it_stores_custom_field_values_correctly_on_conversion`
- `it_updates_enquiry_promotion_metadata`

### Updates
- [ ] Migration: Enquiry status & People flag.
- [ ] Enum updates: `EnquiryStatus`, `ServiceTeam`, `EngagementStatus`.
- [ ] `PeopleField` expansion.
- [ ] `ConvertToServiceUserAction` implementation.

# Stitch‑Ready UI Brief (Filament v4 Style)

Date: 2026-02-05
Project: Spinney Hill Integrated CRM
Target UI: Filament v4 admin interface (Resource list, View, Edit, Relation Managers)

## 1. Visual Direction
- Look and feel: clean, clinical, high‑contrast but warm; trust and privacy focused.
- Typography: Filament defaults are acceptable.
- Color: calm neutrals, accent color for alerts. Restricted/safeguarding notes must read as high‑priority.
- Components: Filament native patterns (Tables, Forms, Infolists, Widgets, Notification banners).

## 2. Navigation Structure (Filament v4)
**Navigation Groups**
- Front Door
- Service Users
- Appointments
- Aftercare
- Directories
- Safeguarding
- Reporting
- Admin

**Resources**
- Enquiries
- Service Users
- Notes
- Appointments
- Engagement Logs
- Safeguarding Flags
- Partners (Company directory)
- Education & Outreach (Company directory)
- Donors & Supporters (People directory)
- Donations
- Reports (Page)
- Audit Log (Page)

## 3. Core Screens (Filament Pattern)

### A. Dashboard
Widgets:
- Enquiries Today (count + trend)
- High‑risk Enquiries (count)
- Appointments Today
- Follow‑ups Due
- Donor Contributions This Month

### B. Enquiries
List:
- Columns: Category, Caller, Risk Flag, Status, Handled By, Date/Time
- Filters: Category, Risk Flag, Status, Date Range
Form:
- Caller details, Reason for contact, Risk flags, Advice/action, Referral, Staff handler, Date/Time
Actions:
- Convert to Service User
- Assign to staff

### C. Service Users (People)
List:
- Columns: Name, Consent Status, Risk Level, Assigned Team, Last Contacted
View:
- Tabs: Profile, Case Notes, Appointments, Engagement History, Safeguarding
Form:
- Contact + consent + presenting issues + risk summary

### D. Notes
List:
- Columns: Title, Service User, Note Type, Visibility, Author, Created At
Form:
- Title, Body, Service Type, Note Type, Visibility
Behavior:
- Restricted notes only visible to Safeguarding Leads

### E. Appointments
List:
- Columns: Service User, Type, Assigned To, Starts At, Status
Calendar:
- Month/Week/Day view (FullCalendar or Guava)
Form:
- Service User, Type, Staff, Date/Time, Status, Location, Notes
Actions:
- Send email confirmation

### F. Engagement Logs (Aftercare)
List:
- Columns: Service User, Type, Outcome, Next Steps, Staff, Date
Form:
- Type, Outcome, Next Steps, Date/Time, Staff

### G. Safeguarding Flags
List:
- Columns: Service User, Severity, Status, Created By, Created At
Form:
- Severity, Details, Status, Linked Enquiry, Resolution Notes

### H. Directories
Partners:
- Columns: Name, Support Type, Referral Criteria, Contact
Education & Outreach:
- Columns: Organisation, Key Contact, Email, Last Engagement
Donors:
- Columns: Donor Name, Gift Aid Status, Total Donated, Last Donation

### I. Donations
List:
- Columns: Donor, Amount, Gift Aid, Date, Purpose
Form:
- Donor, Amount, Date, Gift Aid, Purpose

### J. Reporting
Pages:
- Enquiry Volume & Types
- Service Uptake & Referrals
- Engagement & Outcomes
- Donations & Gift Aid

## 4. Role‑Based Visibility
- Frontline: Enquiries + Appointments only
- Practitioners: Assigned Service Users + Notes + Appointments
- Safeguarding Leads: All + Restricted Notes + Flags
- Fundraising: Directories + Donations
- Management: Reporting + Read‑only access

## 5. UI Components Expected
- Filament Tables with search, filters, and bulk actions
- Filament Forms with sectioned schemas
- Relation Managers for notes, appointments, engagement logs on Service User
- Widgets for high‑risk counts and follow‑ups
- Notifications for booking confirmations

## 6. Stitch Prompt Guidance
When generating UI, instruct Stitch to:
- Follow Filament v4 UI patterns.
- Emphasize compliance and safeguarding visibility.
- Include clear “restricted note” UI affordance.
- Include “Convert to Service User” action from Enquiry list.

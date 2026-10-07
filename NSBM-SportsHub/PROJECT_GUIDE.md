# SportsHub Project Guide

## Assignment coverage

SportsHub implements the Topic 3 requirements through these modules:

| Requirement | Implementation |
|---|---|
| Admin login | Role-based authentication and admin dashboard |
| Manage sports clubs | Full club CRUD |
| Club membership approvals | Student join request + admin status management |
| Training schedules | Training Session CRUD |
| Matches / fixtures | Match & Fixture CRUD |
| Tournaments | Tournament CRUD + student registration |
| Match scores/results | Match Result CRUD |
| Facility/equipment booking | Student booking CRUD + admin approval |
| Participation/performance reports | Participation CRUD + analytics page |
| Student register/login | Registration and login flows |
| Browse/join clubs | Student club directory + join action |
| View schedules and fixtures | Student read access |
| Register for tournaments | Tournament registration workflow |
| View results and standings data | Results module |
| Track participation | Student-scoped participation history |
| Search/filter | Generic search and status filters across CRUD modules |

## CRUD modules

1. Sports Clubs
2. Club Memberships
3. Training Sessions
4. Matches & Fixtures
5. Tournaments
6. Tournament Registrations
7. Match Results
8. Facility & Equipment Bookings
9. Participation History

## Recommended team division

For a four-person team, a balanced division is:

- **Member 1:** Authentication + Sports Clubs + Memberships
- **Member 2:** Training Sessions + Matches
- **Member 3:** Tournaments + Tournament Registrations + Results
- **Member 4:** Bookings + Participation + Reports / UI polish

All members should still understand the complete database and overall flow for the demonstration.

## Demo checklist

- [ ] Import `schema.sql` and `seed.sql`
- [ ] Login as student
- [ ] Browse clubs and submit join request
- [ ] Create/edit/cancel own booking
- [ ] Register for an open tournament
- [ ] View fixtures, results and participation
- [ ] Login as admin
- [ ] Approve/edit a membership
- [ ] Create/edit/delete a training session
- [ ] Create/edit/delete a match
- [ ] Create/edit/delete a tournament
- [ ] Record a result
- [ ] Review a facility/equipment booking
- [ ] Add a participation record
- [ ] Open analytics/reports
- [ ] Demonstrate responsive/mobile navigation
- [ ] Demonstrate dark/light theme and animations

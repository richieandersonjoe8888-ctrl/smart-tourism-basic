## Order of Doing

1. Complete the auth service

- [x] Create profile table
- [x] Create user table
- [x] Create Registration screen
- [x] Create Login screen
- [x] Create profile edit screen (tourist)
- [x] ~~Create profile edit screen (vendor)~~
- ~~Do jwt token related features (idk what this entails atw)~~
- Implement Laravel Sanctum for API authentication (returns 401 Unauthorized for API routes instead of redirecting to login)
- Vendors are not user (for this system). Vendors belongs to a user. "Vendor" is a status that offers:
  1. Access to vendors' permission
  2. Ability to edit a particular company.
- Vendors can be orphaned
- Therefore, make a vendor-service, where profile edit screen for vendors live. Therefore, it isn't in the scope of the auth service.

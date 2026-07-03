## Order of Doing

1. Complete the auth service

- Create profile table
- Create user table
- Create Registration screen
- Create Login screen
- Create profile edit screen (tourist)
- ~~Create profile edit screen (vendor)~~
- Do jwt token related features (idk what this entails atw)
- Vendors are not user (for this system). Vendors belongs to a user. "Vendor" is a status that offers:
  1. Access to vendors' permission
  2. Ability to edit a particular company.
- Vendors can be orphaned
- Therefore, make a vendor-service, where profile edit screen for vendors live. Therefore, it isn't in the scope of the auth service.

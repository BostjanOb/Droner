# Droner

Drone CI proxy runner

## Plan

- [ ] Sync repos from drone for user
 - [ ] Get repositories and add them to repositories table (only active)
 - [ ] Link repositories to user
 - [ ] Remove repositories from users (if removed)
 
- [ ] CRUD users

- [ ] Repositories
 - [ ] Enabling / Disabling it for builds (generate token)
 - [ ] Get repository info (with the latest build status)

- [ ] Builds
 - [ ] Create new build (with deny - depends on a threshold)
 - [ ] Send build command to drone
 - [ ] Get build info

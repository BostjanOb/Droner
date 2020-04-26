# Droner

Drone CI proxy runner

## Plan

#### Sync Repositories
- [x] Sync repos from drone for user
- [x] Get repositories and add them to repositories table (only active)
- [x] Link repositories to user
- [x] Remove repositories from users (if removed)
 
#### Repositories
- [x] Enabling / Disabling it for builds (generate token)
- [ ] Get repository info (with the latest build status)

#### Builds
- [ ] Create new build (with deny - depends on a threshold)
- [ ] Send build command to drone
- [ ] Get build info

#### Users CRUD
- [ ] CRUD users

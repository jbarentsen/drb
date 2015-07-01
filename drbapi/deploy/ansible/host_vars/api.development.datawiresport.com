---
# configuration for staging server

vm: 0
env: staging
users:
    - root
hostname: api.development.datawiresport.com
common_libs:
    - vim
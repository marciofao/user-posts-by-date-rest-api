# User Posts by date - rest API endpoint
A simple plugin for visualizing userd posts amouunt by date range

The plugin works by enabling the following endpoint in your wordpress instance:

/wp-json/users/v1/user-listing?range=20230101-20233101

where

range=[start date]-[end date]
using date format: yyyymmdd

Results are returned as Json like this following example:

```
[
 {
  "id": "1",
  "email": "user@example.com",
  "posts": 2
 },
 {
 "id": "2",
 "email": "user2@example.com",
 "posts": 3
 }
]
`


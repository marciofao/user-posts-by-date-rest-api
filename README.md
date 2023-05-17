# User Posts by date - rest API endpoint
A simple plugin for visualizing userd posts amount by date range

The plugin works by enabling the following endpoint in your wordpress instance:

/wp-json/users/v1/user-listing?range=20230101-20231231

usage:

```range=[start date]-[end date]```

uses date format: yyyymmdd

Results are returned as a Json response:

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
```

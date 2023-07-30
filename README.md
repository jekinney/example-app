## Simple message board with comments

* A user must have an account and logged in to see messages
* Any authenticated user can post a message and comment on messages
* The author of a message or comment can edit or remove their posts
* This is a crud application, but probably better of with a better work flow if not used in a test scenario. In-line editing and not having create/edit pages, but it gets the point across
* Factories and seeder is set up. If you run ```artisan db:seed``` you will get ten messages with 5 comments. All with there own user for testing and verification.
* This was developed with WSL, Docker and Laravel Sail for local development.
* Mail is sent to all users except the author of the message or comment when a new message/comment is created. This scope for a production server would need to be narrowed but it was a requirement for the test
* Using Breeze and Tailwind css for UI and authentication
* Model Policies are set and routes use auth middle ware for the basics The policies ensure author is the only one who can update or delete their own meessage /comment


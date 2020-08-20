# No-Polls API
This is the Lumen backend for No-Polls. It is not required, as No-Polls will use the public backend on my server located at: [api-no-polls.noahdhollowell.co.uk](https://api-no-polls.noahdhollowell.co.uk)  

> View the [frontend](https://github.com/NoahNok/No-Polls)

## Installation
1. Clone the repo
2. Run **composer install**
3. Configure your webserver to redirect all requests to public/index.php
4. Clone the .env example and configure for yourself
5. Use the included SQL file to initialise your database **DO NOT** use Lumens migration as it will result in errors!

## Public API Abuse
Abusing the public API will result in an IP Ban. If constant abuse is recieved I will take down the public API and list it as private requiring access keys to use (a future commit will add this)

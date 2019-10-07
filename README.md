# Trip Application Installation Guide

1) Install dependencies :  
`composer install`

2) Copy .env.example into a new .env file: 
    - Set the database environment variables

3) Create databases (<db_name> as local and `testing_db` as testing) manually or automatically:  
`php artisan db:create <db_name>`

4) Migrate and seed database(s):  
`php artisan migrate --seed`  
`php artisan migrate --database=testing`

5) (Optional) Run all the tests to make sure everything is good to go:  
`vendor/bin/phpunit`

6) Run the following commands (in the root directory of the app):
    
    - Enroll an agency into a rewards program:  
    `php artisan tet:enroll-agency <agency_id> <rewards_program_id>`
    
    - See all enrollments:  
    `php artisan tet:show-enrollments`    
    
    - Calculate all monthly service excellence rewards of enrolled agencies in a specific year/month:  
    `php artisan tet:calculate-service-excellence-rewards <year> <month>`
    
    - Calculate all annual booking goal rewards of enrolled agencies in a specific year:  
    `php artisan tet:calculate-booking-goal-rewards <year>`

<p align="center">#TOMS (Traffic Order Management System) </p>

### About TOMS

TOMS is an application that aims to help manage or organize HEB traffic order replacing the old way which is the use of google spreadsheet

####Version 1.0 Features
- Attaching Order form using gravity API from humaneyeballs.com
- Easy search and filter orders
- Organized priority and order status
- User login, registration, reset password and logging order changes.
- Organized notes

####Version 1.2 Upcomming Feature
- Handling concurrent order edit and realtime list update

####Vesion 2.0 Upcomming Feature
- Automated creation of order using Authorize.net and Paypal API

### Installation
- composer update
- php artisan key:generate
- setup database, mail and gravity configuration in .env file
- php aritsan migrate
- php artisan db:seed

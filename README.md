This is my e-commerce website built with PHP and CodeIgniter 3. This is my capstone project for Village 88 and is a work in progress. Front-end designed by Jhaver Gurtiza.

See below a screenshot of my ERD for the database used for this ecommerce website:
![My database ERD for the ecommerce web app](/resources/ERD_10.png)

Navigating to the homepage of this website will first bring the guest user to the homepage - a dashboard or catalog showcasing the products. This view would be slightly different if a user has signed in, and if the signed-in user is an admin, they will instead be taken to the admin dashboard.

An overview of each page and corresponding URLs:
* /login - login page - if validation of user input passes, this function will create a user session with this user's account
    * if user is signed in: will redirect to the catalog
    * if admin is signed in: will redirect to admin dashboard
* /signup - signup page - if validation of user input passes, this function will add a new user to the Users table in the database
    * if user is signed in: will redirect to the catalog
    * if admin is signed in: will redirect to admin dashboard

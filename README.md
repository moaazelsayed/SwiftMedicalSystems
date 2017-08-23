Entry point -> http://elsayedm.myweb.cs.uwindsor.ca/60334/project/html/index.html

# Swift Medical Systems
Swift Medical Systems is an industry leader in Hospital Management Systems. Our system provides a full solution for managing patients, nurses, doctors, departments, and different hospital related equipment. Join us to find out more.

## Login
* Start session
* Automatic redirection depending on user account

## Signup
* Automatic dynamic password checking & confirmation checking 
* Doctor department signup
* Password hashing and session start/session login
* Automatic redirection depending on user account

## Logout
* Destroys session variables and session
* Redirection to login page

## Admin
* Pull current user info from session (ie displays name and other info)
* Dynamic loading of user profiles
* Dynamic Pie chart representing users
* Clicking on different user types in pie legend temproraly hides them and displays new pie chart
* Dynamic table created from user profiles
* Search box queries based on first name, last name, user type and email
* Clicking on header of each column sorts column by ascending or descending order
* Dynamic page reference based on amount of enteries and number of entries per page

### TESTING: 
* Create new user or use: `user: elsayedmoaaz@gmail.com` and `pass: password`

## Patient
* Dynamically load all doctor names into array for choosing while booking appointment
* Book appointment through dashboard

### TESTING: 
* Create new user or use: `user: elsayedm@uwindsor.ca` and `pass: password`

## Doctor
* Dynamic table created from patient appointments
* Search box queries based on patient email, doctor email, appointment date and time, appointment reason and appointment id
* Clicking on header of each column sorts column by ascending or descending order
* Dynamic page reference based on amount of enteries and number of entries per page

### TESTING: 
* Create new user or use: `user: jsmith@gmail.com` and `pass: password`

## Nurse
* Dynamic table created from patient appointments
* Search box queries based on patient email, doctor email, appointment date and time, appointment reason and appointment id
* Clicking on header of each column sorts column by ascending or descending order
* Dynamic page reference based on amount of enteries and number of entries per page

### TESTING: 
* Create new user or use: `user: sfisher@gmail.com` and `pass: password`
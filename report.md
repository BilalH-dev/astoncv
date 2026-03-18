# DG1IAD Portfolio 3 Report

## Name: Bilal Haq  
## Student ID Number: 250227688

## Basic information
- **Website URL:** http://250227688.cs2410-web01pvm.aston.ac.uk/
- **Source code link (optional):** https://github.com/BilalH-dev/astoncv/
- **One registered user account:** 
    - **Username/Email address:** ```james.walker@example.com```
    - **Password:** ```Ast0nC7!123```

## Brief Description of Technologies and Structure 
I have used vanilla PHP (server-side), as well as HTML and CSS (client-side) to develop AstonCV. I have chosen to use the Bootstrap CSS framework since it provides a responsive and user-friendly interface, allowing me to focus on the development of the backend. This has allowed me to implement features such as a dynamic header - users will see account-related features whilst visitors are presented with links to login and register.

Whilst the system does not use a full Model View Controller (MVC) or an object-oriented approach, the final solution separates database access, PHP logic and output. Database connections and interactions are handled in a separate file, while logic and output are combined within the corresponding page.

## Implementation of the required functions
### Functional Requirements for visitors 
| Functions                                                                  | Main Source File(s) | Working (yes/no) | Notes |
|----------------------------------------------------------------------------|---------------------|------------------|-------|
| **P1.** View the basic information of all CVS                                  | index.php       | Yes              |       |
| **P2.** Click one CV in the list to view the CV details                        | index.php <br> viewcv.php | Yes        |       |
| **P3.** Search all CVs using first name, last name or key programming language | index.php       | Yes              |       |
| **P4.** Register to become a registered user                                   | register.php    | Yes              |       | 

### Functional Requirements for registered users
| Functions                                              | Main Source File(s) | Working (yes/no) | Notes |
|--------------------------------------------------------|---------------------|------------------|-------|
| **R1.** Log into the system                            | login.php           | Yes              |       |
| **R2.** Edit/Update their CV by inputting more details | editcv.php          | Yes              |       |
| **R3.** Log out of the system                          | logout.php          | Yes              |       |

## Security Measures
| Features | Main Source File(s) | Notes |
|----------|---------------------|-------|
| Authentication | login.php     |       |
| Authorisation  | mycv.php <br> editcv.php | Visitors (users not logged into an account) are redirected to login.php to log into their account when attempting to access pages accessible only to registered users. Additionally, the userid is stored in the current session (after authentication) to ensure that logged in users can only view and edit their own CV. |
| Form Validation | login.php <br> register.php <br> editcv.php | Form validation has been implemented both client-side (HTML) and server-side.|
| Prepared SQL statements | *Database queries - implemented using PDO* | Prepared SQL statements have been used for a variety of functions, such as searching CVs and inserting new data. |
| HTML sanitisation | index.php <br> viewcv.php <br> mycv.php | If a user has put HTML elements in any part of their profile, they have no effect on the website (i.e. they will be displayed in plain text). |
| Storing hashed passwords | register.php <br> login.php <br> Database | When the user creates their account, the PHP script which handles validation and account creation will hash their password before storing it into the database. Upon login, the inputted password is compared against the hashed password. |
| Cross-Site Request Forgery (CSRF) | register.php <br> login.php <br> editcv.php | CSRF fields have been used on pages with forms to avoid unauthorised requests (particularly from outside of the website). |

# BARTA APP PROJECT

The Barta app I'm developing is a social networking app.



# Developing step-by-step
**In the first week, I implemented the following features:**

 - User registration 
 - User login 
 - User profile view 
 - User profile update

**In the second week, I implemented the following features:**

 - Post create
 - Post update (by author)
 - Post delete (by author)
 - Show all post in home page 
 - Show post in profile page (specific users posts)

## Important notes

**I used the following the first week**

 - Laravel has been installed
 - Configured the environment (.env)
 - setup template from view directory
 - run database migration (***users***)
 - defined logic in the controller
 - made form request for validation
 - used view composer 
 - used AppServiceProvider for compos class
 - defined routes
 - changed default timezone UTC to Asia/Dhaka 

**I used the following the second week**

 - Remove composer view
 - run database migration (***posts***)
 - create form request for post validation
 - Changed main route from '/home' to '/' in RouteServiceProvider 
 - Used resource controller for posts
 - Used X time ago library (***nesbot/carbon***)
 - Used middlewares (**auth, web**)
 - Implement auto-expand text area
 - Showing view count

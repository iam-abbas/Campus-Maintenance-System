# HOSTEL MAINTENANCE SYSTEM



#### Basic Description:
SRM Amaravati hostel maintenance system is a complaint management system, built for hostel students. We found that the system currently being used is pretty bad and the complaints registered by students are not being attended to, mostly due to the information not being conveyed properly. This application solves the problem in the best possible way. The students can raise their complaints and concerns through the application onto a common server. When a student raises his/her complaint, the admin will be able to see it on his panel and can take the necessary action. He can choose to either decline the complaint  or assign it to one of the workers of the respective department.The assigned worker will have 1 hour to accept the job. If the time happens to run out, the admin will be notified and priority of complaint will be increased. The admin can also add a message or any important news which he wants everyone to be notified of.


## User Guide

#### Login:
- Users have a dedicated Panel.
- Open the APP(recommended) or Web Server 
- Login with your student ID and default password (birthdate)
- You’ll be redirected to your dashboard. 



#### Dashboard:
- You can view your complaints and their status.
- You can also check out the news feed for any updates from management.
- You can also choose to delete the complaint before it is assigned to a worker.

#### New Complaint:
- You can raise a new complaint by: Menu > New Complaint
- We have also added a Profanity Filter to avoid the use of bad/abusive language and maintain a peaceful environment.
- You can register your complaint, by choosing the concerned department and submit.

Your complaint is now registered with the management. Just sit back and leave it to the management to act upon your complaint and resolve it.
Now, when you get the status that your complaint has been resolved, you will have two options. If you are satisfied with the work done, you have the option to  mark your issue as completed. If not, you also have the option to add remarks and feedback using the comment section.

#### Comments:
If you want to add a remark/feedback to your complaint, you can do it under the comment section.
You can access the comment section by clicking on the complaint on your Dashboard.
- You can post one comment every 5 minutes. (This is to reduce spamming. No hard feelings :) )

## Administrator Guide

- We have a dedicated panel for Admins.
- Admin Panel can be accessed through the application as well , but we recommend to use the desktop Web Server for better a better user experience.
- Front Page of Admin Panel has various statistics based on user behavior and the nature of complaints so that they could get an overview of the complaints. 


#### Complaints:
- Control Panel for the complaints can be accessed by clicking on “Complaints” on the main menu.
- Admin will be able to see all the pending/assigned/active complaints on his Panel.
- Users, Admins and Workers will be notified whenever required,  using a pop-up notification.

- The Admin has the ability to decline the complaint if he considers it inappropriate.


#### Priority System:

- If a worker has accepted the job assigned to him, but has not acted on it within one day, the priority will be increased by one.
- Complaints with the highest priority will be on the top of the list, indicating immediate attention.
- Priority count can be seen next to the name of the user. It is represented as an up arrow with the respective count.
- Admin can choose to reassign the work or add a comment.

* Note: Admin can add as many comments as he wants. We assume that the admin will not stoop to spamming.There is no spam filter for Admin and the worker as well. *

#### Database Export:
- Admin can export the whole data till date in the form of an Excel sheet. 
- The following data can be accessed by the admin:-
  - User Database
  - Worker Database
  - Time to Time Database ( Weekly, Monthly, Yearly)
    - Choose the required data option, enter the information and click “Export as CSV”.
  - For accessing the user database, choose “User Stats”
    - Input Required: Student ID
  - For accessing the worker database, choose “Manpower Stats”
    - Input Required: The Name of the Worker
  - For accessing the Time to Time database, choose “Complaint Database”.
    - Input Required: From date and To date.

#### News Feed:
- Admin can add news to feed by going to “Update News” Page.
- The admin has to give a title and enter the news/updates in the body and click Submit.

## Worker Guide

- Worker can login with the username and password provided to him.
- He has two sections on his dashboard:-
- Recent Complaints and Accepted Jobs.
- He can choose to either accept the job or decline it.
- Once he accepts it, he has to finish the job and has no way to decline it apart from contacting the Admin.

#### Mobile Push Notifications:
- Worker will get a push notification as soon as he has been assigned a job.
- He has one hour to accept the job or else the complaint will be automatically declined.
- If a worker accepts the job, the respective student will get the push notification.
- The admin will get a push notification if the worker chooses to decline the job.

## Technical Report


**Github Repository:**
https://github.com/iam-abbas/hostel-management


#### Resources Used:

- Base Template by www.wrappixel.com
- Android Studio
- Xampp
- Phpmyadmin
- Firebase Cloud Messaging


#### Programming Languages Used:

- PHP
- Java
- JavaScript
- JQuery
- CSS
- HTML
- AJAX


#### Description:
- The whole system is built on a PHP backend. An Apache server has been set up along with MySQL.
- A Database has been created with name “comp_sys”.
- The Database has been connected to PHP Backend in the file config.php. 
- MySQL Database
- Database has 4 tables:
  - Users. This table contains user data like Roll Number and Password.
  - Complaints. This table contains complaint data.
  - New Feed: This table contains the news feed.
  - Comments: This table contains the comments.
- A basic android app has been built with a webview property.
- The android app also includes Google Firebase Cloud Messaging configurations to send push notifications.




## SETUP GUIDE

#### Downloads:
- Source Code:- https://github.com/iam-abbas/hostel-management
- XAMPP:- https://www.apachefriends.org/download.html
- Android Studio:- https://developer.android.com/studio
- A Text Editor (optional)

#### Prerequisites:
- Basic knowledge on how to operate an apache server.
- Basic knowledge about Android Studio
- Basic Java Skills

### Steps:
1. After downloading xampp. Run Xampp.
1. Start Apache and MySQL servers.
1. Download the Source code and copy it to PATH/xampp/htdocs/.
1. Click on “Admin” of MySQL server. You will be directed to phpmyadmin panel.
1. Create a New Database with any name.
1. Import the SQL file into that database.
1. Go to your PATH/xampp/htdocs/html/ltr/.
1. Open config.php in your text editor. Edit it according to your database  settings.
1. You Should be able to access the system from your http://localhost.
1. Now Open Android Studio
1. Open the project Android APP provided in the source code.
1. Open MainActivty.java from app/java/com.example.hostelmanagement/.
1. Update line 64 with your IP Address.
1. To find out the IP Address.
1. Open CMD
1. Type in “ipconfig”.
   - Your IPv4 address is your IP Address.


- Open webviewapp.java from the same directory and edit line 29 with your IP Address.
That’s it you are good to go.


###### This work is licensed under a https://creativecommons.org/licenses/by-sa/4.0/ Creative Commons Attribution-ShareAlike 4.0 (CC BY-SA 4.0).

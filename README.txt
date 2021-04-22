NOTTSTUTOR - Software Engineering Group Project by Group 2A

About the Project

The purpose of the NottsTutor project is to create a system that can help personal tutors execute their tasks with ease. The main aim is to create a system that helps automate the process of assigning tutors to students, which is currently being done manually by the senior tutors. In the meantime, the system would also cater to the needs of tutors such as being able to always view updated tutee information, keeping records of students’ information and managing their information through the system as compared to the manual way of keeping the records in an excel sheet. The NottsTutor websiite is developed with the aim of improving the existing system and providing a more functional, robust system that will reduce the workload of senior tutors.

                                                   How to Run

First, download the Software-Grp-2A ZIP file and extract the Software-Grp-2A folder. The Software-Grp-2A folder should contain the following folders and files:

Codes folder: the NottsTutor code
csv_db .sql: the database used for NottsTutor
README.txt/README.md: README file on how to run the code
CSV Files folder: a folder containing the CSV files of student information
The following are the files inside the CSV Files folde: 

student_data.csv: a CSV file containing information about all new intake students
existingStudents.csv: a CSV file containing information about already existing students at the University of Nottingham Malaysia

                                             XAMPP and Localhost
Installing XAMPP

To run the NottsTutor code, it is required that XAMPP is installed to allow for access and use of the system. The following link by wikihow.com provides exact instructions on how to download and install XAMPP on your computer: https://www.wikihow.com/Install-XAMPP-for-Windows

                                              Uploading the Database

1. Run XAMPP

2. Click the start button for Apache and MySQL Apache and MySQL buttons

3. Type in localhost in your browser. It should open to the XAMPP dashboard.

4. Click on phpMyAdmin on the top right corner of the page.

This should open the phpyMyAdmin dashboard.

5. Create a new database by clicking on 'Create' on the left side panel.

6. Type in the name csv_db 15 and click create.

 **Make sure that the name of the database created is csv_db 15 so the SQL file can be imported correctly.

7. Click on the 'Import' button in the top bar.

8. Click on 'Choose File' and choose the SQL file provided called 'csv_db 15.sql'.

9. Scroll to the buttom of the page and click on the 'Go' button.

After successfuly importing the SQL file, the csv_db 15 database should have the following 8 tables:
- academic plan codes
- administrators
- remarks
- senior tutors
- students
- temp
- tempemails
- tutors

                                        Accessing the NottsTutor Website

1. Inside the XAMPP folder, there is a folder called 'htdocs'

2. Extract the 'Software-Grp-2A' folder and place it inside the htdocs folder.

3. Inside the Codes folder, there should be the following 28 files:

- Ariel-View-Campus2.jpg
- Connection.php
- default.css
- forgotPassword.php
- Import.php
- Importpage.php
- login.css
- Login.php
- Loginpage.php
- Modulespage.php
- Newmodulepage.php
- Newremarkspage.php
- Personalpage.php
- Progression.php
- Search.php
- SearchedModule.php
- SearchedTable.php
- SearchedTutee.php
- SortNew.php
- StudentView.php
- style.css
- table.css
- Tuteepage.php
- TutorChange.php
- Tutorpage.php
- unmclogo.png
- UserInformationStudent.php
- UserInformationTutors.php


4. Type in http://localhost/Software-Grp-2A/Codes/Loginpage.php in your browser to access the Login screen of NottsTutor.

                                             Using the NottsTutor Website

The following are a list of IDs and passwords to log on to the NottsTutor system and access its features:

Administrator
ID: 10000001
Password: 0000

Regular Tutor
ID: 50000033
Password: 1234

Senior Tutor
ID: 50000031
Password: 1234

Student
ID: 20050927
Password: 1234

Each of these users have different privileges that allow them access to different features of the NottsTutor system:

- The administrator log onto the system first to upload the CSV file called 'student_data' which contains a list of all student information.
- The system will then import this list of students and automatically assign groups of students a tutor.
- Tutors can then log onto the system to view their assigned tutees and their information.
- In addition to viewing their assigned tutees, Senior Tutors can also view information about all tutees and their respective tutors under their school.
- Students can log on to the system to view information about their assigned tutor and a list of other students in their year under the same tutor.

                                                NottsTutor Website

Another way of seeing the functionality of the code is to access the NottsTutor system online via its website.
NottsTutor has been deployed online and can be accessed and viewed via http://hfyer1.jupiter.nottingham.edu.my/Loginpage.php
The fuctionality of the NottsTutor system can be viewed through each page of the website.

Refer to the User Manual in the final report for a detailed explanation of how to use the system's different features.
The final report also provides details of all other functions provided by NottsTutor.
# prj-cir2-web-2019-2020

This site allows you to classify the cyclists, registered in the different clubs of the region, on each race of the year.
The aim is to be able to produce the general classification, as well as some statistics at the end of the season.

### Dependencies

You must have on your machine :

- PHP version 7 or higher
- A Web server (Apache)
- MySQL 
The project has been tested under XAMP, under WINDOWS environment.

### Installation

Download the zip file from my Github, then save the project as Xamp/htdocs.

### Setting Up

## On XAMP dependancies
The site has its own database that you must load in order to make it functional. To do this, go to phpmyadmin and follow the steps below:

1. Click on the import to your server's database section.
2. Download the table.sql file from where you saved the project in the DB folder.
3. Don't forget to select the options **_Character set of the file_:** utf-8 and **_FORMAT_** SQL
4. Click on execute.

Everything is included in the table.sql file, but if you want to change the connection logins, you can change the constants in the `api/constants.php` file. As long as you don't forget to change them in phpmyadmin.
The same goes for your virtual host domain in `front/constants.js` .

## On Linux Commands

### Use

To view the data of the cyclists of a club you just have to connect to the site and enter the email of one of the users. 
> We advise you to have a notepad to put them.

To see the participants of a race or to see the data of a race click on the races button on the top left.
You will be able to see the races, the participants, and add in both cases.

The site is not yet finished and some features are not working perfectly.
Enjoy.

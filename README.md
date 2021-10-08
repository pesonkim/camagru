# Camagru

Instagram-like image sharing app - a web branch project and my first full stack web app for [Hive Helsinki](https://www.hive.fi/en/) coding school.

<p align="center">
  <img src="https://github.com/pesonkim/camagru/blob/master/app/assets/img/Screen%20Shot%202021-10-08%20at%205.55.39%20PM.png">
</p>

## Task

The aim of this project was to build a **Instagram-like web app**, where the users can create their profile, browse through a list of recommended profiles or conduct a search by age, distance, fame rating, commong tags. Users can like, report and block other users and chat with users that liked them back.

The aim of this project was to build an **Instagram-like web app**, that allows to make basic photo editing using webcam captures or uploaded images and predefined 'sticker' images, that are superimposed on top of the original files, creating a final image that mixes both.

**Project constraints:**

- Client-side: HTML, CSS, pure JavaScript without any frameworks
- Server-side: standard PHP library
- Database: MySQL with PDO driver 
- No errors, warnings or notice on both server- and client- sides
- No security breaches (e.g. no SQL, HTML injections, plain passwords in the database)
- Compatible at least with Firefox (>=41) and Chrome (>= 46)
- Responsive design

## Stack

Frontend:

- HTML
- CSS
- Tailwind CSS
- JavaScript
- AJAX

Backend:

- PHP
- Apache
- MySQL

## Functionality

* User features:
	* Register / Login, including activating account and resetting password through a unique link send by email.
	* User data management: modify username or email, update password, set notification preferences, or delete profile.
	* Create, manage and delete user's own uploads.


* Gallery features:
	* Infinite scroll gallery view, that scales with screen width.
	* All images are public, only logged in users can can leave likes and comments.
	* Lightbox/Image modal to view full resolution images.
	* Upload authors are notified by email on new comments.

* Editing features:
	* Create custom images using webcam or upladed images and combine them with various stickers.
	* Live preview of the edited result, directly on the webcam preview.

## Run locally
* Download and install a local webserver, e.g. MAMP from [bitnami](https://bitnami.com/stack/mamp)
* Make sure you can send email from your terminal
* Git clone the repository inside document root folder of your server, e.g. `htdocs` in Apache
* Update `config/database.php` to match your database credentials
* Run `php config/setup.php` to create the database
* Open http://localhost/folder_name in your preferred browser

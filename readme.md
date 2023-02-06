## WordPress Booking

* Contributors: leonelkenfack
* Requires at least: 5.2
* Tested up to: 6.1
* Stable tag: 1.0.2
* Requires PHP: 7.2
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Date : 2022/21/12
* Version: 1.0.2

## Short description

WordPress reservation is a WordPress plugin for managing events, booking and making appointments

---

## Description of the plugin

This plugin allows you to create an **event** of any type by entering its **name**, a **short description**, a **long description**, a **start date**, an **end date**, a **duration per session**, the type of **repetition** of the event, the **working days** of the week, the **place** of the event, **the price**, the **maximum number of places** per session, the **reservation limit** in the future, the and the **margins** between the different sessions.

An event has an image; This image can be added thanks to the featured image or if not it will be the first image in the Gutenberg editor. In the case of deadlines, a default image is added.
Once the event is created, you can edit or delete it, just like with posts and pages. Events can also have categories.
When the visitor opens an event, he can open it and book a session on a given date. The administrator and the visitor will receive an email notification to let them know that the reservation has been made.
The administrator can change the time of a session or cancel the session.

---

## Installation Guide

You need to follow the following steps to install and operate the plugin on your WordPress site

1. First, download the source code and make sure it is compressed into a zip file.
2. Install the plugin.
3. Create a new page paste the shortcode [event_list].
4. Go to **general > event** and edit configure your preferences and click save.
5. Go to **general > permalinks** by clicking on save.

---

## Architecture et contenu

**asset**

**_frontend**

**__css**

* calandar.css: *Allows you to format the calendar*
* event.css: *Allows to give a style to the display page of the different events*
* single-event.css: *Allows to give a stylr to the presentation page of an event*

**__images**

* default.png: *Contains the default image file for events without an image*

**__js**

* calandar.js: *Allows to set up the calendar with **jQuery** and to exchange information with **Ajax***

**_backend**

**__js**

* script.js: *Allows you to set up data exchange with **Ajax** for modifying and deleting a reservation.* 

**config**

* globalVars.php: *This is where the global variables and some constants used in the project are defined.*
* text.php: *Some strings that are used in several files*

**model** : The different files contain the functions interacting with the database**

**src**

**_backend**

* Metadata.php: *This is where all event type metadata is created.*
* Setting.php: *This is where the **general>event** page is created*

**_frontend**

* load_template.php : *Allows you to reload a custom template file if the current post type is an event*
* construct_template.php: *In this file, we retrieve and process the ajax information to be able to manage the calendar and the reservation.*

**_functions**

* fonction.php: *Contains the function which makes it possible to build a mail by putting the information of the user.*

**vendor**: *This is the result of installing dependencies with composer*

**views**

* enqueue_script.php: *Allows to include style files in plugin pages*

**_backend**

* Metabox.php: *Allows you to build the different custom post boxes event*

**_frontend**

* Events.php: *Allows to define the shape of an event post-type in the display page of all events*
* single-event.php: *Allows to define the shape of an event post-type in its display page*

**instant-appointment.php**: *This is the main plugin file. This is where any information related to the plugin is added*

---

## Changelog

**1.0.2**
* Design improvement
* Fixed some minor bugs

**1.0.1**
* Establishment of the reservation calendar
* Saving reservations in the database
* Success reservation email
* reservation cancellation email

**1.0.0**
* Setting up the event
* Setting up event parameters
* Displays of events on the frontend

---

# garden
small php MVC framework

## Overview
The garden framework approach is quite simple, following mvc principles.

This repository provides you a quickstarter. Once cloned  you just need to write your functions incrementally in "controllers" folder. Each controller should be associated with an route, in order to generate it's output. To generate it's output you need to be using the view function, which requires a view, or you can set the data to a View object then output it's json using the outputJSON method.

## Usage case
[Bookmarks](https://github.com/seapvnk/bookmarks) is an exemple of garden in practice, it's a simple web application which use views for rendering it's content, and controllers writted as small functions which provides an easy to extend archicture, just like i said before, you can incrementally write controllers to create new functionalities.


## Usage
In this demostration i'll be using xampp enviroment.

````bash
cd ../../opt/lampp
sudo ./lampp start
cd htdocs

git clone https://github.com/seapvnk/garden
mv garden myapp

sudo chown username:daemon /opt/lampp/htdocs/myapp -R
sudo chmod 775 /opt/lampp/htdocs/p -R

cd myapp
# now open your text editor
````

At this point you're supposed to see an starter page [here](http://localhost/myapp/)


## Documentation 
The documentation is'nt available for now.


## Licence
garden is [MIT licenced](https://github.com/seapvnk/garden/blob/main/LICENSE)

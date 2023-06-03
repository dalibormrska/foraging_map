# Foraging Map
### version 1.0

## Eat the wilderness
:blueberries::strawberry::green_apple::cherries:

***Foraging Map*** is a multitier web application built mostly with PHP showing foraging spots around the world.

You can create your own foraging spot :compass: and add the type of plant you found there. 

Even if you don't log in you can see all the spots created by other users. 

## Features

- Map of spots
- Login / register a user
- See, add, edit, delete spots
- Frontend utilising TailwindCSS
- API endpoint with token authentication
- External API to search for plants and retrieve info about a plant

## Start

Fork the repo and feel free to import the provided database dump.

Then create a `config.php` file in the root of the project where you should define the `APPLICATION_NAME`, the database credentials `DB_HOST`, `DB_USER`, `DB_PASSWORD` and `DB_DATABASE` and lastly your own `JWT_SECRET` and `TREFLE_TOKEN`.

## Start tailwind

Tailwind is included as a standalone CLI configuration with an `tailwindcss` executable in the `frontend/` folder. The executable might need to be replaced by one that is suitable for your architecture. Read more about it, and download suitable executable at [Tailwind's blog](https://tailwindcss.com/blog/standalone-cli). 

To run the CSS watching, navigate to /frontend in the terminal
`cd frontend`

Start a watcher
`./tailwindcss -i assets/css/input.css -o assets/css/output.css --watch --minify`

Now the Tailwind's classes will be automatically parsed into pure CSS in the output.css file.

## APIs Used

This application was built using [Trefle API](https://trefle.io/), [Leaflet.js](https://leafletjs.com/) and [OpenStreetMap](https://www.openstreetmap.org/).

Trefle API was used to search and add foraging plant type to a spot. 

Leaflet.js library was used to display the map, locate a spot and access the location's coordination, while OpenStreetMap tiles API have been utilised to retrieve the imagery.

## About

This application is created by *Dalibor* :duck: and *Zoe* :black_cat:. 

We are two students in Sweden. This is our last project before graduation. 

Thank you for visiting.

*30/05/2023*

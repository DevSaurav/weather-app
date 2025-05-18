# 🌤️ Laravel Weather App

This is a weather forecasting application built with **Laravel 12**, **Sanctum** for secure API authentication, **MySQL** for data persistence, and the **OpenWeatherMap API** to fetch real-time weather data.

## 🚀 Features

- 🔐 Token-based authentication using Laravel Sanctum
- 🌦️ Real-time weather updates from OpenWeatherMap
- 📍 Search weather by city name, deafault is Perth, WA australia
- 🗃️ Store and retrieve weather logs via MySQL
- 🧩 Modular API architecture (ideal for mobile or frontend integration)

## 🛠️ Tech Stack

- **Backend Framework**: Laravel 12
- **Authentication**: Laravel Sanctum
- **Database**: MySQL
- **Weather API**: OpenWeatherMap
- **API Testing**: Postman / Laravel HTTP Client

## 🔧 Setup Instructions

1. **Clone the repository**  
   ```bash
   $ git clone https://github.com/DevSaurav/weather-app.git
   $ cd weather-app

2. **Install composer**  
   ```bash
   $ composer install
   
3. **Generate App Key** 
   rename .env.example to .env file and copy the output key below, place in env file. 
   ```bash
   $ php artisan key:generate
   

4. **Create database**  
   
   Create a database named weather and update the env file as below:
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=weather
   DB_USERNAME=root
   DB_PASSWORD=

5. **Add migrations and seed**  
   ```bash
   $ php artisan migrate
   $ php artisan db:seed

6. **Run the app**
   Hit the command below to load the app in the route http://127.0.0.1:8000, 8000 as a default artisan port.
   ```bash
   $ php artisan serve

7. **Run the unit test**  
   ```bash
   $ php artisan test

8. **Run the unit test**  
   ```bash
   $ php artisan queue:work # start the welcome email notification job, use --queue=UpdateWeatherData to start a job for weather update
   $ php artisan queue:listen # listen to the status of jobs being processed, use --queue=UpdateWeatherData to listen to the jobs from weather update

9. **Using postman collection for API**  
   ```bash
   Import the postman_collection file from the root folder.
   Hit the POST api/register to register, change the default name to your name.
   Hit the POST api/login to get the token, save this to use in authorization header as a Bearer token.
   Play hit the apis to create posts, get posts and weather using the token above.



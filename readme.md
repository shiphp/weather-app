# Shiphp: Weather App

### A PHP Application Using Docker

This project is the companion app used as a demonstration in the free Shiphp eBook "[Building PHP Applications in Docker](https://www.shiphp.com/books)". The book goes through building this application in more detail, but if you just want to set this project up, instructions for local development are below.

## Local Setup

- Clone this repository

- Install the composer dependencies: `docker run --rm -v $(pwd):/app composer:latest install`.

- Run the MySQL Database: `docker run -d --rm --name weather-db -e MYSQL_USER=admin -e MYSQL_DATABASE=weather -e MYSQL_PASSWORD=p23l%v11p -e MYSQL_RANDOM_ROOT_PASSWORD=true -v $(pwd)/.data:/var/lib/mysql mysql:5.7`

- Create the `locations` table in the `weather` database: `docker exec -it weather-db mysql --user=admin --password=p23l%v11p --execute="CREATE TABLE locations (id VARCHAR(64) NOT NULL, weather JSON NULL, last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP);" weather`
 
- Build the application image: `docker build -t shiphp/weather-app .`

- Run the application container and link it to the database: `docker run -d --rm --name=weather-app -p 38000:80 -v $(pwd):/var/www/html --link weather-db -e DATABASE_HOST='weather-db' -e DATABASE_USER='admin' -e DATABASE_PASSWORD='p23l%v11p' -e DATABASE_NAME='weather' shiphp/weather-app`

Visit `localhost:38000/index.php/locations/<WOEID>` to get the weather by [WOEID](http://woeid.rosselliot.co.nz/). For example, the WOEID of New York is `2459115`, so you can get the weather there by going to:

```
http://localhost:38000/index.php/locations/2459115
```

The JSON response should look something like this:

```json
{
  "consolidated_weather": [
    {
      "id": 6515238362939392,
      "weather_state_name": "Showers",
      "weather_state_abbr": "s",
      "wind_direction_compass": "SW",
      "created": "2017-09-13T17:19:45.453080Z",
      "applicable_date": "2017-09-13",
      "min_temp": 18.595000000000002,
      "max_temp": 26.588333333333335,
      "the_temp": 25.096666666666664,
      "wind_speed": 5.185939193315041,
      "wind_direction": 234.27666550585474,
      "air_pressure": 1018.23,
      "humidity": 65,
      "visibility": 14.774032152230971,
      "predictability": 73
    },
    {
      "id": 6150681538854912,
      "weather_state_name": "Heavy Rain",
      "weather_state_abbr": "hr",
      "wind_direction_compass": "S",
      "created": "2017-09-13T17:19:48.587360Z",
      "applicable_date": "2017-09-14",
      "min_temp": 19.886666666666667,
      "max_temp": 25.80666666666667,
      "the_temp": 23.930000000000003,
      "wind_speed": 6.513836670810466,
      "wind_direction": 188.68394449517282,
      "air_pressure": 1018.0699999999999,
      "humidity": 79,
      "visibility": 11.286897021395053,
      "predictability": 77
    },
    {
      "id": 5044823023157248,
      "weather_state_name": "Heavy Cloud",
      "weather_state_abbr": "hc",
      "wind_direction_compass": "SSW",
      "created": "2017-09-13T17:19:51.710010Z",
      "applicable_date": "2017-09-15",
      "min_temp": 19.44666666666667,
      "max_temp": 26.38,
      "the_temp": 24.236666666666665,
      "wind_speed": 3.0399122991529466,
      "wind_direction": 195.40487284133778,
      "air_pressure": 1022.9,
      "humidity": 74,
      "visibility": 13.153185397279886,
      "predictability": 71
    },
    {
      "id": 4771100797960192,
      "weather_state_name": "Showers",
      "weather_state_abbr": "s",
      "wind_direction_compass": "ENE",
      "created": "2017-09-13T17:19:55.111680Z",
      "applicable_date": "2017-09-16",
      "min_temp": 19.638333333333335,
      "max_temp": 26.016666666666666,
      "the_temp": 23.900000000000002,
      "wind_speed": 4.368622607794481,
      "wind_direction": 72.246968864351,
      "air_pressure": 1019.895,
      "humidity": 73,
      "visibility": 12.363733297542353,
      "predictability": 73
    },
    {
      "id": 4685651014320128,
      "weather_state_name": "Heavy Cloud",
      "weather_state_abbr": "hc",
      "wind_direction_compass": "ENE",
      "created": "2017-09-13T17:19:56.897010Z",
      "applicable_date": "2017-09-17",
      "min_temp": 18.736666666666665,
      "max_temp": 25.365,
      "the_temp": 23.689999999999998,
      "wind_speed": 5.59878173461253,
      "wind_direction": 68.72902518115791,
      "air_pressure": 1017.345,
      "humidity": 72,
      "visibility": 14.218836991966914,
      "predictability": 71
    },
    {
      "id": 5497454929641472,
      "weather_state_name": "Light Cloud",
      "weather_state_abbr": "lc",
      "wind_direction_compass": "NE",
      "created": "2017-09-13T17:20:00.419270Z",
      "applicable_date": "2017-09-18",
      "min_temp": 17.691666666666666,
      "max_temp": 24.013333333333335,
      "the_temp": 20.685000000000002,
      "wind_speed": 6.835117951165197,
      "wind_direction": 54.0738317624301,
      "air_pressure": 1015.62,
      "humidity": 69,
      "visibility": null,
      "predictability": 70
    }
  ],
  "time": "2017-09-13T15:05:23.977630-04:00",
  "sun_rise": "2017-09-13T06:34:56.731262-04:00",
  "sun_set": "2017-09-13T19:07:56.998962-04:00",
  "timezone_name": "LMT",
  "parent": {
    "title": "New York",
    "location_type": "Region / State / Province",
    "woeid": 2347591,
    "latt_long": "42.855350,-76.501671"
  },
  "sources": [
    {
      "title": "BBC",
      "slug": "bbc",
      "url": "http://www.bbc.co.uk/weather/",
      "crawl_rate": 180
    },
    {
      "title": "Forecast.io",
      "slug": "forecast-io",
      "url": "http://forecast.io/",
      "crawl_rate": 480
    },
    {
      "title": "HAMweather",
      "slug": "hamweather",
      "url": "http://www.hamweather.com/",
      "crawl_rate": 360
    },
    {
      "title": "Met Office",
      "slug": "met-office",
      "url": "http://www.metoffice.gov.uk/",
      "crawl_rate": 180
    },
    {
      "title": "OpenWeatherMap",
      "slug": "openweathermap",
      "url": "http://openweathermap.org/",
      "crawl_rate": 360
    },
    {
      "title": "Weather Underground",
      "slug": "wunderground",
      "url": "https://www.wunderground.com/?apiref=fc30dc3cd224e19b",
      "crawl_rate": 720
    },
    {
      "title": "World Weather Online",
      "slug": "world-weather-online",
      "url": "http://www.worldweatheronline.com/",
      "crawl_rate": 360
    },
    {
      "title": "Yahoo",
      "slug": "yahoo",
      "url": "http://weather.yahoo.com/",
      "crawl_rate": 180
    }
  ],
  "title": "New York",
  "location_type": "City",
  "woeid": 2459115,
  "latt_long": "40.71455,-74.007118",
  "timezone": "US/Eastern"
}
```

## API Documentation

This API supports two endpoints:

- `GET /locations/<WOEID>` - Retrieves the weather for a location and saves it to the local MySQL database. On subsequent requests, this endpoint will return the cached version of the weather.
- `DELETE /locations/<WOEID>` - Deletes the local weather entry for a location (if it exists). 

## Contributing

If you see a problem with this repository or the setup instructions, feel free to submit an issue or a pull request.

## License

Copyright 2017, Karl L. Hughes

> Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at
>
>    http://www.apache.org/licenses/LICENSE-2.0
>
> Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.

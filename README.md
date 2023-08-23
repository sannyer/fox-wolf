# webpont api task
## install
Copy files to web space or an empty folder (`<app dir>`).

Have MariaDB or MySQL installed.

Run in mysql client:

```sql
CREATE USER wpuser@localhost IDENTIFIED BY 'wpuser123';
CREATE DATABASE wp_smiglecz;
GRANT ALL PRIVILEGES ON wp_smiglecz.* to wpuser@localhost;
```
If you want to use other creds or database name, keep in mind to update your `.env` file accordingly.

Run shell command:

```sh
php artisan migrate
```

Add new line to your crontab (`crontab -e`)

```
* * * * * cd <app dir> && /usr/local/bin/php artisan schedule:run >> storage/logs/cron.log
```

If you copied to webspace, now you can use the api. If not, start a local ad-hoc webserver:

```sh
php artisan serve
```

From now on, every city that there is in the cities table, will fetch weather data every 10 minutes.
In this case, your hostname will be localhost:8000.

The below api urls are available to call:

- `<hostname>/liveweather/<cityname>`: Queries the actual weather for a city. If the city is not in the database yet, it'll look it up and then store in the `cities` table. This way you can add a city to the "watch list". From now on, for this city, the weather data will be fetched every 10 minutes.
- `<hostname>/weather/<cityname>`: Fetches the last 24 hours weather data for the given city. If the city is not in the database, it results a 404 error.
- `<hostname>/schema`: Explains the data structure in which the weather data will be answered.
- `<hostname>/update`: You can manually trigger the data fetch for all cities. As an answer, it tells you how many cities were updated. The call is identical to the 10-minute scheduled update.


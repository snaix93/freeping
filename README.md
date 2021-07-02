# Freeping.io - lightweight but powerful monitoring
This is the repository of https://freeping.io.
The staging system is https://dev.freeping.io

## Execute checks
Checks are executed by satellites running the so-called [pinger](https://bitbucket.org/cloudradar/pinger/src/master/).
Check are executed from different pinger in parallel. Running a local pinger is usually not needed. 
The local development can use the staging pingers tp execute checks.

The pingers will queue the requested checks and send the results back to a call back url. That means your local web server must become available on the public internet.
One option is using the free service [expose](https://beyondco.de/services). 
The binary and an access token has been baked into the VM.

From the www-data account execute `expose share freeping.local`.
A random URL will be generated and displayed, for example `https://vgmvjpkvnp.sharedwithexpose.com`
Use this URL as `APP_URL` in your `.env` file. 
Leave the console open to observe incoming callback requests.

## PHP Dependencies
PHP8, and php-redis is needed.
### Install PHP Redis
To install php-redis on Ubuntu 20.04 execute
```bash
apt install php-pear php8.0-dev make
yes '' | pecl install redis
echo "extension=redis.so">/etc/php/8.0/mods-available/redis.ini
cd /etc/php/8.0/cli/conf.d && ln -s /etc/php/8.0/mods-available/redis.ini 20-redis.ini
php -m|grep redis
cd /etc/php/8.0/fpm/conf.d/ && ln -s /etc/php/8.0/mods-available/redis.ini 20-redis.ini
php-fpm8.0 -t && service php8.0-fpm restart
```

### Install PHP Lua

https://github.com/phpv8/v8js/blob/php7/README.Linux.md
```bash
apt install liblua5.1-dev
pecl install luasandbox

echo "extension=luasandbox.so">/etc/php/8.0/mods-available/luasandbox.ini
cd /etc/php/8.0/cli/conf.d && ln -s /etc/php/8.0/mods-available/luasandbox.ini 20-luasandbox.ini
php -m|grep luasandbox
cd /etc/php/8.0/fpm/conf.d/ && ln -s /etc/php/8.0/mods-available/luasandbox.ini 20-luasandbox.ini
php-fpm8.0 -t && service php8.0-fpm restart
```

## Manage Influx

### Install Influx2
*On the VM influx2 is already installed. Your can skip this section.*
````shell
wget https://dl.influxdata.com/influxdb/releases/influxdb2-2.0.6-amd64.deb
sudo dpkg -i influxdb2-2.0.6-amd64.deb
service influxdb start
influx setup
````

During the setup, answer as follows
````text
Welcome to InfluxDB 2.0!
Please type your primary username: app
Please type your password: Aingo7iey
Please type your password again: Aingo7iey
Please type your primary organization name: monitoring
Please type your primary bucket name: dummy
Please type your retention period in hours.
Or press ENTER for infinite: 24
````

Read the default token that has been generated during the setup.
````shell
influx auth list --json
````
Store the default token in your .env to `INFLUX_TOKEN`

This projects uses Influx2. InfluxDB Version 2 comes with a built-in web interface on port 8086.
Default credentials of the VM:
```yaml
user: app
password: Aingo7iey
token: ErCxe8jLyekz42B2nrm7gilwVJccRc_-7JKbFZOC1xAbsobl07tiLJyFrB4JcEPlBQzbDCbsvYCVamcEd_RoTQ==
org: monitoring
```

For your comfort insert the Influx environment variables to your shell profile.
Append the following lines to your `~/.profile` file.
```shell
export INFLUX_TOKEN=<YOUR_TOKEN>
export INFLUX_ORG=monitoring
```


### Create Buckets
```shell
export INFLUX_TOKEN=<YOUR_TOKEN>
export INFLUX_ORG=monitoring
#influx bucket delete -n eventHistory
influx bucket create -r 90d -n eventHistory
influx bucket create -r 30d -n captureHistory
```

### Insert and query Influx
InfluxDB2 has no interactive client anymore. Below you find some examples how to use the  new none-interactive client.

Examples to interact with the eventHistory:
```shell
# Insert a row
influx write \
  -b eventHistory \
  -p ns \
 'events,user_id=1,event_id=68bf1053-60de-43ff-93c6-62fb06673fe2,connect=example.com,originator=Pulse,severity=Alert\
 description="text",meta="["some-json"]"
  
 # Query the data
 influx query \
'from(bucket: "eventHistory")
 |> range(start: 1970-01-01T00:00:00.000000001Z) |> last()
 |> filter(fn: (r) => r["_measurement"] == "events")'

influx query \
'from(bucket: "eventHistory")
|> range(start: -1h, stop: now())
|> last()
|> filter(fn: (r) => r._measurement == "problems" and r.user_id == "1")
|> drop(columns:["_start", "_stop","user_id","event_id"])
|> map(fn:(r) => ({ r with timestampns: uint(v: r._time) }))
|> group(columns: ["user_id"], mode: "by")
|> sort(columns:["_time"],desc:true)'
```
Examples to interact with the captureHistory:
```shell
influx write \
  -b captureHistory \
  -p ns \
 'base-monitoring:13,hostname=gaga.de disk:d:free:percent=100,hint="text",sausage=1.0'
 
influx write \
  -b captureHistory \
  -p ns \
 'base-monitoring:13,hostname=gaga.de disk:d:free:percent=100,hint="text",sausage="wurst"'
 # Throws an error because 'sausage' is expected to be a float.
 
influx query \
'from(bucket: "captureHistory")
|> range(start: -1h, stop: now())
|> last()
|> filter(fn: (r) => r._measurement == "hase:1")
|> drop(columns:["_start", "_stop"])'

# Select only specified columns
influx query \
'from(bucket: "captureHistory")
|> range(start: -1h, stop: now())
|> last()
|> filter(fn: (r) => r._measurement == "hase:1")
|> keep(columns:["_start", "_stop"])'

# Show measurements in a bucket
influx query \
'import "influxdata/influxdb/schema"
schema.measurements(bucket: "captureHistory")'

# Delete a measurement
influx delete --bucket captureHistory \
  --start 1970-01-01T00:00:00Z \
  --stop $(date +"%Y-%m-%dT%H:%M:%SZ") \
  -p '_measurement="hase:1"'
```

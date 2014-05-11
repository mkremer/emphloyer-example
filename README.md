# Emphloyer example with PDO

This project is a simple test example that uses Emphloyer with PDO. You can use
this to play around with it a bit.

## Setup

The easiest way to get up and running is by using
[Vagrant](http://www.vagrantup.com/).

If you cannot or do not want to use Vagrant you will need to ensure that you 
have MySQL running on localhost and that the database emphloyer\_example exists.

Install the dependencies with composer with

    composer install

Set the following environmental variables:

- DB\_USER to the MySQL user (set this to root when using the Vagrant box)
- DB\_PWD to the MySQL user password (set this to an empty string when using the
  Vagrant box)
- REGULAR\_WORKERS to the number of concurrent workers to run for jobs of types
  other than 'priority'
- PRIORITY\_WORKERS to the number of concurrent workers to run for jobs of the
  type 'priority'

With bash you would execute:

    export DB\_USER=username
    export DB\_PWD=password
    export REGULAR\_WORKERS=2
    export PRIORITY\_WORKERS=1

To initialize the test database run:

    php init.php

The init script drops the test tables and then re-creates them. It then proceeds
to insert 1000 jobs, 900 with type 'regular' and 100 with type 'priority'.

## Running the example

To run the example simply run (from the project root):

    vendor/bin/emphloyer -c config.php

Once the output stops Emphloyer has finished processing jobs.

The test jobs insert records into the things table, you can check how long the
entire process took with:

    select (max(created_at) - min(created_at)) as runtime from things;


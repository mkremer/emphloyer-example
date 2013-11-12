# Emphloyer example with PDO

This project is a simple test example that uses Emphloyer with PDO. You can use
this to play around with it a bit.

## Setup

To run this example you need to have MySQL running on localhost. The database
emphloyer\_example must exist.

Install the dependencies with composer with

    composer install

Set the following environmental variables:

- DB\_USER to the MySQL user
- DB\_PWD to the MySQL user password
- WORKERS to the number of concurrent workers to run

With bash you would execute:

    export DB\_USER=username
    export DB\_PWD=password
    export WORKERS=2

To initialize the test database run:

    php init.php

The init script drops the test tables and then re-creates them. It then proceeds
to insert 1000 jobs.

## Running the example

To run the example simply run (from the project root):

    vendor/bin/emphloyer -c config.php

Once the output stops Emphloyer has finished processing jobs.

The test jobs insert records into the things table, you can check how long the
entire process took with:

    select (max(created_at) - min(created_at)) as runtime from things;


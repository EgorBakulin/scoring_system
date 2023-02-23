# Scoring system

Test task for the Sweak company.

Small application with registration form, admin panel and console command.

## Installation

### Linux

#### Requirement

* make
* docker
* docker-compose

user must be root. or user must be in group `docker` and selinux must be `disabled`

<hr>

After that enter in project root directory and run `make install`. Web application will run in `localhost:80`. You aso
can enter to the php container run `make connect_app`

## Usage

Ahis application has two routes.

* `/` Registration form
* `/admin` admin panel

One console command. For run it type `make app_scoring_calculate` in terminal. This command recalculate customers score
and show score in stdout. You can also recalculate score only for one customer just put customer id to command argument.
F.e. `make app_scoring_calculate 1` recalculate score only for customer with id 1.

And one fixture. you can run it with command `make load_fixtures`

For execute tests run `make test`

Also you can use other make commands run `make help` to show you command list with descriptions

# Simple REST API

This project is simple REST API for user CRUD operations. It was created as sample project for a job interview in the past.

## Requirements

- PHP v7.1 or higher
- MySQL (MariaDB) v5 or higher
- Composer
- Unix based system (optional - for pre commit hook)

## Installation

- `git clone git@github.com:zatrepalek/simple-rest-api.git local-dir`
- `composer install`
- (Optional) set pre commit hook via `ln -s -f ../../pre-commit.sh .git/hooks/pre-commit`

## Setup
- Create mysql database and run queries from file `tests/database/structure.sql` to create DB structure.
- Edit configuration in `app/config/local.json` for previous database (SELECT/UPDATE/DELETE privileges needed).
- Edit test configuration in `app/config/test.json` for test database (SELECT/UPDATE/DELETE/CREATE DATABASE/DROP DATABASE/CREATE TABLE privileges needed).

## Usage

HTTP status codes are used as response codes. In case of error, json with array with key 'errors' is returned
else empty json is returned. In case of any problem HTTTP 500 error is returned, otherwise see codes below.

Sample request using curl:

```
curl -X POST 'http://localhost/users' -d '{"name": "Patrick Doe","email": "john@example.com","phone": 123456789}' -H "Content-Type: application/json"
```

Sample response:

```
{"name":"Patrick Doe","email":"john@example.com","phone":123456789,"id":1}
```

### Create user

- Method **POST**
- Location **/users**
- Body **json object with "name" (string from 1 to 200 characters long), "email" (string, valid email) and "phone" (integer, 9 digits, first digit greater than 0)**

Returns status code 200 on success, resource as json in body and Location header containing path to resource.

#### Example

```json
{
 "name": "Patrick Doe",
 "email": "john@example.com",
 "phone": 123456789
}
```

### Get user

- Method **GET**
- Location **/users/{id}**

Returns status code 200 on success and resource as json.
Status code 404 is returned in case nothing found.

### List users

- Method **GET**
- Location **/users**

Returns status code 200 on success and array of resource (if any) as json.

### Update user

- Method **PATCH**
- Location **/users/{id}**
- Body **json object with at least one of "name" (string from 1 to 200 characters long), "email" (string, valid email) and "phone" (integer, 9 digits, first digit greater than 0)**

Returns status code 200 on success and resource as json.
Status code 404 is returned in case resource with particular id not found.

#### Example

```json
{
  "phone": 100000000,
  "name": "Mark Smith"
}
```

### Replace user

- Method **PUT**
- Location **/users/{id}**
- Body **json object with  "name" (string from 1 to 200 characters long), "email" (string, valid email) and "phone" (integer, 9 digits, first digit greater than 0)**

Returns status code 200 on success and resource as json.
Status code 404 is returned in case resource with particular id not found.

#### Example

```json
{
  "name": "Johnann",
  "email": "j@example.com",
  "phone": 100000000
}
```

### Delete user

- Method **DELETE**
- Location **/users/{id}**

Returns status code 200 on success.
Status code 404 is returned in case resource with particular id not found.

## Development

### Composer commands

`composer static` Run static code analysis (https://github.com/phpstan/phpstan) of src/ and tests/ directories.

`composer tests` Run phpunit (https://github.com/sebastianbergmann/phpunit) tests in tests/ directory.

### Git hooks

Script pre-commit.sh runs `composer static` and if successfull, then `composer tests` and allows to commit if both successful.

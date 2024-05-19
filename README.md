# genesis_test
Software Engineering School 4.0 Test Task

# Project Overview

In this project, data retrieval and recording were implemented according to API requirements.

## Framework and Deployment

The task was completed using the Phalcon framework, adhering to deployment requirements in Docker. The root directory contains a `docker-compose` file. The database is populated during initialization. Additionally, a primitive test bash script is located in the `test` folder.

## Project Structure

- **Phalcon MVC Framework**: The entire PHP application is located in `application/app`.
  - **config/router**: Routing configuration
  - **controllers**: Controllers for handling requests and responses
  - **models**: Models for database interactions

### Database Operations

Queries from PHP are directed to stored procedures for better performance.

### Email Functionality

Although planned, the email sending feature was not fully implemented. The plan was to use cron jobs to send a GET request to the server, which would then use PHPMailer to send emails. While email retrieval and currency value processing are completed, and cron creation is done, the cron job is not passing the request properly, and the mailer is not fully functional yet.

## Additional Information

For someone familiar with the topic, the provided information should be sufficient to understand the code.

### Notes

## Purpose

This project template is a Composer-based setup that helps kickstart a Drupal project. It includes configurations needed to work on your server.

## Requirements

To successfully set up the project, ensure the following dependencies are installed:
- [Docker](https://docs.docker.com/install/): A containerization tool to run isolated environments.
- [Docksal](https://docs.docksal.io/getting-started/setup/): A containerization tool to run isolated environments.

**Note:** PHP and Composer are not needed on your local machine as they will be installed within the Docksal containers.

## Preparing the System

### Storage Requirements

Ensure you have **56GB** of free disk space before starting. The installation process needs this space to download and set up everything.

### Creating the Workspace

**Navigate into your `webroot` folder**:

```bash
cd ~/webroot
```

### Cloning the Repository

1. **Clone the project from GitHub**:
   ```bash
   git clone https://github.com/nhanlq/itconsultis-drupal.git
   ```
2. **Move into the project directory**:
   ```bash
   cd itconsultis-drupal
   ```

### Setup

## Installation

### Start project

1. Run command `fin start` to start build project in your local machine
2. Extract database `itconsoltis.zip`
3. Import database ` fin db import itconsoltis.sql`
4. Run clear cache before run test `fin drush cr`
5. Login admin via drush `fin drush uli` then copy url then paste to your browser
   

### Create content for about us page

1. **Create a page of about us content type**
2. **Enter all data then go to frontend page to check (http://localhost:3000)**:


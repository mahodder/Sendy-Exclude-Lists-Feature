# Sendy-Exclude-Lists-Feature
Works only with Sendy 2.0.4

Instructions:

* Back up your files and database just in case.
* Unzip and upload its contents to your Sendy installation using an FTP client (like FileZilla) overwriting Sendy files.
* Go to url http://your-sendy-installation.com/exclude-db-changes.php Put your own Sendy url of course. This will make a necessary change to your database.
* Delete exclude-db-changes.php file from your server.

That should be it. Now when you create a new campaign you'll have an option to select which lists you'd like to exclude.

Adapted from Igor's version for Sendy 2.0.3 https://sendy.co/forum/discussion/5827/mod-exclude-lists-feature
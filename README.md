# Translation service helper

Find translation files. Extract and combine strings. Export to format of your choice.

### When, why and how to use the translation service helper ? ###

* When? You have a localized project which consists of different parts (e.g. web, mobile, app). You want to bring together all the different translation strings into one resource (file).
* Why? Makes it easy to create a single resource (file) from many different translation files to give to a translator.
* How? 
 * See all commands: php src/cli.php 
 * Execute with config file: php src/cli.php -c myconfig.yaml -e android -p myproject -q

### Minimum requirements ###

* Make sure you have a PHP interpreter (Min. version 5.2.4)
* Install composer (see https://getcomposer.org/doc/00-intro.md)
* Clone the git repository (see https://github.com/OpenHaus/translation-service-helper) into a directory of your choice
* Change into the directory where you cloned the git respository into
* Run 'composer install' in this directory

### Contribution guidelines ###

* Please see the source.
* Happy to get unit tests.

### Who do I talk to? ###

* Created by * [Fabio Bacigalupo](mailto:f.bacigalupo@open-haus.de). Feel free to get in touch (OpenHaus on github.com). I´d love to hear your feedback!
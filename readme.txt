=== Testing Elevated ===
Contributors: utsavladani
Donate link: https://github.com/Utsav-Ladani/Testing-Elevated
Tags: testing, testing elevated, database, commit, rollback
Requires at least: 5.0
Tested up to: 6.3
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Quick testing environment for WordPress. It helps to test the feature and commit or rollback the changes.

== Description ==

# Testing Elevated
This plugin helps to test the WordPress plugin or theme. It creates a kind of virtual environment for testing. You can do all things without affecting the site's actual database, but still, things work as they should be. After that, you can revert the changes or apply the changes to the actual database.

It helps when you want to test something on the actual database but not sure about the results. It is very helpful for testing or developing the plugin or theme.

## Features
- Revert or flush the changes you made during testing.
- Apply those changes to the actual database and make it persistent.

## How to use

1. Install and activate the plugin.
2. Select the *Start* option from the sidebar.
3. Do your testing.
4. Select the *Rollback* option from the sidebar to revert the changes.
5. Select the *Commit* option from the sidebar to apply the changes to the actual database.

## Want to contribute?

1. [Fork the repository](https://github.com/Utsav-Ladani/Testing-Elevated).
2. Clone the repository.
3. Create a new branch.
4. Make changes.
5. Commit and push the changes.
6. Create a pull request.
7. Wait for the review.
8. If everything is fine, your pull request will be merged.

== Frequently Asked Questions ==

= How to use this plugin? =

1. Install and activate the plugin.
2. Select the *Start* option from the sidebar.
3. Do your testing.
4. Select the *Rollback* option from the sidebar to revert the changes.
5. Select the *Commit* option from the sidebar to apply the changes to the actual database.

= It is not working? =

It requires to place the *db.php* file in the *wp-content* directory. If another plugin is already using the *db.php* file, then it will not work. In that case, you can copy the code from the *db.php* file from this plugin and paste it into the existing *db.php* file.

== Screenshots ==

1. Testing Elevated plugin sidebar menu.

== Changelog ==

= 1.0.0 =
* First release :)

== Upgrade Notice ==

= 1.0.0 =
* First release :)

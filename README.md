# Testing Elevated

This plugin helps to test the WordPress. It creates kind of virtual environment for testing. You can do all things without affecting the site's actual database, but still things works as it should be. After that you have control to revert back the changes or apply the changes to the actual database. 

It helps when you want to test something on actual database but not sure about the results. It is very helpful for testing or developing the plugins or themes. 

## Features
- Revert back or flush the changes you made during testing.
- Apply those changes to the actual database and make it persistent.

## Warning
- Things not works as expected when want to create a new post or anythings which is associated with the auto-incremented ID.
- This plugin plugin works by disabling `autocommit` and `commit`/`rollback` the changes on database
- Any Insert query associated with auto generated primary key is tends to fail.

## Author
**Name**: Utsav Ladani


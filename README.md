# SSTM - Simple System Tests Management
Want a place to manage and perform your system tests ?  Automated testing tools are not always suitable for all type of softwares.  If you have a system where manual tests are required, SSTM is for you.  You will add your own systems, applications and features.  You manage and perform your own tests.

## Setup the system
On your web server, copy/paste all files you find in this repository.

### SQL Setup
The system needs specific tables and fields in your MySQL database.  The script `schema.sql` will create the database for you.

# SSTM - Model
In SSTM, you will define tests to perform for your applications.  But first, please take the time to read these definitions.

- Suite:  A suite is a system.
- Package:  A package is a group of applications within your suite.
- Application:  An application is a module or a group of functions.
- Function: A function is something your application do.

- Version: A version is a name or ID for a new release of your suite.
- Environment:  An environment is an isolated "place" where your suite lives (dev/test/live).

- Test: A test is something you want to try to confirm the function still works as it should.
- Phase: A phase is a set of tests you need to do for a new version in an envionment.

## Example
To help you understand, here is a simple example:

* Suite:  Microsoft Office
  * Package:  Word
    * Application:  Writing
      * Function: Predefined Styles
        * Test 1: Apply predefined style "Title" on a selected segment of text.
        * Test 2: Apply stype "Normal" to remove any style applied on a selected segment of text.
      * Function: Insert medias
        * Test 1: Insert a picture (file type JPEG)
        * Test 2: Insert a picture (file type PNG)
        * Test 3: Insert a Youtube video
    * Application: Mail merge
      * Function: Create labels
        * Test 1: Create labels from an Excel spreadsheet
        * Test 2: Create labels from a CSV file


# SSTM - Add a suite
1. In the top-menu, select Suite, then, New suite.
1. Enter a suite name.
1. You will be redirected to your new suite.

## SSTM - Set your suite
When you are in the suite view, a new "Add" option is available in the top-menu.
Use this option to add a new Package, Application, Environment or Version.  You can also add a new test from there.


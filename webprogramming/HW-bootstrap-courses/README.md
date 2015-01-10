Assignment 9
============

See assignment-9.pdf on ItsLearning for the detailed description of the required functionality.


Project setup
-------------

You are provided with a skeleton application that includes basic functionality for navigating between the different pages.

  * We are using Smarty to avoid code duplication. The skeleton that takes care of the navigation is provided. PHP is used only for serving static pages; you'll need to set your Smarty path in the `inc/config.inc.php` file, but apart from that no changes to the PHP files are required.
  * The functionality has to be implemented on the client side, that means, you'll need to edit the template files (`smarty/templates/*.tpl`) and JavaScript files (`js/*.js`).
  * Each page has a main div with a unique id (main, modules, course). To decide which page we are on, we check whether the given div id exists; this is already added in `js/myscripts.js`.
  * All required Bootstrap and jQuery components are already included in `index.tpl`.


Hints
-----

### Task 1

  * The container element for the fixed-width grid layout is already included in `index.tpl`. (Meaning: you don't need to change `index.tpl` at all.)
  * Create the required layout for the main page in `main.tpl`.
  * Navigation bar (`templates/navbar.tpl`):
    * See <http://getbootstrap.com/components/#navbar-default>
    * Use `container-fluid` for the navigation bar
    * Use `class="active"` for the active page


### Task 2

  * Files: 
    * `smarty/templates/modules.tpl`: The table using the appropriate Bootstrap classes is already added. You don't need to edit this file.
    * `js/modules.js`: add information about modules 
    * `js/myscripts.js`: complete the code inside `if ($('#modules').length > 0) {`
      * See <http://www.datatables.net/examples/data_sources/js_array.html> for using DataTables with JavaScript sourced data. Use the `modulesToTable()` function to get the list of modules in this format. 
  * For the optional sorting exercise see <http://datatables.net/development/sorting>


### Task 3

  * Edit `js/myscripts.js` (inside `if ($('#course').length > 0) {`)
    * Apart from initializing the modules table (similarly as it was done in Task 2), you also need to add an extra column to the table with a checkbox input element, and write some jQuery/JavaScript code to handle the event of selection/deselection of modules.
  * Edit `smarty/templates/course.tpl`
    * See <http://datatables.net/examples/api/form.html> on how to include form elements into DataTables.
    * See <http://getbootstrap.com/components/#progress-stacked> for the stacked progressbar component.


Delivery
--------

  1. Push your solution to github
  2. Deploy it on the unix servers so that it is available at <http://www.ux.uis.no/~yourusername/dat310-mycourse>
  3. Submit your unix username on itslearning

<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * tdmcreate module
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         tdmcreate
 * @since           2.5.0
 * @author          Txmod Xoops http://www.txmodxoops.org
 * @version         $Id: admin.php 11084 2013-02-23 15:44:20Z timgno $
 */
//Menu
define('_AM_TDMCREATE_ADMIN_INDEX', "Index");
define('_AM_TDMCREATE_ADMIN_MODULES', "Add Module");
define('_AM_TDMCREATE_ADMIN_TABLES', "Add Table");
define('_AM_TDMCREATE_ADMIN_CONST', "Build Module");
define('_AM_TDMCREATE_ADMIN_ABOUT', "About");
define('_AM_TDMCREATE_ADMIN_PREFERENCES', "Preferences");
define('_AM_TDMCREATE_ADMIN_UPDATE', "Update");
define('_AM_TDMCREATE_ADMIN_NUMMODULES', "Statistics");
define('_AM_TDMCREATE_THEREARE_NUMMODULES', "There are <span class='red bold'>%s</span> modules stored in the Database");
define('_AM_TDMCREATE_THEREARE_NUMTABLES', "There are <span class='red bold'>%s</span> tables stored in the Database");
define('_AM_TDMCREATE_THEREARE_NUMFIELDS', "There are <span class='red bold'>%s</span> fields stored in the Database");

define('_AM_TDMCREATE_TABLES_FIELDS_MORE_ELEMENTS', "Forms: Elements");
define('_AM_TDMCREATE_TABLES_FIELDS_MORE_PARENT_ID', "Parent: Category id");
define('_AM_TDMCREATE_TABLES_FIELDS_MORE_DISPLAY_ADMIN', "Page: Show admin");
define('_AM_TDMCREATE_TABLES_FIELDS_MORE_DISPLAY_USER', "Page: View User");
define('_AM_TDMCREATE_TABLES_FIELDS_MORE_BLOC', "Block: View");
define('_AM_TDMCREATE_TABLES_FIELDS_MORE_MAIN_FIELD', "Table: Main Field");
define('_AM_TDMCREATE_TABLES_FIELDS_MORE_SEARCH', "Search: Index");
define('_AM_TDMCREATE_TABLES_FIELDS_MORE_REQUIRED', "Forms: Required field");

// General
define('_AM_TDMCREATE_FORMOK', "Successfully saved");
define('_AM_TDMCREATE_FORMDELOK', "Successfully deleted");
define('_AM_TDMCREATE_FORMSUREDEL', "Are you sure to delete: <b><span style='color : Red'>%s </span></b>");
define('_AM_TDMCREATE_FORMSURERENEW', "Are you sure to update: <b><span style='color : Red'>%s </span></b>");
define('_AM_TDMCREATE_FORMUPLOAD', "Upload file");
define('_AM_TDMCREATE_FORMIMAGE_PATH', "Files in %s ");
define('_AM_TDMCREATE_FORMACTION', "Action");
define('_AM_TDMCREATE_FORMEDIT', "Modification");
define('_AM_TDMCREATE_FORMDEL', "Clear");
define('_AM_TDMCREATE_FORMFIELDS', "Edit fields");
define('_AM_TDMCREATE_FORM_INFO_TABLE_OPTIONAL_FIELD', "Optional fields");
define('_AM_TDMCREATE_FORM_INFO_TABLE_STRUCTURES_FIELD', "Structures fields");
define('_AM_TDMCREATE_FORM_INFO_TABLE_ICON_FIELD', "Icon fields");

define('_AM_TDMCREATE_ID', "ID");
define('_AM_TDMCREATE_NAME', "Name");
define('_AM_TDMCREATE_BLOCKS', "Blocks");
define('_AM_TDMCREATE_NB_FIELDS', "Number of fields");
define('_AM_TDMCREATE_IMAGE', "Image");
define('_AM_TDMCREATE_DISPLAY_ADMIN', "Visible in Admin Panel");
// 1.37
define('_AM_TDMCREATE_DISPLAY_USER', "Visible in User View");

//Modules.php
//Buttons
define('_AM_TDMCREATE_ADD_MODULE', "Add new module");
//Form
define('_AM_TDMCREATE_MODULE_ADD', "Add a new module");
define('_AM_TDMCREATE_MODULE_EDIT', "Edit module");
//define('_AM_TDMCREATE_MODULE_IMPORTANT', "Required Information");

define('_AM_TDMCREATE_MODULE_IMPORTANT', "Information");
define('_AM_TDMCREATE_MODULE_NOTIMPORTANT', "Optional Information");
define('_AM_TDMCREATE_MODULE_ID', "Id");
define('_AM_TDMCREATE_MODULE_NAME', "Name");
define('_AM_TDMCREATE_MODULE_NAME_DESC', "The module name can contain spaces and special characters such as accents.<br /> 
An example would be: <b class='white'>My Simple Module</b>");
define('_AM_TDMCREATE_MODULE_DIRNAME', "Directory Name");
define('_AM_TDMCREATE_MODULE_DIRNAME_DESC', "The module directory can not contain spaces or special characters such as accents.<br /> 
An example would be: <b class='white'>mysimplemodule</b>.<br />In case you write the module directory with uppercase characters, they are replaced automatically with lowercase, and if there are spaces they will also be automatically deleted.");
define('_AM_TDMCREATE_MODULE_VERSION', "Version");
define('_AM_TDMCREATE_MODULE_SINCE', "Since");
define('_AM_TDMCREATE_MODULE_DESCRIPTION', "Description");
define('_AM_TDMCREATE_MODULE_AUTHOR', "Author");
define('_AM_TDMCREATE_MODULE_AUTHOR_MAIL', "Author Email");
define('_AM_TDMCREATE_MODULE_AUTHOR_WEBSITE_URL', "Author Site Url");
define('_AM_TDMCREATE_MODULE_AUTHOR_WEBSITE_NAME', "Author Site Name");
define('_AM_TDMCREATE_MODULE_CREDITS', "Credits");	
define('_AM_TDMCREATE_MODULE_LICENSE', "License");
define('_AM_TDMCREATE_MODULE_RELEASE_INFO', "Release Info");	
define('_AM_TDMCREATE_MODULE_RELEASE_FILE', "Release File");
define('_AM_TDMCREATE_MODULE_MANUAL', "Manual");	
define('_AM_TDMCREATE_MODULE_MANUAL_FILE', "Manual File");
define('_AM_TDMCREATE_MODULE_IMAGE', "Image");
define('_AM_TDMCREATE_MODULE_DEMO_SITE_URL', "Demo Site Url");	
define('_AM_TDMCREATE_MODULE_DEMO_SITE_NAME', "Demo Site Name");	
define('_AM_TDMCREATE_MODULE_SUPPORT_URL', "Support URL");
define('_AM_TDMCREATE_MODULE_SUPPORT_NAME', "Support Name");
define('_AM_TDMCREATE_MODULE_WEBSITE_URL', "Module Website URL");
define('_AM_TDMCREATE_MODULE_WEBSITE_NAME', "Module Website Name");
define('_AM_TDMCREATE_MODULE_RELEASE', "Release");
define('_AM_TDMCREATE_MODULE_STATUS', "Status");
define('_AM_TDMCREATE_MODULE_PAYPAL_BUTTON', "Button for Donations");
define('_AM_TDMCREATE_MODULE_SUBVERSION', "Subversion module");
define('_AM_TDMCREATE_MODULE_ADMIN', "Visible Admin");
define('_AM_TDMCREATE_MODULE_USER', "Visible User");
define('_AM_TDMCREATE_MODULE_SEARCH', "Enable Search");
define('_AM_TDMCREATE_MODULE_COMMENTS', "Enable Comments");
define('_AM_TDMCREATE_MODULE_NOTIFICATIONS', "Enable Notifications");
define('_AM_TDMCREATE_MODULE_PERMISSIONS', "Enable Permissions");
define('_AM_TDMCREATE_MODULE_INROOT_COPY', "Copy this module also in root/modules?");
// Added in version 1.39
define('_AM_TDMCREATE_MODULE_NBFIELDS', "Fields");
define('_AM_TDMCREATE_MODULE_BLOCKS', "Blocks");
define('_AM_TDMCREATE_MODULE_ADMIN_LIST', "Admin");
define('_AM_TDMCREATE_MODULE_USER_LIST', "User");
define('_AM_TDMCREATE_MODULE_SUBMENU_LIST', "Submenu");
define('_AM_TDMCREATE_MODULE_SEARCH_LIST', "Search");
define('_AM_TDMCREATE_MODULE_COMMENTS_LIST', "Comments");
define('_AM_TDMCREATE_MODULE_NOTIFICATIONS_LIST', "Notifications");
define('_AM_TDMCREATE_MODULE_PERMISSIONS_LIST', "Permissions");
define('_AM_TDMCREATE_MODULE_MIN_PHP', "Minimum PHP");
define('_AM_TDMCREATE_MODULE_MIN_XOOPS', "Minimum XOOPS");
define('_AM_TDMCREATE_MODULE_MIN_ADMIN', "Minimum Admin");
define('_AM_TDMCREATE_MODULE_MIN_MYSQL', "Minimum Database");

//Tables.php
// Buttons
define('_AM_TDMCREATE_ADD_TABLE', "Add new table");
//Form1
define('_AM_TDMCREATE_TABLE_ADD', "Add Table");
define('_AM_TDMCREATE_TABLE_EDIT', "Edit Table");
define('_AM_TDMCREATE_TABLE_MODULES', "Choose a module");
define('_AM_TDMCREATE_TABLE_NAME', "Table Name");
define('_AM_TDMCREATE_TABLE_NAME_DESC', "Unique Name for this Table, and is automatically added the prefix <span class='bold'>mod_</span>");
define('_AM_TDMCREATE_TABLE_CATEGORY', "This table is a category or topic?");
define('_AM_TDMCREATE_TABLE_CATEGORY_DESC', "<b class='red bold'>WARNING</b>: <i>Once you have used this option for this module, and edit this table,<br />will not be displayed following the creation of other tables</i>");
define('_AM_TDMCREATE_TABLE_NBFIELDS', "Number fields");
define('_AM_TDMCREATE_TABLE_NBFIELDS_DESC', "Number of fields for this table");
define('_AM_TDMCREATE_TABLE_FIELDNAME', "Prefix Field Name");
define('_AM_TDMCREATE_TABLE_FIELDNAME_DESC', "This is the prefix of field name (optional)<br />If you leave the field blank, doesn't appear anything in the fields of the next screen,<br />otherwise you'll see all the fields with a prefix type (e.g: <span class='bold'>cat</span> of table <span class='bold'>categories</span>)");
define('_AM_TDMCREATE_TABLE_OPTIONS_CHECKS_DESC', "For each table created, a file is created on behalf of this.<br /> 
Selecting one or more of these options, deciding whether to enter the name of the file to other files or you define a condition in these other files, need to be created or not.");
define('_AM_TDMCREATE_TABLE_IMAGE', "Table Logo");
// Added in version 1.91
define('_AM_TDMCREATE_TABLE_AUTO_INCREMENT', " Auto Increment");
define('_AM_TDMCREATE_TABLE_AUTO_INCREMENT_OPTION', "Default checked");
define('_AM_TDMCREATE_TABLE_AUTO_INCREMENT_DESC', "Check this option if table have the Auto Increment ID");
//
define('_AM_TDMCREATE_TABLE_BLOCKS', "Block for this table");
define('_AM_TDMCREATE_TABLE_BLOCKS_DESC', "(blocks: random, latest, today)");
define('_AM_TDMCREATE_TABLE_ADMIN', "View in Admin Panel");
define('_AM_TDMCREATE_TABLE_USER', "View in User Side");
define('_AM_TDMCREATE_TABLE_SUBMENU', "View in Submenu");
define('_AM_TDMCREATE_TABLE_SEARCH', "Search for this table");
define('_AM_TDMCREATE_TABLE_EXIST', "The name specified for this table is already in use");
define('_AM_TDMCREATE_TABLE_COMMENTS', "Comments for this table");
// Added in version 1.39
define('_AM_TDMCREATE_TABLE_NOTIFICATIONS', "Notifications for this table");
define('_AM_TDMCREATE_TABLE_PERMISSIONS', "Permissions for this table");
// v1.38
define('_AM_TDMCREATE_TABLE_IMAGE_DESC', "<span class='red bold'>WARNING</span>: If you want to choose a new image, is best to name it with the module name before and follow with the name of the image so as not to overwrite any images with the same name, in the <span class='bold'>Frameworks/moduleclasses/moduleadmin/icons/32/</span>. Otherwise an other solution, would be to insert the images in the module, a new folder is created, with the creation of the same module - <span class='bold'>images/32</span>.");
define('_AM_TDMCREATE_TABLE_FORM_SAVED_OK', "The table <b class='green'>%s</b> is successfully saved");
define('_AM_TDMCREATE_TABLE_FORM_UPDATED_OK', "The table <b class='green'>%s</b> is successfully updated");

//Form2
define('_AM_TDMCREATE_FIELD_ADD', "Add fields");
define('_AM_TDMCREATE_FIELD_EDIT', "Edit fields");
define('_AM_TDMCREATE_FIELD_NUMBER', "N&#176;");
define('_AM_TDMCREATE_FIELD_NAME', "Field Name");
define('_AM_TDMCREATE_FIELD_TYPE', "Type");
define('_AM_TDMCREATE_FIELD_VALUE', "Value");
define('_AM_TDMCREATE_FIELD_ATTRIBUTE', "Attribute");
define('_AM_TDMCREATE_FIELD_NULL', "Null");
define('_AM_TDMCREATE_FIELD_DEFAULT', "Default");
define('_AM_TDMCREATE_FIELD_KEY', "Key");
// Others
define('_AM_TDMCREATE_FIELD_PARAMETERS', "Parameters");
define('_AM_TDMCREATE_FIELD_ELEMENTS', "Options Elements");
define('_AM_TDMCREATE_FIELD_ELEMENT_NAME', "Form: Element");
define('_AM_TDMCREATE_FIELD_ADMIN', "Page: Show Admin Side");
define('_AM_TDMCREATE_FIELD_USER', "Page: Show User Side");
define('_AM_TDMCREATE_FIELD_BLOCK', "Block: View");
define('_AM_TDMCREATE_FIELD_MAINFIELD', "Table: Main Field");
define('_AM_TDMCREATE_FIELD_SEARCH', "Search: Index");
define('_AM_TDMCREATE_FIELD_REQUIRED', "Field: Required");
define('_AM_TDMCREATE_ADMIN_SUBMIT', "Send");

define('_AM_TDMCREATE_ID_LIST', "Id");
define('_AM_TDMCREATE_NAME_LIST', "Name");
define('_AM_TDMCREATE_IMAGE_LIST', "Image");
define('_AM_TDMCREATE_NBFIELDS_LIST', "Fields");
define('_AM_TDMCREATE_PARENT_LIST', "Parent");
define('_AM_TDMCREATE_INLIST_LIST', "Inlist");
define('_AM_TDMCREATE_INFORM_LIST', "Inform");
define('_AM_TDMCREATE_ADMIN_LIST', "Admin");
define('_AM_TDMCREATE_USER_LIST', "User");	 
define('_AM_TDMCREATE_BLOCK_LIST', "Block");
define('_AM_TDMCREATE_MAIN_LIST', "Main");
define('_AM_TDMCREATE_SEARCH_LIST', "Search");
define('_AM_TDMCREATE_REQUIRED_LIST', "Required");

//Modules.php
//Form
define('_AM_TDMCREATE_MODULES_ADD', "Add a new module");
define('_AM_TDMCREATE_MODULES_EDIT', "Create a module");
define('_AM_TDMCREATE_MODULES_IMPORTANT', "Required Information");
define('_AM_TDMCREATE_MODULES_NOTIMPORTANT', "Optional Information");
define('_AM_TDMCREATE_MODULES_NAME', "Name");
define('_AM_TDMCREATE_MODULES_VERSION', "Version");
define('_AM_TDMCREATE_MODULES_SINCE', "Since");
define('_AM_TDMCREATE_MODULES_DESCRIPTION', "Description");
define('_AM_TDMCREATE_MODULES_AUTHOR', "Author");
define('_AM_TDMCREATE_MODULES_AUTHOR_MAIL', "Author's Email");
define('_AM_TDMCREATE_MODULES_AUTHOR_WEBSITE_URL', "Author's Website");
define('_AM_TDMCREATE_MODULES_AUTHOR_WEBSITE_NAME', "Website's Name");
define('_AM_TDMCREATE_MODULES_CREDITS', "Credits");	
define('_AM_TDMCREATE_MODULES_LICENSE', "License");
define('_AM_TDMCREATE_MODULES_RELEASE_INFO', "Release Info");	
define('_AM_TDMCREATE_MODULES_RELEASE_FILE', "File attached to the release");
define('_AM_TDMCREATE_MODULES_MANUAL', "Manual");	
define('_AM_TDMCREATE_MODULES_MANUAL_FILE', "Manual file");
define('_AM_TDMCREATE_MODULES_IMAGE', "Logo of the module");
define('_AM_TDMCREATE_MODULES_DEMO_SITE_URL', "URL of the demo site");
define('_AM_TDMCREATE_MODULES_DEMO_SITE_NAME', "Title of the demo site");	
define('_AM_TDMCREATE_MODULES_FORUM_SITE_URL', "Forum URL");
define('_AM_TDMCREATE_MODULES_FORUM_SITE_NAME', "Forum URL Title");
define('_AM_TDMCREATE_MODULES_WEBSITE_URL', "Module Website");
define('_AM_TDMCREATE_MODULES_WEBSITE_NAME', "Module Website Title");
define('_AM_TDMCREATE_MODULES_RELEASE', "Release");
define('_AM_TDMCREATE_MODULES_STATUS', "Status");
define('_AM_TDMCREATE_MODULES_DISPLAY_ADMIN', "Visible in Admin");
define('_AM_TDMCREATE_MODULES_DISPLAY_USER', "Visible in User side");
define('_AM_TDMCREATE_MODULES_ACTIVE_SEARCH', "Enable search");
define('_AM_TDMCREATE_MODULES_ACTIVE_COMMENTS', "Enable comments");
define('_AM_TDMCREATE_MODULES_ACTIVE_NOTIFICATIONS', "Enable notifications");
define('_AM_TDMCREATE_MODULES_ACTIVE_PERMISSIONS', "Enable Permissions");
define('_AM_TDMCREATE_MODULE_INROOT_MODULES_COPY', "Copy of this module directly in root/modules?");
define('_AM_TDMCREATE_MODULES_PAYPAL_BUTTON', "Paypal Button");
define('_AM_TDMCREATE_MODULES_SUBVERSION', "Subversion");

//Tables.php
//Form1
define('_AM_TDMCREATE_TABLES_ADD', "Add tables to the form:");
define('_AM_TDMCREATE_TABLES_EDIT', "Edit Module Tables");
define('_AM_TDMCREATE_TABLES_MODULES', "Select a module");
define('_AM_TDMCREATE_TABLES_NAME', "Name of the table <br> <i>(The name of the module will automatically be added to the prefix)</i> <br> Example: &#39;mod_module-name_table&#39;");
define('_AM_TDMCREATE_TABLES_FIELDNAME', "Prefix of the fields <br> <i>(The prefix name will automatically be added in the next step)</i><br />Example: &#39;fieldname&#39;<br />WARNING: Don't use underscore first of fieldname - this is what TDMCreate was generating");
define('_AM_TDMCREATE_TABLES_NUMBER_FIELDS', "Number of fields for this table");
define('_AM_TDMCREATE_TABLES_IMAGE', "Table Icon");
define('_AM_TDMCREATE_TABLES_CATEGORY', "This table is a category?");
define('_AM_TDMCREATE_TABLES_CATEGORY_DESC', "<i>Once you have used this field,<br />will not be displayed following the creation of other tables</i>");
define('_AM_TDMCREATE_TABLES_BLOCKS', "Create block for this table");
define('_AM_TDMCREATE_TABLES_ADMIN', "Visible in Admin View");
define('_AM_TDMCREATE_TABLES_USER', "Visible in User View");
define('_AM_TDMCREATE_TABLES_SUBMITTER', "Add submitter");
define('_AM_TDMCREATE_TABLES_CREATED', "Add created");
define('_AM_TDMCREATE_TABLES_ONLINE', "Add online");
define('_AM_TDMCREATE_TABLES_SEARCH', "Active research for this table <br> <i>The form for the moment, is able to handle the search on the table <br> If you confirm the search option will be disabled</i>");
define('_AM_TDMCREATE_TABLES_EXIST', "The name specified for this table is already in use");
define('_AM_TDMCREATE_TABLES_COMMENTS', "Active comments for this table <br> <i>The module can manage for the moment, the comments on a table <br> Comments option will be disabled if you Confirmed</i>");
define('_AM_TDMCREATE_TABLES_NOTIFICATIONS', "Active notifications for this table.");
define('_AM_TDMCREATE_TABLES_PERMISSIONS', "Active permissions for this table <br /> <i><span class='red big'>WARNING</span>: you can use only for this table</i>");
define('_AM_TDMCREATE_TABLES_CATEGORY_ADD', "Add the table to the category");
//Form2
define('_AM_TDMCREATE_TABLES_FIELDS_ADD', "Add the fields");
define('_AM_TDMCREATE_TABLES_FIELDS_EDIT', "Edit your field");
define('_AM_TDMCREATE_TABLES_FIELDS_NAME', "Field Name");
define('_AM_TDMCREATE_TABLES_FIELDS_TYPE', "Type");
define('_AM_TDMCREATE_TABLES_FIELDS_VALUE', "Value");
define('_AM_TDMCREATE_TABLES_FIELDS_ATTRIBUTES', "Attributes");
define('_AM_TDMCREATE_TABLES_FIELDS_NULL', "Null");
define('_AM_TDMCREATE_TABLES_FIELDS_DEFAULT', "Default");
define('_AM_TDMCREATE_TABLES_FIELDS_INDEX', "Index");
define('_AM_TDMCREATE_TABLES_FIELDS_MORE', "Other");
//define('_AM_TDMCREATE_ADMIN_SUBMIT', "Submit");
//Const.php
define('_AM_TDMCREATE_CONST_MODULES', "Select the module you want to build");
define('_AM_TDMCREATE_CONST_TABLES', "Select the table you want to build");

//------------ new additions: Ver. 1.11 -----------------------

define('_AM_TDMCREATE_ADMIN_PERMISSIONS', "Permissions");
define('_AM_TDMCREATE_FORMON', "Online");
define('_AM_TDMCREATE_FORMOFF', "Offline");

define('_AM_TDMCREATE_TRANSLATION_PERMISSIONS_ACCESS', "Allowed to access");
define('_AM_TDMCREATE_TRANSLATION_PERMISSIONS_SUBMIT', "Allowed to post");

define('_AM_TDMCREATE_THEREARE_DATABASE1', "There are <span style='color: #ff0000; font-weight: bold'>%s</span>");
define('_AM_TDMCREATE_THEREARE_DATABASE2', "in the database");
define('_AM_TDMCREATE_THEREARE_PENDING', "There are <span style='color: #ff0000; font-weight: bold'>%s</span>");
define('_AM_TDMCREATE_THEREARE_PENDING2', "waiting");

define('_AM_TDMCREATE_FORMADD', "Add");

define('_AM_TDMCREATE_MIMETYPES', "Mime types authorized for:");
define('_AM_TDMCREATE_MIMESIZE', "Allowable size:");
define('_AM_TDMCREATE_EDITOR', "Editor:");

//------------ new additions: Ver. 1.15 -----------------------

define('_AM_TDMCREATE_ABOUT_WEBSITE_FORUM', "Forum Web Site");

//------------ new additions: Ver. 1.37 -----------------------
define('_AM_TDMCREATE_MODULES_LIST', "Module List");
define('_AM_TDMCREATE_MODULES_NEW', "New Module");
define('_AM_TDMCREATE_TABLES_LIST', "Tables List");
define('_AM_TDMCREATE_TABLES_NEW', "New Table");
define('_AM_TDMCREATE_TABLES_NEW_CATEGORY', "New Category");
define('_AM_TDMCREATE_FIELDS_LIST', "Fields List");

//1.38
define('_AM_TDMCREATE_TABLES_STATUS', "Show Table Status");
define('_AM_TDMCREATE_TABLES_WAITING', "Show Table Waiting");

//1.39
define('_AM_TDMCREATE_MODULES_MIN_PHP', "Minimum PHP");
define('_AM_TDMCREATE_MODULES_MIN_XOOPS', "Minimum XOOPS");
define('_AM_TDMCREATE_MODULES_MIN_ADMIN', "Minimum Admin");
define('_AM_TDMCREATE_MODULES_MIN_MYSQL', "Minimum Database");
define('_AM_TDMCREATE_BUILDING_FILES', "Files that have been compiled");
define('_AM_TDMCREATE_BUILDING_SUCCESS', "Success build");
define('_AM_TDMCREATE_BUILDING_FAILED', "Failed build");
define('_AM_TDMCREATE_CONST_OK_ARCHITECTURE_ROOT', "The structure of the module was created in root/modules (index.html, folders, ...)");
define('_AM_TDMCREATE_CONST_NOTOK_ARCHITECTURE_ROOT', "Problems: Creating the structure of the module in root/modules (index.html, icons ,...)");

// Added in version 1.59
define('_AM_TDMCREATE_TABLE_ID', "Id");
define('_AM_TDMCREATE_TABLE_NAME_LIST', "Name");
define('_AM_TDMCREATE_TABLE_IMAGE_LIST', "Table Icon");
define('_AM_TDMCREATE_TABLE_NBFIELDS_LIST', "Fields");
define('_AM_TDMCREATE_TABLE_BLOCKS_LIST', "Blocks");
define('_AM_TDMCREATE_TABLE_ADMIN_LIST', "Admin");
define('_AM_TDMCREATE_TABLE_USER_LIST', "User");
define('_AM_TDMCREATE_TABLE_SUBMENU_LIST', "Submenu");
define('_AM_TDMCREATE_TABLE_SEARCH_LIST', "Search");
define('_AM_TDMCREATE_TABLE_COMMENTS_LIST', "Comments");
define('_AM_TDMCREATE_TABLE_NOTIFICATIONS_LIST', "Notifications");
define('_AM_TDMCREATE_TABLE_PERMISSIONS_LIST', "Permissions");
define('_AM_TDMCREATE_EDIT_TABLE', "Edit Table");
define('_AM_TDMCREATE_EDIT_FIELDS', "Edit Fields");
define('_AM_TDMCREATE_BUILD_INROOT', "Do you want to install this module in the modules root of your site?");
define('_AM_TDMCREATE_BUILD_INROOT_DESC', "<b class='red big'>WARNING</b>: If in the modules directory of your site is installed a module with the same name,<br />as the one you are about to create now, this will be erased with the appropriate consequences.<br />We recommend you to first check, in the root/modules of your site, if this module already exists.");
//define('_AM_TDMCREATE_MODULE_PERMISSIONS', "Enable permissions");
//define('_AM_TDMCREATE_MODULE_INSTALL', "Install this module directly in root/modules?");

// Added in version 1.91
define('_AM_TDMCREATE_CHANGE_DISPLAY', "Change Display");
define('_AM_TDMCREATE_TOGGLE_SUCCESS', "Successfully Changed Display");
define('_AM_TDMCREATE_TOGGLE_FAILED', "Changing Display Failed");
define('_AM_TDMCREATE_ERROR_TABLE_NAME_EXIST', "<b class='red big'>WARNING</b>: The table <b class='big red'>%s</b> exists for this module, create a new one with a different name");
define('_AM_TDMCREATE_FIELD_PARENT', "Field: Is parent");
define('_AM_TDMCREATE_FIELD_INLIST', "Admin: Visible in list");
define('_AM_TDMCREATE_FIELD_INFORM', "Admin: Visible in form");
define('_AM_TDMCREATE_TABLE_MODSELOPT', "Select a Module");
define('_AM_TDMCREATE_BUILD_MODSELOPT', "Select and build a Module");
define('_AM_TDMCREATE_NOTMODULES', "There aren't modules, pleace create one first");
define('_AM_TDMCREATE_NOTTABLES', "There aren't tables, pleace create one first");
define('_AM_TDMCREATE_FIELD_FORM_SAVED_OK', "Fields of table %s successfully saved");
define('_AM_TDMCREATE_FIELD_FORM_UPDATED_OK', "Fields of table %s successfully updated");
//
define('_AM_TDMCREATE_THEREARENT_MODULES', "There aren't modules");
define('_AM_TDMCREATE_THEREARENT_TABLES', "There aren't tables");
define('_AM_TDMCREATE_THEREARENT_FIELDS', "There aren't fields");
//Creation
define('_AM_TDMCREATE_MODULE_BUTTON_NEW_LOGO', "Create new Logo");
//OK
define('_AM_TDMCREATE_OK_ARCHITECTURE', "<span class='green'>The structure of the module was created (index.html, folders, icons, docs files)</span>");
define('_AM_TDMCREATE_FILE_CREATED', "The file <b>%s</b> is created in the <span class='green bold'>%s</span> folder");
//NOTOK
define('_AM_TDMCREATE_NOTOK_ARCHITECTURE', "<span class='red'>Problems: Creating the structure of the module (index.html, folders, icons, docs files)</span>");
define('_AM_TDMCREATE_FILE_NOTCREATED', "Problems: Creating file <b class='red'>%s</b> in the <span class='red bold'>%s</span> folder");
//
define('_AM_TDMCREATE_BUILDING_DIRECTORY', "Files created in the directory <span class='bold'>uploads/tdmcreate/repository/</span> of the module <span class='bold green'>%s</span>");
define('_AM_TDMCREATE_FIELD_PARAMETERS_LIST', "<b>Parameters List</b>");
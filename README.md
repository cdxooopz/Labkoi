# Labkoi<br>
Template MVC Bakoffice Project<br>
Included : <br>
• PDO Class database <br>
• Bootstrap  <br>
• Responsive Design <br>
• MVC Structure <br>
• Installation Module <br>

# How to start with this MVC template <br>
1. Download or clone this project to your local place.
2. Create Database that you need to connect (Required Mysql as base on project.).
3. Open url "http://localhost/[your_folder]/"
4. Enter the database config, Project config.
5. Enter the username and password after finish installation.
Note: You can manual setting without installation.php.
# Database use.
• You can used database class as below:<br>
```php
<?php
  $db = new DB();
  $db->table('tableName')->get();
```
or using Vivek Wicky Aswal's PDO class.
```php
<?php
  $db = new Model();
  $db->all();
```

# Refference <br>
• AdminLTE <br>
• Class Database from Vivek Wicky Aswal (Include Modified in Labkoi) <br>

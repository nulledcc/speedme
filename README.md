# speedme

Author: **Davit G.**
Date: **2017**

SpeedMe Beta V1.0

Speed me is a small MVC PHP framework

More documentation will be soon

#####DIR locations#####

Controllers: **api/controllers/**

Views: **api/views**

Models: **api/models**

helpers: **api/helpers**

#####ROUTING#####

http://www.yoursite.com/{actionController}/{method}/{other[array[...]]}

**default controller**

*controller.index.php*

**controller default method**

```php
public function actionIndex(){
  //controller action
}
```
Controller first action method can be used same as controller name.

For example` **controller.books.php**


```php
use speedme\views\view;

class books extends view {
    public function actionBooks(){
        parent::$page_title = 'My books';
        //render(['section'=>'php_view_file'])
        parent::render(array('body'=>'books'));
    }
}
```

Views are seample php files that have posibility to use custom variables.

In case of 'controller.books.php' view file is views/book.php'

book.php can have {t_name} rendering blocks

**controller.books.php**
```php
use speedme\views\view;

class books extends view {
    public function actionBooks(){
        parent::$page_title = 'My books';
        //render(['section'=>'php_view_file'])
        parent::render(array('body'=>'books'));
        parent::template('{my_test}','123');
        parent::template('{{my_double}}','456');
    }
}
```
**books.php**

```html
{my_test} {{my_double}}
```


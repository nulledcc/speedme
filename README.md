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
        parent::render(array('body'=>'books'));
    }
}
```



<?php
/*speedme framework
*Author : Davit G.
*contact-email: dxjan@ya.ru*/

use speedme\views\view;

class index extends view {

    public function actionIndex(){
        parent::$page_title = 'My website page title';
        parent::render(array('body'=>'index'));
        parent::template(
            '{test}',
            \speedme\helper\getbootstrap::alert('<strong>Danger</strong> try not to save.')->danger.
            \speedme\helper\getbootstrap::alert('test')->success.
            \speedme\helper\getbootstrap::badge('test',true)->default.
            \speedme\helper\getbootstrap::badge('test',true)->primary.
            \speedme\helper\getbootstrap::badge('test',true)->success.
            \speedme\helper\getbootstrap::badge('test',true)->warning.
            \speedme\helper\getbootstrap::badge('test')->danger.
            \speedme\helper\getbootstrap::badge('test')->info.
            \speedme\helper\getbootstrap::breadcrumb([
                ['value'=>'home','href'=>'#home'],
                ['value'=>'link1','href'=>'#l1'],
                ['value'=>'link2','href'=>'#l2'],
                ['value'=>'link3','active'=>true],
            ]).
            \speedme\helper\getbootstrap::breadcrumb([
                ['value'=>'home','href'=>'#home','attributes'=>['class'=>'keke','onclick'=>'alert(\'home\');return false;']],
                ['value'=>'link1','href'=>'#l1','attributes'=>['class'=>'keke','onclick'=>'alert(\'l1\');return false;']],
                ['value'=>'link2','href'=>'#l2'],
                ['value'=>'link3','active'=>true,'attributes'=>['class'=>'koko']]
            ],2).
            \speedme\helper\getbootstrap::button('button')->primary.
            \speedme\helper\getbootstrap::button('button','button',[],'input')->secondary.
            \speedme\helper\getbootstrap::button('button','button',[],'input')->success.
            \speedme\helper\getbootstrap::button('button','#button',[],'a')->link.
            \speedme\helper\getbootstrap::button('button','#button',[],'button',true,'button')->danger
        );
    }
}

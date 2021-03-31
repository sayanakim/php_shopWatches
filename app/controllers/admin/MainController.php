<?php


namespace app\controllers\admin;
use RedBeanPHP\R;

class MainController extends AppController
{
    public function indexAction() {
        $countNewOrder = R::count('order', "status = '0'");
        $countUsers = R::count('user');
        $countProducts = R::count('product');
        $countCategories = R::count('category');

        $this->setMeta('Панель управления');
        $this->set(compact('countNewOrder', 'countCategories', 'countProducts', 'countUsers'));

    }
}
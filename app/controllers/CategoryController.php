<?php


namespace app\controllers;


use app\models\Breadcrumbs;
use app\models\Category;
use ishop\App;
use ishop\libs\Pagination;

class CategoryController extends AppController
{
    public function viewAction()
    {
//        debug($this->route);
        $alias = $this->route['alias'];
        $category = \R::findOne('category', 'alias = ?', [$alias]);
//        debug($category);
        if (!$category) {
            throw new \Exception('Старница не найдена', 404);
        }

        // хлебные крошки
        $breadcrumbs = Breadcrumbs::getBreadcrumbs($category->id);

        $cat_model = new Category();
        $ids = $cat_model->getIds($category->id);
        $ids = !$ids ? $category->id : $ids . $category->id;

        // постраничная пагинация
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = App::$app->getProperty('pagination');
        $total = \R::count('product', "category_id IN ($ids)");
        $pagination = new Pagination($page, $perpage, $total);
//        echo $pagination;
        $start = $pagination->getStart();


        $products = \R::find('product', "category_id IN ($ids) LIMIT $start, $perpage");
        $this->setMeta($category->title, $category->description, $category->keywords);
        $this->set(compact('products', 'breadcrumbs', 'pagination', 'total'));
    }

}
<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class MagentoApiController extends Controller {

    protected $credentials = [
            'login' => 'mikoop',
            'password' => 't0UnNIyffihbb31HIPEpG',
            'path' => 'http://app.com.au'
        ];
    protected $images_category_id = '3';
    protected $adapter;
    protected $categoryManager;

    public function __construct(Request $request){
        return 'test';
        $this->adapter  = new \Smalot\Magento\RemoteAdapter($this->credentials['path'], $this->credentials['login'], $this->credentials['password']);
        $this->categoryManager = new \Smalot\Magento\Catalog\Category( $this->adapter );
    }
    /**
     *  Get all category arrays from magento
     *  @return Array
     * */
	public function getAllCategories(){

        $category = $this->getCategoryInfoById( $this->images_category_id );
        return $allCategories = explode( ",", $category['children'] );

    }

    public function getCategoryInfoById( $id ){
            $category = $this->categoryManager->getInfo( $id )->execute();
            return $category;
    }

    public function getCategoryNames(){

        $category_ids = $this->getAllCategories();
        $category_names = [];

        foreach($category_ids as $category_id){

            $item['id'] = $category_id;
            $category = $this->getCategoryInfoById( $category_id );
            $item['name'] = $category['name'];

            array_push($category_names, $item );
        }
        return $category_names;
    }

    public function getProductsByCategory($id){


        return $id;
    }
}

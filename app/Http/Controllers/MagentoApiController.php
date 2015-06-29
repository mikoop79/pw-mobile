<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;


class MagentoApiController extends Controller {

    protected $credentials = [
            'login' => 'mikoop',
            'password' => 't0UnNIyffihbb31HIPEpG',
            'path' => 'http://pickawall.com.au'
        ];

    protected $images_category_id = '3';
    protected $adapter;
    protected $categoryManager;
    protected $queue;
    protected $product_queue;
    protected $productManager;


    public function __construct(Request $request){
        $this->adapter  = new \Smalot\Magento\RemoteAdapter($this->credentials['path'], $this->credentials['login'], $this->credentials['password']);
        $this->categoryManager = new \Smalot\Magento\Catalog\Category( $this->adapter );
        // Build the queue for multicall
        $this->queue = new \Smalot\Magento\MultiCallQueue($this->adapter);
    }
    /**
     *  Get all category arrays from magento
     *  @return Array
     * */
	public function getAllCategories(){
        // new manager for the all the ids from list
        $categoryManager = new \Smalot\Magento\Catalog\Category( $this->adapter );
        $category = $categoryManager->getInfo( $this->images_category_id )->execute();
        // send string to array to use.
        return $allCategories = explode( ",", $category['children'] );
    }

    /**
     * Add multiple category requests to the queue
     * @param $category_id
     *
     * */
    public function addCategoryToQueue( $id ){
            $this->categoryManager->getInfo( $id )->addToQueue( $this->queue );
    }

    /**
     * Get all the category names from the ids.
     * @return array of all categories with full list
     * */
    public function getCategories(){

        $category_ids = $this->getAllCategories();
        foreach( $category_ids as $category_id ){
            $this->addCategoryToQueue( $category_id );
        }
        $categories = $this->queue->execute();
        return $categories;
    }
    /*=
     *  Get the array of items to go into the select dropdown
     *  @return array of categories. eg. id => '1' and 'name' => 'images'
     * */
    public function getCategoryList(){
        $select_list = [];
        $categories = $this->getCategories();
        foreach($categories as $category) {
            $item['id'] = $category['category_id'];
            $item['name'] = $category['name'];
            array_push($select_list, $item);
        }
        return $select_list;
    }

    public function getProductsByCategoryId( $id ){
        // new manager for the all the ids from list

        $this->product_queue = new \Smalot\Magento\MultiCallQueue($this->adapter);
        $this->productManager = new \Smalot\Magento\Catalog\Product( $this->adapter );
        $categoryManager = new \Smalot\Magento\Catalog\Category( $this->adapter );
        $products  = $categoryManager->getAssignedProducts( $id )->execute();
        foreach($products as $product){
            $this->getProductDetails($product);
        }

//
        $product_details = $this->product_queue->execute();
        return $product_details;

    }

    public function getProductDetails($product){
            $this->productManager->getInfo( $product['product_id'] )->addToQueue( $this->product_queue );
    }



}

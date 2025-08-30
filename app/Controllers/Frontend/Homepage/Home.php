<?php
namespace App\Controllers\Frontend\Homepage;
use App\Controllers\FrontendController;

class Home extends FrontendController{

	public $data = [];

	public function __construct(){
		$this->data['module'] = 'home';
		$this->data['language'] = $this->currentLanguage();
	}

	public function index(){
        $session = session();
		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL;
		$panel = get_panel([
			'locate' => 'home',
			'language' => $this->currentLanguage()
		]);
        foreach ($panel as $key => $value) {
			$this->data['panel'][$value['keyword']] = $value;
		}

		$data = only_cat([
			'object' => [
				'catalogue' => json_encode([])
			],
			'module' => ['product', 'catalogue'],
			'select_cat' => '',
			'param' => [
				'language' => $this->currentLanguage()
			]
		]);

        foreach ($data as $key => $value) {
            $id[$key] = $value['id'];
            $data[$key]['post'] = [];
        }

        $id_list = [];
        if(isset($data) && is_array($data) && count($data)){
            foreach($data as $key => $val){
                $id_list[] = $val['id'];
            }
        }
        $mang = $this->AutoloadModel->_get_where([
            'select' => 'tb1.catalogueid, tb3.id, tb2.module, ,tb3.rate, tb3.price, tb3.price_promotion, tb3.hot, tb2.info, tb3.bar_code, tb3.length, tb3. width, tb3.landing_link, tb2.title,tb2.description,  tb2.content, tb2.canonical, tb3.created_at, tb3.album, tb3.image, tb4.title as cat_title, tb4.canonical as cat_canonical, tb3.created_at',
            'table' => 'object_relationship as tb1',
            'join' =>[
                [
                    'product_translate as tb2','tb2.module = "product" AND tb2.objectid = tb1.objectid AND tb2.language = \''.$this->currentLanguage().'\'','inner'
                ],
                [
                    'product as tb3', 'tb1.objectid = tb3.id','inner'
                ],
                [
                    'product_translate as tb4','tb4.module = "product_catalogue" AND tb3.catalogueid = tb4.objectid AND tb4.language = \''.$this->currentLanguage().'\'','inner'
                ],
            ],
            'where' => ['tb1.module' => 'product', 'tb3.deleted_at' => 0, 'tb3.publish' => 1],
            'where_in_field' => 'tb1.catalogueid',
            'where_in' => $id,
            'query' => '
                (
                    SELECT COUNT(*)
                    FROM product as t
                    WHERE tb3.catalogueid = t.catalogueid
                    AND tb3.id <= t.id AND tb3.deleted_at = 0
                ) <= 12
            ',
            'group_by' => 'tb3.id',
            'limit' => 100,
            'order_by' => 'tb3.order desc, tb3.created_at desc'
        ],TRuE);
        if(isset($mang) &&  is_array($mang)  && count($mang)){
            foreach ($mang as $keymang => $valmang) {
                $mang[$keymang]['album'] = json_decode($valmang['album']);
                if(isset($mang[$keymang]['image']) && $mang[$keymang]['image'] != ''){
                    $mang[$keymang]['avatar'] = $mang[$keymang]['image'];
                }else{
                    $mang[$keymang]['avatar'] = (isset($mang[$keymang]['album'][0]) ? $mang[$keymang]['album'][0] : '');
                }
            }
        }

        if(isset($data) && is_array($data) && count($data)){
            foreach ($data as $key => $value) {
                foreach ($mang as $keyMang => $valueMang) {
                    if($value['id'] == $valueMang['catalogueid']){
                        $data[$key]['post'][] = $valueMang;
                    }
                }
            }
        }

		$this->data['home'] = 'home';
		$this->data['listProduct'] = $data;
		$this->data['template'] = 'frontend/homepage/home/index';
		return view('frontend/homepage/layout/home', $this->data);
	}

	public function condition_catalogue($catalogueid = 0){
		$id = [];
		if($catalogueid > 0){
			$catalogue = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
				'table' => 'product_catalogue as tb1',
				'join' =>  [
					[
						'product_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
					],
									],
				'where' => ['tb1.id' => $catalogueid],
			]);

			$catalogueChildren = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => 'product_catalogue',
				'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
			], TRUE);

			$id = array_column($catalogueChildren, 'id');
		}
		return [
			'where_in' => $id,
			'where_in_field' => 'tb1.catalogueid'
		];
	}

	public function quantri(){
        $session = session();
		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$this->data['template'] = 'frontend/homepage/home/quantri';
		return view('frontend/homepage/layout/home', $this->data);
	}

	public function customer(){
        $session = session();
		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$this->data['template'] = 'frontend/homepage/home/customer';
		return view('frontend/homepage/layout/home', $this->data);
	}

	public function wishlist(){
        $session = session();
        $cookie = (isset($_COOKIE['product_wishlist']) ? explode(',', $_COOKIE['product_wishlist']) : []);
		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL;
		if(isset($cookie) && is_array($cookie) && count($cookie)){
			$this->data['productList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.catalogueid as cat_id, tb1.price,tb1.hot,tb1.order, tb1.price_promotion, tb1.bar_code,  tb1.image,   tb1.publish, tb3.title ,   tb3.content, tb3.sub_title, tb3.sub_content, tb3.canonical, tb3.meta_title, tb3.meta_description, tb3.made_in ',
				'table' => 'product as tb1',
				'where' => [
					'tb1.deleted_at' => 0,
					'tb1.publish' => 1
				],
				'where_in' => $cookie,
				'where_in_field' => 'tb1.id',
				'join' => [
					[
						'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
					]
				],
				'order_by'=> 'tb1.order desc, tb1.id desc',
				'group_by' => 'tb1.id'
			], TRUE);
		}


		$this->data['home'] = 'home';
		$this->data['template'] = 'frontend/homepage/home/wishlist';
		return view('frontend/homepage/layout/home', $this->data);
	}

	private function handle_category($panel){
		$where_in = [];
		if(isset($panel['category-home']) && is_array($panel['category-home']) && count($panel['category-home'])){
			foreach ($panel['category-home'] as $keyCategory => $valueCategory) {
				if(isset($valueCategory) && is_array($valueCategory) && count($valueCategory)){
					foreach($panel['category-home'][$keyCategory]['data'] as $key => $val){
						$where_in[] = $val['id'];
					}

					$panel['category-home'][$keyCategory]['data'] = recursive($panel['category-home'][$keyCategory]['data']);
				}

				if(isset($panel['category-home'][$keyCategory]['data']) && is_array($panel['category-home'][$keyCategory]['data']) && count($panel['category-home'][$keyCategory]['data'])){
					foreach($panel['category-home'][$keyCategory]['data'] as $key => $val){
						if(isset($val['post']) && is_array($val['post']) && count($val['post'])){
							$panel['category-home'][$keyCategory]['data'][$key]['post'] = array_merge($panel['category-home'][$keyCategory]['data'][$key]['post'], $val['post']);
						}
						if(isset($val['children']) && is_array($val['children']) && count($val['children'])){
							$new_array = $this->get_child_panel($val['children']);
						}
					}
				}
			}
		}
		return $panel['category-home'];
	}

	private function get_child_panel($param = []){
		$arr = [];
		foreach ($param as $key => $value) {

			if(isset($value['post']) && is_array($value['post']) && count($value['post'])){
				$arr = array_merge($arr, $value['post']);
			}
		    if(isset($value['children']) && is_array($value['children']) && count($value['children'])){
		    	$new_array = $this->get_child_panel($value['children']);
		    	$arr = array_merge($arr, $new_array);
		    }
		}
		return $arr;
	}
}

<?php
namespace App\Controllers\Frontend\Auth;
use App\Controllers\FrontendController;

class DetailUser extends FrontendController{

	public $data = [];

	public function __construct(){
		$this->data['language'] = $this->currentLanguage();
		$this->data['module'] = 'member';
	}

	public function index(){
		$cookie = '';
		if(isset($_COOKIE[AUTH.'member']) && $_COOKIE[AUTH.'member'] != ''){
			$cookie = json_decode($_COOKIE[AUTH.'member'],TRUE);
		}
		$this->data['user'] = $this->AutoloadModel->_get_where([
			'select' => 'fullname, id, address, phone, image, gender, birthday, email, cityid, districtid, wardid, description',
			'table' => 'member',
			'where' => [
				'publish' => 1,
				'deleted_at' => 0,
				'id' => $cookie['id']
			]
		]);

		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL.'thong-tin-chi-tiet'.HTSUFFIX;


		$this->data['home'] = 'detail_user';
        $this->data['template'] = 'frontend/auth/detail/index';
        return view('frontend/homepage/layout/home', $this->data);
	}

	public function update(){
		$cookie = '';
		if(isset($_COOKIE[AUTH.'member']) && $_COOKIE[AUTH.'member'] != ''){
			$cookie = json_decode($_COOKIE[AUTH.'member'],TRUE);
		}
		$this->data['user'] = $this->AutoloadModel->_get_where([
			'select' => 'fullname, id, address, phone, image, gender, birthday, email, cityid, districtid, wardid, description',
			'table' => 'member',
			'where' => [
				'publish' => 1,
				'deleted_at' => 0,
				'id' => $cookie['id']
			]
		]);

		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL.'thong-tin-chi-tiet'.HTSUFFIX;


		$this->data['home'] = 'detail_user';
        $this->data['template'] = 'frontend/auth/detail/update';
        return view('frontend/homepage/layout/home', $this->data);
	}

}

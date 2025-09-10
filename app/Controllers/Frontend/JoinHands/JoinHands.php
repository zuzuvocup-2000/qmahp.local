<?php
namespace App\Controllers\Frontend\JoinHands;

use App\Controllers\FrontendController;
use App\Models\LanguageKeywordModel;

class JoinHands extends FrontendController
{
    public $data = [];
    public $languageKeywordModel;

    public function __construct()
    {
        $this->data['module'] = 'join_hands';
        $this->data['language'] = $this->currentLanguage();
        $this->languageKeywordModel = new LanguageKeywordModel();
    }

    /**
     * Display the main "Join Hands" page
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        $session = session();
        $this->data['general'] = $this->general;
        $this->data['keywordList'] = $this->languageKeywordModel->getKeywordTranslations($this->data['language']);
        
        // Set meta information
        $this->data['meta_title'] = $this->data['keywordList']['chung-tay-title'];
        $this->data['meta_description'] = $this->data['keywordList']['chung-tay-description'];
        $this->data['og_type'] = 'website';
        $this->data['canonical'] = BASE_URL . 'chung-tay.html';
        $this->data['panel'] =  [];
        $panel = get_panel([
			'locate' => 'join_hands',
			'language' => $this->currentLanguage()
		]);
		foreach ($panel as $key => $value) {
			$this->data['panel'][$value['keyword']] = $value;
		}

        // Contact information
        $this->data['contact_info'] = [
            'address1' => 'Nhà NV21 BT 12 – Khu đô thị LIDECO – Hoài Đức – Hà Nội',
            'address2' => 'Số nhà 11, ngõ 68 Xuân Thuỷ - Cầu Giấy – Hà Nội',
            'phone1' => '0947 087 898',
            'phone2' => '0912 056 561',
            'email' => 'nguyentoquyen_68@yahoo.com',
            'bank_account' => '12310001041928',
            'bank_name' => 'Ngân hàng Đầu Tư và Phát Triển Việt Nam (BIDV)',
            'account_holder' => 'Quỹ Mái Ấm Hạnh Phúc'
        ];

        $this->data['template'] = 'frontend/join_hands/index';
        return view('frontend/homepage/layout/home', $this->data);
    }

    /**
     * Handle donation form submission
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function submitDonation()
    {
        $session = session();
        
        if ($this->request->getMethod() === 'post') {
            $validate = $this->validation();
            
            if ($this->validate($validate['validate'], $validate['errorValidate'])) {
                $store = [
                    'email' => trim($this->request->getPost('email')),
                    'fullname' => trim($this->request->getPost('fullname')),
                    'phone' => trim($this->request->getPost('phone')),
                    'address' => '', // Not required for donation form
                    'content' => trim($this->request->getPost('message')),
                    'title' => 'Gửi thông tin đóng góp',
                    'contactid' => $this->contact_id_generator(),
                    'type' => 'donation', // Mark as donation type
                    'deleted_at' => 0,
                    'created_at' => $this->currentTime
                ];
                
                $insert = $this->AutoloadModel->_insert([
                    'table' => 'contact',
                    'data' => $store
                ]);

                if ($insert > 0) {
                    $session->setFlashdata('success', 'Cảm ơn bạn đã đóng góp thông tin. Chúng tôi sẽ liên hệ lại sớm nhất!');
                    return redirect()->to(base_url('chung-tay.html'));
                } else {
                    $session->setFlashdata('errors', ['Có lỗi xảy ra xin vui lòng thử lại!']);
                    // Load lại trang với dữ liệu cũ
                    return $this->index();
                }
            } else {
                $errors = $this->validator->listErrors();
                $session->setFlashdata('errors', is_array($errors) ? $errors : [$errors]);
                // Lưu dữ liệu form để hiển thị lại
                $session->setFlashdata('form_data', [
                    'fullname' => $this->request->getPost('fullname'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'message' => $this->request->getPost('message')
                ]);
                // Load lại trang với dữ liệu cũ
                return $this->index();
            }
        }

        return redirect()->to(base_url('chung-tay.html'));
    }

    /**
     * Generate unique contact ID
     * 
     * @return string
     */
    private function contact_id_generator()
    {
        $order = $this->AutoloadModel->_get_where([
            'select' => 'id',
            'table' => 'contact',
            'order_by' => 'id desc'
        ]);
        $lastId = 0;
        if (!isset($order) || is_array($order) == false || count($order) == 0) {
            $lastId = 1;
        } else {
            $lastId = $order['id'] + 1;
        }
        $orderId = 'CT_' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
        return $orderId;
    }

    /**
     * Validation rules for donation form
     * 
     * @return array
     */
    private function validation()
    {
        // Load validation helper
        helper('validation');
        
        // Get validation rules from constants
        $validate = get_form_validation_rules('donation_form');
        
        // Get validation messages based on current language
        $errorValidate = get_form_validation_messages('donation_form', $this->data['language']);
        
        return [
            'validate' => $validate,
            'errorValidate' => $errorValidate,
        ];
    }
}

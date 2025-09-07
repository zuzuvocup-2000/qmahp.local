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

        // Sample data for activities
        $this->data['activities'] = [
            [
                'title' => 'TRAO HỖ TRỢ 3 CĂN NHÀ ĐẠI ĐOÀN KẾT CHO NGƯỜI MƯỜNG VÀ 500 CHĂN ẤM MÙA ĐÔNG CHO HỌC SINH',
                'location' => 'HUYỆN YÊN THỦY, TỈNH HÒA BÌNH',
                'date' => '05/11/2023',
                'description' => 'Quỹ Mái ấm Hạnh phúc, Hà Nội phối hợp cùng Huyện ủy, Hội đồng Nhân dân, Ủy ban Nhân dân, Ủy ban Mặt trận Tổ quốc huyện Mù Cang Chải trao tặng 03 căn nhà đại đoàn kết cho 03 hộ gia đình người đồng bào dân tộc Mường có hoàn cảnh khó khăn về nhà ở; trao 500 chăn ấm mùa đông cho học sinh là con em các gia đình hộ nghèo.',
                'image' => '/upload/images/yenthuy1.jpg',
                'amount' => '150,000,000 VNĐ'
            ],
            [
                'title' => 'TRAO QUÀ TẾT TẠI XÃ PHÚ LỘC, HUYỆN PHÙ NINH, TỈNH PHÚ THỌ',
                'location' => 'XÃ PHÚ LỘC, HUYỆN PHÙ NINH, TỈNH PHÚ THỌ',
                'date' => '28/01/2024',
                'description' => 'Quỹ Mái ấm Hạnh phúc đã về trực tiếp trao quà tết cho các hộ gia đình nghèo, cận nghèo, các hộ gia đình có hoàn cảnh đặc biệt khó khăn, người tàn tật, các cụ phụ lão trên 80 tuổi và toàn bộ các hộ gia đình khu dân cư số 4 xã Phú Lộc.',
                'image' => '/upload/images/tht-4.jpg',
                'amount' => '294,200,000 VNĐ'
            ]
        ];

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
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            
            $validation->setRules([
                'fullname' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email',
                'phone' => 'required|min_length[10]|max_length[15]',
                'message' => 'max_length[500]'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                // Process donation information
                $donationData = [
                    'fullname' => $this->request->getPost('fullname'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'message' => $this->request->getPost('message'),
                    'created_at' => $this->currentTime
                ];

                // Here you would typically save to database
                // For now, we'll just return success message
                
                $session = session();
                $session->setFlashdata('success', 'Cảm ơn bạn đã đóng góp thông tin. Chúng tôi sẽ liên hệ lại sớm nhất!');
                
                return redirect()->to(base_url('chung-tay.html'));
            } else {
                $session = session();
                $session->setFlashdata('errors', $validation->getErrors());
                return redirect()->to(base_url('chung-tay.html'));
            }
        }

        return redirect()->to(base_url('chung-tay.html'));
    }
}

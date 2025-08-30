<?php

namespace App\Controllers\Backend\Language;

use App\Controllers\BaseController;
use App\Models\LanguageKeywordModel;

/**
 * Language Keyword Controller
 *
 * Manages language keywords and translations in the backend
 *
 * @package App\Controllers\Backend\Language
 */
class LanguageKeyword extends BaseController
{
    /**
     * Data array for view
     *
     * @var array
     */
    protected $data;

    /**
     * Language Keyword Model instance
     *
     * @var LanguageKeywordModel
     */
    protected $languageKeywordModel;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->data = [];
        $this->data['module'] = 'language_keyword';
        $this->languageKeywordModel = new LanguageKeywordModel();
    }

    /**
     * Index page - List all language keywords
     *
     * @param int $page Page number
     * @return \CodeIgniter\HTTP\Response
     */
    public function index($page = 1)
    {
        $session = session();
        $flag = $this->authentication->check_permission([
            'routes' => 'backend/language/languagekeyword/index'
        ]);

        if ($flag === false) {
            $session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
            return redirect()->to(BASE_URL . 'backend/dashboard/dashboard/index');
        }

        helper(['mypagination']);
        $page = (int) $page;
        $perpage = ($this->request->getGet('perpage')) ? (int) $this->request->getGet('perpage') : 20;
        $where = $this->condition_where();
        $keyword = $this->condition_keyword();
        $module = $this->request->getGet('module');

        // Get total count
        $config['total_rows'] = $this->languageKeywordModel->getKeywordsCount(
            $module,
            isset($where['publish']) ? $where['publish'] : null
        );

        if ($config['total_rows'] > 0) {
            $config = pagination_config_bt([
                'url' => 'backend/language/languagekeyword/index',
                'perpage' => $perpage
            ], $config);

            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();

            $totalPage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page <= 0) ? 1 : $page;
            $page = ($page > $totalPage) ? $totalPage : $page;
            $page = $page - 1;
            // Get keywords with pagination
            $this->data['keywordList'] = $this->languageKeywordModel->searchKeywords(
                $keyword,
                $module,
                $config['per_page'],
                $page * $config['per_page']
            );
        } else {
            $this->data['keywordList'] = [];
            $this->data['pagination'] = '';
        }

        $this->data['currentKeyword'] = $this->request->getGet('keyword');
        $this->data['template'] = 'backend/language/languagekeyword/index';
        return view('backend/dashboard/layout/home', $this->data);
    }

    /**
     * Create new language keyword
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function create()
    {
        $session = session();
        $flag = $this->authentication->check_permission([
            'routes' => 'backend/language/languagekeyword/create'
        ]);

        if ($flag === false) {
            $session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
            return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
        }

        if ($this->request->getMethod() === 'post') {
            $validate = $this->validation();
            if ($this->validate($validate['validate'], $validate['errorValidate'])) {
                $insert = $this->store(['method' => 'create']);

                $resultId = $this->languageKeywordModel->insert($insert);

                if ($resultId > 0) {
                    $session->setFlashdata('message-success', 'Tạo từ khóa đa ngữ thành công! Hãy tạo từ khóa tiếp theo.');
                    return redirect()->to(BASE_URL . 'backend/language/languagekeyword/create');
                } else {
                    $session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
                }
            } else {
                $this->data['validate'] = $this->validator->listErrors();
            }
        }

        $this->data['fixWrapper'] = 'fix-wrapper';
        $this->data['method'] = 'create';
        $this->data['template'] = 'backend/language/languagekeyword/create';
        return view('backend/dashboard/layout/home', $this->data);
    }

    /**
     * Update existing language keyword
     *
     * @param int $id Keyword ID
     * @return \CodeIgniter\HTTP\Response
     */
    public function update($id = 0)
    {
        $id = (int) $id;
        $session = session();
        $flag = $this->authentication->check_permission([
            'routes' => 'backend/language/languagekeyword/update'
        ]);

        if ($flag === false) {
            $session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
            return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
        }

        // Get keyword data
        $this->data[$this->data['module']] = $this->languageKeywordModel->find($id);

        if (!isset($this->data[$this->data['module']]) || empty($this->data[$this->data['module']])) {
            $session->setFlashdata('message-danger', 'Từ khóa không tồn tại');
            return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
        }

        if ($this->request->getMethod() === 'post') {
            $validate = $this->validation();
            if ($this->validate($validate['validate'], $validate['errorValidate'])) {
                $update = $this->store(['method' => 'update']);
                $flag = $this->languageKeywordModel->update($id, $update);

                if ($flag > 0) {
                    $session->setFlashdata('message-success', 'Cập nhật từ khóa đa ngữ thành công!');
                    return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
                } else {
                    $session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
                }
            } else {
                $this->data['validate'] = $this->validator->listErrors();
            }
        }

        $this->data['fixWrapper'] = 'fix-wrapper';
        $this->data['method'] = 'update';
        $this->data['template'] = 'backend/language/languagekeyword/update';
        return view('backend/dashboard/layout/home', $this->data);
    }

    /**
     * Delete language keyword
     *
     * @param int $id Keyword ID
     * @return \CodeIgniter\HTTP\Response
     */
    public function delete($id = 0)
    {
        $id = (int) $id;
        $session = session();
        $flag = $this->authentication->check_permission([
            'routes' => 'backend/language/languagekeyword/delete'
        ]);

        if ($flag === false) {
            $session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
            return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
        }

        // Get keyword data
        $this->data[$this->data['module']] = $this->languageKeywordModel->find($id);

        if (!isset($this->data[$this->data['module']]) || empty($this->data[$this->data['module']])) {
            $session->setFlashdata('message-danger', 'Từ khóa không tồn tại');
            return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
        }

        if ($this->request->getPost('delete')) {
            $flag = $this->languageKeywordModel->delete($id);

            if ($flag > 0) {
                $session->setFlashdata('message-success', 'Xóa từ khóa thành công!');
            } else {
                $session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
            }
            return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
        }

        $this->data['template'] = 'backend/language/languagekeyword/delete';
        return view('backend/dashboard/layout/home', $this->data);
    }

    /**
     * Bulk import keywords from language files
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function import()
    {
        $session = session();
        $flag = $this->authentication->check_permission([
            'routes' => 'backend/language/languagekeyword/import'
        ]);

        if ($flag === false) {
            $session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
            return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
        }

        if ($this->request->getMethod() === 'post') {
            $module = $this->request->getPost('module');
            $keywords = $this->request->getPost('keywords');

            if (!empty($module) && !empty($keywords)) {
                try {
                    $keywordsArray = json_decode($keywords, true);
                    if (is_array($keywordsArray)) {
                        $imported = $this->languageKeywordModel->bulkImportKeywords($keywordsArray, $module);
                        $session->setFlashdata('message-success', "Import thành công {$imported} từ khóa!");
                        return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
                    } else {
                        $session->setFlashdata('message-danger', 'Định dạng dữ liệu không hợp lệ!');
                    }
                } catch (\Exception $e) {
                    $session->setFlashdata('message-danger', 'Có lỗi xảy ra: ' . $e->getMessage());
                }
            } else {
                $session->setFlashdata('message-danger', 'Vui lòng nhập đầy đủ thông tin!');
            }
        }

        $this->data['fixWrapper'] = 'fix-wrapper';
        $this->data['template'] = 'backend/language/languagekeyword/import';
        return view('backend/dashboard/layout/home', $this->data);
    }

    /**
     * Export keywords to language file format
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function export()
    {
        $session = session();
        $flag = $this->authentication->check_permission([
            'routes' => 'backend/language/languagekeyword/export'
        ]);

        if ($flag === false) {
            $session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
            return redirect()->to(BASE_URL . 'backend/language/languagekeyword/index');
        }

        $module = $this->request->getGet('module');
        $language = $this->request->getGet('language') ?: 'en';

        if (!empty($module)) {
            $exportData = $this->languageKeywordModel->exportLanguageFile($module, $language);

            // Return JSON response for download
            return $this
                ->response
                ->setJSON($exportData)
                ->setHeader('Content-Type', 'application/json')
                ->setHeader('Content-Disposition', "attachment; filename=\"{$module}_{$language}.json\"");
        }

        $this->data['fixWrapper'] = 'fix-wrapper';
        $this->data['template'] = 'backend/language/languagekeyword/export';
        return view('backend/dashboard/layout/home', $this->data);
    }

    /**
     * AJAX search keywords
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function ajaxSearch()
    {
        $keyword = $this->request->getGet('keyword');
        $module = $this->request->getGet('module');
        $limit = (int) ($this->request->getGet('limit') ?: 10);

        if (!empty($keyword)) {
            $results = $this->languageKeywordModel->searchKeywords($keyword, $module, $limit);
            return $this->response->setJSON([
                'success' => true,
                'data' => $results
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Vui lòng nhập từ khóa tìm kiếm'
        ]);
    }

    /**
     * Set where conditions for filtering
     *
     * @return array
     */
    private function condition_where(): array
    {
        $where = [];

        $publish = $this->request->getGet('publish');
        if (isset($publish)) {
            $where['publish'] = $publish;
        }

        $deleted_at = $this->request->getGet('deleted_at');
        if (isset($deleted_at)) {
            $where['deleted_at'] = $deleted_at;
        } else {
            $where['deleted_at'] = 0;
        }

        return $where;
    }

    /**
     * Set keyword search condition
     *
     * @param string $keyword
     * @return string
     */
    private function condition_keyword(string $keyword = ''): string
    {
        if (!empty($this->request->getGet('keyword'))) {
            $keyword = $this->request->getGet('keyword');
        }
        return $keyword;
    }

    /**
     * Prepare data for store/update
     *
     * @param array $param
     * @return array
     */
    private function store(array $param = []): array
    {
        helper(['text']);

        $store = [
            'keyword' => validate_input($this->request->getPost('keyword')),
            'module' => validate_input($this->request->getPost('module')),
            'en_translation' => validate_input($this->request->getPost('en_translation')),
            'vi_translation' => validate_input($this->request->getPost('vi_translation')),
            'description' => validate_input($this->request->getPost('description')),
            'order' => (int) ($this->request->getPost('order') ?: 0),
            'publish' => (int) ($this->request->getPost('publish') ?: 1),
        ];

        if ($param['method'] === 'create') {
            $store['created_at'] = $this->currentTime;
            $store['userid_created'] = $this->auth['id'];
        } else {
            $store['updated_at'] = $this->currentTime;
            $store['userid_updated'] = $this->auth['id'];
        }

        return $store;
    }

    /**
     * Validation rules
     *
     * @return array
     */
    private function validation(): array
    {
        $validate = [
            'keyword' => 'required|min_length[1]|max_length[255]',
            'module' => 'required|min_length[1]|max_length[100]',
            'en_translation' => 'required|min_length[1]|max_length[500]',
            'vi_translation' => 'required|min_length[1]|max_length[500]',
        ];

        $errorValidate = [
            'keyword' => [
                'required' => 'Bạn phải nhập vào trường từ khóa',
                'min_length' => 'Từ khóa phải có ít nhất 1 ký tự',
                'max_length' => 'Từ khóa không được vượt quá 255 ký tự'
            ],
            'module' => [
                'required' => 'Bạn phải chọn module',
                'min_length' => 'Module phải có ít nhất 1 ký tự',
                'max_length' => 'Module không được vượt quá 100 ký tự'
            ],
            'en_translation' => [
                'required' => 'Bạn phải nhập bản dịch tiếng Anh',
                'min_length' => 'Bản dịch tiếng Anh phải có ít nhất 1 ký tự',
                'max_length' => 'Bản dịch tiếng Anh không được vượt quá 500 ký tự'
            ],
            'vi_translation' => [
                'required' => 'Bạn phải nhập bản dịch tiếng Việt',
                'min_length' => 'Bản dịch tiếng Việt phải có ít nhất 1 ký tự',
                'max_length' => 'Bản dịch tiếng Việt không được vượt quá 500 ký tự'
            ]
        ];

        return [
            'validate' => $validate,
            'errorValidate' => $errorValidate,
        ];
    }
}

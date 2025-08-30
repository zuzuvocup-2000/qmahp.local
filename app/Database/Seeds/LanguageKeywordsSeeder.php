<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Language Keywords Seeder
 * 
 * Populates the language_keywords table with sample data
 * for testing and demonstration purposes
 * 
 * @package App\Database\Seeds
 */
class LanguageKeywordsSeeder extends Seeder
{
    /**
     * Run the seeder
     * 
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'keyword' => 'sidebar_sb_article',
                'module' => 'cms',
                'en_translation' => 'Blog',
                'vi_translation' => 'QL Bài Viết',
                'description' => 'Sidebar menu item for blog management',
                'order' => 1,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'sidebar_sb_article_catalogue',
                'module' => 'cms',
                'en_translation' => 'Blog Category',
                'vi_translation' => 'QL Nhóm Bài Viết',
                'description' => 'Sidebar menu item for blog category management',
                'order' => 2,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'sidebar_sb_user',
                'module' => 'cms',
                'en_translation' => 'User',
                'vi_translation' => 'QL Thành Viên',
                'description' => 'Sidebar menu item for user management',
                'order' => 3,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'sidebar_sb_setting',
                'module' => 'cms',
                'en_translation' => 'Setting',
                'vi_translation' => 'Cấu Hình Chung',
                'description' => 'Sidebar menu item for settings',
                'order' => 4,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'sidebar_sb_language',
                'module' => 'cms',
                'en_translation' => 'Language',
                'vi_translation' => 'QL Ngôn Ngữ',
                'description' => 'Sidebar menu item for language management',
                'order' => 5,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'nav_nav_logout',
                'module' => 'cms',
                'en_translation' => 'Logout',
                'vi_translation' => 'Đăng xuất',
                'description' => 'Navigation logout button text',
                'order' => 6,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'nav_nav_welcome',
                'module' => 'cms',
                'en_translation' => 'Welcome to KIM LIEN TRAVEL Admin Panel.',
                'vi_translation' => 'Chào mừng các bạn đã đến với trang quản trị được xây dựng bởi HT VIỆT NAM',
                'description' => 'Welcome message in navigation',
                'order' => 7,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'nav_nav_search',
                'module' => 'cms',
                'en_translation' => 'Search for something...',
                'vi_translation' => 'Nhập từ khóa để tìm kiếm...',
                'description' => 'Search placeholder text',
                'order' => 8,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'footer_ft_company',
                'module' => 'cms',
                'en_translation' => 'HT VietNam Company',
                'vi_translation' => 'Công ty HT VietNam',
                'description' => 'Company name in footer',
                'order' => 9,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'footer_ft_welcome',
                'module' => 'cms',
                'en_translation' => 'Welcome to HT VietNam Panel',
                'vi_translation' => 'Chào mừng đến với HT VietNam Panel',
                'description' => 'Welcome message in footer',
                'order' => 10,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'home_home_news',
                'module' => 'cms',
                'en_translation' => 'LATEST NEWS',
                'vi_translation' => 'TIN TỨC MỚI NHẤT',
                'description' => 'Latest news section title',
                'order' => 11,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'home_home_tour',
                'module' => 'cms',
                'en_translation' => 'LATEST TOUR',
                'vi_translation' => 'TOUR MỚI NHẤT',
                'description' => 'Latest tour section title',
                'order' => 12,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'home_home_contact',
                'module' => 'cms',
                'en_translation' => 'CUSTOMER CONTACT INFORMATION',
                'vi_translation' => 'THÔNG TIN LIÊN HỆ KHÁCH HÀNG',
                'description' => 'Customer contact information section title',
                'order' => 13,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'tour_tour_title',
                'module' => 'cms',
                'en_translation' => 'Tour Management',
                'vi_translation' => 'Quản Lý Tour',
                'description' => 'Tour management page title',
                'order' => 14,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'tour_tour_add',
                'module' => 'cms',
                'en_translation' => 'Add new Tour',
                'vi_translation' => 'Thêm Tour mới',
                'description' => 'Add new tour button text',
                'order' => 15,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'tour_tour_save',
                'module' => 'cms',
                'en_translation' => 'Save',
                'vi_translation' => 'Lưu',
                'description' => 'Save button text',
                'order' => 16,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'tour_tour_change',
                'module' => 'cms',
                'en_translation' => 'Edit',
                'vi_translation' => 'Chỉnh sửa',
                'description' => 'Edit button text',
                'order' => 17,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'tour_tour_deleteall',
                'module' => 'cms',
                'en_translation' => 'Delete All',
                'vi_translation' => 'Xóa tất cả',
                'description' => 'Delete all button text',
                'order' => 18,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'tour_tour_status',
                'module' => 'cms',
                'en_translation' => 'Status',
                'vi_translation' => 'Trạng thái',
                'description' => 'Status column header',
                'order' => 19,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ],
            [
                'keyword' => 'tour_tour_action',
                'module' => 'cms',
                'en_translation' => 'Action',
                'vi_translation' => 'Thao tác',
                'description' => 'Action column header',
                'order' => 20,
                'publish' => 1,
                'userid_created' => 1,
                'userid_updated' => 1
            ]
        ];

        // Insert the data
        $this->db->table('language_keywords')->insertBatch($data);
    }
}

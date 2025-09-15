<?php $main_nav = get_menu(array('keyword' => 'main-menu','language' => 'vi', 'output' => 'array')); ?>
<?php 
	$cookie  = [];
    if(isset($_COOKIE[AUTH.'member'])) $cookie = json_decode($_COOKIE[AUTH.'member'],TRUE);
?>

<div class="mobile-sidebar-overlay" id="mobileSidebarOverlay"></div>

<div class="mobile-sidebar" id="mobileSidebar">
    <div class="mobile-sidebar-header">
        <div class="mobile-sidebar-logo">
            <img src="<?php echo $general['homepage_logo']; ?>" alt="Logo" class="logo-img">
        </div>
        <button class="mobile-sidebar-close" id="mobileSidebarClose">
            <i class="fa fa-times"></i>
        </button>
    </div>
    
    <div class="mobile-sidebar-content">
        <nav class="mobile-nav">
            <ul class="mobile-nav-list">
                <?php 
                if(isset($main_nav['data']) && !empty($main_nav['data']) && is_array($main_nav['data']) && count($main_nav['data']) > 0): 
                    foreach($main_nav['data'] as $key => $value): 
                        if(is_array($value) && !empty($value) && isset($value['canonical']) && isset($value['title']) && !empty($value['canonical']) && !empty($value['title'])):
                ?>
                        <li class="mobile-nav-item">
                            <div class="mobile-nav-item-header uk-flex uk-flex-middle uk-flex-space-between">
                                <a href="<?php echo htmlspecialchars($value['canonical']).HTSUFFIX ?>" class="mobile-nav-link">
                                    <span><?php echo htmlspecialchars($value['title']) ?></span>
                                </a>
                                <?php if(isset($value['children']) && !empty($value['children']) && is_array($value['children']) && count($value['children']) > 0): ?>
                                <div class="btn-more" data-toggle="submenu-<?php echo $value['id']; ?>">
                                    <i class="fa fa-angle-down"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if(isset($value['children']) && !empty($value['children']) && is_array($value['children']) && count($value['children']) > 0): ?>
                            <ul class="mobile-submenu" id="submenu-<?php echo $value['id']; ?>" style="display: none;">
                                <?php foreach($value['children'] as $child): ?>
                                <li class="mobile-submenu-item">
                                    <a href="<?php echo htmlspecialchars($child['canonical']).HTSUFFIX ?>" class="mobile-submenu-link">
                                        <span><?php echo htmlspecialchars($child['title']) ?></span>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                <?php 
                        endif;
                    endforeach; 
                endif; 
                ?>
            </ul>
        </nav>
    </div>
</div>


<script>
$(document).ready(function() {
    $('.btn-menu-bar').on('click', function() {
        $('#mobileSidebarOverlay').addClass('active');
        $('#mobileSidebar').addClass('active');
        $('body').css('overflow', 'hidden');
    });
    
    $('#mobileSidebarClose, #mobileSidebarOverlay').on('click', function() {
        $('#mobileSidebarOverlay').removeClass('active');
        $('#mobileSidebar').removeClass('active');
        $('body').css('overflow', '');
    });
    
    var isToggling = false;
    
    $(document).off('click', '.btn-more').on('click', '.btn-more', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        
        if (isToggling) {
            console.log('Already toggling, ignoring click');
            return false;
        }
        
        isToggling = true;
        
        var $this = $(this);
        var targetId = $this.data('toggle');
        var submenu = $('#' + targetId);
        
        var isVisible = submenu.is(':visible');
        
        if (isVisible) {
            submenu.slideUp(300, function() {
                isToggling = false;
            });
            $this.removeClass('rotate');
        } else {
            submenu.slideDown(300, function() {
                isToggling = false;
            });
            $this.addClass('rotate');
        }
        
        return false;
    });
    
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) {
            $('#mobileSidebarOverlay').removeClass('active');
            $('#mobileSidebar').removeClass('active');
            $('body').css('overflow', '');
        }
    });
    
    $(window).on('resize', function() {
        if ($(window).width() > 768) {
            $('#mobileSidebarOverlay').removeClass('active');
            $('#mobileSidebar').removeClass('active');
            $('body').css('overflow', '');
        }
    });
});
</script>
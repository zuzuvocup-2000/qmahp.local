<?php
/**
 * Language Switcher Component
 * 
 * This component provides a language switcher for the website
 * 
 * @var string $type Type of switcher (simple, dropdown)
 * @var array $options Options for the switcher
 */

$type = $type ?? 'simple';
$options = $options ?? [];

// Default options
$defaults = [
    'current_language' => get_current_language(),
    'show_flags' => true,
    'show_text' => true,
    'class' => 'language-switcher',
    'item_class' => 'language-item',
    'active_class' => 'active',
    'separator' => ' | '
];

$options = array_merge($defaults, $options);
$urls = get_language_switcher_urls();

$languages = [];
foreach (\App\Config\LanguageConstants::getSupported() as $code) {
    $languages[$code] = [
        'name' => \App\Config\LanguageConstants::getName($code),
        'flag' => \App\Config\LanguageConstants::getFlag($code),
        'url' => $urls[$code]
    ];
}

if ($type === 'dropdown') {
    // Dropdown style
    $current = $languages[$options['current_language']];
    $current_text = '';
    if ($options['show_flags']) {
        $current_text .= $current['flag'] . ' ';
    }
    if ($options['show_text']) {
        $current_text .= $current['name'];
    }
    ?>
    <div class="<?= $options['class'] ?>">
        <button class="language-button" onclick="toggleLanguageMenu()">
            <?= $current_text ?> ▼
        </button>
        <div class="language-menu" id="languageMenu">
            <?php foreach ($languages as $code => $lang): ?>
                <?php if ($code === $options['current_language']) continue; ?>
                <?php
                $text = '';
                if ($options['show_flags']) {
                    $text .= $lang['flag'] . ' ';
                }
                if ($options['show_text']) {
                    $text .= $lang['name'];
                }
                ?>
                <a href="<?= $lang['url'] ?>" class="<?= $options['item_class'] ?>">
                    <?= $text ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <script>
    function toggleLanguageMenu() {
        const menu = document.getElementById('languageMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('languageMenu');
        const button = event.target.closest('.language-button');
        if (!button && !menu.contains(event.target)) {
            menu.style.display = 'none';
        }
    });
    </script>
    
    <style>
    .language-dropdown {
        position: relative;
        display: inline-block;
    }
    
    .language-button {
        background: none;
        border: 1px solid #ddd;
        padding: 8px 12px;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
    }
    
    .language-button:hover {
        background-color: #f5f5f5;
    }
    
    .language-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        z-index: 1000;
        min-width: 120px;
    }
    
    .language-menu a {
        display: block;
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
        font-size: 14px;
    }
    
    .language-menu a:hover {
        background-color: #f5f5f5;
    }
    </style>
    <?php
} else {
    // Simple style
    $items = [];
    foreach ($languages as $code => $lang) {
        $is_active = ($code === $options['current_language']);
        $class = $options['item_class'];
        
        if ($is_active) {
            $class .= ' ' . $options['active_class'];
        }
        
        $text = '';
        if ($options['show_flags']) {
            $text .= $lang['flag'] . ' ';
        }
        if ($options['show_text']) {
            $text .= $lang['name'];
        }
        
        $items[] = sprintf(
            '<a href="%s" class="%s">%s</a>',
            $lang['url'],
            $class,
            $text
        );
    }
    ?>
    <div class="<?= $options['class'] ?>">
        <?= implode($options['separator'], $items) ?>
    </div>
    
    <style>
    .language-switcher a {
        text-decoration: none;
        color: #333;
        font-size: 14px;
        padding: 4px 8px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    
    .language-switcher a:hover {
        background-color: #f5f5f5;
    }
    
    .language-switcher a.active {
        background-color: #007bff;
        color: white;
    }
    </style>
    <?php
}
?>

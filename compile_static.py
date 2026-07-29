import re
import json
import random
import os

default_config = {
    "header": {
        "title": "Admin Dashboard | ZethDevs",
        "description": "Hi my name is ThanhDieu / A freelance / web developer / vexer",
        "keywords": "thanhdieu,web thanhdieu,vuong thanhdieu,thanhdieutv,wsteam,wusteam,thanhdieu home,profile thanhdieu",
        "favicon": "./res/v5/img/logo.jpg",
        "namesite": "ADMIN | CONTROL PANEL",
        "avatar": "./res/v5/img/avatar.gif",
        "userName": ["Hello Admin", "Welcome to Admin Panel.", "Control and configure your site 🚀"],
        "trigger": "👉 Tìm hiểu tôi 😶&zwj;🌫️",
        "bio1": "🤖️ Administrator",
        "bio2": "🔍 High Security Mode",
        "bio3": "💻 Control Panel active",
        "bio4": "Monitoring traffic live 📊",
        "bio5": "Custom CSS & Animations 🎨",
        "bio6": "Optimized performance 🚀",
        "SocialNetworks": {
            "facebook": "https://facebook.com/wusthanhdieu",
            "instagram": "https://www.instagram.com/vuongsondieu2k2",
            "tiktok": "https://www.tiktok.com/",
            "telegram": "https://t.me/thanhdieuchannel"
        }
    },
    "lovedays": {
        "avatar_male": "./res/v5/img/male.jpeg",
        "name_male": "ThanhDieu",
        "avatar_female": "./res/v5/img/female.jpeg",
        "name_female": "Ngoc Tram",
        "time_relashiption": "28/03/2024"
    },
    "music": [
        {
            "url": "https://files.catbox.moe/4bjjfg.mp3",
            "avatar": "https://i.ibb.co/Pt4ZJJd/that-girl-1545280005.jpg",
            "title": "That Girl",
            "author": "Olly Murs"
        },
        {
            "url": "https://files.catbox.moe/m8b4hr.mp3",
            "avatar": "https://i.imgur.com/e28b0dD.png",
            "title": "Thiên Lý Ơi",
            "author": "Jack ( 5 Triệu )"
        },
        {
            "url": "https://files.catbox.moe/yrpft2.mp3",
            "avatar": "https://i.imgur.com/DAaTklq.png",
            "title": "Thuỷ Triều",
            "author": "Quang Hùng MasterD"
        },
        {
            "url": "https://files.catbox.moe/jlat9a.mp3",
            "avatar": "https://i.imgur.com/vp5Vsx5.png",
            "title": "風立ちぬ ( Gió Nổi )",
            "author": "周深"
        },
        {
            "url": "https://files.catbox.moe/hkqk6x.mp3",
            "avatar": "https://i.imgur.com/GEOKT8b.png",
            "title": "Chúng Ta Của Tương Lai",
            "author": "Sơn Tùng M-TP"
        },
        {
            "url": "https://files.catbox.moe/acg0vl.mp3",
            "avatar": "https://i.ibb.co/MDVY07s/619964de31327dbf8491d14d2c25533f.jpg",
            "title": "Hoa Cỏ Lau",
            "author": "Phong Max"
        },
        {
            "url": "https://files.catbox.moe/s8opab.mp3",
            "avatar": "https://i.ibb.co/6R8V7S7/ed0741228ad36870e13624120474e50a.jpg",
            "title": "Sau Lời Từ Khước",
            "author": "Phan Mạnh Quỳnh"
        },
        {
            "url": "https://files.catbox.moe/gvqgma.mp3",
            "avatar": "https://i.ibb.co/gvXHBqv/ab67616d0000b273ae85dfd27beee97a3a009f68.jpg",
            "title": "Em Đã Xa Anh Remix",
            "author": "Như Việt"
        },
        {
            "url": "https://files.catbox.moe/dvjckq.mp3",
            "avatar": "https://i.ibb.co/VpFyXhS/ab44498b5b432879428719390baf1180-1490064587.jpg",
            "title": "Anh Đã Quen Với Cô Đơn",
            "author": "Soobin Hoàng Sơn"
        }
    ]
}

# Create res/config dir if not exists
os.makedirs('res/config', exist_ok=True)

# Write res/config/config.json if not exists
json_path = 'res/config/config.json'
if not os.path.exists(json_path):
    with open(json_path, 'w', encoding='utf-8') as f:
        json.dump(default_config, f, indent=4, ensure_ascii=False)
    print(f"Created default config at {json_path}")
else:
    print(f"Loading existing config from {json_path}")
    with open(json_path, 'r', encoding='utf-8') as f:
        default_config = json.load(f)

# Read index.php
with open('index.php', 'r', encoding='utf-8') as f:
    php_content = f.read()

# Find where <!DOCTYPE html> begins
html_start = php_content.find('<!DOCTYPE html>')
if html_start == -1:
    print("Could not find <!DOCTYPE html> tag in index.php")
    exit(1)

html_content = php_content[html_start:]

# Pre-render standard template tags using defaults
config = default_config
header = config['header']
lovedays = config['lovedays']
music = config['music']

def get_rand():
    return str(random.randint(1, 999))

replacements = {
    '<?=$ThanhDieuHeader->description?>': header['description'],
    '<?=$ThanhDieuHeader->keywords?>': header['keywords'],
    '<?=$ThanhDieuHeader->favicon?>': header['favicon'],
    '<?=$ThanhDieuHeader->title?>': header['title'],
    '<?=$ThanhDieuHeader->avatar?>': header['avatar'],
    '<?=$ThanhDieuHeader->namesite?>': header['namesite'],
    '<?= json_encode($ThanhDieuHeader->userName ?? []) ?>': json.dumps(header['userName'], ensure_ascii=False),
    '<?= count($ThanhDieuMusicList->songs) ?>': str(len(music)),
    '<?=$ThanhDieuHeader->bio1?>': header['bio1'],
    '<?=$ThanhDieuHeader->bio2?>': header['bio2'],
    '<?=$ThanhDieuHeader->bio3?>': header['bio3'],
    '<?=$ThanhDieuHeader->bio4?>': header['bio4'],
    '<?=$ThanhDieuHeader->bio5?>': header['bio5'],
    '<?=$ThanhDieuHeader->bio6?>': header['bio6'],
    '<?= $ThanhDieuLoveDays->ConfigLove[\'time_relashiption\']; ?>': lovedays['time_relashiption'],
    '<?=$ThanhDieuLoveDays->ConfigLove[\'avatar_male\'];?>': lovedays['avatar_male'],
    '<?=$ThanhDieuLoveDays->ConfigLove[\'name_male\'];?>': lovedays['name_male'],
    '<?=$ThanhDieuLoveDays->ConfigLove[\'avatar_female\'];?>': lovedays['avatar_female'],
    '<?=$ThanhDieuLoveDays->ConfigLove[\'name_female\'];?>': lovedays['name_female'],
    '<?= htmlspecialchars($ThanhDieuHeader->title) ?>': header['title'],
    '<?= htmlspecialchars($ThanhDieuHeader->namesite) ?>': header['namesite'],
    '<?= htmlspecialchars($ThanhDieuHeader->favicon) ?>': header['favicon'],
    '<?= htmlspecialchars($ThanhDieuHeader->avatar) ?>': header['avatar'],
    '<?= htmlspecialchars($ThanhDieuHeader->description) ?>': header['description'],
    '<?= htmlspecialchars($ThanhDieuHeader->keywords) ?>': header['keywords'],
    '<?= htmlspecialchars($ThanhDieuHeader->bio1) ?>': header['bio1'],
    '<?= htmlspecialchars($ThanhDieuHeader->bio2) ?>': header['bio2'],
    '<?= htmlspecialchars($ThanhDieuHeader->bio3) ?>': header['bio3'],
    '<?= htmlspecialchars($ThanhDieuHeader->bio4) ?>': header['bio4'],
    '<?= htmlspecialchars($ThanhDieuHeader->bio5) ?>': header['bio5'],
    '<?= htmlspecialchars($ThanhDieuHeader->bio6) ?>': header['bio6'],
    '<?= implode("\\n", $ThanhDieuHeader->userName ?? []) ?>': "\n".join(header['userName']),
    '<?= htmlspecialchars($ThanhDieuHeader->SocialNetworks[\'facebook\'] ?? \'\') ?>': header['SocialNetworks'].get('facebook', ''),
    '<?= htmlspecialchars($ThanhDieuHeader->SocialNetworks[\'instagram\'] ?? \'\') ?>': header['SocialNetworks'].get('instagram', ''),
    '<?= htmlspecialchars($ThanhDieuHeader->SocialNetworks[\'tiktok\'] ?? \'\') ?>': header['SocialNetworks'].get('tiktok', ''),
    '<?= htmlspecialchars($ThanhDieuHeader->SocialNetworks[\'telegram\'] ?? \'\') ?>': header['SocialNetworks'].get('telegram', ''),
    '<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove[\'time_relashiption\'] ?? \'\') ?>': lovedays.get('time_relashiption', ''),
    '<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove[\'name_male\'] ?? \'\') ?>': lovedays.get('name_male', ''),
    '<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove[\'avatar_male\'] ?? \'\') ?>': lovedays.get('avatar_male', ''),
    '<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove[\'name_female\'] ?? \'\') ?>': lovedays.get('name_female', ''),
    '<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove[\'avatar_female\'] ?? \'\') ?>': lovedays.get('avatar_female', ''),
    '<?= date(\'Y-m-d H:i:s\') ?>': '2026-07-29 14:15:00',
    '<?= $_SERVER[\'REMOTE_ADDR\'] ?? \'127.0.0.1\' ?>': '127.0.0.1',
    '<?= $_SERVER[\'HTTP_HOST\'] ?? \'localhost\' ?>': 'localhost',
    '<?= $_SERVER[\'SERVER_PROTOCOL\'] ?? \'HTTP/1.1\' ?>': 'HTTP/1.1',
    '<?= json_encode($GLOBALS[\'TD_CONFIG_DATA\'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?>': json.dumps(config, indent=4, ensure_ascii=False)
}

for tag, val in replacements.items():
    html_content = html_content.replace(tag, val)

html_content = re.sub(r'<\?=rand\(1,999\)\?>', lambda m: get_rand(), html_content)
html_content = re.sub(r'<\?php echo rand\(1,999\)\?>', lambda m: get_rand(), html_content)

# Render Songs loops
loop_pattern_1 = r'<\?php foreach \(\$ThanhDieuMusicList->songs as \$index => \$song\): \?>.*?<\?php endforeach; \?>'
songs_html_table = ""
for index, song in enumerate(music):
    songs_html_table += f"""                                <tr>
                                    <td>{ index + 1 }</td>
                                    <td>
                                        <img src="{ song['avatar'] }" style="width: 42px; height: 42px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-color);">
                                    </td>
                                    <td style="font-weight: 700;">{ song['title'] }</td>
                                    <td>{ song['author'] }</td>
                                    <td>
                                        <span style="font-size: 0.82rem; opacity: 0.6; word-break: break-all;">{ song['url'] }</span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display:inline-flex; gap: 8px;">
                                            <button class="dash-btn-danger delete-song-btn" data-index="{ index }">
                                                <i class="ri-delete-bin-fill"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>\n"""

html_content = re.sub(loop_pattern_1, songs_html_table, html_content, flags=re.DOTALL)

loop_pattern_2 = r'<\?php foreach \(\$ThanhDieuMusicList->songs as \$song\): \?>.*?<\?php endforeach; \?>'
songs_html_selector = ""
for song in music:
    songs_html_selector += f"""                                        <li url="{ song['url'] }">
                                            <span class="name">
                                                <img class="singer-avatar ls-is-cached" src="{ song['avatar'] }">
                                                <span class="title">
                                                    <font style="vertical-align: inherit;">{ song['title'] }</font>
                                                </span>
                                            </span>
                                            <span class="author">
                                                <font style="vertical-align: inherit;">{ song['author'] }</font>
                                            </span>
                                        </li>\n"""

html_content = re.sub(loop_pattern_2, songs_html_selector, html_content, flags=re.DOTALL)

# Insert the Reset Config button in the Developer area
developer_panel_end_pattern = r'(\s+<div class="dash-stat-icon" style="background:#28a745;">\s+<i class="ri-checkbox-circle-fill"></i>\s+</div>\s+</div>\s+</div>)'
reset_button_html = """\n                    <div style="text-align: left; margin-top: 20px;">
                        <button class="dash-btn-primary" id="btn-reset-config" style="background: linear-gradient(135deg, #f43f5e, #e11d48); box-shadow: 0 8px 25px rgba(225, 29, 72, 0.4);">
                            <i class="ri-refresh-line"></i> Reset to Repository Default Config
                        </button>
                    </div>\n"""

html_content = re.sub(developer_panel_end_pattern, r'\1' + reset_button_html, html_content)

# Replace the original script block with our Hybrid Server-Client Manager
script_block_pattern = r'<script>\s+\$\(document\)\.ready\(function\(\) \{.*?\}\);\s+</script>'

new_script_block = """<script>
    // Global Config Object
    var config = null;

    function applyConfig(cfg) {
        if (!cfg) return;
        config = cfg;

        // 1. Header & SEO
        document.title = config.header.title;
        $('meta[name="description"]').attr('content', config.header.description);
        $('meta[name="keywords"]').attr('content', config.header.keywords);
        $('meta[property="og:title"]').attr('content', config.header.title);
        $('link[rel="shortcut icon"]').attr('href', config.header.favicon + '?v=' + Math.floor(Math.random()*1000));
        $('.loading-img').attr('src', config.header.favicon + '?v=' + Math.floor(Math.random()*1000));
        
        // 2. Namesite & Brand
        $('.dash-sidebar-header h3').text(config.header.namesite || "WS ADMIN");
        $('.sidebar-profile h4').text(config.header.namesite);
        $('.logo-web-title .web-title').text(config.header.namesite);
        
        // 3. Avatar
        $('.avatar-img').attr('src', config.header.avatar + '?v=' + Math.floor(Math.random()*1000));
        
        // 4. Greetings (Typed.js handles initialization, so we set attribute before it initializes)
        $('#userName').attr('data-username', JSON.stringify(config.header.userName));
        $('#userName').data('username', config.header.userName);
        
        // 5. Bio Tags
        $('.info-left .tag').eq(0).html(config.header.bio1);
        $('.info-left .tag').eq(1).html(config.header.bio2);
        $('.info-left .tag').eq(2).html(config.header.bio3);
        $('.info-right .tag').eq(0).html(config.header.bio4);
        $('.info-right .tag').eq(1).html(config.header.bio5);
        $('.info-right .tag').eq(2).html(config.header.bio6);

        // 6. Relationship Details
        $('.img-male img:first-child').attr('src', config.lovedays.avatar_male);
        $('.img-male span').html(config.lovedays.name_male);
        $('.img-female img:first-child').attr('src', config.lovedays.avatar_female);
        $('.img-female span').html(config.lovedays.name_female);
        $('#anniversary-date-binder').attr('data-ngayyeu', config.lovedays.time_relashiption);

        // 7. Songs Rendering
        var tableBody = $('#tab-music tbody');
        if (tableBody.length) {
            tableBody.empty();
            config.music.forEach(function(song, index) {
                var row = `<tr>
                    <td>${ index + 1 }</td>
                    <td>
                        <img src="${ song.avatar }" style="width: 42px; height: 42px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-color);">
                    </td>
                    <td style="font-weight: 700;">${ song.title }</td>
                    <td>${ song.author }</td>
                    <td>
                        <span style="font-size: 0.82rem; opacity: 0.6; word-break: break-all;">${ song.url }</span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display:inline-flex; gap: 8px;">
                            <button class="dash-btn-danger delete-song-btn" data-index="${ index }">
                                <i class="ri-delete-bin-fill"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>`;
                tableBody.append(row);
            });
        }

        var menuList = $('.music_menu_list');
        if (menuList.length) {
            menuList.empty();
            config.music.forEach(function(song) {
                var item = `<li url="${ song.url }">
                    <span class="name">
                        <img class="singer-avatar ls-is-cached" src="${ song.avatar }">
                        <span class="title">
                            <font style="vertical-align: inherit;">${ song.title }</font>
                        </span>
                    </span>
                    <span class="author">
                        <font style="vertical-align: inherit;">${ song.author }</font>
                    </span>
                </li>`;
                menuList.append(item);
            });
        }

        // 8. Badges & Counts
        $('.dash-stat-card:has(.dash-stat-label:contains("Active Songs")) .dash-stat-value').text(config.music.length + ' Tracks');
        $('#tab-music .dash-card-title:contains("Loaded Audio Tracks")').html('<i class="ri-music-2-line"></i> Loaded Audio Tracks (' + config.music.length + ' total)');

        // 9. Input field values
        $('input[name="title"]').val(config.header.title);
        $('input[name="namesite"]').val(config.header.namesite);
        $('input[name="favicon"]').val(config.header.favicon);
        $('input[name="avatar"]').val(config.header.avatar);
        $('input[name="description"]').val(config.header.description);
        $('input[name="keywords"]').val(config.header.keywords);

        $('input[name="bio1"]').val(config.header.bio1);
        $('input[name="bio2"]').val(config.header.bio2);
        $('input[name="bio3"]').val(config.header.bio3);
        $('input[name="bio4"]').val(config.header.bio4);
        $('input[name="bio5"]').val(config.header.bio5);
        $('input[name="bio6"]').val(config.header.bio6);

        $('textarea[name="usernames"]').val((config.header.userName || []).join('\\n'));

        $('input[name="social_facebook"]').val(config.header.SocialNetworks.facebook || '');
        $('input[name="social_instagram"]').val(config.header.SocialNetworks.instagram || '');
        $('input[name="social_tiktok"]').val(config.header.SocialNetworks.tiktok || '');
        $('input[name="social_telegram"]').val(config.header.SocialNetworks.telegram || '');

        $('input[name="time_relashiption"]').val(config.lovedays.time_relashiption);
        $('input[name="name_male"]').val(config.lovedays.name_male);
        $('input[name="avatar_male"]').val(config.lovedays.avatar_male);
        $('input[name="name_female"]').val(config.lovedays.name_female);
        $('input[name="avatar_female"]').val(config.lovedays.avatar_female);

        // Developer Area Textarea
        $('#tab-developer textarea').val(JSON.stringify(config, null, 4));
    }

    // Immediately load config before everything else executes
    var localData = localStorage.getItem('config_data');
    if (localData) {
        try {
            config = JSON.parse(localData);
            applyConfig(config);
        } catch(e) {
            console.error("Error parsing local config data:", e);
        }
    }

    // Try fetching config.json asynchronously to merge or initialize
    $.ajax({
        url: './res/config/config.json',
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (!localData) {
                config = data;
                localStorage.setItem('config_data', JSON.stringify(config));
                applyConfig(config);
                if (window.updateAnniversaryDisplay) {
                    window.updateAnniversaryDisplay();
                }
            }
        },
        error: function(err) {
            console.warn("Could not load config.json dynamically, relying on pre-rendered or localStorage configuration.");
        }
    });

    $(document).ready(function() {
        // Tab switching logic
        $('.dash-nav-item').on('click', function() {
            var targetTab = $(this).data('tab');
            
            $('.dash-nav-item').removeClass('active');
            $(this).addClass('active');
            
            $('.dash-tab-panel').removeClass('active');
            $('#tab-' + targetTab).addClass('active');
            
            // Update topbar title
            var tabTitle = $(this).find('span').text().trim();
            var tabIcon = $(this).find('i').attr('class');
            $('.dash-topbar-title').html('<i class="' + tabIcon + '" style="color:#5046e5;"></i> ' + tabTitle);

            // In mobile, close sidebar after clicking item
            if ($(window).width() <= 991) {
                $('.dash-sidebar').removeClass('mobile-open');
            }
        });

        // Toggle Sidebar in Mobile
        $('.toggle-sidebar-btn').on('click', function() {
            $('.dash-sidebar').toggleClass('mobile-open');
        });

        // Calculate and cache anniversary active days
        window.updateAnniversaryDisplay = function() {
            var dateStr = $('#anniversary-date-binder').attr('data-ngayyeu');
            if (dateStr) {
                var parts = dateStr.split(/[\\/\\-:]/);
                if (parts.length === 3) {
                    var day = parseInt(parts[0], 10);
                    var month = parseInt(parts[1], 10) - 1;
                    var year = parseInt(parts[2], 10);
                    var annDate = new Date(year, month, day);
                    var today = new Date();
                    var diffTime = Math.abs(today - annDate);
                    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    $('#day-counter-display').text(diffDays + ' Days');
                }
            }
        }
        setInterval(window.updateAnniversaryDisplay, 10000);
        window.updateAnniversaryDisplay();

        // Save General Settings
        $('#form-general').on('submit', function(e) {
            e.preventDefault();
            Wstoast.loading('Saving general settings...');
            
            var formData = $(this).serialize() + '&action=save_general';
            
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    Wstoast.closeAll();
                    if (response && response.status === 'success') {
                        // PHP backend successfully saved to disk!
                        // Remove localStorage override so we load directly from the updated config.json
                        localStorage.removeItem('config_data');
                        Wstoast.success(response.message || 'General configurations successfully updated on disk!');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        saveGeneralLocally();
                    }
                },
                error: function() {
                    // Fallback to localStorage if PHP is not available (e.g. GitHub Pages)
                    saveGeneralLocally();
                }
            });

            function saveGeneralLocally() {
                if (!config) config = {};
                if (!config.header) config.header = {};
                if (!config.header.SocialNetworks) config.header.SocialNetworks = {};

                config.header.title = $('input[name="title"]').val();
                config.header.namesite = $('input[name="namesite"]').val();
                config.header.favicon = $('input[name="favicon"]').val();
                config.header.avatar = $('input[name="avatar"]').val();
                config.header.description = $('input[name="description"]').val();
                config.header.keywords = $('input[name="keywords"]').val();

                config.header.bio1 = $('input[name="bio1"]').val();
                config.header.bio2 = $('input[name="bio2"]').val();
                config.header.bio3 = $('input[name="bio3"]').val();
                config.header.bio4 = $('input[name="bio4"]').val();
                config.header.bio5 = $('input[name="bio5"]').val();
                config.header.bio6 = $('input[name="bio6"]').val();

                var usernamesArray = $('textarea[name="usernames"]').val().split('\\n').map(s => s.trim()).filter(Boolean);
                config.header.userName = usernamesArray;

                config.header.SocialNetworks.facebook = $('input[name="social_facebook"]').val();
                config.header.SocialNetworks.instagram = $('input[name="social_instagram"]').val();
                config.header.SocialNetworks.tiktok = $('input[name="social_tiktok"]').val();
                config.header.SocialNetworks.telegram = $('input[name="social_telegram"]').val();

                localStorage.setItem('config_data', JSON.stringify(config));
                
                Wstoast.closeAll();
                Wstoast.success('General configurations successfully updated (locally)!');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        });

        // Save Relationship configurations
        $('#form-relationship').on('submit', function(e) {
            e.preventDefault();
            Wstoast.loading('Saving anniversary configurations...');
            
            var formData = $(this).serialize() + '&action=save_relationship';
            
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    Wstoast.closeAll();
                    if (response && response.status === 'success') {
                        localStorage.removeItem('config_data');
                        Wstoast.success(response.message || 'Relationship configurations updated on disk!');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        saveRelationshipLocally();
                    }
                },
                error: function() {
                    saveRelationshipLocally();
                }
            });

            function saveRelationshipLocally() {
                if (!config) config = {};
                if (!config.lovedays) config.lovedays = {};

                config.lovedays.time_relashiption = $('input[name="time_relashiption"]').val();
                config.lovedays.name_male = $('input[name="name_male"]').val();
                config.lovedays.avatar_male = $('input[name="avatar_male"]').val();
                config.lovedays.name_female = $('input[name="name_female"]').val();
                config.lovedays.avatar_female = $('input[name="avatar_female"]').val();

                localStorage.setItem('config_data', JSON.stringify(config));
                
                Wstoast.closeAll();
                Wstoast.success('Relationship configurations updated (locally)!');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        });

        // Add Song
        $('#form-add-song').on('submit', function(e) {
            e.preventDefault();
            Wstoast.loading('Adding track to playlist...');
            
            var formData = $(this).serialize() + '&action=add_song';
            
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    Wstoast.closeAll();
                    if (response && response.status === 'success') {
                        localStorage.removeItem('config_data');
                        Wstoast.success(response.message || 'New song added successfully to disk!');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        addSongLocally();
                    }
                },
                error: function() {
                    addSongLocally();
                }
            });

            function addSongLocally() {
                if (!config) config = {};
                if (!config.music) config.music = [];

                var newSong = {
                    title: $('input[name="song_title"]').val() || "Unknown",
                    author: $('input[name="song_author"]').val() || "Unknown Artist",
                    url: $('input[name="song_url"]').val() || "",
                    avatar: $('input[name="song_avatar"]').val() || "https://i.imgur.com/e28b0dD.png"
                };

                if (newSong.url) {
                    config.music.push(newSong);
                    localStorage.setItem('config_data', JSON.stringify(config));
                    Wstoast.closeAll();
                    Wstoast.success('New song added successfully (locally)!');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    Wstoast.closeAll();
                    Wstoast.error('Song MP3 URL cannot be empty!');
                }
            }
        });

        // Delete Song
        $(document).on('click', '.delete-song-btn', function() {
            var index = parseInt($(this).attr('data-index') || $(this).data('index'), 10);
            var row = $(this).closest('tr');
            if (confirm('Are you sure you want to permanently delete this track?')) {
                Wstoast.loading('Deleting track...');
                
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: {
                        action: 'delete_song',
                        index: index
                    },
                    dataType: 'json',
                    success: function(response) {
                        Wstoast.closeAll();
                        if (response && response.status === 'success') {
                            localStorage.removeItem('config_data');
                            Wstoast.success(response.message || 'Song deleted successfully from disk!');
                            row.fadeOut(500, function() {
                                location.reload();
                            });
                        } else {
                            deleteSongLocally();
                        }
                    },
                    error: function() {
                        deleteSongLocally();
                    }
                });

                function deleteSongLocally() {
                    if (config && config.music && index >= 0 && index < config.music.length) {
                        config.music.splice(index, 1);
                        localStorage.setItem('config_data', JSON.stringify(config));
                        Wstoast.closeAll();
                        Wstoast.success('Song deleted successfully (locally)!');
                        row.fadeOut(500, function() {
                            location.reload();
                        });
                    } else {
                        Wstoast.closeAll();
                        Wstoast.error('Invalid song index!');
                    }
                }
            }
        });

        // Reset Config Button logic
        $('#btn-reset-config').on('click', function() {
            if (confirm('Are you sure you want to reset all configurations to the repository config.json defaults?')) {
                Wstoast.loading('Resetting configuration...');
                localStorage.removeItem('config_data');
                Wstoast.closeAll();
                Wstoast.success('Configuration reset successfully!');
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        });

        // Dynamic Server Load Simulation
        setInterval(function() {
            var randomCpu = Math.floor(Math.random() * (35 - 12 + 1)) + 12;
            var randomRam = Math.floor(Math.random() * (55 - 30 + 1)) + 35;
            var randomPing = Math.floor(Math.random() * (48 - 20 + 1)) + 25;
            
            $('#cpu-load').text(randomCpu + '%');
            $('#ram-load').text(randomRam + '%');
            $('#ping-load').text(randomPing + 'ms');
        }, 4000);
    });
</script>"""

# Replace script using regex
html_content = re.sub(script_block_pattern, new_script_block, html_content, flags=re.DOTALL)

# Let's save index.html
with open('index.html', 'w', encoding='utf-8') as f:
    f.write(html_content)

print("Generated beautiful fully interactive index.html successfully!")

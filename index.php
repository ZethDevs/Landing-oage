<?php require_once './res/config/option.php'; ?>
<?php 
$ThanhDieuHeader = new ThanhDieuHeader();
$ThanhDieuLoveDays = new ThanhDieuLoveDays();
$ThanhDieuMusicList = new ThanhDieuMusicList();
$ThanhDieuHeader->CommonMethod();
$ThanhDieuLoveDays->CommonMethod();
$ThanhDieuMusicList->CommonMethod();

// Handle Form Submissions (AJAX actions)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $configData = $GLOBALS['TD_CONFIG_DATA'];

    if ($_POST['action'] === 'save_general') {
        $configData['header']['title'] = $_POST['title'] ?? $configData['header']['title'];
        $configData['header']['namesite'] = $_POST['namesite'] ?? $configData['header']['namesite'];
        $configData['header']['description'] = $_POST['description'] ?? $configData['header']['description'];
        $configData['header']['keywords'] = $_POST['keywords'] ?? $configData['header']['keywords'];
        $configData['header']['favicon'] = $_POST['favicon'] ?? $configData['header']['favicon'];
        $configData['header']['avatar'] = $_POST['avatar'] ?? $configData['header']['avatar'];
        $configData['header']['bio1'] = $_POST['bio1'] ?? $configData['header']['bio1'];
        $configData['header']['bio2'] = $_POST['bio2'] ?? $configData['header']['bio2'];
        $configData['header']['bio3'] = $_POST['bio3'] ?? $configData['header']['bio3'];
        $configData['header']['bio4'] = $_POST['bio4'] ?? $configData['header']['bio4'];
        $configData['header']['bio5'] = $_POST['bio5'] ?? $configData['header']['bio5'];
        $configData['header']['bio6'] = $_POST['bio6'] ?? $configData['header']['bio6'];
        
        if (isset($_POST['usernames']) && !empty($_POST['usernames'])) {
            $usernamesArray = array_map('trim', explode("\n", $_POST['usernames']));
            $configData['header']['userName'] = array_values(array_filter($usernamesArray));
        }

        if (isset($_POST['social_facebook'])) {
            $configData['header']['SocialNetworks']['facebook'] = $_POST['social_facebook'];
        }
        if (isset($_POST['social_instagram'])) {
            $configData['header']['SocialNetworks']['instagram'] = $_POST['social_instagram'];
        }
        if (isset($_POST['social_tiktok'])) {
            $configData['header']['SocialNetworks']['tiktok'] = $_POST['social_tiktok'];
        }
        if (isset($_POST['social_telegram'])) {
            $configData['header']['SocialNetworks']['telegram'] = $_POST['social_telegram'];
        }

        ThanhDieuConfigHelper::saveConfig($configData);
        echo json_encode(["status" => "success", "message" => "General configurations successfully updated!"]);
        exit;
    }

    if ($_POST['action'] === 'save_relationship') {
        $configData['lovedays']['name_male'] = $_POST['name_male'] ?? $configData['lovedays']['name_male'];
        $configData['lovedays']['avatar_male'] = $_POST['avatar_male'] ?? $configData['lovedays']['avatar_male'];
        $configData['lovedays']['name_female'] = $_POST['name_female'] ?? $configData['lovedays']['name_female'];
        $configData['lovedays']['avatar_female'] = $_POST['avatar_female'] ?? $configData['lovedays']['avatar_female'];
        $configData['lovedays']['time_relashiption'] = $_POST['time_relashiption'] ?? $configData['lovedays']['time_relashiption'];

        ThanhDieuConfigHelper::saveConfig($configData);
        echo json_encode(["status" => "success", "message" => "Relationship configurations updated!"]);
        exit;
    }

    if ($_POST['action'] === 'add_song') {
        $newSong = [
            "title" => $_POST['song_title'] ?? "Unknown",
            "author" => $_POST['song_author'] ?? "Unknown Artist",
            "url" => $_POST['song_url'] ?? "",
            "avatar" => $_POST['song_avatar'] ?? "https://i.imgur.com/e28b0dD.png"
        ];
        if (!empty($newSong['url'])) {
            $configData['music'][] = $newSong;
            ThanhDieuConfigHelper::saveConfig($configData);
            echo json_encode(["status" => "success", "message" => "New song added successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Song MP3 URL cannot be empty!"]);
        }
        exit;
    }

    if ($_POST['action'] === 'delete_song') {
        $index = intval($_POST['index']);
        if (isset($configData['music'][$index])) {
            array_splice($configData['music'], $index, 1);
            ThanhDieuConfigHelper::saveConfig($configData);
            echo json_encode(["status" => "success", "message" => "Song deleted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid song index!"]);
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="theme-custom">
<head>
    <!--/ @Meta Tag /-->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#00FFFF">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="description" content="<?=$ThanhDieuHeader->description?>">
    <meta name="author" content="ThanhDieuTV">
    <meta name="keywords" content="<?=$ThanhDieuHeader->keywords?>">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <link rel="shortcut icon" href="<?=$ThanhDieuHeader->favicon?>?v=<?=rand(1,999)?>" type="image/x-icon">
    <meta property="og:title" content="<?=$ThanhDieuHeader->title?>">
    <meta property="og:url" content="//thanhdieu.com">
    <meta property="og:image" content="./res/v5/img/bg3.webp">
    <title><?=$ThanhDieuHeader->title?></title>
    <!--/ @StyleSheets /-->
    <link rel="stylesheet" href="./res/v5/css/ws.theme.css">
    <link rel="stylesheet" href="./res/v5/css/animation.css">
    <link rel="stylesheet" href="./res/v5/css/index.css?v=<?php echo rand(1,999)?>">
    <link rel="stylesheet" href="./res/v5/css/style.css">
    <link rel="stylesheet" href="./res/v5/css/custom-love.css">
    <!--/ @Frameworks /-->
    <link rel="stylesheet" href="./res/v5/libs/jbox@1.3.3/jBox.all.min.css">
    <!--/ @CDN /-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.thanhdieu.com/dialog/wstoast/ws.toast.css?v=1">

    <style>
    /* Dashboard Styling Overrides */
    #td-main {
        padding: 0 !important;
        display: flex;
        flex-direction: row;
        min-height: 100vh;
        max-width: 100vw;
        width: 100vw;
        background: transparent;
        box-sizing: border-box;
    }

    .dash-sidebar {
        width: 290px;
        background: var(--card-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border-right: 1px solid var(--border-color);
        padding: 25px;
        display: flex;
        flex-direction: column;
        height: 100vh;
        position: sticky;
        top: 0;
        z-index: 100;
        transition: all 0.3s ease;
        flex-shrink: 0;
        box-sizing: border-box;
    }

    .sidebar-profile {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 25px;
    }

    /* Maintain avatar borders and effects inside sidebar */
    .sidebar-profile .about-me {
        margin: 0 !important;
        justify-content: center !important;
    }

    .sidebar-profile .about-me .avatar-img {
        width: 7.5em !important;
        height: 7.5em !important;
    }

    .sidebar-profile .about-me .avatar:before {
        width: 18px !important;
        height: 18px !important;
        bottom: 10px !important;
        right: 10px !important;
    }

    .dash-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-grow: 1;
    }

    .dash-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 18px;
        border-radius: 12px;
        color: var(--text-color);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.25s ease;
        border: 1px solid transparent;
        text-decoration: none;
    }

    .dash-nav-item:hover {
        background: var(--card-hover-bg);
        border-color: var(--border-color);
        color: var(--text-color);
        transform: translateX(4px);
    }

    .dash-nav-item.active {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(80, 70, 229, 0.45);
        border-color: rgba(99, 102, 241, 0.4);
    }

    .dash-sidebar-footer {
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .dash-content-area {
        flex-grow: 1;
        padding: 35px;
        overflow-y: auto;
        height: 100vh;
        display: flex;
        flex-direction: column;
        gap: 30px;
        box-sizing: border-box;
    }

    .dash-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        padding: 18px 30px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .dash-topbar-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: var(--text-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .dash-topbar-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .dash-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 25px;
    }

    .dash-stat-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dash-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border-color: rgba(99, 102, 241, 0.5);
    }

    .dash-stat-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .dash-stat-label {
        font-size: 0.8rem;
        color: var(--text-color);
        opacity: 0.6;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 700;
    }

    .dash-stat-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-color);
    }

    .dash-stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .dash-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        margin-bottom: 30px;
    }

    .dash-card-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-color);
        margin-top: 0;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    .dash-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
    }

    .dash-form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .dash-form-group.full-width {
        grid-column: 1 / -1;
    }

    .dash-label {
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--text-color);
    }

    .dash-input, .dash-textarea {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px 18px;
        color: var(--text-color);
        font-size: 0.98rem;
        transition: all 0.25s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .dark-mode .dash-input, .dark-mode .dash-textarea {
        background: rgba(0, 0, 0, 0.2);
    }

    .dash-input:focus, .dash-textarea:focus {
        outline: none;
        border-color: #6366f1;
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
    }

    .dash-btn-primary {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff !important;
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.98rem;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 8px 25px rgba(80, 70, 229, 0.4);
    }

    .dash-btn-primary:hover {
        background: linear-gradient(135deg, #4f46e5, #4338ca);
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(80, 70, 229, 0.5);
    }

    .dash-btn-danger {
        background: linear-gradient(135deg, #f43f5e, #e11d48);
        color: #ffffff !important;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .dash-btn-danger:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(225, 29, 72, 0.3);
    }

    .dash-table-wrapper {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 14px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .dash-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.95rem;
    }

    .dash-table th {
        background: rgba(255, 255, 255, 0.04);
        padding: 14px 20px;
        font-weight: 700;
        border-bottom: 2px solid var(--border-color);
        color: var(--text-color);
    }

    .dash-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        color: var(--text-color);
    }

    .dash-table tr:last-child td {
        border-bottom: none;
    }

    .dash-table tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    /* Sidebar Hamburger in Mobile */
    .toggle-sidebar-btn {
        display: none;
        font-size: 1.5rem;
        background: none;
        border: none;
        color: var(--text-color);
        cursor: pointer;
    }

    .dash-sidebar-header {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
    }

    /* Mobile responsive styles */
    @media (max-width: 991px) {
        #td-main {
            flex-direction: column !important;
        }
        .dash-sidebar {
            width: 100% !important;
            height: auto !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: auto !important;
            border-right: none !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 15px 20px !important;
            transform: translateY(0);
        }
        .dash-sidebar.mobile-open {
            height: 100vh !important;
        }
        .dash-sidebar.mobile-open .dash-nav-list {
            display: flex !important;
        }
        .dash-sidebar.mobile-open .dash-sidebar-footer {
            display: flex !important;
        }
        .dash-sidebar .dash-nav-list {
            display: none;
            margin-top: 15px;
        }
        .dash-sidebar .dash-sidebar-footer {
            display: none;
            margin-top: 15px;
        }
        .toggle-sidebar-btn {
            display: block !important;
        }
        .dash-sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .dash-content-area {
            padding: 20px !important;
            margin-top: 75px !important;
            height: calc(100vh - 75px) !important;
        }
        .sidebar-profile {
            display: none !important;
        }
    }

    /* Logs & activity styles */
    .log-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .log-item {
        display: flex;
        gap: 15px;
        align-items: flex-start;
        padding-bottom: 12px;
        border-bottom: 1px dashed var(--border-color);
    }
    .log-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .log-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(80, 70, 229, 0.1);
        color: #5046e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .log-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .log-text {
        font-size: 0.92rem;
        color: var(--text-color);
        font-weight: 500;
    }
    .log-time {
        font-size: 0.78rem;
        color: var(--text-color);
        opacity: 0.5;
    }
    </style>
</head>
<body class="BodyStyle">
    <!--/ @Lock Screen Welcome Overlay /-->
    <div class="td-lock-screen">
        <section class="td-welcome">
            <div class="medias">
                <video class="item_video" autoplay loop muted playsinline>
                    <source src="./res/v5/files/video/hutao.mp4" type="video/mp4">
                </video>
                <div class="date"></div>
            </div>
            <div class="infos">
                <div class="logo-web-title">
                    <img class="logo-ws" src="https://i.imgur.com/dxVZLOG.png" alt="Vương Thanh Diệu">
                    <span class="web-title">𝑻𝒉𝒂𝒏𝒉𝑫𝒊𝒆𝒖</span>
                </div>
                <span class="web_desc"></span>
                <div>
                    <i class="icon ni ni-arrow-down close-lockscreen"></i>
                </div>
            </div>
        </section>
    </div>

    <!--/ @Pace Loader /-->
    <div class="pace pace-active">
        <div class="pace-progress" data-progress-text="0%" data-progress="0" style="transform: translate3d(0%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
    </div>
    <div id="loading-box">
        <div class="loading-bg">
            <img class="loading-img entered loading" src="<?=$ThanhDieuHeader->favicon?>?v=<?=rand(1,999)?>" data-ws-status="loading">
            <div class="loading-image-dot"></div>
            <div id="loading-percentage">0%</div>
        </div>
    </div>

    <!--/ @Main Container Redesigned into Admin Dashboard /-->
    <main id="td-main">
        <!--/ @Sidebar Navigation Panel /-->
        <aside class="dash-sidebar">
            <div class="dash-sidebar-header">
                <div style="display:flex; align-items:center; gap: 10px;">
                    <i class="ri-dashboard-3-fill" style="font-size: 1.8rem; color: #5046e5;"></i>
                    <h3 style="margin: 0; font-weight: 800; font-size: 1.15rem; letter-spacing: 0.5px; color: var(--text-color);">WS ADMIN</h3>
                </div>
                <button class="toggle-sidebar-btn">
                    <i class="ri-menu-line"></i>
                </button>
            </div>

            <!--/ Preserving the Majestic Original Avatar & Crown exactly with its awesome border glow animations /-->
            <div class="sidebar-profile">
                <div class="about-me">
                    <div class="avatar">
                        <img class="avatar-img" src="<?=$ThanhDieuHeader->avatar?>?v=<?=rand(1,999)?>" alt="Vương Thanh Diệu">
                        <img class="crown" src="./res/v5/img/crown/mong-vuot-rong.png">
                    </div>
                </div>
                <div style="margin-top: 15px;">
                    <h4 style="font-size: 1.1rem; margin: 0; font-weight: 700; color: var(--text-color);"><?=$ThanhDieuHeader->namesite?></h4>
                    <span style="font-size: 0.78rem; opacity: 0.6; color: var(--text-color);">System Administrator</span>
                    <div style="margin-top: 8px;">
                        <span class="badge badge-success" style="background: #28a745; color: white; border-radius: 20px; padding: 3px 12px; font-size: 0.72rem; display: inline-flex; align-items: center; gap: 4px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #fff; display: inline-block; animation: pulse 1.5s infinite;"></span> Online
                        </span>
                    </div>
                </div>
            </div>

            <!--/ Sidebar Navigation Items /-->
            <ul class="dash-nav-list">
                <li class="dash-nav-item active" data-tab="overview">
                    <i class="ri-home-4-fill"></i>
                    <span>Overview</span>
                </li>
                <li class="dash-nav-item" data-tab="general">
                    <i class="ri-settings-4-fill"></i>
                    <span>Config Website</span>
                </li>
                <li class="dash-nav-item" onclick="window.open('res/config/config.html','_blank')">
                    <i class="ri-file-settings-fill"></i>
                    <span>Config</span>
                </li>
                <li class="dash-nav-item" data-tab="relationship">
                    <i class="ri-heart-pulse-fill"></i>
                    <span>Anniversary Panel</span>
                </li>
                <li class="dash-nav-item" data-tab="music">
                    <i class="ri-music-2-fill"></i>
                    <span>Music Playlist</span>
                </li>
                <li class="dash-nav-item" data-tab="developer">
                    <i class="ri-terminal-box-fill"></i>
                    <span>Developer Area</span>
                </li>
            </ul>

            <!--/ Sidebar Footer Details /-->
            <div class="dash-sidebar-footer">
                <button class="dash-btn-primary" onclick="$('.td-welcome').slideDown('slow'); $('.td-lock-screen').animate({opacity: 1}, 'fast').css('pointer-events', 'auto');" style="padding: 10px; width: 100%; font-size: 0.88rem;">
                    <i class="ri-lock-fill"></i> Lock Dashboard
                </button>
            </div>
        </aside>

        <!--/ @Main Content Area /-->
        <section class="dash-content-area">
            
            <!--/ Top Navbar Area /-->
            <header class="dash-topbar">
                <h2 class="dash-topbar-title">
                    <i class="ri-home-4-fill" style="color:#5046e5;"></i> Overview
                </h2>
                <div class="dash-topbar-actions">
                    <button class="dash-btn-circle change-skin" title="Toggle Light/Dark Theme">
                        <i class="ri-sun-line"></i>
                    </button>
                    <button class="dash-btn-circle setting-site" title="Background Options">
                        <i class="ri-palette-line"></i>
                    </button>
                    <div id="real-time" style="font-size: 1rem; font-weight: 700; color: var(--text-color); background: rgba(255,255,255,0.05); padding: 8px 16px; border-radius: 12px; border: 1px solid var(--border-color); position: static;">00:00:00</div>
                </div>
            </header>

            <!--/ ==================== TAB 1: OVERVIEW PANEL ==================== /-->
            <div id="tab-overview" class="dash-tab-panel active">
                
                <!--/ Beautiful Dynamic Typography Welcomer /-->
                <div class="dash-card" style="background: linear-gradient(135deg, rgba(80, 70, 229, 0.08), rgba(244, 63, 94, 0.04));">
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap: 20px;">
                        <div>
                            <h2 class="HoVaTen__" style="text-align: left; font-size: 1.85rem; margin: 0; margin-bottom: 8px; text-shadow: none;">
                                <span id="userName" data-userName='<?= json_encode($ThanhDieuHeader->userName ?? []) ?>'></span>
                            </h2>
                            <p style="margin: 0; font-size: 0.95rem; opacity: 0.75; color: var(--text-color);">
                                Welcome back to your master control dashboard. Here you can configure system parameters, update metadata, monitor performance, and customize live modules.
                            </p>
                        </div>
                    </div>
                </div>

                <!--/ Metric Statistics KPI Cards /-->
                <div class="dash-stats-grid">
                    <div class="dash-stat-card">
                        <div class="dash-stat-info">
                            <span class="dash-stat-label">Total Traffic</span>
                            <span class="dash-stat-value">12,580</span>
                        </div>
                        <div class="dash-stat-icon icon-indigo">
                            <i class="ri-line-chart-fill"></i>
                        </div>
                    </div>
                    <div class="dash-stat-card">
                        <div class="dash-stat-info">
                            <span class="dash-stat-label">Anniversary Countdown</span>
                            <span class="dash-stat-value" id="day-counter-display" style="font-size: 1.45rem;">-- Days</span>
                        </div>
                        <div class="dash-stat-icon icon-rose">
                            <i class="ri-heart-fill"></i>
                        </div>
                    </div>
                    <div class="dash-stat-card">
                        <div class="dash-stat-info">
                            <span class="dash-stat-label">Active Songs</span>
                            <span class="dash-stat-value"><?= count($ThanhDieuMusicList->songs) ?> Tracks</span>
                        </div>
                        <div class="dash-stat-icon icon-emerald">
                            <i class="ri-music-fill"></i>
                        </div>
                    </div>
                    <div class="dash-stat-card">
                        <div class="dash-stat-info">
                            <span class="dash-stat-label">Ping Latency</span>
                            <span class="dash-stat-value" id="ping-load">42ms</span>
                        </div>
                        <div class="dash-stat-icon icon-amber">
                            <i class="ri-radar-fill"></i>
                        </div>
                    </div>
                </div>

                <div style="height: 30px;"></div>

                <!--/ Majestic Profile Bio Block with exact original tags and crown avatar borders preserved! /-->
                <div class="dash-card">
                    <h3 class="dash-card-title">
                        <i class="ri-admin-fill" style="color: #6366f1;"></i> Administrator Signature Card
                    </h3>
                    <div style="display: flex; flex-direction: column; align-items: center; padding: 20px 0;">
                        
                        <!--/ Majestic floating tags and avatar core precisely as requested /-->
                        <div class="about-me" style="display: flex; align-items: center; gap: 30px; margin: 0 auto; flex-wrap: wrap; justify-content: center;">
                            <div class="info-left">
                                <span class="tag"><?=$ThanhDieuHeader->bio1?></span>
                                <span class="tag"><?=$ThanhDieuHeader->bio2?></span>
                                <span class="tag"><?=$ThanhDieuHeader->bio3?></span>
                            </div>
                            <div class="avatar" style="position: relative;">
                                <img class="avatar-img" src="<?=$ThanhDieuHeader->avatar?>?v=<?=rand(1,999)?>" alt="Vương Thanh Diệu">
                                <img class="crown" src="./res/v5/img/crown/mong-vuot-rong.png">
                            </div>
                            <div class="info-right">
                                <span class="tag"><?=$ThanhDieuHeader->bio4?></span>
                                <span class="tag"><?=$ThanhDieuHeader->bio5?></span>
                                <span class="tag"><?=$ThanhDieuHeader->bio6?></span>
                            </div>
                        </div>

                    </div>
                </div>

                <!--/ Dual Widget Layout /-->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
                    
                    <!--/ Active Counter Live Widget from original page /-->
                    <div class="dash-card">
                        <h3 class="dash-card-title">
                            <i class="ri-timer-flash-fill" style="color: #e11d48;"></i> Live Relationship Timer
                        </h3>
                        <div style="padding: 10px 0;">
                            <!-- Original hidden date binder -->
                            <div class="hide" id="anniversary-date-binder" data-ngayyeu="<?= $ThanhDieuLoveDays->ConfigLove['time_relashiption']; ?>"></div>
                            
                            <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap; margin-bottom: 25px;">
                                <div style="text-align: center; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); padding: 12px 18px; border-radius: 12px; min-width: 70px;">
                                    <span id="day" style="font-size: 1.8rem; font-weight: 800; color: #f43f5e;">00</span>
                                    <div style="font-size: 0.72rem; opacity: 0.6; text-transform: uppercase; margin-top: 4px; font-weight: bold; color: var(--text-color);">Days</div>
                                </div>
                                <div style="text-align: center; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); padding: 12px 18px; border-radius: 12px; min-width: 70px;">
                                    <span id="hours" style="font-size: 1.8rem; font-weight: 800; color: var(--text-color);">00</span>
                                    <div style="font-size: 0.72rem; opacity: 0.6; text-transform: uppercase; margin-top: 4px; font-weight: bold; color: var(--text-color);">Hours</div>
                                </div>
                                <div style="text-align: center; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); padding: 12px 18px; border-radius: 12px; min-width: 70px;">
                                    <span id="minute" style="font-size: 1.8rem; font-weight: 800; color: var(--text-color);">00</span>
                                    <div style="font-size: 0.72rem; opacity: 0.6; text-transform: uppercase; margin-top: 4px; font-weight: bold; color: var(--text-color);">Mins</div>
                                </div>
                                <div style="text-align: center; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); padding: 12px 18px; border-radius: 12px; min-width: 70px;">
                                    <span id="seconds" style="font-size: 1.8rem; font-weight: 800; color: var(--text-color);">00</span>
                                    <div style="font-size: 0.72rem; opacity: 0.6; text-transform: uppercase; margin-top: 4px; font-weight: bold; color: var(--text-color);">Secs</div>
                                </div>
                            </div>

                            <!-- Coupling preview graphic -->
                            <div class="bg-wrap" style="position: relative; display: block; margin: 0 auto; max-width: 100%;">
                                <div class="bg-img" style="border: none; box-shadow: none; background: none;">
                                    <div class="middle animated" style="display: flex; justify-content: center; align-items: center; gap: 20px; position: static;">
                                        <div class="img-male" style="position: relative; display: flex; flex-direction: column; align-items: center;">
                                            <img src="<?=$ThanhDieuLoveDays->ConfigLove['avatar_male'];?>" alt="<?=$ThanhDieuLoveDays->ConfigLove['name_male'];?>" style="width: 70px; height: 70px; border-radius: 50%; border: 3px solid var(--border-color);">
                                            <img class="crown-love" src="./res/v5/img/crown/khung-4.png" style="width: 90px; height: auto; position: absolute; top: -10px;">
                                            <span style="font-size: 0.85rem; font-weight: 700; margin-top: 8px; color: var(--text-color);"><?=$ThanhDieuLoveDays->ConfigLove['name_male'];?></span>
                                        </div>
                                        <div class="heart" style="background-size: contain; width: 35px; height: 35px; margin: 0;"></div>
                                        <div class="img-female" style="position: relative; display: flex; flex-direction: column; align-items: center;">
                                            <img src="<?=$ThanhDieuLoveDays->ConfigLove['avatar_female'];?>" alt="<?=$ThanhDieuLoveDays->ConfigLove['name_female'];?>" style="width: 70px; height: 70px; border-radius: 50%; border: 3px solid var(--border-color);">
                                            <img class="crown-love" src="./res/v5/img/crown/khung-4.png" style="width: 90px; height: auto; position: absolute; top: -10px;">
                                            <span style="font-size: 0.85rem; font-weight: 700; margin-top: 8px; color: var(--text-color);"><?=$ThanhDieuLoveDays->ConfigLove['name_female'];?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!--/ System Security & Logging Panel /-->
                    <div class="dash-card">
                        <h3 class="dash-card-title">
                            <i class="ri-shield-keyhole-fill" style="color: #10b981;"></i> Security Logs & Status
                        </h3>
                        <div class="log-list">
                            <div class="log-item">
                                <div class="log-icon"><i class="ri-refresh-line"></i></div>
                                <div class="log-details">
                                    <span class="log-text">Dynamic classes parsed successfully</span>
                                    <span class="log-time">Just now</span>
                                </div>
                            </div>
                            <div class="log-item">
                                <div class="log-icon" style="color: #28a745; background: rgba(40,167,69,0.1);"><i class="ri-checkbox-circle-line"></i></div>
                                <div class="log-details">
                                    <span class="log-text">Database option.json integrity confirmed</span>
                                    <span class="log-time">5 minutes ago</span>
                                </div>
                            </div>
                            <div class="log-item">
                                <div class="log-icon" style="color: #17a2b8; background: rgba(23,162,184,0.1);"><i class="ri-info-i"></i></div>
                                <div class="log-details">
                                    <span class="log-text">Administrator session started from 127.0.0.1</span>
                                    <span class="log-time">1 hour ago</span>
                                </div>
                            </div>
                            <div class="log-item">
                                <div class="log-icon" style="color: #ffc107; background: rgba(255,193,7,0.1);"><i class="ri-key-2-line"></i></div>
                                <div class="log-details">
                                    <span class="log-text">SSL cryptographic protocol activated</span>
                                    <span class="log-time">12 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!--/ ==================== TAB 2: CONFIG WEBSITE PANEL ==================== /-->
            <div id="tab-general" class="dash-tab-panel">
                <form id="form-general">
                    <div class="dash-card">
                        <h3 class="dash-card-title">
                            <i class="ri-global-fill"></i> Metadata & Identity Configuration
                        </h3>
                        <div class="dash-form-grid">
                            <div class="dash-form-group">
                                <label class="dash-label">Website Title</label>
                                <input type="text" class="dash-input" name="title" value="<?= htmlspecialchars($ThanhDieuHeader->title) ?>" required>
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Website Brand / Name Site</label>
                                <input type="text" class="dash-input" name="namesite" value="<?= htmlspecialchars($ThanhDieuHeader->namesite) ?>" required>
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Favicon Link</label>
                                <input type="text" class="dash-input" name="favicon" value="<?= htmlspecialchars($ThanhDieuHeader->favicon) ?>" required>
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Admin Avatar (GIF or PNG)</label>
                                <input type="text" class="dash-input" name="avatar" value="<?= htmlspecialchars($ThanhDieuHeader->avatar) ?>" required>
                            </div>
                            <div class="dash-form-group full-width">
                                <label class="dash-label">Website Description (SEO)</label>
                                <input type="text" class="dash-input" name="description" value="<?= htmlspecialchars($ThanhDieuHeader->description) ?>">
                            </div>
                            <div class="dash-form-group full-width">
                                <label class="dash-label">Keywords (Comma-separated)</label>
                                <input type="text" class="dash-input" name="keywords" value="<?= htmlspecialchars($ThanhDieuHeader->keywords) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="dash-card">
                        <h3 class="dash-card-title">
                            <i class="ri-user-star-fill"></i> Subtitle & Profile Biography Tags
                        </h3>
                        <div class="dash-form-grid">
                            <div class="dash-form-group">
                                <label class="dash-label">Bio Tag 1</label>
                                <input type="text" class="dash-input" name="bio1" value="<?= htmlspecialchars($ThanhDieuHeader->bio1) ?>">
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Bio Tag 2</label>
                                <input type="text" class="dash-input" name="bio2" value="<?= htmlspecialchars($ThanhDieuHeader->bio2) ?>">
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Bio Tag 3</label>
                                <input type="text" class="dash-input" name="bio3" value="<?= htmlspecialchars($ThanhDieuHeader->bio3) ?>">
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Bio Tag 4</label>
                                <input type="text" class="dash-input" name="bio4" value="<?= htmlspecialchars($ThanhDieuHeader->bio4) ?>">
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Bio Tag 5</label>
                                <input type="text" class="dash-input" name="bio5" value="<?= htmlspecialchars($ThanhDieuHeader->bio5) ?>">
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Bio Tag 6</label>
                                <input type="text" class="dash-input" name="bio6" value="<?= htmlspecialchars($ThanhDieuHeader->bio6) ?>">
                            </div>
                            <div class="dash-form-group full-width">
                                <label class="dash-label">Typed Subtitle Greetings (One string per line)</label>
                                <textarea class="dash-textarea" name="usernames" rows="4"><?= implode("\n", $ThanhDieuHeader->userName ?? []) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="dash-card">
                        <h3 class="dash-card-title">
                            <i class="ri-links-fill"></i> Social Network Integrations
                        </h3>
                        <div class="dash-form-grid">
                            <div class="dash-form-group">
                                <label class="dash-label">Facebook Profile URL</label>
                                <input type="text" class="dash-input" name="social_facebook" value="<?= htmlspecialchars($ThanhDieuHeader->SocialNetworks['facebook'] ?? '') ?>">
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Instagram Profile URL</label>
                                <input type="text" class="dash-input" name="social_instagram" value="<?= htmlspecialchars($ThanhDieuHeader->SocialNetworks['instagram'] ?? '') ?>">
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">TikTok Profile URL</label>
                                <input type="text" class="dash-input" name="social_tiktok" value="<?= htmlspecialchars($ThanhDieuHeader->SocialNetworks['tiktok'] ?? '') ?>">
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Telegram Group/Channel URL</label>
                                <input type="text" class="dash-input" name="social_telegram" value="<?= htmlspecialchars($ThanhDieuHeader->SocialNetworks['telegram'] ?? '') ?>">
                            </div>
                        </div>
                        <div style="margin-top: 30px; text-align: right;">
                            <button type="submit" class="dash-btn-primary">
                                <i class="ri-save-3-fill"></i> Save General Configurations
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!--/ ==================== TAB 3: ANNIVERSARY PANEL ==================== /-->
            <div id="tab-relationship" class="dash-tab-panel">
                <form id="form-relationship">
                    <div class="dash-card">
                        <h3 class="dash-card-title">
                            <i class="ri-heart-pulse-fill"></i> Relationship Coupling Configurations
                        </h3>
                        <div class="dash-form-grid">
                            <!-- Anniversary Date Picker -->
                            <div class="dash-form-group full-width">
                                <label class="dash-label">Anniversary Start Date (Format: DD/MM/YYYY)</label>
                                <input type="text" class="dash-input" name="time_relashiption" placeholder="e.g. 28/03/2024" value="<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove['time_relashiption'] ?? '') ?>" required>
                                <span style="font-size:0.8rem; opacity: 0.6; color: var(--text-color);">The date format must be exactly DD/MM/YYYY or DD-MM-YYYY to allow countdown algorithms to function.</span>
                            </div>

                            <!-- Male configuration -->
                            <div class="dash-form-group">
                                <label class="dash-label">Partner A: Name (Male)</label>
                                <input type="text" class="dash-input" name="name_male" value="<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove['name_male'] ?? '') ?>" required>
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Partner A: Avatar Image (Male)</label>
                                <input type="text" class="dash-input" name="avatar_male" value="<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove['avatar_male'] ?? '') ?>" required>
                            </div>

                            <!-- Female configuration -->
                            <div class="dash-form-group">
                                <label class="dash-label">Partner B: Name (Female)</label>
                                <input type="text" class="dash-input" name="name_female" value="<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove['name_female'] ?? '') ?>" required>
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Partner B: Avatar Image (Female)</label>
                                <input type="text" class="dash-input" name="avatar_female" value="<?= htmlspecialchars($ThanhDieuLoveDays->ConfigLove['avatar_female'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div style="margin-top: 30px; text-align: right;">
                            <button type="submit" class="dash-btn-primary" style="background: linear-gradient(135deg, #f43f5e, #e11d48); box-shadow: 0 8px 25px rgba(225, 29, 72, 0.4);">
                                <i class="ri-heart-add-fill"></i> Save Anniversary Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!--/ ==================== TAB 4: MUSIC PLAYLIST PANEL ==================== /-->
            <div id="tab-music" class="dash-tab-panel">
                
                <!--/ Add track form /-->
                <div class="dash-card">
                    <h3 class="dash-card-title">
                        <i class="ri-add-circle-fill" style="color:#10b981;"></i> Add Track to Playlist
                    </h3>
                    <form id="form-add-song">
                        <div class="dash-form-grid">
                            <div class="dash-form-group">
                                <label class="dash-label">Song Title</label>
                                <input type="text" class="dash-input" name="song_title" placeholder="e.g. Chúng Ta Của Tương Lai" required>
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Singer / Author</label>
                                <input type="text" class="dash-input" name="song_author" placeholder="e.g. Sơn Tùng M-TP" required>
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">MP3 Audio URL</label>
                                <input type="text" class="dash-input" name="song_url" placeholder="Direct link to audio (.mp3)" required>
                            </div>
                            <div class="dash-form-group">
                                <label class="dash-label">Song Thumbnail Cover URL</label>
                                <input type="text" class="dash-input" name="song_avatar" placeholder="Cover image url" required>
                            </div>
                        </div>
                        <div style="margin-top: 20px; text-align: right;">
                            <button type="submit" class="dash-btn-primary" style="background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);">
                                <i class="ri-music-fill"></i> Inject Audio Track
                            </button>
                        </div>
                    </form>
                </div>

                <!--/ Song List Table /-->
                <div class="dash-card">
                    <h3 class="dash-card-title">
                        <i class="ri-music-2-line"></i> Loaded Audio Tracks (<?= count($ThanhDieuMusicList->songs) ?> total)
                    </h3>
                    <div class="dash-table-wrapper">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Artist</th>
                                    <th>Audio Stream Link</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ThanhDieuMusicList->songs as $index => $song): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <img src="<?= htmlspecialchars($song['avatar']) ?>" style="width: 42px; height: 42px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-color);">
                                    </td>
                                    <td style="font-weight: 700;"><?= htmlspecialchars($song['title']) ?></td>
                                    <td><?= htmlspecialchars($song['author']) ?></td>
                                    <td>
                                        <span style="font-size: 0.82rem; opacity: 0.6; word-break: break-all;"><?= htmlspecialchars($song['url']) ?></span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display:inline-flex; gap: 8px;">
                                            <button class="dash-btn-danger delete-song-btn" data-index="<?= $index ?>">
                                                <i class="ri-delete-bin-fill"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!--/ ==================== TAB 5: DEVELOPER PANEL ==================== /-->
            <div id="tab-developer" class="dash-tab-panel">
                <div class="dash-card">
                    <h3 class="dash-card-title">
                        <i class="ri-terminal-box-fill"></i> Developer System Information
                    </h3>
                    <div class="dash-form-grid">
                        <div class="dash-stat-card">
                            <div class="dash-stat-info">
                                <span class="dash-stat-label">Virtual CPU Usage</span>
                                <span class="dash-stat-value" id="cpu-load">24%</span>
                            </div>
                            <div class="dash-stat-icon" style="background:#5046e5;">
                                <i class="ri-cpu-line"></i>
                            </div>
                        </div>
                        <div class="dash-stat-card">
                            <div class="dash-stat-info">
                                <span class="dash-stat-label">Virtual Memory Usage</span>
                                <span class="dash-stat-value" id="ram-load">42%</span>
                            </div>
                            <div class="dash-stat-icon" style="background:#17a2b8;">
                                <i class="ri-database-2-line"></i>
                            </div>
                        </div>
                        <div class="dash-stat-card">
                            <div class="dash-stat-info">
                                <span class="dash-stat-label">ZethDevs System Mode</span>
                                <span class="dash-stat-value" style="font-size: 1.5rem; color:#28a745;">STABLE V5</span>
                            </div>
                            <div class="dash-stat-icon" style="background:#28a745;">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div style="height: 30px;"></div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                        <div>
                            <h4 class="dash-label">Server Environment Details</h4>
                            <p style="opacity: 0.7; font-size: 0.9rem; color: var(--text-color);">
                                <strong>Operating Timezone:</strong> Asia/Ho_Chi_Minh <br>
                                <strong>Server Time:</strong> <?= date('Y-m-d H:i:s') ?> <br>
                                <strong>Client Host IP:</strong> <?= $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1' ?> <br>
                                <strong>HTTP Host:</strong> <?= $_SERVER['HTTP_HOST'] ?? 'localhost' ?> <br>
                                <strong>Protocol:</strong> <?= $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1' ?>
                            </p>
                        </div>
                        <div>
                            <h4 class="dash-label">Active Variables Cache</h4>
                            <textarea class="dash-textarea" style="font-family: monospace; font-size: 0.8rem;" rows="6" readonly><?= json_encode($GLOBALS['TD_CONFIG_DATA'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <!--/ @Setting Panel Dialog (retaining existing framework compatibility) /-->
    <ul class="nk-sticky-toolbar">
        <li class="demo-settings">
            <a class="toggle tipinfo" data-target="SettingPanel">
                <svg class="icon-spin" viewBox="0 0 30 30" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path class="st2" d="M26.6,12.9l-2.9-0.3c-0.2-0.7-0.5-1.4-0.8-2l1.8-2.3c0.2-0.2,0.1-0.5,0-0.7l-2.2-2.2c-0.2-0.2-0.5-0.2-0.7,0 l-2.3,1.8c-0.6-0.4-1.3-0.6-2-0.8l-0.3-2.9C17,3.2,16.8,3,16.6,3h-3.1c-0.3,0-0.5,0.2-0.5,0.4l-0.3,2.9c-0.7,0.2-1.4,0.5-2,0.8 L8.3,5.4c-0.2-0.2-0.5-0.1-0.7,0L5.4,7.6c-0.2,0.2-0.2,0.5,0,0.7l1.8,2.3c-0.4,0.6-0.6,1.3-0.8,2l-2.9,0.3C3.2,13,3,13.2,3,13.4v3.1 c0,0.3,0.2,0.5,0.4,0.5l2.9,0.3c0.2,0.7,0.5,1.4,0.8,2l-1.8,2.3c-0.2,0.2-0.1,0.5,0,0.7l2.2,2.2c0.2,0.2,0.5,0.2,0.7,0l2.3-1.8 c0.6,0.4,1.3,0.6,2,0.8l0.3,2.9c0,0.3,0.2,0.4,0.5,0.4h3.1c0.3,0,0.5-0.2,0.5-0.4l0.3-2.9c0.7-0.2,1.4-0.5,2-0.8l2.3,1.8 c0.2,0.2,0.5,0.1,0.7,0l2.2-2.2c0.2-0.2,0.2-0.5,0-0.7l-1.8-2.3c0.4-0.6,0.6-1.3,0.8-2l2.9-0.3c0.3,0,0.4-0.2,0.4-0.5v-3.1 C27,13.2,26.8,13,26.6,12.9z M15,19c-2.2,0-4-1.8-4-4c0-2.2,1.8-4,4-4s4,1.8,4,4C19,17.2,17.2,19,15,19z"></path>
                    </g>
                </svg>
            </a>
        </li>
    </ul>

    <div class="nk-demo-panel toggle-slide toggle-slide-right toggle-screen-any content-active" id="SettingPanel" data-content="SettingPanel" data-toggle-overlay="true" data-toggle-body="true" data-toggle-screen="any">
        <div class="nk-demo-head">
            <h6 class="mb-0">WS Settings</h6>
            <a class="nk-demo-close toggle btn btn-icon btn-trigger revarse mr-n2 active" data-target="SettingPanel" href="#">
                <em class="icon ni ni-cross"></em>
            </a>
        </div>
        <div class="nk-opt-panel" data-simplebar="init">
            <div class="simplebar-wrapper">
                <div class="simplebar-mask">
                    <div class="simplebar-offset">
                        <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                            <div class="simplebar-content">
                                <div class="nk-opt-set nk-opt-set-aside-apps change-bg">
                                    <div class="nk-opt-set-title">Dashboard Backdrop</div>
                                    <div class="nk-opt-list col-4x">
                                        <div class="nk-opt-item active" data-bg="./res/v5/img/bg.gif">
                                            <span class="nk-opt-item-bg"><img src="./res/v5/img/bg.gif"></span>
                                            <span class="nk-opt-item-name">Default</span>
                                        </div>
                                        <div class="nk-opt-item" data-bg="./res/v5/img/anime-wall.jpg">
                                            <span class="nk-opt-item-bg"><img src="./res/v5/img/anime-wall.jpg"></span>
                                            <span class="nk-opt-item-name">Anime</span>
                                        </div>
                                        <div class="nk-opt-item" data-bg="./res/v5/img/bg3.webp">
                                            <span class="nk-opt-item-bg"><img src="./res/v5/img/bg3.webp"></span>
                                            <span class="nk-opt-item-name">Sosuke</span>
                                        </div>
                                        <div class="nk-opt-item" data-bg="https://api.thanhdieu.com/random-background.php">
                                            <span class="nk-opt-item-bg"><img src="./res/v5/img/random.jpeg"></span>
                                            <span class="nk-opt-item-name">Random</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-opt-set">
                                <div class="nk-opt-set-title">Active Music Selector</div>
                                <br />
                                <div class="nk-opt-list">
                                    <ul class="music_menu_list">
                                        <?php foreach ($ThanhDieuMusicList->songs as $song): ?>
                                        <li url="<?= htmlspecialchars($song['url']) ?>">
                                            <span class="name">
                                                <img class="singer-avatar ls-is-cached" src="<?= htmlspecialchars($song['avatar']) ?>">
                                                <span class="title">
                                                    <font style="vertical-align: inherit;"><?= htmlspecialchars($song['title']) ?></font>
                                                </span>
                                            </span>
                                            <span class="author">
                                                <font style="vertical-align: inherit;"><?= htmlspecialchars($song['author']) ?></font>
                                            </span>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="nk-opt-set">
                                <div class="nk-opt-set-title">Active UI Mode</div>
                                <div class="nk-opt-list col-2x">
                                    <div class="nk-opt-item active" data-key="mode" data-update="light-mode">
                                        <span class="nk-opt-item-bg is-light"><span class="theme-light"></span></span>
                                        <span class="nk-opt-item-name">Light</span>
                                    </div>
                                    <div class="nk-opt-item" data-key="mode" data-update="dark-mode">
                                        <span class="nk-opt-item-bg"><span class="theme-dark"></span></span>
                                        <span class="nk-opt-item-name">Dark</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--/ Floating widgets /-->
    <div class="running-cat">
        <img src="./res/v5/img/cat.webp" alt="Running Cat">
    </div>
    <span id="fps">
        <font color="#640366">FPS: 60 </font>
        <span style="color:#009e45">Stable 😂</span>
    </span>
    <footer id="footer" style="position: fixed; bottom: 10px; right: 10px; padding: 0; width: auto; z-index: 50; display: block;">
        <span><a href="//thanhdieu.com" target="_blank" style="font-size: 0.8rem; opacity: 0.5;">&copy; ThanhDieu 2024</a></span>
    </footer>

    <!--/ @Framework /-->
    <script src="./res/v5/libs/jquery/jquery-3.6.0.min.js"></script>
    <script src="./res/v5/libs/jquery.pjax/jquery.pjax.min.js"></script>
    <script src="./res/v5/libs/jbox@1.3.3/jBox.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js" data-pace-options='{"restartOnRequestAfter":false,"eventLag":false}'></script>
    <!--/ @Index Resource /-->
    <script src="./res/v5/js/index.js?v=<?php echo rand(1,999)?>"></script>
    <!--/ @CDN /-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
    <script src="//cdn.thanhdieu.com/dialog/wstoast/ws.toast.js"></script>

    <!--/ AJAX and Dashboard Logic Script /-->
    <script>
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
        function updateAnniversaryDisplay() {
            var dateStr = $('#anniversary-date-binder').attr('data-ngayyeu');
            if (dateStr) {
                var parts = dateStr.split(/[\/\-:]/);
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
        updateAnniversaryDisplay();
        setInterval(updateAnniversaryDisplay, 10000);

        // AJAX: Save General Settings
        $('#form-general').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize() + '&action=save_general';
            Wstoast.loading('Saving general settings...');
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    Wstoast.closeAll();
                    if (response.status === 'success') {
                        Wstoast.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        Wstoast.error(response.message);
                    }
                },
                error: function() {
                    Wstoast.closeAll();
                    Wstoast.error('Failed to communicate with server.');
                }
            });
        });

        // AJAX: Save Relationship Info
        $('#form-relationship').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize() + '&action=save_relationship';
            Wstoast.loading('Saving anniversary configurations...');
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    Wstoast.closeAll();
                    if (response.status === 'success') {
                        Wstoast.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        Wstoast.error(response.message);
                    }
                },
                error: function() {
                    Wstoast.closeAll();
                    Wstoast.error('Failed to update couple configurations.');
                }
            });
        });

        // AJAX: Add Song
        $('#form-add-song').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize() + '&action=add_song';
            Wstoast.loading('Adding track to playlist...');
            $.ajax({
                url: 'index.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    Wstoast.closeAll();
                    if (response.status === 'success') {
                        Wstoast.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        Wstoast.error(response.message);
                    }
                },
                error: function() {
                    Wstoast.closeAll();
                    Wstoast.error('Failed to add track.');
                }
            });
        });

        // AJAX: Delete Song
        $('.delete-song-btn').on('click', function() {
            var index = $(this).data('index');
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
                        if (response.status === 'success') {
                            Wstoast.success(response.message);
                            row.fadeOut(500, function() {
                                location.reload();
                            });
                        } else {
                            Wstoast.error(response.message);
                        }
                    },
                    error: function() {
                        Wstoast.closeAll();
                        Wstoast.error('Failed to delete track from backend storage.');
                    }
                });
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
    </script>
</body>
</html>
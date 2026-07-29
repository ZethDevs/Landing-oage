<?php
/**
 * @package thanhdieuv5 (tester)
 * @author  Vương Thanh Diệu <www.facebok.com/wusthanhdieu>
 */
interface ThanhDieuConfigInterface {
    public function CommonMethod();
}

class ThanhDieuConfigHelper {
    public static $jsonPath = __DIR__ . '/config.json';
    
    public static function loadConfig() {
        if (!file_exists(self::$jsonPath)) {
            $default = [
                "header" => [
                    "title" => "Admin Dashboard | ZethDevs",
                    "description" => "Hi my name is ThanhDieu / A freelance / web developer / vexer",
                    "keywords" => "thanhdieu,web thanh dieu,vuong thanh dieu,thanhdieutv,wsteam,wusteam,thanhdieu home,profile thanhdieu",
                    "favicon" => "./res/v5/img/logo.jpg",
                    "namesite" => "ADMIN | CONTROL PANEL",
                    "avatar" => "./res/v5/img/avatar.gif",
                    "userName" => ["Hello Admin", "Welcome to Admin Panel.", "Control and configure your site 🚀"],
                    "trigger" => "👉 Tìm hiểu tôi 😶&zwj;🌫️",
                    "bio1" => "🤖️ Administrator",
                    "bio2" => "🔍 High Security Mode",
                    "bio3" => "💻 Control Panel active",
                    "bio4" => "Monitoring traffic live 📊",
                    "bio5" => "Custom CSS & Animations 🎨",
                    "bio6" => "Optimized performance 🚀",
                    "SocialNetworks" => [
                        "facebook" => "https://facebook.com/wusthanhdieu",
                        "instagram" => "https://www.instagram.com/vuongsondieu2k2",
                        "tiktok" => "https://www.tiktok.com/",
                        "telegram" => "https://t.me/thanhdieuchannel"
                    ]
                ],
                "lovedays" => [
                    "avatar_male" => "./res/v5/img/male.jpeg",
                    "name_male" => "ThanhDieu",
                    "avatar_female" => "./res/v5/img/female.jpeg",
                    "name_female" => "Ngoc Tram",
                    "time_relashiption" => "28/03/2024"
                ],
                "music" => [
                    [
                        "url" => "https://files.catbox.moe/4bjjfg.mp3",
                        "avatar" => "https://i.ibb.co/Pt4ZJJd/that-girl-1545280005.jpg",
                        "title" => "That Girl",
                        "author" => "Olly Murs"
                    ],
                    [
                        "url" => "https://files.catbox.moe/m8b4hr.mp3",
                        "avatar" => "https://i.imgur.com/e28b0dD.png",
                        "title" => "Thiên Lý Ơi",
                        "author" => "Jack ( 5 Triệu )"
                    ],
                    [
                        "url" => "https://files.catbox.moe/yrpft2.mp3",
                        "avatar" => "https://i.imgur.com/DAaTklq.png",
                        "title" => "Thuỷ Triều",
                        "author" => "Quang Hùng MasterD"
                    ],
                    [
                        "url" => "https://files.catbox.moe/jlat9a.mp3",
                        "avatar" => "https://i.imgur.com/vp5Vsx5.png",
                        "title" => "風立ちぬ ( Gió Nổi )",
                        "author" => "周深"
                    ],
                    [
                        "url" => "https://files.catbox.moe/hkqk6x.mp3",
                        "avatar" => "https://i.imgur.com/GEOKT8b.png",
                        "title" => "Chúng Ta Của Tương Lai",
                        "author" => "Sơn Tùng M-TP"
                    ],
                    [
                        "url" => "https://files.catbox.moe/acg0vl.mp3",
                        "avatar" => "https://i.ibb.co/MDVY07s/619964de31327dbf8491d14d2c25533f.jpg",
                        "title" => "Hoa Cỏ Lau",
                        "author" => "Phong Max"
                    ],
                    [
                        "url" => "https://files.catbox.moe/s8opab.mp3",
                        "avatar" => "https://i.ibb.co/6R8V7S7/ed0741228ad36870e13624120474e50a.jpg",
                        "title" => "Sau Lời Từ Khước",
                        "author" => "Phan Mạnh Quỳnh"
                    ],
                    [
                        "url" => "https://files.catbox.moe/gvqgma.mp3",
                        "avatar" => "https://i.ibb.co/gvXHBqv/ab67616d0000b273ae85dfd27beee97a3a009f68.jpg",
                        "title" => "Em Đã Xa Anh Remix",
                        "author" => "Như Việt"
                    ],
                    [
                        "url" => "https://files.catbox.moe/dvjckq.mp3",
                        "avatar" => "https://i.ibb.co/VpFyXhS/ab44498b5b432879428719390baf1180-1490064587.jpg",
                        "title" => "Anh Đã Quen Với Cô Đơn",
                        "author" => "Soobin Hoàng Sơn"
                    ]
                ]
            ];
            file_put_contents(self::$jsonPath, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
        return json_decode(file_get_contents(self::$jsonPath), true);
    }

    public static function saveConfig($data) {
        file_put_contents(self::$jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

$GLOBALS['TD_CONFIG_DATA'] = ThanhDieuConfigHelper::loadConfig();

class ThanhDieuHeader implements ThanhDieuConfigInterface {
    public $title;
    public $description;
    public $keywords;
    public $favicon;
    public $namesite;
    public $avatar;
    public $userName;
    public $trigger;
    public $bio1;
    public $bio2;
    public $bio3;
    public $bio4;
    public $bio5;
    public $bio6;
    public $SocialNetworks;

    public function __construct() {
        $c = $GLOBALS['TD_CONFIG_DATA']['header'];
        $this->title = $c['title'] ?? "";
        $this->description = $c['description'] ?? "";
        $this->keywords = $c['keywords'] ?? "";
        $this->favicon = $c['favicon'] ?? "";
        $this->namesite = $c['namesite'] ?? "";
        $this->avatar = $c['avatar'] ?? "";
        $this->userName = $c['userName'] ?? [];
        $this->trigger = $c['trigger'] ?? "";
        $this->bio1 = $c['bio1'] ?? "";
        $this->bio2 = $c['bio2'] ?? "";
        $this->bio3 = $c['bio3'] ?? "";
        $this->bio4 = $c['bio4'] ?? "";
        $this->bio5 = $c['bio5'] ?? "";
        $this->bio6 = $c['bio6'] ?? "";
        $this->SocialNetworks = $c['SocialNetworks'] ?? [];
    }

    public function CommonMethod(){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }
}

class ThanhDieuLoveDays implements ThanhDieuConfigInterface {
    public $ConfigLove;

    public function __construct() {
        $this->ConfigLove = $GLOBALS['TD_CONFIG_DATA']['lovedays'] ?? [];
    }

    public function CommonMethod() {}
}

class ThanhDieuMusicList implements ThanhDieuConfigInterface {
    public $songs;

    public function __construct() {
        $this->songs = $GLOBALS['TD_CONFIG_DATA']['music'] ?? [];
    }

    public function CommonMethod() {}
}

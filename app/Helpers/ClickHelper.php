<?php
namespace App\Helpers;
use App\Models\Click;
use App\Models\Link;
use Illuminate\Http\Request;

class ClickHelper {
    static private function getCountry($ip) {
        $country_iso = geoip()->getLocation($ip)->iso_code;
        return $country_iso;
    }

    static private function getHost($url) {
        // Return host given URL; NULL if host is
        // not found.
        return parse_url($url, PHP_URL_HOST);
    }

    static public function recordClick(Link $link, Request $request) {
        /**
         * Given a Link model instance and Request object, process post click operations.
         * @param Link model instance $link
         * @return boolean
         */

        $ip = Self::getIp();
        $referer = $request->server('HTTP_REFERER');

        $click = new Click;
        $click->link_id = $link->id;
        $click->ip = $ip;
        $click->country = self::getCountry($ip);
        $click->referer = $referer;
        $click->referer_host = ClickHelper::getHost($referer);
        $click->user_agent = $request->server('HTTP_USER_AGENT');
        $click->save();

        return true;
    }
    static public function getIp(){
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ip_array = explode(",",$ip);
            $ip = $ip_array[0];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}

<?php
/**
 * Brightery Facebook Bushiness Scraper v3
 *
 * @Author: Muhammad El-Saeed <m.elsaeed@brightery.com.eg>
 * @link: https://www.brightery.com.eg/en/product/brightery-facebook-business-scraper
 * @copyright: 2016 Brightery Inc.
 *
 */

namespace Brightery;

if (!defined('Brightery')) die("Access Forbidden");

class Configurations
{
    public static $superInstance;

    function get()
    {
        $app = $this->getApp();
        unset($app['app_secret']);
        superInstance('Output')->render($app);
    }

    public function getApp($appId = null)
    {
        $apps = Configurations::$superInstance['config'];
        if ($appId) {
            $napps = [];
            foreach ($apps as $a)
                if ($a['app_id'] != $appId['app_id'])
                    $napps[] = $a;
            $apps = $napps;
            self::$superInstance['Input']->session('app', $apps[rand(0, count($apps) - 1)]);
        }
        if (!$app = superInstance('Input')->session('app'))
            self::$superInstance['Input']->session('app', $apps[rand(0, count($apps) - 1)]);

        $app = self::$superInstance['Input']->session('app');
        Configurations::$superInstance['app'] = $app;
        return $app;
    }
}
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

class Input
{
    private $inputs = [];

    public function __construct()
    {
        session_start();
        $_POST = (array)json_decode(file_get_contents("php://input"));
        $this->inputs['post'] = $_POST;
        $this->inputs['get'] = $_GET;
        $this->inputs['session'] = $_SESSION;
        $this->inputs['cookie'] = $_COOKIE;
        $this->inputs['config'] = Configurations::$superInstance['config'];
    }

    public function post($var)
    {
        return $this->grap(__FUNCTION__, $var);
    }

    public function get($var)
    {
        return $this->grap(__FUNCTION__, $var);
    }

    public function session($var, $var2 = null)
    {
        if (!$var2)
            return $this->grap(__FUNCTION__, $var);
        else
        {
            $this->inputs['session'][$var] = $var2;
            $_SESSION[$var] = $var2;
        }
    }

    public function cookie($var)
    {
        return $this->grap(__FUNCTION__, $var);
    }

    public function config($var)
    {
        return $this->grap(__FUNCTION__, $var);
    }

    private function filter($data)
    {
        if (is_array($data) && count($data)) {
            foreach ($data as $key => $element) {
                $data[$key] = $this->filter($element);
            }
        } else {
            $data = trim(htmlentities(strip_tags($data)));
            $data = stripslashes($data);
        }
        return $data;
    }

    private function grap($type, $var)
    {
        if (isset($this->inputs[$type][$var]))
            return $this->filter($this->inputs[$type][$var]);
    }


}
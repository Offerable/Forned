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


class Output
{
    public $errors;

    function __construct()
    {
        // SETUP RESPONSE HEADERS
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }

    public function render($data = [])
    {
        $output = [];
        if ($this->errors) {
            $output = ['error' => true, 'message' => implode("<br />", $this->errors)];
        } else
            $output['error'] = false;

        $output['data'] = $data;

        echo json_encode($output);
    }
}
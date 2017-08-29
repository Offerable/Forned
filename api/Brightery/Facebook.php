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

class Facebook
{
    private $input;

    function __construct()
    {
        $this->input = superInstance('Input');
    }

    function group_members()
    {
        $app = superInstance('Configurations')->getApp();
        $center = null;


        $id = @trim($this->input->post('id'));
        $limit = @trim($this->input->post('limit'));
        $type = 'user';

        $accessToken = "&access_token=" . @trim($this->input->post('accessToken')) OR null;

        $res = ['type' => $type, 'data' => [], 'error' => false];

        $fields = null;

//        $fields = '&fields=id,name,birthday,bio,email,gender,interested_in,is_verified,link,location,meeting_for,religion,relationship_status,website,work,cover,devices,education,hometown,languages,picture,age_range';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v2.7/$id/members?limit=$limit" . $accessToken . $fields );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);

        $Output = superInstance('Output');

        if (isset($res->error)) {
            $Output->errors[] = $res->error->message;

            if ($res->error->code == 341) {
                superInstance('Configurations')->getApp();
                $Output->errors[] = "Limit reached, Please reload the page to switch to another app.";
                return $Output->render();
            }

        }


        $res->type = $type;
        return $Output->render($res);
    }

    function search()
    {
        $app = superInstance('Configurations')->getApp();
        $center = null;
        $location = @trim($_POST['location']->name) OR null;
        $query = @urlencode($this->input->post('query') . ($location ? ' ' . $location : null));
        $limit = @trim($this->input->post('limit'));
        $type = @trim($this->input->post('type')) OR 'page';
        $accessToken = "&access_token=" . $app['app_id'] . "|" . $app['app_secret'] . "";
        if ($type != 'page' && $type != 'place')
            $accessToken = "&access_token=" . @trim($this->input->post('accessToken')) OR null;

        $res = ['type' => $type, 'data' => [], 'error' => false];

        if ($this->input->post('center'))
            $center = "&center=" . $this->input->post('center') . "&distance=" . $this->input->post('distance');

        $fields = null;
        if ($type == 'page') {
            $fields = '&fields=id,name,single_line_address,phone,emails,website,fan_count,link,is_verified,about,picture';
        } elseif ($type == 'group') {
            $fields = '&fields=id,icon,name,description,email,privacy,cover';
        } elseif ($type == 'user') {
            $fields = '&fields=id,name,birthday,bio,email,gender,interested_in,is_verified,link,location,meeting_for,religion,relationship_status,website,work,cover,devices,education,hometown,languages,picture,age_range';
        } elseif ($type == 'event') {
            $fields = '&fields=id,name,attending_count,noreply_count,maybe_count,interested_count,declined_count,owner,place,category,can_guests_invite,cover,start_time,end_time,type,ticket_uri';
        } elseif ($type == 'place') {
            $fields = '&fields=id,name,location';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v2.7/search?q=$query&type=$type&limit=$limit" . $accessToken . $fields . $center);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);

        $Output = superInstance('Output');

        if (isset($res->error)) {
            $Output->errors[] = $res->error->message;

            if ($res->error->code == 341) {
                superInstance('Configurations')->getApp();
                $Output->errors[] = "Limit reached, Please reload the page to switch to another app.";
                return $Output->render();
            }

        }


        $res->type = $type;
        return $Output->render($res);
    }

    function autocomplete()
    {
        $app = superInstance('Configurations')->getApp();
        $query = @urlencode($this->input->post('query'));
        $accessToken = "&access_token=" . $app['app_id'] . "|" . $app['app_secret'] . "";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/v2.7/search?locale=en_US&type=adgeolocation&q=$query" . $accessToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        die($res);
        $res = json_decode($res);

        $Output = superInstance('Output');

        return $Output->render($res);
    }

    function paging()
    {
        $url = $_POST['url'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);

        $Output = superInstance('Output');

        if (isset($res->error))
            $Output->errors[] = $res->error->message;

        return $Output->render($res);
    }
}

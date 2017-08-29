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

class Export
{
    private function headers()
    {
        header('Content-Type: text/csv; charset=utf-8');
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=brightery_" . microtime() . '.csv');
        header("Content-Transfer-Encoding: binary");

    }

    function download()
    {
        superInstance('Input');
        $this->headers();
        $this->process(@$_POST['items'], @$_POST['fields']);
    }

    private function process($items, $fields)
    {
        $fields = array_filter($fields, function ($field) {
            return $field->checked == true && !isset($field->merge);
        });

        $super = [];
        $f = [];
        $r = [];
        $rows = [];
        foreach ($fields as $field) {
            $f[] = $field->name;
            $r[] = $field->raw;
            $super[$field->raw] = $field->name;
        }


        foreach ((array)$items as $item) {
            $row = [];
            $cols = [];

            foreach ($super as $raw => $title) {
                $col = @$item->$raw;
                if (is_array(@$col) or is_object(@$col))
                    $col = @implode(', ', @$col);
                if (! @$col)
                    @$col = ' - ';
                $cols[$raw] = @$col;
            }
            $rows[] = @$cols;
        }

        $output = fopen('php://output', 'w');
        fputcsv($output, $f);
        foreach ($rows as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
    }
}
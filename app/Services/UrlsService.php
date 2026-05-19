<?php

namespace App\Services;

use Hashids\Hashids;
use App\Models\Urls;

class UrlsService
{
    public function getUrl(string $shortcode)
    {
        return Urls::where('shortcode', $shortcode)->first();
    }

    public function createShortUrl(array $data)
    {
        $data['shortcode'] = $this->generateShortcode($data['url']);
        // echo json_encode($data['shortcode']);
        return Urls::create($data);
    }


    public function generateShortcode(string $url)
    {

        $hashids = new Hashids(
            env('HASHIDS_SALT'),                                    // salt
            0,                                                  // min length (0 = padrão)
            '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' // alphabet
        );

        $number = rand(14000000, 999999999);

        $encoded = $hashids->encode($number);
        return $encoded;

        // $decoded = $hashids->decode($encoded);
        // echo $decoded[0]; // 11157 (retorna array, pega o primeiro elemento)
    }
}

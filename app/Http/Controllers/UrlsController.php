<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UrlsService;


class UrlsController extends Controller
{
    public function getUrlByShortcode(string $shortcode, UrlsService $urlService)
    {
        $url = $urlService->getUrl($shortcode);
        return redirect($url->url, 302);
    }

    public function createShortUrl(Request $request, UrlsService $urlService)
    {
        $data = $request->all();
        $url = $urlService->createShortUrl($data);
        $url->shortUrl = "http://localhost:8000/" . $url->shortcode;
        return response()->json($url);
    }
}

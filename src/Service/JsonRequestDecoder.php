<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

/**
 * Decodes POST JSON and adds content to $request
 */
class JsonRequestDecoder
{
    /**
     * Decodes POST JSON and adds content to $request
     * @param Request $request
     *
     * @return void
     */
    public function decode(Request $request): void
    {
        // @todo check contentType and attribute if JSON already decoded
        $array = json_decode((string)$request->getContent(), true);
        // @todo check json_last_error_msg
        $request->request->replace(is_array($array) ? $array : []);
    }
}
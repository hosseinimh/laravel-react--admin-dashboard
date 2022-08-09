<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\Service as ServiceParent;
use Illuminate\Http\Resources\Json\JsonResource;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $service;

    public function __construct(ServiceParent $service = null)
    {
        date_default_timezone_set('Asia/Tehran');

        $this->service = $service;
    }

    public function handleJsonResponse($data, $statusCode = 200, $isRESTApi = false)
    {
        $array = [];

        if ($data) {
            if ($isRESTApi && $data instanceof JsonResource) {
                $array = $data;
            } else {
                foreach ($data as $key => $value) {
                    $array[$key] = $value;
                }
            }
        }

        if ($isRESTApi && !$data) {
            return response()->json(null, $statusCode);
        }

        return response()->json($array, $statusCode);
    }
}

<?php

namespace App\Http\Resources\Json;

use Illuminate\Http\Resources\Json\ResourceResponse as BaseResourceResponse;

class ResourceResponse extends BaseResourceResponse
{
    /**
     * Calculate the appropriate status code for the response.
     *
     * @return int
     */
    protected function calculateStatus()
    {
        return 200;
    }
}

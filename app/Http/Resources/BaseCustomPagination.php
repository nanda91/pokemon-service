<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCustomPagination extends ResourceCollection
{
    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset($jsonResponse['links'],$jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }

    protected function pagination($meta)
    {
        $page = (int) $meta['page'] ?? 0;
        $perPage = (int) $meta['perPage'] ?? 0;
        $totalData = (int) $meta['totalData'] ?? 0;
        $totalPage = ceil($totalData / $perPage);

        return [
            'page' => $page,
            'limit' => $perPage,
            'total' => $totalData,
            'totalPages' => $totalPage,
        ];
    }

    protected function populateDataSuccess(JsonResource $data, $meta, $facet = null)
    {
        return[
            'code' => 200,
            'message' => 'OK',
            'data' => $data,
            'pageSummary' => $this->pagination($meta),
        ];
    }
}

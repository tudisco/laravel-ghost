<?php

namespace Igorsgm\Ghost\Responses;

use Igorsgm\Ghost\Apis\BaseApi;
use Igorsgm\Ghost\Models\Meta;
use Igorsgm\Ghost\Models\Resources\BaseResource;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

class SuccessResponse
{
    /**
     * @var BaseApi
     */
    private $contentApi;

    /**
     * @var BaseResource
     */
    private $resource;

    /**
     * @var Response|mixed
     */
    private $response;

    /**
     * @var bool
     */
    public $success = true;

    /**
     * @var Collection|array
     */
    public $data = [];

    /**
     * @var Meta|array
     */
    public $meta = [];

    /**
     * @param  BaseApi  $contentApi
     * @param  BaseResource  $resource
     * @param  Response|mixed  $response
     */
    public function __construct($contentApi, BaseResource $resource, $response)
    {
        $this->contentApi = $contentApi;
        $this->resource = $resource;
        $this->response = $response;

        $this->handle();
    }

    /**
     * @return void
     */
    private function handle()
    {
        $resourceName = $this->resource->getResourceName();
        $responseData = $this->response->json($resourceName);
        $meta = $this->response->json('meta');

        if (in_array($resourceName, ['settings', 'site'])) {
            $data = new $this->resource($responseData);
        } else {
            $data = collect();
            $responseData = !empty($responseData) ? $responseData : [];
            foreach ($responseData as $resourceItemData) {
                $data->push(new $this->resource($resourceItemData));
            }
        }

        $this->data = $data;

        if (!empty($meta)) {
            $this->meta = new Meta($meta);
        }
    }

    /**
     * Fetches the Previous page response
     * @return array|array[]|SuccessResponse
     */
    public function getPreviousPage()
    {
        $previusPage = $this->meta->prev();
        return $this->contentApi->page($previusPage)->get();
    }

    /**
     * Fetches the Next page response
     * @return array|array[]|SuccessResponse
     */
    public function getNextPage()
    {
        $nextPage = $this->meta->next();
        return $this->contentApi->page($nextPage)->get();
    }
}

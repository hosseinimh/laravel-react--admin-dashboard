<?php

namespace App\Services;

use App\Constants\ErrorCodes;

class Service
{
    protected $entityResource;

    protected function handleGet($item)
    {
        if ($item) {
            return $this->handleOK(['item' => new $this->entityResource($item)]);
        }

        return $this->handleError();
    }

    protected function handleGetItems($items, $isRESTApi = false)
    {
        if ($items) {
            return $this->handleOK(['items' => $this->entityResource::collection($items)], $isRESTApi);
        }

        return $this->handleError();
    }

    protected function handleStore($result)
    {
        if ($result) {
            return $this->handleOK();
        }

        return $this->handleError(['_error' => __('general.store_error'), '_errorCode' => ErrorCodes::SERVER_ERROR]);
    }

    protected function handleUpdate($result)
    {
        if ($result) {
            return $this->handleOK();
        }

        return $this->handleError(['_error' => __('general.update_error'), '_errorCode' => ErrorCodes::SERVER_ERROR]);
    }

    protected function handleDelete($result)
    {
        if ($result) {
            return $this->handleOK();
        }

        return $this->handleError(['_error' => __('general.delete_error'), '_errorCode' => ErrorCodes::SERVER_ERROR]);
    }

    protected function handleItemNotFound()
    {
        return $this->handleError(['_error' => __('general.item_not_found'), '_errorCode' => ErrorCodes::ITEM_NOT_FOUND]);
    }

    protected function handleOK($data = null, $isRESTApi = false)
    {
        return $this->handleResult(true, $data, $isRESTApi);
    }

    protected function handleError($data = null)
    {
        return $this->handleResult(false, $data);
    }

    protected function handleErrorMessage($message)
    {
        return $this->handleError(['_error' => $message, '_errorCode' => ErrorCodes::CLIENT_ERROR]);
    }

    private function handleResult($result, $data, $isRESTApi = false)
    {
        $result = $isRESTApi ? [] : ['_result' => $result ? '1' : '0'];

        if ($data && is_array($data)) {
            foreach ($data as $key => $value) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}

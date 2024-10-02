<?php

namespace App\Traits;

use App\Enums\MessageType;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\GenericListBySearchResponse;
use App\Http\Responses\GenericListResponse;
use App\Http\Responses\GenericObjectResponse;
use App\Http\Responses\GenericResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait JsonResponseHandler
{
    public function addMessage(BaseResponse $response,
                               array|string $messages,
                               MessageType  $type): BaseResponse
    {
        if (is_array($messages)) {
            foreach ($messages as $message) {
                foreach ($message as $value) {
                    $method = 'add' . ucfirst($type->value) . 'Message';
                    $response->$method($value);
                }
            }
        } elseif (is_string($messages)) {
            $message = $messages;
            $method = 'add' . ucfirst($type->value) . 'Message';

            $response->$method($message);
        }

        return $response;
    }

    public function setMessageResponse(mixed       $response,
                                       MessageType $type,
                                       int         $codeStatus): mixed
    {
        $this->setBaseResponse($response, $type, $codeStatus);

        return $response;
    }

    private function setBaseResponse(BaseResponse $response,
                                     MessageType  $type,
                                     int          $codeStatus): void
    {
        $response->type = $type->value;
        $response->codeStatus = $codeStatus;
    }

    public function setGenericResponse(GenericResponse $response,
                                       mixed           $result,
                                       MessageType     $type,
                                       int             $codeStatus): GenericResponse
    {
        $response->result = $result;

        $this->setBaseResponse($response, $type, $codeStatus);

        return $response;
    }

    public function setGenericObjectResponse(GenericObjectResponse $response,
                                             object|array          $dto,
                                             MessageType           $type,
                                             int                   $codeStatus): GenericObjectResponse
    {
        $response->dto = $dto;

        $this->setBaseResponse($response, $type, $codeStatus);

        return $response;
    }

    public function setGenericListResponse(GenericListResponse $response,
                                           Collection          $dtoList,
                                           MessageType         $type,
                                           int                 $codeStatus): GenericListResponse
    {
        $response->dtoList = $dtoList;

        $this->setBaseResponse($response, $type, $codeStatus);

        return $response;
    }

    public function setGenericListBySearchResponse(GenericListBySearchResponse $response,
                                                   Collection                  $dtoListBySearch,
                                                   MessageType                 $type,
                                                   int                         $codeStatus,
                                                   int                         $totalCount): GenericListBySearchResponse
    {
        $response->dtoListBySearch = $dtoListBySearch;

        $this->setBaseResponse($response, $type, $codeStatus);

        $response->totalCount = $totalCount;

        return $response;
    }

    public function setGenericListBySearchAndPaginationResponse(GenericListBySearchAndPaginationResponse $response,
                                                                Collection                               $dtoListBySearchAndPagination,
                                                                MessageType                              $type,
                                                                int                                      $codeStatus,
                                                                int                                      $totalCount,
                                                                array                                    $meta): GenericListBySearchAndPaginationResponse
    {
        $response->dtoListBySearchAndPagination = $dtoListBySearchAndPagination;

        $this->setBaseResponse($response, $type, $codeStatus);

        $response->totalCount = $totalCount;
        $response->meta = $meta;

        return $response;
    }

    protected function getAllJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'messages' => $response->getMessageResponseAll(),
        ], $response->getCodeStatus());
    }

    protected function getAllLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'message' => $response->getMessageResponseAllLatest(),
        ], $response->getCodeStatus());
    }

    protected function getSuccessJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'messages' => $response->getMessageResponseSuccess(),
        ], $response->getCodeStatus());
    }

    protected function getSuccessLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'message' => $response->getMessageResponseSuccessLatest(),
        ], $response->getCodeStatus());
    }

    protected function getErrorJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'messages' => $response->getMessageResponseError(),
        ], $response->getCodeStatus());
    }

    protected function getErrorLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'message' => $response->getMessageResponseErrorLatest(),
        ], $response->getCodeStatus());
    }

    protected function getInfoJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'messages' => $response->getMessageResponseInfo(),
        ], $response->getCodeStatus());
    }

    protected function getInfoLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'message' => $response->getMessageResponseInfoLatest(),
        ], $response->getCodeStatus());
    }

    protected function getWarningJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'messages' => $response->getMessageResponseWarning(),
        ], $response->getCodeStatus());
    }

    protected function getWarningLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'message' => $response->getMessageResponseWarningLatest(),
        ], $response->getCodeStatus());
    }

    protected function getFileResponse(mixed $response): JsonResponse
    {
        return response()->json($response->result->body, $response->getCodeStatus(), [
            'Content-Type' => $response->result->file_mime,
            'Content-disposition' => 'attachment; filename=' . $response->result->file_name . '.' . $response->result->file_extension
        ]);
    }

    protected function getJsonResponse(BaseResponse $response,
                                       ?array       $meta = null): JsonResponse
    {
        $init = [
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
        ];

        if ($meta) {
            $meta = array_merge($init, $meta);
        } else {
            $meta = $init;
        }

        return response()->json(array_merge($meta, [
            'result' => $response->result,
        ]), $response->getCodeStatus());
    }

    protected function getObjectJsonResponse(GenericObjectResponse $response,
                                             ?string               $resource = null,
                                             ?array                $meta = null): JsonResponse
    {
        $init = [
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
        ];

        if ($meta) {
            $meta = array_merge($init, $meta);
        } else {
            $meta = $init;
        }

        return response()->json(array_merge($meta, [
            'result' => ($resource) ? new $resource($response->getDto()) : $response->getDto(),
        ]), $response->getCodeStatus());
    }

    protected function getListJsonResponse(GenericListResponse $response,
                                           ?string             $resource = null,
                                           ?array              $meta = null): JsonResponse
    {
        $init = [
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
        ];

        if ($meta) {
            $meta = array_merge($init, $meta);
        } else {
            $meta = $init;
        }

        return response()->json(array_merge($meta, [
            'result' => ($resource) ? new $resource($response->getDtoList()) : $response->getDtoList(),
        ]), $response->getCodeStatus());
    }

    protected function getListBySearchJsonResponse(GenericListBySearchResponse $response,
                                                   ?string                     $resource = null,
                                                   ?array                      $meta = null): JsonResponse
    {
        $init = [
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'total_count' => $response->getTotalCount(),
        ];

        if ($meta) {
            $meta = array_merge($init, $meta);
        } else {
            $meta = $init;
        }

        return response()->json(array_merge($meta, [
            'result' => ($resource) ? new $resource($response->getDtoListBySearch()) : $response->getDtoListBySearch(),
        ]), $response->getCodeStatus());
    }

    protected function getListBySearchAndPaginationJsonResponse(GenericListBySearchAndPaginationResponse $response,
                                                                ?string                                  $resource = null,
                                                                ?array                                   $meta = null): JsonResponse
    {
        $init = array_merge([
            'type' => $response->getType(),
            'code_status' => $response->getCodeStatus(),
            'total_count' => $response->getTotalCount(),
        ], $response->getMeta());

        if ($meta) {
            $meta = array_merge($init, $meta);
        } else {
            $meta = $init;
        }

        return response()->json(array_merge($meta, [
            'result' => ($resource) ? new $resource($response->getDtoListBySearchAndPagination()) : $response->getDtoListBySearchAndPagination(),
        ]), $response->getCodeStatus());
    }
}

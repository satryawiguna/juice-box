<?php

namespace App\Services\Contracts;

use App\Enums\MessageType;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\GenericListBySearchResponse;
use App\Http\Responses\GenericListResponse;
use App\Http\Responses\GenericObjectResponse;
use App\Http\Responses\GenericResponse;
use Illuminate\Support\Collection;

interface IBaseService
{
    public function addMessage(BaseResponse $response,
                               array|string $message,
                               MessageType  $type);

    public function setMessageResponse(mixed       $response,
                                       MessageType $type,
                                       int         $codeStatus): mixed;

    public function setGenericResponse(GenericResponse $response,
                                       mixed           $result,
                                       MessageType     $type,
                                       int             $codeStatus): GenericResponse;

    public function setGenericObjectResponse(GenericObjectResponse $response,
                                             object|array          $dto,
                                             MessageType           $type,
                                             int                   $codeStatus): GenericObjectResponse;

    public function setGenericListResponse(GenericListResponse $response,
                                           Collection          $dtoList,
                                           MessageType         $type,
                                           int                 $codeStatus): GenericListResponse;

    public function setGenericListBySearchResponse(GenericListBySearchResponse $response,
                                                   Collection                  $dtoListBySearch,
                                                   MessageType                 $type,
                                                   int                         $codeStatus,
                                                   int                         $totalCount): GenericListBySearchResponse;

    public function setGenericListBySearchAndPaginationResponse(GenericListBySearchAndPaginationResponse $response,
                                                                Collection                               $dtoListBySearchAndPagination,
                                                                MessageType                              $type,
                                                                int                                      $codeStatus,
                                                                int                                      $totalCount,
                                                                array                                    $meta): GenericListBySearchAndPaginationResponse;

    public function getOpsigoRequestHeader(): array;
}

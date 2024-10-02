<?php

namespace App\Services\Contracts;

use App\Http\Requests\Blog\PostListRequest;
use App\Http\Requests\Blog\PostSearchAndPaginationRequest;
use App\Http\Requests\Blog\PostSearchRequest;
use App\Http\Requests\Blog\PostStoreRequest;
use App\Http\Requests\Blog\PostUpdateRequest;
use App\Http\Responses\BaseResponse;
use App\Http\Responses\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\GenericListBySearchResponse;
use App\Http\Responses\GenericListResponse;
use App\Http\Responses\GenericObjectResponse;
use App\Http\Responses\GenericResponse;

interface IPostService
{
    public function fetchAllPages(PostListRequest $request): GenericListResponse;

    public function fetchAllSearchPages(PostSearchRequest $request): GenericListBySearchResponse;

    public function fetchAllSearchAndPaginationPages(PostSearchAndPaginationRequest $request): GenericListBySearchAndPaginationResponse;

    public function getPage(string $id): GenericObjectResponse;

    public function storePage(PostStoreRequest $request): GenericObjectResponse;

    public function updatePage(string $id, PostUpdateRequest $request): GenericResponse;

    public function destroyPage(string $id): BaseResponse;
}

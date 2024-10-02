<?php

namespace App\Http\Controllers\Api\Blog;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Blog\PostListRequest;
use App\Http\Requests\Blog\PostSearchAndPaginationRequest;
use App\Http\Requests\Blog\PostSearchRequest;
use App\Http\Requests\Blog\PostStoreRequest;
use App\Http\Requests\Blog\PostUpdateRequest;
use App\Http\Resources\Blog\PostCollectionResource;
use App\Http\Resources\Blog\PostResource;
use App\Services\Contracts\IPostService;

class PostController extends ApiBaseController
{
    protected readonly IPostService $_pageService;

    public function __construct(IPostService $pageService)
    {
        $this->_pageService = $pageService;
    }

    public function list(PostListRequest $request)
    {
        $pages = $this->_pageService->fetchAllPages($request);

        if ($pages->isError()) {
            return $this->getErrorLatestJsonResponse($pages);
        }

        return $this->getListJsonResponse($pages, PostCollectionResource::class);
    }

    public function search(PostSearchRequest $request)
    {
        $pages = $this->_pageService->fetchAllSearchPages($request);

        if ($pages->isError()) {
            return $this->getErrorLatestJsonResponse($pages);
        }

        return $this->getListBySearchJsonResponse($pages, PostCollectionResource::class);
    }

    public function searchAndPagination(PostSearchAndPaginationRequest $request)
    {
        $page = $this->_pageService->fetchAllSearchAndPaginationPages($request);

        if ($page->isError()) {
            return $this->getErrorLatestJsonResponse($page);
        }

        return $this->getListBySearchAndPaginationJsonResponse($page, PostCollectionResource::class);
    }

    public function show(string $id)
    {
        $page = $this->_pageService->getPage($id);

        if ($page->isError()) {
            return $this->getErrorLatestJsonResponse($page);
        }

        return $this->getObjectJsonResponse($page, PostResource::class);
    }

    public function store(PostStoreRequest $request)
    {
        $storePage = $this->_pageService->storePage($request);

        if ($storePage->isError()) {
            return $this->getErrorLatestJsonResponse($storePage);
        }

        return $this->getObjectJsonResponse($storePage, PostResource::class);
    }

    public function update(string $id, PostUpdateRequest $request)
    {
        $updatePage = $this->_pageService->updatePage($id, $request);

        if ($updatePage->isError()) {
            return $this->getErrorLatestJsonResponse($updatePage);
        }

        return $this->getJsonResponse($updatePage);
    }

    public function destroy(string $id)
    {
        $destroyPage = $this->_pageService->destroyPage($id);

        if ($destroyPage->isError()) {
            return $this->getErrorLatestJsonResponse($destroyPage);
        }

        return $this->getSuccessLatestJsonResponse($destroyPage);
    }
}

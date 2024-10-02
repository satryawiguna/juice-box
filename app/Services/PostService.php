<?php

namespace App\Services;

use App\Enums\MessageType;
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
use App\Repositories\Contracts\IPostRepository;
use App\Services\Contracts\IPostService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostService extends BaseService implements IPostService
{
    private readonly IPostRepository $_pageRepository;

    public function __construct(IPostRepository $pageRepository)
    {
        $this->_pageRepository = $pageRepository;
    }

    public function fetchAllPages(PostListRequest $request): GenericListResponse
    {
        $response = new GenericListResponse();

        try {
            $pages = $this->_pageRepository->all($request);

            $this->setGenericListResponse($response,
                $pages,
                MessageType::SUCCESS,
                Response::HTTP_OK);
        }
        catch (HttpResponseException|QueryException $ex) {
            throw $ex;
        }
        catch (Exception $ex) {
            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function fetchAllSearchPages(PostSearchRequest $request): GenericListBySearchResponse
    {
        $response = new GenericListBySearchResponse();

        try {
            $pages = $this->_pageRepository->allSearch($request);

            $this->setGenericListBySearchResponse($response,
                $pages,
                MessageType::SUCCESS,
                Response::HTTP_OK,
                $pages->count());
        }
        catch (HttpResponseException|QueryException $ex) {
            throw $ex;
        }
        catch (Exception $ex) {
            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function fetchAllSearchAndPaginationPages(PostSearchAndPaginationRequest $request): GenericListBySearchAndPaginationResponse
    {
        $response = new GenericListBySearchAndPaginationResponse();

        try {
            $pages = $this->_pageRepository->allSearchAndPagination($request);

            $this->setGenericListBySearchAndPaginationResponse($response,
                $pages->getCollection(),
                MessageType::SUCCESS,
                Response::HTTP_OK,
                $pages->total(),
                ['per_page' => $pages->perPage(), 'current_page' => $pages->currentPage()]);
        }
        catch (HttpResponseException|QueryException $ex) {
            throw $ex;
        }
        catch (Exception $ex) {
            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function getPost(string $id): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $page = $this->_pageRepository->findById($id);

            if (!$page)
                throw new ModelNotFoundException;

            $this->setGenericObjectResponse($response,
                $page,
                MessageType::SUCCESS,
                Response::HTTP_OK);
        }
        catch (HttpResponseException|QueryException|ModelNotFoundException $ex) {
            throw $ex;
        }
        catch (Exception $ex) {
            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function storePost(PostStoreRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        DB::beginTransaction();

        try {
            $request->merge([
                'author_id' => Auth::id(),
                'publish_date' => Carbon::now()
            ]);

            $page = $this->_pageRepository->create($request);

            DB::commit();

            $this->setGenericObjectResponse($response,
                $page,
                MessageType::SUCCESS,
                Response::HTTP_OK);
        }
        catch (HttpResponseException|QueryException $ex) {
            DB::rollBack();

            throw $ex;
        }
        catch (Exception $ex) {
            DB::rollBack();

            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function updatePost(string $id, PostUpdateRequest $request): GenericResponse
    {
        $response = new GenericResponse();

        DB::beginTransaction();

        try {
            $page = $this->_pageRepository->findById($id);

            if (!$page)
                throw new ModelNotFoundException;

            $updatePage = $this->_pageRepository->update($request);

            DB::commit();

            $this->setGenericResponse($response,
                $updatePage,
                MessageType::SUCCESS,
                Response::HTTP_OK);
        }
        catch (HttpResponseException|QueryException|ModelNotFoundException $ex) {
            DB::rollBack();

            throw $ex;
        }
        catch (Exception $ex) {
            DB::rollBack();

            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

    public function destroyPost(string $id): BaseResponse
    {
        $response = new BaseResponse();

        try {
            $page = $this->_pageRepository->findById($id);

            if (!$page)
                throw new ModelNotFoundException;

            $this->_pageRepository->delete($id);

            $this->addMessage($response, __('message.success.page_deleted_success'), MessageType::SUCCESS);
            $this->setMessageResponse($response, MessageType::SUCCESS, Response::HTTP_OK);
        }
        catch (QueryException|ModelNotFoundException $ex) {
            DB::rollBack();

            throw $ex;
        }
        catch (Exception $ex) {
            DB::rollBack();

            $this->addMessage($response, __('message.error.something_went_wrong'), MessageType::ERROR);
            $this->setMessageResponse($response, MessageType::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR);

            Log::error(__('message.error.something_went_wrong') . ' → ' . $ex->getMessage(), getLoggingContext());
        }

        return $response;
    }

}

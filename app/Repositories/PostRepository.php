<?php

namespace App\Repositories;

use App\Http\Requests\Blog\PostSearchAndPaginationRequest;
use App\Http\Requests\Blog\PostSearchRequest;
use App\Http\Requests\Common\ListRequest;
use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostRepository extends BaseRepository implements IPostRepository
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }

    public function all(ListRequest $request): Collection
    {
        $pages = $this->_model;

        $where = [];

        if ($request->status) {
            array_push($where, ['status', '=', $request->status]);
        }

        if (count($where) > 0) {
            $pages = $pages->where($where);
        }

        if ($request->publish_dates) {
            $publishDates = json_decode($request->publish_dates);

            $pages = $pages->whereBetween('publish_date', [$publishDates->start, $publishDates->end]);
        }

        return $pages
            ->orderBy($request->order_by, $request->sort)
            ->get();
    }

    public function allSearch(PostSearchRequest $request): Collection
    {
        $pages = $this->_model;

        $where = [];

        if ($request->status) {
            array_push($where, ['status', '=', $request->status]);
        }

        if (count($where) > 0) {
            $pages = $pages->where($where);
        }

        if ($request->publish_dates) {
            $pages = $pages->whereBetween('publish_date', [$request->publish_dates['start'], $request->publish_dates['end']]);
        }

        if ($request->search) {
            $keyword = $request->search;

            $pages = $pages->whereRaw('(title LIKE ?)', $this->searchByKeyword($keyword));
        }

        return $pages->orderBy($request->order_by, $request->sort)
            ->get();
    }

    private function searchByKeyword(string $keyword)
    {
        return [
            'title' => '%' . $keyword . '%'
        ];
    }

    public function allSearchAndPagination(PostSearchAndPaginationRequest $request): LengthAwarePaginator
    {
        $pages = $this->_model;

        $where = [];

        if ($request->status) {
            array_push($where, ['status', '=', $request->status]);
        }

        if (count($where) > 0) {
            $pages = $pages->where($where);
        }

        if ($request->publish_dates) {
            $pages = $pages->whereBetween('publish_date', [$request->publish_dates['start'], $request->publish_dates['end']]);
        }

        if ($request->search) {
            $keyword = $request->search;

            $pages = $pages->whereRaw('(title LIKE ?)', $this->searchByKeyword($keyword));
        }

        return $pages
            ->orderBy($request->order_by, $request->sort)
            ->paginate($request->per_page, ['*'], 'page', $request->page);
    }

}

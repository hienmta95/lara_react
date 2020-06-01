<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Post\PostService;
use App\Http\Requests\Backend\PostStoreRequest;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $result = $this->postService->getMany($request);
            if ($result['type'] != $this->postService::SUCCESS) {
                return res(500, $result);
            }
            return res(200, $result);
        } catch (\Exception $e) {
            return serverError($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            if (!empty($request->errors)) {
                return $request->throwValidationException();
            } else {
                $result = $this->postService->createOne($request->validated());
                if ($result['type'] != $this->postService::SUCCESS) {
                    DB::rollback();
                    return res(500, $result);
                }

                DB::commit();
                return res(200, $result);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return serverError($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = $this->postService->getOne(['id' => $id]);
            if ($result['type'] != $this->postService::SUCCESS) {
                return res(500, $result);
            }
            return res(200, $result);
        } catch (\Exception $e) {
            return serverError($e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            if (!empty($request->errors)) {
                return $request->throwValidationException();
            } else {
                $result = $this->postService->updateOne($id, $request->all());
                if ($result['type'] != $this->postService::SUCCESS) {
                    DB::rollback();
                    return res(500, $result);
                }

                DB::commit();
                return res(200, $result);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return serverError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $result = $this->postService->deleteOne($id);
            if ($result['type'] != $this->postService::SUCCESS) {
                DB::rollback();
                return res(500, $result);
            }

            DB::commit();
            return res(200, $result);
        } catch (\Exception $e) {
            DB::rollback();
            return serverError($e);
        }
    }
}

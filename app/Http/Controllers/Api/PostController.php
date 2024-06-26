<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostCollection;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\API\Post\CreatePostRequest;
use App\Http\Requests\API\Post\UpdatePostRequest;


class PostController extends Controller
{
    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $response = $this->service->index($request);
            return $this->successResp('Successfully retrieved data!', new PostCollection($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function store(CreatePostRequest $request)
    {
        try {
            $response = $this->service->store($request->validated());
            return $this->successResp('Successfully added post!', new PostResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function show($id)
    {
        try {
            $response = $this->service->show($id);
            return $this->successResp('Successfully retrieved data!', new PostResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function update(UpdatePostRequest $request, $id)
    {
        try {
            $response = $this->service->update($request->validated(), $id);
            return $this->successResp('Succesfully updated post!', new PostResource($response));
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->service->destroy($id);
            return $this->successResp('Successfully deleted post!', $response);
        } catch (ValidationException $th) {
            return $this->errorResp($th->errors());
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Tag(
 *  name="Categories",
 * description="api for categories (admin only)"
 * )
 */
class CategoryController extends Controller
{
    use AuthorizesRequests;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *  path="/categories",
     * summary="get all category",
     * tags={"Categories"},
     * security={{"bearerAuth":{}}},
     *
     * @OA\Response(
     *  response="200",
     * description="successfull operation",
     *
     *  @OA\JsonContent(
     * type="array",
     *
     *  @OA\Items(ref="#/components/schemas/CategoryResource")
     * )
     * ),
     * )
     */
    public function index()
    {
        //
        $categories = $this->categoryService->getAllCategories();

        return response()->json(CategoryResource::collection($categories), 200);

    }

    /**
     * @OA\Post(
     *  path="/categories",
     *  summary="create a category (admin only)",
     *  tags={"Categories"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\RequestBody(
     *      required = true,
     *
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreCategoryRequest")
     *      )
     *  ),
     *
     *  @OA\Response(
     *      response="201",
     *      description="category created successfull",
     *
     *      @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     * )
     * )
     */
    public function store(StoreCategoryRequest $request)
    {

        $this->authorize('create', Category::class);
        $category = $this->categoryService->addCategory($request->validated());

        return response()->json(new CategoryResource($category), 201);
    }

    /**
     * @OA\Get(
     *  path="/categories/{id}",
     *  summary="get category by id",
     *  tags={"Categories"},
     *  security={{"bearerAuth":{}}},
     *
     *  @OA\Parameter(
     *  name="id",
     *  in="path",
     * required=true,
     *
     * @OA\Schema(type="integer")
     * ),
     *
     * @OA\Response(
     *  response="200",
     * description = "successful operation",
     *
     * @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     * )
     *
     * )
     */
    public function show(string $id)
    {
        //
        $category = $this->categoryService->getCategoryById($id);

        return response()->json(new CategoryResource($category), 200);
    }

    /**
     * @OA\Put(
     *      path="/categories/{id}",
     *      summary="update the category (admin only)",
     *      tags={"Categories"},
     *      security={{"bearerAuth":{}}},
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *
     *      @OA\Schema(type="integer")
     * ),
     *
     * @OA\RequestBody(
     * required=true,
     *
     * @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(ref="#/components/schemas/UpdateCategoryRequest")
     *
     * )
     * ),
     *
     * @OA\Response(
     *      response="201",
     *      description="successfully",
     *
     * @OA\JsonContent(ref="#/components/schemas/CategoryResource")
     * )
     *
     * )
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        //
        $category = Category::findOrFail($id);

        $this->authorize('update', $category);

        $category = $this->categoryService->updateCategory($id, $request->validated());

        return response()->json(new CategoryResource($category), 201);

    }

    /**
     * @OA\Delete(
     *    path="/categories/{id}",
     *    summary="delete a category (admin only)",
     *      tags={"Categories"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     *  name="id",
     *  in="path",
     *  required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     *  response="204",
     * description="category deleted successfully"
     * )
     * )
     */
    public function destroy(string $id)
    {
        //

        $category = Category::findOrFail($id);
        $this->authorize('delete', $category);

        $this->categoryService->deleteCategory($id);

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Services\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class TaskController extends Controller
{
    public function index(Request $request, Category $categoryModel, Task $taskModel, $idCategory = null)
    {
        try {
            if (isset($request->idCategory)) $idCategory = $request->idCategory;
            $q = $request->get('q');
            return view('task.index', [
                'categories' => $categoryModel->getCategories(),
                'tasks' => $taskModel->search($idCategory, $q),
                'tasksCount' => $taskModel->countTasks(),
                'idActiveCategory' => $idCategory ? $idCategory : 0,
            ]);
        } catch (\ErrorException $err) {
            throw new \ErrorException($err->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request, FileUploadService $fileUploadService): JsonResponse
    {
        try {
            $this->validate($request, [
                'id' => 'integer',
                'idCategory' => 'integer',
                'name' => 'required|min:3|max:30',
            ]);
            $path = $fileUploadService->uploadFile($request->file('image'), 'task/files');
            $request->id == 0 ? $model = new Task : $model = Task::find($request->id);
            $model->name = $request->name;
            $model->image = $path;
            $request->idCategory ? $model->idCategory = $request->idCategory : $model->idCategory = null;
            $model->save();

            return response()->json(['success' => true]);
        } catch (\ErrorException $err) {
            throw new \ErrorException($err->getMessage());
        }
    }


    public function destroy($id): JsonResponse
    {
        try {
            $model = Task::find($id);
            $model->delete();

            return response()->json(['success' => true]);
        } catch (\ErrorException $err) {
            throw new \ErrorException($err->getMessage());
        }
    }

    public function setStage(Request $request): JsonResponse
    {
        try {
            $model = Task::find($request->id);
            $model->done = $request->isDone;
            $model->save();

            return response()->json(['success' => true]);
        } catch (\ErrorException $err) {
            throw new \ErrorException($err->getMessage());
        }
    }
}

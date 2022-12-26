<?php

namespace App\Http\Controllers;

use App\classes\RemoveBadWords;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class RemoveBadWordsController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $this->sanitizeRequest($request);

        $pipes = [
            RemoveBadWords::class
        ];

        app(Pipeline::class)
            ->send($data)
            ->through($pipes)
            ->then(fn ($data) => Task::storeValue($data));

        return response()->json(['message' => 'new task stored']);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function sanitizeRequest(Request $request): array
    {
        return [
             'title' => $request->request->get('title'),
             'description' => $request->request->get('description')
        ];
    }
}

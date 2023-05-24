<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class QuestionApiController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            // 'OrgIsRequired',
        ]);
    }

    /**
     * function index
     *
     * @param \Illuminate\Http\Request request
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function index(
        Request $request,
        $questionId,
    ): JsonResponse {
        if (!$questionId || !\is_string($questionId) || !Str::isUuid($questionId)) {
            dd([__FILE__ . ':' . __LINE__]);
            \abort(404);
        }

        $organization = Organization::getByOrgRefAndCache(\session('org_ref'));

        if (!$organization) {
            \abort(404);
        }

        $question = Cache::remember(
            md5(\implode('-', [__METHOD__, $questionId])),
            60 /*secs*/,
            fn () => Question::query()
                ->whereNotNull('organization_id')
                ->whereId($questionId)->firstOrFail()
        );

        return response()->json($question);
    }
}

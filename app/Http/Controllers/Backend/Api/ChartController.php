<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function chartcomment()
    {
        $lolo  = Comment::select(DB::raw('count(*) as count_comment'), DB::raw('Month(created_at) as month'))
            ->whereYear('created_at', date('Y'))->groupBy(DB::raw('Month(created_at)'))->pluck('count_comment', 'month');
        foreach ($lolo as $key => $dataset) {
            $label[] = date('M', mktime(0, 0, 0, $key, 1));
            $datasets[] = $dataset;
        }

        return response()->json([
            $label, $datasets
        ]);
    }
    public function chartuser()
    {
     $posts_user = User::select('name')->withCount('posts')->orderBy('posts_count', 'desc')->pluck('name', 'posts_count')->take(4)->toArray();

        foreach($posts_user as $data => $name_user)
        {
            $names[] = ['label' => $name_user , 'value' => $data];
        }

        return response()->json($names);
    }
}

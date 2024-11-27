<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFeed;

class DataFeedController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getDataFeed(Request $request)
    {
        $df = new DataFeed();

        return (object)[
            'labels' => $df->getDataFeed(
                $request->datatype,
                'label',
                $request->limit
            ),
            'data' => $df->getDataFeed(
                $request->datatype,
                'data',
                $request->limit
            ),
        ];
    }

//     public function getDataFeed()
// {
//     $dataFeeds = DataFeed::all();
//     // dd($dataFeeds);

//     $data = $dataFeeds->pluck('data');  // Extract data column
//     $labels = $dataFeeds->pluck('label');  // Extract label column

//     return response()->json([
//         'data' => $data,
//         'labels' => $labels,
//     ]);
// }


}

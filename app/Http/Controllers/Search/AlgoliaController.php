<?php namespace App\Http\Controllers\Search;

use App\Pitch;
use App\Http\Requests;
use AlgoliaSearch\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AlgoliaSearch\Client as AlgoliaClient;

class AlgoliaController extends Controller {

    /**
     * Add an Algolia index
     * @param $index string
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addIndex($index) {
        // initialize API Client & Index
        $client = new AlgoliaClient(env('ALGOLIA_APP_ID'), env('ALGOLIA_API_KEY'));
        $index = $client->initIndex($index);

        $results = Pitch::whereIn('status', [2,3])->get();

        if ($results) {

            $batch = [];
            // iterate over results and send them by batch of 10000 elements
            foreach ($results as $object) {
                $row['objectID']        = $object->objectId.'_mark';
                $row['id']              = $object->id;
                $row['title']           = $object->title;
                $row['url']             = $object->url;
                $row['description']     = $object->description;
                $row['investors']       = $object->investors;
                $row['amount_raised']   = $object->reached_amount;
                $row['progress']        = $object->progress;
                $row['overfunding']     = $object->overfunding;
                $row['thumb_path']      = $object->companyLogoPath();
                $row['status_code']     = $object->status;
                $row['status_string']   = $object->status_string;
                $row['funded']          = $object->status == 3;

                array_push($batch, $row);

                if (count($batch) == 10000) {
                    $index->saveObjects($batch);
                    $batch = [];
                }
            }

            $index->saveObjects($batch);
        }

        return view('utils.index.add');
    }

    /**
     * Clear an existing Algolia index
     *
     * @param $index string
     * @return Response
     * @throws \AlgoliaSearch\AlgoliaException
     */
    public function clearIndex($index)
    {
        // initialize API Client & Index
        $client = new AlgoliaClient(env('ALGOLIA_APP_ID'), env('ALGOLIA_API_KEY'));

        //dd($client);
        $index = $client->initIndex($index);

        $index->clearIndex();

//        $res = $index->saveObject([
//            'objectID' => 'pitch_20678',
//            'status_code' => 3
//        ]);
//
////		$client->moveIndex("cc_dev_pitches_temp", "cc_dev_pitches");
//
//        dd($res);

        return view('utils.index.clear');
    }

}

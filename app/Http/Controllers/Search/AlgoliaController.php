<?php namespace App\Http\Controllers\Search;

use App\Pitch;
use App\Search;
use League\Csv\Reader;
use AlgoliaSearch\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlgoliaController extends Controller {

    /**
     * Add an Algolia index
     *
     * @param Search $search
     * @param $index string
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \AlgoliaSearch\AlgoliaException
     */
    public function addPitchIndex(Search $search, $index)
    {
        $search->addPitchIndex($index);

        return view('utils.search.index.add');
    }

    /**
     * Clear an existing Algolia index
     *
     * @param Search $search
     * @param $index string
     *
     * @return Response
     *
     * @throws \AlgoliaSearch\AlgoliaException
     */
    public function clearIndex(Search $search, $index)
    {
        $search->clearIndex($index);

        return view('utils.search.index.clear');
    }

    /**
     * Display option to upload a file to be parsed and converted to search index
     */
    public function uploadIndexFile()
    {
        return view('utils.search.index.upload');
    }

    /**
     * Parse a CSV file and prepare for indexing
     *
     * @param search $search
     * @param Request $request
     *
     * @param string $index
     * @return string
     */
    public function parseIndexFile(Search $search, Request $request, $index = 'cc_blog')
    {
        // Validate the file type
        $this->validate($request, [
            'file' => 'required|mimes:txt,csv'
        ]);

        $search->setInputFile($request->file('file'));

        $search->parseIndexFile($index);

        return 'Got file';
    }

}

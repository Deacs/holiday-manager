<?php namespace App\Http\Controllers\Search;

use App\Pitch;
use App\Search;
use League\Csv\Reader;
use AlgoliaSearch\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AlgoliaSearch\Client as AlgoliaClient;

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

        return view('utils.index.add');
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

        return view('utils.index.clear');
    }

    /**
     * Display option to upload a file to be parsed and converted to search index
     */
    public function uploadIndexFile()
    {
        return view('utils.index.upload');
    }

    /**
     * Parse a CSV file and prepare for indexing
     *
     * @param search $search
     * @param Request $request
     *
     * @return string
     */
    public function parseIndexFile(Search $search, Request $request)
    {
        // Validate the file type
        $this->validate($request, [
            'file' => 'required|mimes:txt,csv'
        ]);

        $search->setInputFile($request->file('file'));

        $search->parseFile();

        return 'Got file';
    }

}

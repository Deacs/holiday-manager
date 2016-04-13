<?php namespace App;

use League\Csv\Reader;
use AlgoliaSearch\Client as AlgoliaClient;

class Search
{
    protected $client;

    protected $index;

    protected $inputFile;

    public function __construct()
    {
        $this->client = new AlgoliaClient(env('ALGOLIA_APP_ID'), env('ALGOLIA_API_KEY'));
    }

    public function setIndex($index)
    {
        $this->index = $index;
    }

    public function setInputFile($inputFile)
    {
        $this->inputFile = $inputFile;
    }

    public function initIndex($index)
    {
        $this->index = $this->client->initIndex($index);
    }

    /**
     * Prepare and add an index of Pitches
     *
     * @param $index
     */
    public function addPitchIndex($index)
    {
        $this->initIndex($index);

        $results = Pitch::whereIn('status', [2,3])->get();

        if ($results) {

            $batch = [];
            // iterate over results and send them by batch of 10000 elements
            foreach ($results as $object) {
                $row['objectID']        = $object->objectId.'_pitch';
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
                    $this->index->saveObjects($batch);
                    $batch = [];
                }
            }

            $this->index->saveObjects($batch);
        }
    }

    /**
     * Clear an existing index
     *
     * @param $index
     */
    public function clearIndex($index)
    {
        $this->initIndex($index);

        $this->index->clearIndex();
    }

    /**
     * Parse an exported file in order to create an index
     * @param $index
     */
    public function parseIndexFile($index)
    {
        $this->clearIndex($index);

        $this->initIndex($index);

        $filePath = $this->inputFile->getPathName();

        $inputCsv = Reader::createFromPath($filePath);

        $rows = $inputCsv->fetchAll();

        // First element will be the headings
        $headings = array_shift($rows);
        $entries = [];

        foreach ($rows as $row) {
            $entry = [];
            foreach ($row as $key => $item) {
                $entry[$headings[$key]] = strip_tags($item);
            }

            $entries[] = $entry;
        }

        $this->index->addObjects($entries);
    }
}

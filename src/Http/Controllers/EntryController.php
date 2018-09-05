<?php

namespace Laravel\Telescope\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Telescope\Contracts\EntriesRepository;

abstract class EntryController extends Controller
{
    /**
     * The entry type for the controller.
     *
     * @return int
     */
    abstract protected function entryType();

    /**
     * List the entries of the given type.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Laravel\Telescope\Contracts\EntriesRepository $storage
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EntriesRepository $storage)
    {
        return response()->json([
            'entries' => $storage->get($this->entryType(), $request->all())
        ]);
    }

    /**
     * Get an entry with the given ID.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Laravel\Telescope\Contracts\EntriesRepository $storage
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, EntriesRepository $storage, $id)
    {
        $entry = $storage->find($id);

        return response()->json([
            'entry' => $entry,
            'batch' => $entry ? $storage->get(null, ['batch_id' => $entry->batch_id]) : null,
        ]);
    }
}
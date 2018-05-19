<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }

    public function getProducts(Request $request)
    {
        if (Storage::exists('storage.xml')) {
            $xml = simplexml_load_string(Storage::get('storage.xml'));
            $sum = 0;
            if ($xml->count() > 1) {
                $json = json_encode($xml);
                $array = json_decode($json, true);
                $data = collect($array['product']);
                $output = array(
                    'draw' => intval($request->get('draw')),
                    'recordsTotal' => $data->count(),
                    'recordsFiltered' => $data->count(),
                    'aaData' => array(),
                );

                if ($data->count() > 1) {
                    $data = $data->sortByDesc('submitted');
                }

                $id = 1;
                foreach ($data as $field) {
                    $row = array();
                    $row[] = $field['id'];
                    $row[] = $field['name'];
                    $row[] = $field['quantity'];
                    $row[] = $field['price'];
                    $submitted = new Carbon($field['submitted']);
                    $row[] = $submitted->toDateTimeString();
                    $row[] = intval($field['price']) * intval($field['quantity']);
                    $sum += intval($field['price']) * intval($field['quantity']);
                    $output['aaData'][] = $row;
                    ++$id;
                }
            } else {
                $row = array();
                $row[] = (string) $xml->product->id;
                $row[] = (string) $xml->product->name;
                $row[] = (string) $xml->product->quantity;
                $row[] = (string) $xml->product->price;
                $submitted = new Carbon($xml->product->submitted);
                $row[] = $submitted->toDateTimeString();
                $row[] = intval($xml->product->price) * intval($xml->product->quantity);
                $sum += intval($xml->product->price) * intval($xml->product->quantity);
                $output['aaData'][] = $row;
            }

            $row = array();
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = '';
            $row[] = $sum;
            $output['aaData'][] = $row;

            return response()->json($output);
        }

        $output = array(
            'draw' => intval($request->get('draw')),
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'aaData' => array(),
        );

        return response()->json($output);
    }
}

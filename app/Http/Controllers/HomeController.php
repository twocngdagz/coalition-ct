<?php

namespace app\Http\Controllers;

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

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (Storage::exists('storage.xml')) {
            $xml = simplexml_load_string(Storage::get('storage.xml'));
            if ($xml->count() >= 1) {
                foreach ($xml->children() as $child) {
                    if ((string) $child->id == (string) $request->get('id')) {
                        $child->name = $request->get('name');
                        $child->quantity = $request->get('quantity');
                        $child->price = $request->get('price');
                    }
                }
            }
            Storage::put('storage.xml', $xml->asXML());
        }
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

                $productId = 1;
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
                    ++$productId;
                }
            } elseif ($xml->count() == 1) {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Storage::exists('storage.xml')) {
            $xml = simplexml_load_string(Storage::get('storage.xml'));
            $productCount = $xml->count() + 1;
        } else {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products></products>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
            if ($xml->count() == 0) {
                $productCount = 1;
            }
        }
        $product = $xml->addChild('product');
        $product->addChild('id', $productCount);
        $product->addChild('name', $request->get('name'));
        $product->addChild('quantity', $request->get('quantity'));
        $product->addChild('price', $request->get('price'));
        $product->addChild('submitted', Carbon::now()->toDateTimeString());
        Storage::put('storage.xml', $xml->asXML());
    }
}

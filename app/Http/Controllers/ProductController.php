<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Product;

class ProductController extends Controller
{
    private $productPath;
    private $products;

    public function __construct()
    {
        $this->productPath = storage_path('products.json');

        try {
            $this->products = (array) json_decode(file_get_contents(storage_path('products.json')));
        } catch (\Exception $e) {
            $this->products = [];
        };
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('product.index', ['products' => $this->products]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $product = [];

        foreach($this->products ?? [] as $pr) {
            if ($pr->id == $id) {
                $product = $pr;
            }
        }
        if (empty($product)) abort(404);

        return view('product.edit', ['product' => $product]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(CreateRequest $request)
    {
        $data = $request->only('product_name', 'quantity', 'price');

        $data['datetime'] = now();

        $oldProducts = $this->products ?? [];

        try {
            $products = fopen($this->productPath, 'w');

            $id = 0;
            foreach ($oldProducts as $product) {
                if($product->id > $id) $id = $product->id;
            }

            $data['id'] = $id + 1;

            $oldProducts[] = $data;

            fwrite($products, json_encode($oldProducts));

            fclose($products);
        } catch (\Exception $e) {
            if (!empty($products)) {
                fclose($products);
            }

            if(config('app.env') == 'local') {
                throw $e;
            }
            return response(['status' => 'fail', 'message' => 'Unknown error occur while saving.'], 500);
        }

        return response([
            'status' => 'success',
            'message' => 'Successfully stored'
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(UpdateRequest $request, $id)
    {
        $oldProducts = $this->products ?? [];

        $fields = ['product_name', 'quantity', 'price'];
        $data = $request->only(...$fields);

        try {
            $products = fopen($this->productPath, 'w');

            $index = -1;
            $product = [];
            foreach ($oldProducts as $key => $pr) {
                if($pr->id == $id) {
                    $index = $key;
                    $product = $pr;
                    break;
                }
            }
            if ($index == -1) {
                fclose($products);
                return response(['status' => 'fail', 'message' => 'Invalid product id'], 422);
            }

            foreach ($fields as $field) {
                $product->{$field} = $data[$field];
            }

            $oldProducts[$index] = $product;

            fwrite($products, json_encode($oldProducts));

            fclose($products);
        } catch (\Exception $e) {
            if (!empty($products)) {
                fclose($products);
            }
            if(config('app.env') == 'local') {
                throw $e;
            }
            return response(['status' => 'fail', 'message' => 'Unknown error occur while saving.'], 500);
        }

        return response([
            'status' => 'success',
            'message' => 'Successfully updated'
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);

        return response([
            'status' => 'success',
            'message' => 'Successfully deleted'
        ]);
    }

}

<?php

use Carbon\Carbon;

/**
 * ProductController 的注释
 *
 * @作者 roy
 */
class ProductController extends BaseController
{

    public function product_category()
    {
        $categories = ProductCategory::where('dealer_id', '=', $this->dealer->dealer_id)->orderBy('category_id', 'desc')->get();

        return View::make('product.category')->with('categories', $categories);
    }

    public function change_category_status()
    {
        $result = new stdClass();

        DB::transaction(function()
        {
            $category_id = Input::get('category_id');
            $status = Input::get('status_code');
            $category = ProductCategory::find($category_id);
            $category->category_status = $status;
            $category->update();

            $results = DB::select('select * from dish_category_relation where category_id = ?', array($category_id));
            if (isset($results))
            {
                foreach ($results as $key => $value)
                {
                    $dish = Product::find($value->dish_id);
                    $dish->dish_status = $status;
                    $dish->update();
                }
            }
        });

        $result->code = 0;
        return json_encode($result);
    }

    public function save_category()
    {
        $result = new stdClass();
        $category_id = Input::get('category_id', 0);
        $category_name = Input::get('category_name');

        if (empty($category_name))
        {
            $result->code = -1;
            return json_encode($result);
        }

        if ($category_id == 0)
        {
            $category = new ProductCategory();
            $category->category_name = $category_name;
            $category->category_status = 0;
            $category->dealer_id = $this->dealer->dealer_id;
            $category->category_parent_id = -1;

            $category->save();

            $new_id = $category->category_id;
            $result->category_id = $new_id;
            $result->code = 0;
            return json_encode($result);
        } else
        {
            $category = ProductCategory::find($category_id);
            $category->category_name = $category_name;
            $category->update();

            $result->code = 0;
            return json_encode($result);
        }
    }

    public function product_paged()
    {
        $category_id = Input::get('category_id', 0);
        $name = Input::get('product_name', null);

        //product list.
        $list = Product::getProducts($this->dealer->dealer_id, $category_id, $name);


        return View::make('product.product_paged_list', array('list' => $list));
    }

    public function product_item_json()
    {
        $product_id = Input::get('product_id');
        $product = Product::find($product_id);
        $cate = ProductCategoryRelation::where('dish_id', '=', $product_id)->first();
        $product->category_id = $cate->category_id;
        $pic = Pic::where('entity_id', '=', $product_id)
                ->where('pic_type', '=', 2)
                ->first();

        $product->pic_url = $pic->pic_url;

        return json_encode($product);
    }

    public function upload_product_img()
    {

        $result = new stdClass();

        $tempFile = $_FILES['Filedata']['tmp_name'];
        $fileTypes = array('jpg', 'jpeg', 'gif', 'png');
        $fileParts = pathinfo($_FILES['Filedata']['name']);

        //\Debugbar::disable();

        if (!in_array($fileParts['extension'], $fileTypes))
        {
            $result->code = -1;
            $result->msg = 'eror file type.';
            return json_encode($result);
        }

        $path = Config::get('site.img_upload_path') . date('Ym', time()) . '/';
        if (!File::exists($path))
        {
            File::makeDirectory($path, 0777);
        }

        $new_file_name = "1_" . Carbon::now()->getTimestamp() . '_1.' . $fileParts['extension'];

        move_uploaded_file($tempFile, $path . $new_file_name);

        $result->code = 0;
        $result->new_path = 'upload/' . date('Ym', time()) . '/' . $new_file_name;
        $result->name = $new_file_name;
        $result->file_path = Config::get('site.img_http_path') . 'upload/' . date('Ym', time()) . '/' . $new_file_name;
        Cache::flush();
        return json_encode($result);
    }

    public function product()
    {
        $categories_cache_key = 'categories_' . $this->dealer->dealer_id;
        $cates = Cache::get($categories_cache_key, null);
        if (!isset($categories))
        {
            $categories = ProductCategory::whereRaw('dealer_id = :dealer_id and category_status = 1', array(':dealer_id' => $this->dealer->dealer_id))
                    ->select(array('category_id', 'category_name'))
                    ->get();

            $cates = array();
            $cates[0] = '请选择';



            foreach ($categories as $k => $category)
            {
                $cates[$category->category_id] = $category->category_name;
            }

            Cache::put($categories_cache_key, $cates, 200);
        }

        return View::make('product.product_list', array('categories' => $cates));
    }

    public function product_json()
    {
        return Product::getProducts($this->dealer->dealer_id); //paginate(10)->toArray();
    }

    public function save_product()
    {
        $result = new stdClass();

        $product_name = Input::get('edit_product_name');
        $product_id = Input::get('product_id');
        $product_category = Input::get('edit_category_id');
        $product_count = Input::get('product_count', 0);
        $product_price = Input::get('product_price', 0);
        $alert_count = Input::get('alert_count', 0);
        $product_status = Input::get('product_status');
        $product_img_url = Input::get('product_img_url');
        $product_presell = Input::get('product_presell');
        $product_memo = Input::get('product_memo');

        if (empty($product_name) ||
                empty($product_category) ||
                (!is_numeric($product_count)) ||
                (!is_numeric($product_price)))
        {

            $result->code = (empty($product_name) || empty($product_category) || (!is_numeric($product_count)) || (!is_numeric($product_price))
                    );

            $result->msg = "args invalid.";
            return json_encode($result);
        }


        DB::beginTransaction();
        try
        {
            $product = null;
            if ($product_id == -1)
            {
                $product = Product::whereRaw('dealer_id=:dealer_id and dish_name = :dish_name', array(':dealer_id' => $this->dealer->dealer_id,
                            ':dish_name' => $product_name))->first();
                if (!isset($product))
                {
                    $product = new Product();
                }
            } else
            {
                $product = Product::find($product_id);
            }

            $py = new Business\busPinyin();
            $jp = $py->getFirstPY($product_name);
            $qp = $py->getAllPY($product_name);


            $product->dish_name = $product_name;
            $product->dish_jianpin = $py->getFirstPY($product_name);
            $product->dish_quanpin = $py->getAllPY($product_name);
            $product->dish_recommend = 0;
            $product->dish_package_fee = 0;
            $product->dish_is_vaget = 0;
            $product->dish_spicy_level = 0;
            $product->dish_introduction = $product_memo;
            $product->dish_status = $product_status;
            $product->dish_createtime = Carbon::now()->getTimestamp();
            $product->dish_mode = 1;
            $product->dish_modifytime = Carbon::now()->getTimestamp();
            $product->dish_price = $product_price;
            $product->dish_count = $product_count;
            $product->alert_count = $alert_count;
            $product->is_presell = $product_presell;
            $product->dealer_id = $this->dealer->dealer_id;

            $product->save();

            $dr = DB::table('dish_category_relation')
                    ->where('dish_id', '=', $product->dish_id)
                    //->where('category_id', '=', $product_category)
                    ->first();
            if (!isset($dr))
            {
                DB::table('dish_category_relation')
                        ->insert(array('dish_id' => $product->dish_id,
                            'category_id' => $product_category));
            } else
            {
                DB::update(' update dish_category_relation set category_id=:category_id where dish_id=:dish_id', array(':category_id' => $product_category, ':dish_id' => $product->dish_id));
            }

            if (!empty($product_img_url))
            {
                $pic = Pic::whereRaw('entity_id=:product_id and pic_type=2', array(':product_id' => $product->dish_id))
                        ->first();
                if (isset($pic))
                {
                    $pic->pic_url = $product_img_url;
                    $pic->update();
                } else
                {
                    $pic = new Pic();
                    $pic->entity_id = $product->dish_id;
                    $pic->pic_type = 2;
                    $pic->pic_url = $product_img_url;
                    $pic->save();
                }
            }

            DB::commit();
            Cache::flush();
            $result->code = 0;
        } catch (Exception $e)
        {
            DB::rollBack();
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
            $result->msg = $e->getMessage();
            $result->code = -1;
        }

        return json_encode($result);
    }

    public function add_product()
    {
        $product_id = Input::get('add_product_id');
        $add_count = Input::get('add_count');
        $result = new stdClass();
        if (!(is_numeric($product_id) && $product_id > 0 && is_numeric($add_count)))
        {
            $result->code = -1;
            $result->msg = 'args error.';
            return json_encode($result);
        }

        $product = Product::find($product_id);
        $product->dish_count += intval($add_count);
        $product->update();

        $result->code = 0;
        Cache::flush();
        return json_encode($result);
    }

    public function change_product_status()
    {
        $result = new stdClass();
        $product_id = Input::get('product_id');
        $status = Input::get('status_code');

        $product = Product::find($product_id);
        $product->dish_status = $status;
        $product->update();

        Cache::flush();
        $result->code = 0;
        return json_encode($result);
    }

}

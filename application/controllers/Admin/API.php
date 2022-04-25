<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Form;
use Input;
use Session;
use Validator;
use Yajra\Datatables\Facades\Datatables;

class Api extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Kolkata');
        header("Access-Control-Allow-Origin: *");
    }

    public function index() {
        echo "Api List";
        die;
    }

    // pratik code strat

    public function checkVersion(Request $request) {
        if ($request->version == '1.0.12') {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function staticPage(Request $request) {
        
        $sql = "Select * from mp_configuration where title='";
        if ($request->type == 1) {
            $sql .= "About Us";
        } else if ($request->type == 2) {
            $sql .= "Privacy Policy";
        } else if ($request->type == 3) {
            $sql .= "Cancellation & Returns";
        } else if ($request->type == 4) {
            $sql .= "IPR Policy";
        } else if ($request->type == 5) {
            $sql .= "Terms & Conditions";
        } else if ($request->type == 6) {
            $sql .= "Shipping Policy";
        }
        $sql .= "'";
        $data = DB::select($sql);
        return view('pg')->with(['dts' => $data]);
    }

    public function login(Request $request) {
        $con = [
            'phone' => $request->number,
            'password' => md5($request->password)
        ];
        $logdata = DB::table('mp_customer')->where($con)->count();
        if ($logdata > 0) {
            $user = DB::table('mp_customer')->where($con)->first();
            $upcode = [
                'fcm_id' => $request->gcmid
            ];
            $upcon = [
                'mp_customer_id' => $user->mp_customer_id
            ];
            DB::table('mp_customer')->where($upcon)->update($upcode);

            if (isset($request->did)):
                $did = [
                    'user_id' => $request->did
                ];
                $tempcart = DB::table('mp_cart_temp')->where($did)->get();
                foreach ($tempcart as $dt):
                    $allreadycartpro = DB::select('select * from mp_cart where product_id=' . $dt->product_id . ' and user_id=' . $user->mp_customer_id);
                    if (count($allreadycartpro) > 0):
                        if ($dt->qty > $allreadycartpro[0]->qty):
                            $uid = [
                                'mp_cart_id' => $allreadycartpro[0]->mp_cart_id
                            ];
                            $updatproqty = [
                                'qty' => $dt->qty,
                                'variant' => $dt->variant
                            ];
                            DB::table('mp_cart')->where($uid)->update($updatproqty);
                        endif;
                    else:
                        $cartdata = [
                            'product_id' => $dt->product_id,
                            'user_id' => $user->mp_customer_id,
                            'qty' => $dt->qty,
                            'variant' => $dt->variant,
                            'device_type' => $dt->device_type,
                            'status' => 'A',
                            'cdate' => date('Y-m-d H:i:s')
                        ];
                        DB::table('mp_cart')->insertGetId($cartdata);
                    endif;
                endforeach;
                DB::table('mp_cart_temp')->where($did)->delete();
            endif;

            $data = [
                'rep' => $user->mp_customer_id,
                'username' => $user->firstname,
                'email' => $user->email
            ];
            echo json_encode($data);
        } else {
            echo "false";
        }
    }

    public function register(Request $request) {
        $sql = "select mp_customer_id,status,phone,firstname,email from mp_customer where phone='" . $request->mobile . "'";
        $users = DB::select($sql);
        if (count($users) > 0) {
            if ($users[0]->status == "A") {
                $data = [
                    'rep' => "User already Exists"
                ];
            } else {
                $datas = [
                    'otp_code' => $request->otp,
                ];
                $con = [
                    'mp_customer_id' => $users[0]->mp_customer_id
                ];
                DB::table('mp_customer')->where($con)->update($datas);

                //msg
                if ($users[0]->phone != "" && strlen($users[0]->phone) >= 10) {
                    $smscontaint = "Your otp is " . $request->otp;
                    $number = $users[0]->phone;
                    app('App\Http\Controllers\SMSModule')->sendSMS($number, $smscontaint);
                }

                $data = [
                    'rep' => $users[0]->mp_customer_id,
                    'username' => $users[0]->firstname,
                    'email' => $users[0]->email,
                ];
            }
        } else {
            $data = [
                'phone' => $request->mobile,
                'otp_code' => $request->otp,
                'status' => "D",
                'firstname' => $request->fname,
                'email' => $request->email,
                'social_type' => 'Manual',
                'create_date' => date('Y-m-d H:i:s')
            ];
            $lastInsertedID = DB::table('mp_customer')->insertGetId($data);

            //msg
            if (trim($request->mobile) != "" && strlen(trim($request->mobile)) >= 10) {
                $smscontaint = "Your otp is " . $request->otp;
                $number = $request->mobile;
                app('App\Http\Controllers\SMSModule')->sendSMS($number, $smscontaint);
            }

            $data = [
                'rep' => $lastInsertedID,
                'username' => $request->fname,
                'email' => $request->email
            ];
        }
        echo json_encode($data);
    }

    public function setPassword(Request $request) {
        if ($request->userid != ""):
            if ($request->password != ""):
                $uppass = [
                    'password' => md5($request->password),
                    'fcm_id' => $request->gcmid,
                    'status' => 'A'
                ];
                $upcon = [
                    'mp_customer_id' => $request->userid
                ];
                DB::table('mp_customer')->where($upcon)->update($uppass);
                if (isset($request->did)):
                    $did = [
                        'user_id' => $request->did
                    ];
                    $tempcart = DB::table('mp_cart_temp')->where($did)->get();
                    foreach ($tempcart as $dt):
                        $allreadycartpro = DB::select('select * from mp_cart where product_id=' . $dt->product_id . ' and user_id=' . $request->userid);
                        if (count($allreadycartpro) > 0):
                            $uid = [
                                'mp_cart_id' => $allreadycartpro[0]->mp_cart_id
                            ];
                            $updatproqty = [
                                'qty' => $dt->qty + $allreadycartpro[0]->qty,
                                'variant' => $dt->variant
                            ];
                            DB::table('mp_cart')->where($uid)->update($updatproqty);
                        else:
                            $cartdata = [
                                'product_id' => $dt->product_id,
                                'user_id' => $request->userid,
                                'qty' => $dt->qty,
                                'variant' => $dt->variant,
                                'status' => 'A',
                                'cdate' => date('Y-m-d H:i:s')
                            ];
                            DB::table('mp_cart')->insertGetId($cartdata);
                        endif;
                    endforeach;
                    DB::table('mp_cart_temp')->where($did)->delete();
                endif;
                echo "1";
            else:
                echo "0";
            endif;
        else:
            echo "0";
        endif;
    }

    public function forgetPassword(Request $request) {
        $con = [
            'phone' => $request->number
        ];
        $logdata = DB::table('mp_customer')->where($con)->get();
        if (count($logdata) > 0):
            $smscontaint = "Your otp is " . $request->otp;
            app('App\Http\Controllers\SMSModule')->sendSMS($request->number, $smscontaint);

            $changeotp = [
                'otp_code' => $request->otp
            ];
            $con1 = [
                'mp_customer_id' => $logdata[0]->mp_customer_id
            ];
            DB::table('mp_customer')->where($con1)->update($changeotp);
            $data = [
                'res' => true,
                'userid' => $logdata[0]->mp_customer_id
            ];
        else:
            $data = [
                'res' => false,
                'userid' => null
            ];
        endif;
        echo json_encode($data);
    }

    public function changePassword(Request $request) {
        $newpass = [
            'password' => md5($request->password)
        ];
        $con = [
            'mp_customer_id' => $request->userid
        ];
        DB::table('mp_customer')->where($con)->update($newpass);
        echo 1;
    }

    public function sendSms(Request $request) {
        if ($request->mobile != "") {
            if ($request->otp != "") {
                //msg
                if (trim($request->mobile) != "" && strlen(trim($request->mobile)) >= 10) {
                    $smscontaint = "Your otp is " . $request->otp;
                    $number = $request->mobile;
                    app('App\Http\Controllers\SMSModule')->sendSMS($number, $smscontaint);
                }
            }
        }
    }

    public function socialLogin(Request $request) {
        $datas = json_decode($request->data);
        if (!empty($datas->user_credentials)):

            $finalSocialId = $datas->user_credentials[0]->socid;

            // 1.0 Check User Exist or Not
            $con = [
                'social_id' => $finalSocialId
            ];
            $logdata = DB::table('mp_customer')->where($con)->get();
            // 1.0 Over

            if (count($logdata) > 0):

                // 1.1 User Table UpdateData
                $fblastInsertedID = $logdata[0]->mp_customer_id;

                $data = [
                    'last_login' => strtotime(date('Y-m-d H:i:s')),
                    'status' => "A",
                    'fcm_id' => $datas->user_credentials[0]->gcmid
                ];
                $con = [
                    'mp_customer_id' => $fblastInsertedID
                ];
                DB::table('mp_customer')->where($con)->update($data);

            // 1.1 Over
            else:
                // 1.1 User Table Insert
                $n = explode(' ', $datas->user_credentials[0]->fname);
                $fbdata = [
                    'firstname' => (isset($n[0])) ? $n[0] : '',
                    'lastname' => (isset($n[1])) ? $n[1] : '',
                    'social_type' => $datas->user_credentials[0]->soctype,
                    'social_id' => $finalSocialId,
                    'email' => $datas->user_credentials[0]->email,
                    'fcm_id' => $datas->user_credentials[0]->gcmid,
                    'status' => "A",
                    'create_date' => date('Y-m-d H:i:s'),
                    'last_login' => date('Y-m-d H:i:s')
                ];
                $fblastInsertedID = DB::table('mp_customer')->insertGetId($fbdata);
            // 1.1 Over
            endif;

            // 1.2 Check User Order
            $con = [
                'user_id' => $datas->user_credentials[0]->deviceid
            ];
            $userordersmain = DB::table('mp_cart_temp')->where($con)->get();
            // 1.2 Over

            if (count($userordersmain) > 0):

                // 1.4 Order Item Data Insert
                foreach ($userordersmain as $dt):
                    $allreadycartpro = DB::select('select * from mp_cart where product_id=' . $dt->product_id . ' and user_id=' . $fblastInsertedID);
                    if (count($allreadycartpro) > 0):
                        if ($dt->qty > $allreadycartpro[0]->qty):
                            $uid = [
                                'mp_cart_id' => $allreadycartpro[0]->mp_cart_id
                            ];
                            $updatproqty = [
                                'qty' => $dt->qty,
                                'variant' => $dt->variant
                            ];
                            DB::table('mp_cart')->where($uid)->update($updatproqty);
                        endif;
                    else:
                        $cartdata = [
                            'product_id' => $dt->product_id,
                            'user_id' => $fblastInsertedID,
                            'qty' => $dt->qty,
                            'variant' => $dt->variant,
                            'status' => 'A',
                            'cdate' => date('Y-m-d H:i:s')
                        ];
                        DB::table('mp_cart')->insertGetId($cartdata);
                    endif;
                endforeach;
                DB::table('mp_cart_temp')->where($con)->delete();
            // 1.4 over
            endif;

            $data = [
                'rep' => $fblastInsertedID
            ];
            echo json_encode($data);

        else:
            echo "Error";
        endif;
    }

    //BANNERS

    public function banner(Request $request) {
        $data = DB::table('mp_banners')->where('is_trash', 0)->where('active', 0)->select('image_name', 'category_id', 'discount', 'discount_type')->get();
        $dtt = array();
        foreach ($data as $dt) {
            $dtt[] = array(
                'image_name' => 'http://me.missethnik.com/uploads/banner/' . $dt->image_name,
                'category_id' => $dt->category_id,
                'discount' => $dt->discount,
                'discount_type' => $dt->discount_type
            );
        }
        return response()->json($dtt);
    }

    public function categoryBanner(Request $request) {
        if (isset($request->cid) && $request->cid != "") {
            $data = DB::table('mp_banners')->where('is_trash', 0)->where('active', 0)->where('category_id', $request->cid)->select('image_name', 'category_id', 'discount', 'discount_type')->get();
            $dtt = array();
            foreach ($data as $dt) {
                $dtt[] = array(
                    'image_name' => 'http://me.missethnik.com/uploads/banner/' . $dt->image_name,
                    'category_id' => $dt->category_id,
                    'discount' => $dt->discount,
                    'discount_type' => $dt->discount_type
                );
            }
            return response()->json($dtt);
        } else {
            return response()->json(array());
        }
    }

    public function dashBoardBanner(Request $request) {
        $data = DB::Select('select * from mp_dashboard_banner where is_delete="N" and is_status="Y"');
        return response()->json($data);
    }

    public function promotionbanner() {
        $data = DB::Select('select * from mp_promotion_banner where is_delete="N" and is_status="Y"');
        return response()->json($data);
    }

    public function getBanner() {
        $data = DB::Select('SELECT GROUP_CONCAT(category_id) category_id,GROUP_CONCAT(DISTINCT(title)) title,GROUP_CONCAT(DISTINCT(image_name)) image_name ,GROUP_CONCAT(discount_type) discount_type,GROUP_CONCAT(discount) discount,GROUP_CONCAT(is_percentage) percentage FROM `mp_promotion_banner` where is_delete="N" GROUP BY category_id');
        return response()->json($data);
    }

    public function allCatBanner(Request $request) {
        $qr = 'select * from mp_all_cat where is_status = "Y" and is_delete = "N" order by mp_all_cat_id desc limit 1 ';
        $res = DB::Select($qr);

        echo json_encode($res);
    }

    //CATEGORY

    public function home_page_category_display(Request $request) {
        $sql = "SELECT a.mp_category_id,a.title,a.image,a.parent_id,CASE WHEN a.image LIKE 'Cat%' THEN a.image ELSE \"\" END image FROM mp_category a where a.status='A' and a.parent_id=0  Order By set_order limit 8 ";
        $fcat = DB::select($sql);
        return response()->json($fcat);
    }

    public function getMcategory(Request $request) {
        $sql = "SELECT a.mp_category_id,a.title,a.image,a.parent_id,CASE WHEN a.image LIKE 'Cat%' THEN a.image ELSE \"\" END image FROM mp_category a where a.status='A' GROUP by a.mp_category_id";
        $fcat = DB::select($sql);
        return response()->json($fcat);
    }

    //PRODUCT GET

    public function getcwData(Request $request) {
        if ($request->start == 0) {
            $st = 0;
        } else {
            $st = ($request->start * 10) + 1;
        }
        $sql = "SELECT mp.mp_product_id,mp.product_name,mpi.image_name,mp.list_price,mp.selling_price,mp.qty
FROM mp_product_variant mpc
LEFT JOIN mp_product_images mpi ON mpi.mp_product_id=mpc.mp_product_id
INNER JOIN mp_product mp ON mp.mp_product_id=mpi.mp_product_id where mpc.mp_category_id=" . $request->catid . " group by mp.mp_product_id limit " . $st . ",20";
        $fcat = DB::select($sql);
        return response()->json($fcat);
    }

    public function getNewProduct(Request $request) {
        $sql = "select mp.mp_product_id,mp.product_name,mp.sku_number,mp.is_features,mp.list_price,mp.selling_price,mp.likes_count,mp.qty,x.image as image
from mp_product mp
LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x
on x.mp_product_id=mp.mp_product_id WHERE mp.status='A' and mp.qty>0";
        if ($request->start == "") {
            $st = 0;
        } else {
            $st = $request->start;
        }
        if ($request->end == "") {
            $en = 5;
        } else {
            $en = $request->end;
        }
        if ($request->datatype == "FP") {
            $sql .= " and mp.is_features=1";
        } else if ($request->datatype == "NA") {
            $sql .= " ORDER BY mp.create_date DESC";
            if ($request->type == 'M') {
                $sql .= ", RAND() ";
            }
        } else {
            $sql .= "";
        }
        $sql .= " Limit " . $st . "," . $en;
        $data = DB::select($sql);
        echo json_encode($data);
    }

    public function allProductData(Request $request) {
        $con = [
            'Price' => $request->price,
            'Color' => str_replace(' ', '', $request->color),
            'Size' => $request->size,
            'Occasion' => $request->occasion,
            'Material' => $request->material,
        ];

        // Key's
        $key = [
            'mp.selling_price',
            'mpv.mp_variant_id',
            'mpv.mp_variant_id',
            'mpv.mp_variant_id',
            'mpv.mp_variant_id'
        ];


        // wishlist & cart  data
        if ($request->userid == ""):
            $wish = "(CASE WHEN 1=1 THEN 0 ELSE 1 END) as wishlist,";
            $wish1 = "";
//            if (isset($request->devaiceid) && $request->devaiceid != "") {
//                $cart = "(CASE WHEN find_in_set('" . $request->devaiceid . "',GROUP_CONCAT(DISTINCT(mpcr.user_id))) is null or find_in_set('" . $request->devaiceid . "',GROUP_CONCAT(DISTINCT(mpcr.user_id)))=0 THEN 0 ELSE 1 END) as cart,";
//                $cart1 = "LEFT JOIN mp_wishlist mpw ON mpw.product_id=mp.mp_product_id";
//            } else {
//                $cart = "(CASE WHEN 1=1 THEN 0 ELSE 1 END) as cart,";
//                $cart1 = "";
//            }

        else:
            $wish = "(CASE WHEN find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpw.user_id))) is null or find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpw.user_id)))=0 THEN 0 ELSE 1 END) as wishlist,";
            $wish1 = " LEFT JOIN mp_wishlist mpw ON mpw.product_id=mp.mp_product_id";

//            $cart = "(CASE WHEN find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpcr.user_id))) is null or find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpcr.user_id)))=0 THEN 0 ELSE 1 END) as cart,";
//            $cart1 = "LEFT JOIN mp_wishlist mpw ON mpw.product_id=mp.mp_product_id";

        endif;

        // Discount Data
        if ($request->dis == ""):
            $sqldis = "";
            $sqldishave = "";
        else:
            if ($request->distypr != ""):
                $sqldis = "if(round(((mp.list_price-mp.selling_price)/mp.list_price)*100)" . $request->distypr . $request->dis . ",1,0) as dis,";
            else:
                $sqldis = "if(round(((mp.list_price-mp.selling_price)/mp.list_price)*100)=" . $request->dis . ",1,0) as dis,";
            endif;
            $sqldishave = " FIND_IN_SET('1',dis)";
        endif;

        // price wise data get 
//        if(isset($request->pric) && $request->pric){
//            $priceFilter =  "";
//        } else {
//            $priceFilter =  "";
//        }
        // SQL With Sub-Cat or Main-Cat


        $cn = " (SELECT count(*) FROM mp_product WHERE mcnt.status='A' and mcnt.qty>0 ) count, ";
        $sql = "SELECT " . $cn . " " . $wish . "" . $sqldis . " mp.mp_product_id,if(s.p_id is null,0,s.p_id) promo_id,if(s.aval is null,0,1) avals,s.dis,
mp.product_name,
mp.sku_number,
mp.is_features,
mp.list_price,
mp.selling_price,
mp.likes_count,
mp.qty,
x.image as image,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=1,mpv.mp_variant_id,'')))) as Color,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=2,mpv.mp_variant_id,'')))) as Size,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=3,mpv.mp_variant_id,'')))) as Occasion,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=4,mpv.mp_variant_id,'')))) as Material,
mpro.discount,mpro.start_date mprostartdate,mpro.end_date mproenddate,mpro.is_active mproisactive
from mp_product mp
LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x
on x.mp_product_id=mp.mp_product_id
LEFT JOIN mp_product_variant mpv on mp.mp_product_id=mpv.mp_product_id
LEFT JOIN mp_category mc ON mpv.mp_category_id=mc.mp_category_id
LEFT JOIN mp_promotions mpro ON mpro.p_id=mp.mp_product_id" . $wish1 . " 
LEFT JOIN (select p_id,mp_product_id mpid,discount dis,is_active aval from mp_promotions where CURRENT_DATE>start_date and CURRENT_DATE<end_date and is_active=1 and is_trash='N') s ON s.mpid=mp.mp_product_id
WHERE mpv.mp_attributes_id in (1,2,3,4) and mp.status='A' and mp.qty>0";
        // SQL With catid or Not
        $ord = "mp.set_order asc";

        // Search Data
        if ($request->searchval == ""):
            $sql .= "";
        else:
            $sql .= "  and mp.product_description LIKE '%" . $request->searchval . "%'  or mp.product_name LIKE '%" . $request->searchval . "%'";
        endif;

        // Feature Product
        if ($request->FP == ""):
            $sql .= "";
        elseif ($request->FP == "1"):
            $sql .= "  and mp.is_features=1";
        endif;

        // Ordering Data
        if ($request->orders == ""):
            $sqlordes = " ORDER BY " . $ord;
        else:
            // Order selling_price Low to High
            if ($request->orders == "LH"):
                $sl = "mp.selling_price ASC"; // Added ',' Here (Harish)
            // Order selling_price High to low
            elseif ($request->orders == "HL"):
                $sl = "mp.selling_price DESC"; // Added ',' Here (Harish)
            // Order New Arrival
            else:
//                if ($request->FP == ""):
//                    $sl = "mp.is_features desc,mp.mp_product_id DESC";
//                else
                if ($request->FP == "1"):
                    $sl = "mp.is_features desc,mp.mp_product_id DESC";
                elseif ($request->FP == "2"):
                    $sl = "mp.mp_product_id DESC";
                endif;
            endif;
            $sqlordes = " ORDER BY " . $sl;
        endif;

        // Filltering Data
        if (!array_filter($con)):
            $sql .= " GROUP BY mp.mp_product_id ";
            if ($sqldishave != ""):
                $sql .= "HAVING " . $sqldishave;
            endif;
        else:
            $cnt = 0;
            $pcnt = 0;
            for ($i = 0; $i < count($con); $i++):
                if (array_values($con)[$i] != ""):
                    if (array_keys($con)[$i] == 'Price'):
                        $ps = explode(',', array_values($con)[$i]);
                        $sql .= " and (" . array_values($key)[$i] . " between " . $ps[0] . " and " . $ps[1] . ") GROUP BY mp.mp_product_id ";
                        $pcnt++;
                    else:
                        $comma = explode(',', array_values($con)[$i]);

                        if ($cnt == 0):
                            if ($pcnt == 0):
                                $operator = " GROUP By mp.mp_product_id HAVING ";
                            else:
                                $operator = " HAVING ";
                            endif;
                        else:
                            $operator = "and";
                        endif;
                        $sql .= $operator . " (";
                        for ($s = 0; $s < count($comma); $s++):
                            $op = " or";
                            if ($s == count($comma) - 1):
                                $op = " ";
                            endif;
                            $sql .= " FIND_IN_SET('" . $comma[$s] . "'," . array_keys($con)[$i] . ") " . $op;
                        endfor;
                        $sql .= " )";
                        $cnt++;

                    endif;
                endif;
            endfor;
            if ($sqldishave == ""):
                $sql .= "";
            else:
                $sql .= " and " . $sqldishave;
            endif;

        endif;


        // End Length
        if ($request->end == ""):
            $end = 10;
        else:
            $end = $request->end;
        endif;

        // Start Length
        if ($request->start == "" || $request->start == 0):
            $start = 0;
        else:
            $start = ($request->start * 10);
        endif;


        // Length
        $sql .= $sqlordes . " LIMIT " . $end . " OFFSET " . $start;

//        echo $sql;
//        die;

        $data = DB::select($sql);
        echo json_encode($data);
    }

    public function getwhere(Request $request) {

//        echo $request->cattype;
//        die;
        // Get Data
        $con = [
            'Price' => $request->price,
            'Color' => str_replace(' ', '', $request->color),
            'Size' => $request->size,
            'Occasion' => $request->occasion,
            'Material' => $request->material,
        ];

        // Key's
        $key = [
            'mp.selling_price',
            'mpv.mp_variant_id',
            'mpv.mp_variant_id',
            'mpv.mp_variant_id',
            'mpv.mp_variant_id'
        ];


        // wishlist & cart  data
        if ($request->userid == ""):
            $wish = "(CASE WHEN 1=1 THEN 0 ELSE 1 END) as wishlist,";
            $wish1 = "";

//            if (isset($request->devaiceid) && $request->devaiceid != "") {
//                $cart = "(CASE WHEN find_in_set('" . $request->devaiceid . "',GROUP_CONCAT(DISTINCT(mpcr.user_id))) is null or find_in_set('" . $request->devaiceid . "',GROUP_CONCAT(DISTINCT(mpcr.user_id)))=0 THEN 0 ELSE 1 END) as cart,";
//                $cart1 = "LEFT JOIN mp_wishlist mpw ON mpw.product_id=mp.mp_product_id";
//            } else {
//                $cart = "(CASE WHEN 1=1 THEN 0 ELSE 1 END) as cart,";
//                $cart1 = "";
//            }

        else:
            $wish = "(CASE WHEN find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpw.user_id))) is null or find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpw.user_id)))=0 THEN 0 ELSE 1 END) as wishlist,";
            $wish1 = " LEFT JOIN mp_wishlist mpw ON mpw.product_id=mp.mp_product_id";

//            $cart = "(CASE WHEN find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpcr.user_id))) is null or find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpcr.user_id)))=0 THEN 0 ELSE 1 END) as cart,";
//            $cart1 = "LEFT JOIN mp_wishlist mpw ON mpw.product_id=mp.mp_product_id";

        endif;

        // Discount Data
        if ($request->dis == ""):
            $sqldis = "";
            $sqldishave = "";
        else:
            if ($request->distypr != ""):
                $sqldis = "if(round(((mp.list_price-mp.selling_price)/mp.list_price)*100)" . $request->distypr . $request->dis . ",1,0) as dis,";
            else:
                $sqldis = "if(round(((mp.list_price-mp.selling_price)/mp.list_price)*100)=" . $request->dis . ",1,0) as dis,";
            endif;
            $sqldishave = " FIND_IN_SET('1',dis)";
        endif;


// SQL With all Product
        if ($request->cattype == "ALL"):
//            echo "ALL";
//            die;
            $cn = " (SELECT count(*) FROM mp_product mcnt WHERE mcnt.status='A' and mcnt.qty>0 ) count, ";
            $sql = "SELECT   " . $cn . "" . $wish . "" . $sqldis . " mp.mp_product_id,if(s.p_id is null,0,s.p_id) promo_id,if(s.aval is null,0,1) avals,s.dis,
mp.product_name,
mp.sku_number,
mp.is_features,
mp.list_price,
mp.selling_price,
mp.likes_count,
mp.qty,
x.image as image,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=1,mpv.mp_variant_id,'')))) as Color,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=2,mpv.mp_variant_id,'')))) as Size,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=3,mpv.mp_variant_id,'')))) as Occasion,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=4,mpv.mp_variant_id,'')))) as Material,
mpro.discount,mpro.start_date mprostartdate,mpro.end_date mproenddate,mpro.is_active mproisactive
from mp_product mp
LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x
on x.mp_product_id=mp.mp_product_id
LEFT JOIN mp_product_variant mpv on mp.mp_product_id=mpv.mp_product_id
LEFT JOIN mp_category mc ON mpv.mp_category_id=mc.mp_category_id
LEFT JOIN mp_promotions mpro ON mpro.p_id=mp.mp_product_id" . $wish1 . " 
LEFT JOIN (select p_id,mp_product_id mpid,discount dis,is_active aval from mp_promotions where CURRENT_DATE>start_date and CURRENT_DATE<end_date and is_active=1 and is_trash='N') s ON s.mpid=mp.mp_product_id
WHERE  mp.status='A' and mp.qty>0";

            // SQL With catid or Not
            $ord = "mp.set_order asc";

        // SQL With Sub-Cat or Main-Cat
        elseif ($request->cattype == "SubCat"):
//            echo "SubCat";
//            die;
            $cn = " (select count(*) from mp_product mcnt where mcnt.mp_category_id in (" . $request->catid . ") and mcnt.status='A' and mcnt.qty>0 ) count, ";
            $sql = "SELECT " . $cn . " " . $wish . "" . $sqldis . " mp.mp_product_id,if(s.p_id is null,0,s.p_id) promo_id,if(s.aval is null,0,1) avals,s.dis,
mp.product_name,
mp.sku_number,
mp.is_features,
mp.list_price,
mp.selling_price,
mp.likes_count,
mp.qty,
x.image as image,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=1,mpv.mp_variant_id,'')))) as Color,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=2,mpv.mp_variant_id,'')))) as Size,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=3,mpv.mp_variant_id,'')))) as Occasion,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=4,mpv.mp_variant_id,'')))) as Material,
mpro.discount,mpro.start_date mprostartdate,mpro.end_date mproenddate,mpro.is_active mproisactive
from mp_product mp
LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x
on x.mp_product_id=mp.mp_product_id
LEFT JOIN mp_product_variant mpv on mp.mp_product_id=mpv.mp_product_id
LEFT JOIN mp_category mc ON mpv.mp_category_id=mc.mp_category_id
LEFT JOIN mp_promotions mpro ON mpro.p_id=mp.mp_product_id" . $wish1 . " 
LEFT JOIN (select p_id,mp_product_id mpid,discount dis,is_active aval from mp_promotions where CURRENT_DATE>start_date and CURRENT_DATE<end_date and is_active=1 and is_trash='N') s ON s.mpid=mp.mp_product_id
WHERE  mp.status='A' and mp.qty>0";

            // SQL With catid or Not
            $ord = "mp.set_order asc";

            if ($request->catid == ""):
                $sql .= "";
            else:
                $sql .= " and mp.mp_category_id=" . $request->catid;
//                $variant = DB::Select($var);

                $viewcount = [
                    'mp_category_id' => $request->catid,
                    'device_type' => $request->device_type,
                    'created_date' => date('Y-m-d H:i:s'),
                ];
                DB::table('mp_category_view_counter')->insert($viewcount);
            endif;
        else:
//            echo "Main Cat";
//            die;
            $sql1 = "select GROUP_CONCAT(DISTINCT(mp_category_id)) as cid from mp_category WHERE find_in_set('" . $request->catid . "',REPLACE(id_path, '/', ','))";
            $dp = DB::select($sql1);

            if ($dp[0]->cid != "") {
                $cdd = $dp[0]->cid;
            } else {
                $cdd = $request->catid;
            }

            $cn = " (select count(*) from mp_product mcnt where mcnt.mp_category_id in (" . $cdd . ")  and mcnt.status='A' and mcnt.qty>0 ) count, ";
            $sql = "SELECT " . $cn . "" . $wish . "" . $sqldis . " mp.mp_product_id,if(s.p_id is null,0,s.p_id) promo_id,if(s.aval is null,0,1) avals,s.dis,
mp.product_name,
mp.sku_number,
mp.is_features,
mp.list_price,
mp.selling_price,
mp.likes_count,
mp.qty,
x.image as image,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=1,mpv.mp_variant_id,'')))) as Color,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=2,mpv.mp_variant_id,'')))) as Size,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=3,mpv.mp_variant_id,'')))) as Occasion,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=4,mpv.mp_variant_id,'')))) as Material,
mpro.discount,mpro.start_date mprostartdate,mpro.end_date mproenddate,mpro.is_active mproisactive
from mp_product mp
LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id 
            from mp_product_images mpi 
            group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x
on x.mp_product_id=mp.mp_product_id
LEFT JOIN mp_product_variant mpv on mp.mp_product_id=mpv.mp_product_id
LEFT JOIN mp_category mc ON mpv.mp_category_id=mc.mp_category_id
LEFT JOIN mp_promotions mpro ON mpro.p_id=mp.mp_product_id" . $wish1 . " 
LEFT JOIN (select p_id,mp_product_id mpid,discount dis,is_active aval from 
            mp_promotions where CURRENT_DATE>start_date and CURRENT_DATE<end_date and is_active=1 and is_trash='N') s ON s.mpid=mp.mp_product_id
WHERE mp.status='A' and mp.qty>0";


            $ord = "mp.main_order asc";

            // SQL With catid or Not
            if ($request->catid == ""):
                $sql .= "";
            else:
                $sql .= " and mp.mp_category_id in (" . $dp[0]->cid . ")";
                $viewcount = [
                    'mp_category_id' => $request->catid,
                    'device_type' => $request->device_type,
                    'created_date' => date('Y-m-d H:i:s'),
                ];
                DB::table('mp_category_view_counter')->insert($viewcount);
            endif;
        endif;


        // Search Data
        if ($request->searchval == ""):
            $sql .= "";
        else:
            $sql .= "  and mp.qty>0 and (lower(mp.product_description) LIKE '%" . strtolower($request->searchval) . "%' or lower(mp.product_name) LIKE '%" . strtolower($request->searchval) . "%')";
        endif;

        // Feature Product
        if ($request->FP == ""):
            $sql .= "";
        elseif ($request->FP == "1"):
            $sql .= "  and mp.is_features=1";
        endif;

        // Ordering Data
        if ($request->orders == ""):
            $sqlordes = " ORDER BY " . $ord;
        else:
            // Order selling_price Low to High
            if ($request->orders == "LH"):
                $sl = "mp.selling_price ASC"; // Added ',' Here (Harish)
            // Order selling_price High to low
            elseif ($request->orders == "HL"):
                $sl = "mp.selling_price DESC"; // Added ',' Here (Harish)
            // Order New Arrival
            else:
                if ($request->FP == ""):
                    $sl = "mp.is_features desc,mp.mp_product_id DESC";
                elseif ($request->FP == "1"):
                    $sl = "mp.is_features desc,mp.mp_product_id DESC";
                elseif ($request->FP == "2"):
                    $sl = "mp.mp_product_id DESC";
                endif;
            endif;
            $sqlordes = " ORDER BY " . $sl;
        endif;

        // Filltering Data
        if (!array_filter($con)):
            $sql .= " GROUP BY mp.mp_product_id ";
            if ($sqldishave != ""):
                $sql .= "HAVING " . $sqldishave;
            endif;
        else:
            $cnt = 0;
            $pcnt = 0;
            for ($i = 0; $i < count($con); $i++):
                if (array_values($con)[$i] != ""):
                    if (array_keys($con)[$i] == 'Price'):
                        $ps = explode(',', array_values($con)[$i]);
                        $sql .= " and (" . array_values($key)[$i] . " between " . $ps[0] . " and " . $ps[1] . ") GROUP BY mp.mp_product_id ";
                        $pcnt++;
                    else:
                        $comma = explode(',', array_values($con)[$i]);

                        if ($cnt == 0):
                            if ($pcnt == 0):
                                $operator = " GROUP By mp.mp_product_id HAVING ";
                            else:
                                $operator = " HAVING ";
                            endif;
                        else:
                            $operator = "and";
                        endif;
                        $sql .= $operator . " (";
                        for ($s = 0; $s < count($comma); $s++):
                            $op = " or";
                            if ($s == count($comma) - 1):
                                $op = " ";
                            endif;
                            $sql .= " FIND_IN_SET('" . $comma[$s] . "'," . array_keys($con)[$i] . ") " . $op;
                        endfor;
                        $sql .= " )";
                        $cnt++;

                    endif;
                endif;
            endfor;
            if ($sqldishave == ""):
                $sql .= "";
            else:
                $sql .= " and " . $sqldishave;
            endif;

        endif;


        // End Length
//        if ($request->end == ""):
        $end = 12;
//        else:
//            $end = $request->end;
//        endif;
        // Start Length
        if ($request->start == "" || $request->start == 0):
            $start = 0;
        else:
            $start = ($request->start * 12);
        endif;



        // Length
        $sql .= $sqlordes . " LIMIT " . $end . " OFFSET " . $start;
//        $sql .= $sqlordes ;
//        echo $sql;
//        die;

        $data = DB::select($sql);
        echo json_encode($data);
    }

    public function detailProduct(Request $request) {
        // wishlist data
        if ($request->userid == ""):
            $wish = array(array('wishlist' => 0));
            if ($request->devaiceid != "") {
                $c = "select (CASE WHEN find_in_set('" . $request->devaiceid . "',GROUP_CONCAT(DISTINCT(mpcr.user_id))) is null or find_in_set('" . $request->devaiceid . "',GROUP_CONCAT(DISTINCT(mpcr.user_id)))=0 THEN 0 ELSE 1 END) as cart from mp_cart_temp mpcr where mpcr.product_id=" . $request->proid;
                $cart = DB::Select($c);
            } else {
                $cart = array(array('cart' => 0));
            }
        else:
            $w = "select (CASE WHEN find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpw.user_id))) is null or find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpw.user_id)))=0 THEN 0 ELSE 1 END) as wishlist from mp_wishlist mpw where mpw.product_id=" . $request->proid;
            $wish = DB::Select($w);
            $c = " select (CASE WHEN find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpcr.user_id))) is null or find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpcr.user_id)))=0 THEN 0 ELSE 1 END) as cart from mp_cart mpcr where mpcr.product_id=" . $request->proid;
            $cart = DB::Select($c);
        endif;

        $pro = "select if(s.p_id is null,0,s.p_id) promo_id,if(s.aval is null,0,1) avals,s.dis,mp.mp_product_id,mp.mp_category_id,mp.product_name,mp.product_description,mp.sku_number,mp.qty,mp.likes_count,mp.list_price,mp.selling_price,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount from mp_product mp LEFT JOIN (select p_id,mp_product_id mpid,discount dis,is_active aval from mp_promotions where CURRENT_DATE > start_date and CURRENT_DATE < end_date and is_active=1 and is_trash='N') s ON s.mpid=mp.mp_product_id where mp.status='A' AND mp.qty>0 AND mp.mp_product_id=" . $request->proid;
        $product = DB::Select($pro);
        $img = "select mpi.image_name from mp_product_images mpi WHERE mpi.mp_product_id=" . $request->proid . " order by mpi.mp_product_images_id";
        $image = DB::Select($img);
        $var = "select TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=1,mv.title,'')))) as Color,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=2,mv.title,'')))) as Size,
TRIM(BOTH ',' FROM GROUP_CONCAT(DISTINCT(IF(mpv.mp_attributes_id=3,mv.title,'')))) as Occasion
from mp_product_variant mpv LEFT JOIN mp_variant mv ON mv.mp_variant_id=mpv.mp_variant_id
where mpv.mp_attributes_id in (1,2,3) and mpv.mp_product_id=" . $request->proid;
        $variant = DB::Select($var);

        $viewcount = [
            'mp_product_id' => $request->proid,
            'device_type' => $request->device_type,
            'created_date' => date('Y-m-d H:i:s'),
        ];
        DB::table('mp_product_view_counter')->insert($viewcount);

        if (count($product) > 0) {
            $sql = "SELECT mp.*,(SELECT mpi.image_name FROM mp_product_images mpi WHERE mpi.mp_product_id=mp.mp_product_id ORDER BY mpi.mp_product_images_id LIMIT 1) image_name
FROM mp_product mp
WHERE mp.mp_product_id!=" . $request->proid . " and mp.mp_category_id=" . $product[0]->mp_category_id . " order by RAND() limit 8";
            $related = DB::Select($sql);
        } else {
            $related = array();
        }
//        $related = array();
        echo json_encode(array('wishlist' => $wish, 'cart' => $cart, 'product' => $product, 'image' => $image, 'variant' => $variant, 'related' => $related), JSON_PRETTY_PRINT);
    }

    public function updateProductQty(Request $request) {

        if (isset($request->qty) && $request->qty != "") {
            if (is_numeric($request->qty)) {
                if (isset($request->pid) && $request->pid != "") {
                    if (is_numeric($request->qty)) {
                        $qty = $request->qty;
                        if ($request->ptyp == 'M') {
                            $sql = "select mp.mp_product_id,mp.qty as proqry,mp.selling_price from mp_product mp WHERE mp.mp_product_id=" . $request->pid . " GROUP BY mp.mp_product_id";
                            $q = DB::Select($sql);
                            if (count($q) > 0) {
                                if ($qty > 0) {
                                    echo json_encode(array('success' => '1', 'error' => '', 'qty' => $qty,));
                                } else {
                                    echo json_encode(array('success' => '2', 'error' => 'Quantity Mastbe Grater Then 1 '));
                                }
                            } else {
                                echo json_encode(array('success' => '2', 'error' => 'Sorry Something Went wrong Please try again latter'));
                            }
                        } else {
                            $sql = "select mp.mp_product_id,mp.qty as proqry,mp.selling_price from  mp_product mp WHERE mp.mp_product_id=" . $request->pid . " GROUP BY mp.mp_product_id";
                            $q = DB::Select($sql);
                            if (count($q) > 0) {
//                    $cq = $q[0]->cartqty;
                                if ($qty > 0) {


                                    $pq = $q[0]->proqry;
                                    if ($qty <= $pq) {
                                        if ($qty > 4) {
                                            echo json_encode(array('success' => '2', 'error' => 'For more then 4 quantity Contect for wholesale inquiry'));
                                        } else {
                                            echo json_encode(array('success' => '1', 'error' => '', 'qty' => $qty));
                                        }
                                    } else {
                                        echo json_encode(array('success' => '2', 'error' => 'Not Enough Quantity Available'));
                                    }
                                } else {
                                    echo json_encode(array('success' => '2', 'error' => 'Quantity Mastbe Grater Then 1 '));
                                }
                            } else {
                                echo json_encode(array('success' => '2', 'error' => 'Invalid Cart Entry'));
                            }
                        }
                    } else {
                        echo json_encode(array('success' => '2', 'error' => 'Product Id Mustbe In Digit'));
                    }
                } else {
                    echo json_encode(array('success' => '2', 'error' => 'Product Id  Enter Quantity '));
                }
            } else {
                echo json_encode(array('success' => '2', 'error' => 'Quantity Mustbe In Digit'));
            }
        } else {
            echo json_encode(array('success' => '2', 'error' => 'Please Enter Quantity '));
        }
    }

    //Wishlist Operation

    public function addWishlist(Request $request) {
        $sq = "select * from mp_wishlist WHERE product_id=" . $request->pid . " and user_id=" . $request->uid;
        $ds = DB::select($sq);
        if (count($ds) > 0) {

            $sql1 = "delete from mp_wishlist WHERE product_id=" . $request->pid . " and user_id=" . $request->uid;
            DB::delete($sql1);
            $sql2 = "update mp_product set likes_count=likes_count-1 WHERE mp_product_id=" . $request->pid;
            DB::update($sql2);
            $sql3 = "select likes_count from mp_product where mp_product_id=" . $request->pid;
            $rs = DB::Select($sql3);
            echo json_encode(array('success' => '0', 'likes_count' => $rs[0]->likes_count));
        } else {
            $data = array(
                'product_id' => $request->pid,
                'user_id' => $request->uid,
                'status' => 'A',
                'device_type' => $request->device_type,
                'timestamp' => date('Y-m-d H:i:s'),
            );
            $lid = DB::table('mp_wishlist')->insertGetId($data);
            $sql = "update mp_product set likes_count=likes_count+1 WHERE mp_product_id=" . $request->pid;
            DB::update($sql);
            $sql1 = "select likes_count from mp_product where mp_product_id=" . $request->pid;
            $rs = DB::Select($sql1);
            echo json_encode(array('success' => '1', 'likes_count' => $rs[0]->likes_count));
        }
    }

    public function showWishlist(Request $request) {
        if (isset($request->uid) && $request->uid != "") {
            $sql = "SELECT mp.mp_product_id,mp.product_name,mp.qty,mp.list_price,mp.selling_price,mp.likes_count,x.image
FROM mp_wishlist mw
LEFT JOIN mp_product mp ON mp.mp_product_id=mw.product_id
LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x ON x.mp_product_id=mp.mp_product_id
WHERE mw.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
            $data = DB::select($sql);
        } else {
            $data = array();
        }
        echo json_encode($data);
    }

    //Cart Operation

    public function addCart(Request $request) {
        if (isset($request->uid) && $request->uid == "") {
            $chk = DB::select("select * from mp_cart_temp where user_id='" . $request->did . "' and product_id=" . $request->pid);
            if (count($chk) > 0) {
                $sql = "select * from mp_cart_temp WHERE user_id='" . $request->did . "'";
                $dt = DB::select($sql);
                echo json_encode(array('success' => '2', 'cnt' => count($dt), 'reply' => 'already in cart'));
            } else {
                $data = array(
                    'product_id' => $request->pid,
                    'user_id' => $request->did,
                    'qty' => $request->qty,
                    'status' => 'A',
                    'device_type' => $request->device_type,
                    'cdate' => date('Y-m-d H:i:s'),
                    'variant' => $request->variant,
                    'promo_id' => (isset($request->promo_id)) ? $request->promo_id : 0
                );
                $id = DB::table('mp_cart_temp')->insertGetId($data);
                if ($id) {
                    $sql = "select * from mp_cart_temp mc left JOIN mp_product mp ON  mc.product_id = mp.mp_product_id WHERE mc.user_id='" . $request->did . "'";
                    $dt = DB::select($sql);
                    $ppd = "N";
                    foreach ($dt as $d){
                        if($d->payment_option=="P"){
                            $ppd = "Y";
                        }
                    }

                    if($ppd=="Y"){
                        $payment_option="PPD";
                    } else {
                        $payment_option="COD";
                    }
                    echo json_encode(array('success' => '1', 'cnt' => count($dt), 'reply' => 'successfully add in cart','payment_option'=>$payment_option));
                } else {
                    $sql = "select * from mp_cart_temp mc left JOIN mp_product mp ON  mc.product_id = mp.mp_product_id WHERE mc.user_id='" . $request->did . "'";
                    $dt = DB::select($sql);
                    $ppd = "N";
                    foreach ($dt as $d){
                        if($d->payment_option=="P"){
                            $ppd = "Y";
                        }
                    }

                    if($ppd=="Y"){
                        $payment_option="PPD";
                    } else {
                        $payment_option="COD";
                    }
                    echo json_encode(array('success' => '2', 'cnt' => count($dt), 'reply' => 'sorry something went wrong please try again latter','payment_option'=>$payment_option));
                }
            }
        } else {
            $chk = DB::select("select * from mp_cart where user_id=" . $request->uid . " and product_id=" . $request->pid);
            if (count($chk) > 0) {
                $sql = "select * from mp_cart WHERE user_id='" . $request->uid . "'";
                $dt = DB::select($sql);
                echo json_encode(array('success' => '2', 'cnt' => count($dt), 'reply' => 'already in cart'));
            } else {
                $data = array(
                    'product_id' => $request->pid,
                    'user_id' => $request->uid,
                    'qty' => $request->qty,
                    'status' => 'A',
                    'cdate' => date('Y-m-d H:i:s'),
                    'device_type' => $request->device_type,
                    'variant' => $request->variant,
                    'promo_id' => (isset($request->promo_id)) ? $request->promo_id : 0
                );
                $id = DB::table('mp_cart')->insertGetId($data);
                if ($id) {
                    $sql = "select * from mp_cart mc left JOIN mp_product mp ON  mc.product_id = mp.mp_product_id WHERE mc.user_id=" . $request->uid;
                    $dt = DB::select($sql);
                    $ppd = "N";
                    foreach ($dt as $d){
                        if($d->payment_option=="P"){
                            $ppd = "Y";
                        }
                    }

                    if($ppd=="Y"){
                        $payment_option="PPD";
                    } else {
                        $payment_option="COD";
                    }
                    echo json_encode(array('success' => '1', 'cnt' => count($dt), 'reply' => 'successfully add in cart','payment_option'=>$payment_option));
                } else {
                    $sql = "select * from mp_cart mc left JOIN mp_product mp ON  mc.product_id = mp.mp_product_id WHERE mc.user_id='" . $request->uid . "'";
                    $dt = DB::select($sql);
                    $ppd = "N";
                    foreach ($dt as $d){
                        if($d->payment_option=="P"){
                            $ppd = "Y";
                        }
                    }

                    if($ppd=="Y"){
                        $payment_option="PPD";
                    } else {
                        $payment_option="COD";
                    }
                    echo json_encode(array('success' => '2', 'cnt' => count($dt), 'reply' => 'sorry something went wrong please try again latter','payment_option'=>$payment_option));
                }
            }
        }
    }

    public function showCart(Request $request) {
        if (isset($request->uid) && $request->uid == "") {
            $sql = "select if(mpro.p_id is NULL,0,if(CURRENT_DATE>mpro.start_date and CURRENT_DATE < mpro.end_date,1,0)) promo_status,mpro.discount dis,mp.payment_option,mc.variant,mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.list_price,mp.selling_price,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount,mp.likes_count,mp.qty as quantity
FROM mp_cart_temp mc
LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id
LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x
on x.mp_product_id=mp.mp_product_id
LEFT JOIN mp_promotions mpro ON mpro.p_id=mc.promo_id
WHERE mc.user_id='" . $request->did . "'
GROUP BY mp.mp_product_id";
            $data = DB::Select($sql);
//            echo "<pre>";
//            print_r($data);
//            die;

            $fdata =
            $ppd = "N";
            foreach ($data as $dt){
                if($dt->payment_option=="P"){
                    $ppd = "Y";
                }
            }

            if($ppd=="Y"){
                $payment_option="PPD";
            } else {
                $payment_option="COD";
            }

        } else {
            $sql1 = "select if(mpro.p_id is NULL,0,if(CURRENT_DATE>mpro.start_date and CURRENT_DATE < mpro.end_date,1,0)) promo_status,mpro.discount dis,mp.payment_option,mc.variant,mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.list_price,mp.selling_price,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount,mp.likes_count,mp.qty as quantity FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions mpro ON mpro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
            $data = DB::Select($sql1);
//            echo "<pre>";
//            print_r($data);
//            die;
            $ppd = "N";
            foreach ($data as $dt){
                if($dt->payment_option=="P"){
                    $ppd = "Y";
                }
            }

            if($ppd=="Y"){
                $payment_option="PPD";
            } else {
                $payment_option="COD";
            }
        }
        echo json_encode(array('productdetail' => $data,'payment_option'=>$payment_option));
    }

    public function countCart(Request $request) {
        if (isset($request->uid) && $request->uid == "") {
            $sql = " select * from mp_cart_temp where user_id='" . $request->did . "'";
            $data = DB::Select($sql);
            echo count($data);
        } else {
            $sql = " select * from mp_cart where user_id=" . $request->uid;
            $data = DB::Select($sql);
            echo count($data);
        }
    }

    public function removeCart(Request $request) {
        header('Content-Type: application/json; charset=utf-8');
        if (isset($request->uid) && $request->uid == "") {
            $sql = "delete from mp_cart_temp WHERE user_id='" . $request->did . "' and mp_cart_id=" . $request->cid;
            DB::Delete($sql);
            $sql = "select * from mp_cart_temp WHERE user_id='" . $request->did . "'";
            $dt = DB::select($sql);
            echo json_encode(array('success' => '1', 'cnt' => count($dt)));
        } else {
            $sql = "delete from mp_cart WHERE user_id=" . $request->uid . " and mp_cart_id=" . $request->cid;
            DB::Delete($sql);
            $sql = "select * from mp_cart WHERE user_id=" . $request->uid;
            $dt = DB::select($sql);
            echo json_encode(array('success' => '1', 'cnt' => count($dt)));
        }
    }

    public function updateCartQty(Request $request) {

        if (isset($request->uid) && $request->uid == "") {
            if ($request->ptyp == 'M') {
                $sql = "select mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,mp.qty as proqry,mp.selling_price FROM mp_cart_temp mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id WHERE mc.user_id='" . $request->did . "' and mc.product_id=" . $request->pid . " GROUP BY mp.mp_product_id";
                $q = DB::Select($sql);
                if (count($q) > 0) {
                    $cq = $q[0]->cartqty;
                    if ($cq > 1) {
                        $sql = "UPDATE mp_cart_temp SET qty=qty-1 WHERE mp_cart_id=" . $request->cid . " and user_id='" . $request->did . "'";
                        DB::Select($sql);
                        $sql1 = "select if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE<apro.end_date,1,0)) pro_status,apro.discount dis,act.* from mp_cart_temp act LEFT JOIN mp_promotions apro ON apro.p_id=act.promo_id WHERE act.mp_cart_id=" . $request->cid;
                        $rs = DB::Select($sql1);
                        $tot = $rs[0]->qty * $q[0]->selling_price;
                        if ($rs[0]->pro_status == 0):
                            $tot = $tot;
                        else:
                            $tot = $tot - (($tot * $rs[0]->dis) / 100);
                        endif;
                        echo json_encode(array('success' => '1', 'error' => '', 'qty' => $rs[0]->qty, 'total' => $tot));
                    } else {
                        echo json_encode(array('success' => '2', 'error' => 'Quantity Mastbe Grater Then 1 '));
                    }
                } else {
                    echo json_encode(array('success' => '2', 'error' => 'Invalid Cart Entry'));
                }
            } else {
                $sql = "select mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,mp.qty as proqry,mp.selling_price FROM mp_cart_temp mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id WHERE mc.user_id='" . $request->did . "' and mc.product_id=" . $request->pid . " GROUP BY mp.mp_product_id";
                $q = DB::Select($sql);
                if (count($q) > 0) {
                    $cq = $q[0]->cartqty;
                    $pq = $q[0]->proqry;
                    if ($cq <= $pq) {
                        if ($cq > 3) {
                            echo json_encode(array('success' => '2', 'error' => 'For more then 4 quantity Contect for wholesale inquiry'));
                        } else {
                            $sql = "UPDATE mp_cart_temp SET qty=qty+1 WHERE mp_cart_id=" . $request->cid . " and user_id='" . $request->did . "'";
                            DB::Select($sql);
                            $sql1 = "select if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE<apro.end_date,1,0)) pro_status,apro.discount dis,act.* from mp_cart_temp act LEFT JOIN mp_promotions apro ON apro.p_id=act.promo_id WHERE act.mp_cart_id=" . $request->cid;
                            $rs = DB::Select($sql1);
                            $tot = $rs[0]->qty * $q[0]->selling_price;
                            if ($rs[0]->pro_status == 0):
                                $tot = $tot;
                            else:
                                $tot = $tot - (($tot * $rs[0]->dis) / 100);
                            endif;
                            echo json_encode(array('success' => '1', 'error' => '', 'qty' => $rs[0]->qty, 'total' => $tot));
                        }
                    } else {
                        echo json_encode(array('success' => '2', 'error' => 'Not Enough Quantity Available'));
                    }
                } else {
                    echo json_encode(array('success' => '2', 'error' => 'Invalid Cart Entry'));
                }
            }
        } else {
            if ($request->ptyp == 'M') {
                $sql = "select mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,mp.qty as proqry,mp.selling_price FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id WHERE mc.user_id=" . $request->uid . " and mc.product_id=" . $request->pid . " GROUP BY mp.mp_product_id";
                $q = DB::Select($sql);
                if (count($q) > 0) {
                    $cq = $q[0]->cartqty;
                    if ($cq > 1) {
                        $sql1 = "UPDATE mp_cart SET qty=qty-1 WHERE mp_cart_id=" . $request->cid . " and user_id=" . $request->uid;
                        DB::Select($sql1);
                        $sql2 = "select if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE<apro.end_date,1,0)) pro_status,apro.discount dis,act.* from mp_cart act LEFT JOIN mp_promotions apro ON apro.p_id=act.promo_id WHERE act.mp_cart_id=" . $request->cid;
                        $rs = DB::Select($sql2);
                        $tot = $rs[0]->qty * $q[0]->selling_price;
                        if ($rs[0]->pro_status == 0):
                            $tot = $tot;
                        else:
                            $tot = $tot - (($tot * $rs[0]->dis) / 100);
                        endif;
                        echo json_encode(array('success' => '1', 'error' => '', 'qty' => $rs[0]->qty, 'total' => $tot));
                    } else {
                        echo json_encode(array('success' => '2', 'error' => 'Quantity Mastbe Grater Then 1 '));
                    }
                } else {
                    echo json_encode(array('success' => '2', 'error' => 'Invalid Cart Entry'));
                }
            } else {
                $sql = "select mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,mp.qty as proqry,mp.selling_price FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id WHERE mc.user_id=" . $request->uid . " and mc.product_id=" . $request->pid . " GROUP BY mp.mp_product_id";
                $q = DB::Select($sql);
                if (count($q) > 0) {
                    $cq = $q[0]->cartqty;
                    $pq = $q[0]->proqry;
                    if ($cq < $pq) {
                        if ($cq > 3) {
                            echo json_encode(array('success' => '2', 'error' => 'For more then 4 quantity Contect for wholesale inquiry'));
                        } else {
                            $sql = "UPDATE mp_cart SET qty=qty+1 WHERE mp_cart_id=" . $request->cid . " and user_id=" . $request->uid;
                            DB::Select($sql);
                            $sql2 = "select if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE<apro.end_date,1,0)) pro_status,apro.discount dis,act.* from mp_cart act LEFT JOIN mp_promotions apro ON apro.p_id=act.promo_id WHERE act.mp_cart_id=" . $request->cid;
                            $rs = DB::Select($sql2);
                            $tot = $rs[0]->qty * $q[0]->selling_price;
                            if ($rs[0]->pro_status == 0):
                                $tot = $tot;
                            else:
                                $tot = $tot - (($tot * $rs[0]->dis) / 100);
                            endif;
                            echo json_encode(array('success' => '1', 'error' => '', 'qty' => $rs[0]->qty, 'total' => $tot));
                        }
                    } else {
                        echo json_encode(array('success' => '2', 'error' => 'Not Enough Quantity Available'));
                    }
                } else {
                    echo json_encode(array('success' => '2', 'error' => 'Invalid Cart Entry'));
                }
            }
        }
    }

    public function wholesaleInquiry(Request $request) {
        if (isset($request->pid) && isset($request->name) && isset($request->email) && isset($request->mobile) && isset($request->message) && $request->pid == "" && $request->name == "" && $request->email == "" && $request->mobile == "" && $request->message == "") {
            echo '0';
        } else {
            $data = array(
                'product_id' => $request->pid,
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'message' => $request->message,
                'created_date' => date('Y-m-d H:i:s'),
                'status' => 'A'
            );
            
            DB::table('mp_wholesale_inquiry')->insertGetId($data);

            if ($request->mobile != ""):
                $prodts = "select * from mp_product where mp_product_id=" . $request->pid;
                $prodtslog = DB::Select($prodts);
                if (count($prodtslog) > 0):
                    $smscontaint = "Dear, " . $request->name . " Your inquiry for " . $prodtslog[0]->product_name . " has been successfully send. We contact You Soon. Thank you for interested with missethnik.";
                    $number = $request->mobile;
                    app('App\Http\Controllers\SMSModule')->sendSMS($number, $smscontaint);
                endif;
            endif;
            echo '1';
        }
    }

    public function checkoutCart(Request $request) {
        $cptot = 0;
        if ($request->code != "" && $request->code != "null") :
            $con = [
                'couponcode' => $request->code
            ];
            $res = DB::table('mp_manage_coupon')->where($con)->get();
            if (count($res) > 0):
                $checkcouponcodeused = DB::select('select * from mp_order where user_id=' . $request->uid . ' and coupon_code="' . $request->code . '"');
                if (count($checkcouponcodeused) == 0):
                    //coupan code
                    $sql1 = "select  CEIL(mp.selling_price * product_tax/ 100 ) tax, sum(if(apro.p_id is NULL,mc.qty * mp.selling_price,if(CURRENT_DATE > apro.start_date and CURRENT_DATE < apro.end_date,mc.qty * mp.selling_price-(((mc.qty * mp.selling_price)*apro.discount)/100),mc.qty * mp.selling_price))) itemtotalfinal FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid;
                    $totalamount = DB::select($sql1);
                    if (count($totalamount) > 0) :
                        if ($res[0]->min_limit <= $totalamount[0]->itemtotalfinal) :

                            if ($res[0]->flag == 3) {
                                $sql = "select CEIL(mp.selling_price * mp.product_tax / 100 ) tax,mp.cod_charge,mp.shipping_charge,mp.selling_price*mc.qty-CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty)) promodis,CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CASE WHEN mp.mp_category_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")ELSE CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))END) coupandis,(CASE WHEN mp.mp_category_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN 'Y' ELSE 'N' END) as apply,(CASE WHEN mp.mp_category_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")ELSE CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))END) as itemtotalfinal,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,mc.mp_cart_id,mc.product_id,mc.user_id,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.likes_count,mp.qty as quantity,mp.list_price,mp.selling_price,mc.qty as cartqty,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as firstdiscount,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
                                $data = DB::Select($sql);
                            } else if ($res[0]->flag == 2) {
                                $sql = "select CEIL(mp.selling_price * mp.product_tax / 100 ) tax,mp.cod_charge,mp.shipping_charge,mp.selling_price*mc.qty-CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty)) promodis,CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CASE WHEN mp.mp_product_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")ELSE CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))END) coupandis,(CASE WHEN mp.mp_product_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN 'Y' ELSE 'N' END) as apply,(CASE WHEN mp.mp_product_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")ELSE CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))END) as itemtotalfinal,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,mc.mp_cart_id,mc.product_id,mc.user_id,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.likes_count,mp.qty as quantity,mp.list_price,mp.selling_price,mc.qty as cartqty,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as firstdiscount,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
                                $data = DB::Select($sql);
                            } else {
                                $sql = "select CEIL(mp.selling_price * mp.product_tax / 100 ) tax,mp.cod_charge,mp.shipping_charge,mp.selling_price*mc.qty-CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty)) promodis,CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")) coupandis,if(1=1,'Y',1) apply,if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ") as itemtotalfinal,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,mc.mp_cart_id,mc.product_id,mc.user_id,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.likes_count,mp.qty as quantity,mp.list_price,mp.selling_price,mc.qty as cartqty,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as firstdiscount,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
                                $data = DB::Select($sql);
                            }

//                            echo $sql;

                            $sql1 = "SELECT * FROM mp_charges where type='COD' ORDER BY mp_charges_id desc limit 1";
                            $data1 = DB::Select($sql1);
                            $sql2 = "SELECT * FROM mp_charges where type='Shipping' ORDER BY mp_charges_id desc limit 1";
                            $data2 = DB::Select($sql2);

                            if (isset($request->ptyp) && $request->ptyp == "P") {
                                $total = 0;
                                $ship = 0;
                                $cod = 0;
                                $gst = 0;
                                $i = 0;
                                $coupandis = 0;
                                foreach ($data as $dt) {
                                    $cod += 0;
//                    $ship += $data2[0]->Charge;
                                    $ship += $dt->shipping_charge;
                                    $total += $dt->itemtotalfinal;
                                    $gst += $dt->tax;
                                    $data[$i]->Cod = 0;
//                    $data[$i]->Ship = $data2[0]->Charge;
                                    $data[$i]->Ship = $dt->shipping_charge;
                                    $data[$i]->Gst = $dt->tax;
                                    $i++;
                                    $coupandis += $dt->coupandis;
                                }
                            } else {
                                $total = 0;
                                $ship = 0;
                                $cod = 0;
                                $i = 0;
                                $coupandis = 0;
                                foreach ($data as $dt) {
                                    //                    $cod += $data1[0]->Charge;
                                    $cod += $dt->cod_charge;
//                    $ship += $data2[0]->Charge;
                                    $ship += $dt->shipping_charge;
                                    $total += $dt->itemtotalfinal;
                                    $gst += $dt->tax;
//                    $data[$i]->Cod = $data1[0]->Charge;
                                    $data[$i]->Cod = $dt->cod_charge;
//                    $data[$i]->Ship = $data2[0]->Charge;
                                    $data[$i]->Ship = $dt->shipping_charge;
                                    $data[$i]->Gst = $dt->tax;
                                    $i++;
                                    $coupandis += $dt->coupandis;
                                }
                            }

                            $tot = $cod + $ship + $total + $gst;
                            $cptot = $coupandis;
                            $msg = 'Coupon Successfully Applied';

                        else:
                            $sql = "select CEIL(mp.selling_price * mp.product_tax / 100 ) tax,mp.cod_charge,mp.shipping_charge,if(1=1,'N',1) apply,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,if(apro.p_id is NULL,mc.qty * mp.selling_price,if(CURRENT_DATE > apro.start_date and CURRENT_DATE < apro.end_date,mc.qty * mp.selling_price-(((mc.qty * mp.selling_price)*apro.discount)/100),mc.qty * mp.selling_price)) itemtotalfinal,mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.list_price,mp.selling_price,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount,  mp.likes_count,mp.qty as quantity FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
                            $data = DB::Select($sql);
                            $sql1 = "SELECT * FROM mp_charges where type='COD' ORDER BY mp_charges_id desc limit 1";
                            $data1 = DB::Select($sql1);
                            $sql2 = "SELECT * FROM mp_charges where type='Shipping' ORDER BY mp_charges_id desc limit 1";
                            $data2 = DB::Select($sql2);

                            if (isset($request->ptyp) && $request->ptyp == "P") {
                                $total = 0;
                                $ship = 0;
                                $cod = 0;
                                $gst = 0;
                                $i = 0;
                                foreach ($data as $dt) {
                                    $cod += 0;
//                    $ship += $data2[0]->Charge;
                                    $ship += $dt->shipping_charge;
                                    $total += $dt->itemtotalfinal;
                                    $gst += $dt->tax;
                                    $data[$i]->Cod = 0;
//                    $data[$i]->Ship = $data2[0]->Charge;
                                    $data[$i]->Ship = $dt->shipping_charge;
                                    $data[$i]->Gst = $dt->tax;
                                    $i++;
                                }
                            } else {
                                $total = 0;
                                $ship = 0;
                                $cod = 0;
                                $gst = 0;
                                $i = 0;
                                foreach ($data as $dt) {
                                    //                    $cod += $data1[0]->Charge;
                                    $cod += $dt->cod_charge;
//                    $ship += $data2[0]->Charge;
                                    $ship += $dt->shipping_charge;
                                    $total += $dt->itemtotalfinal;
                                    $gst += $dt->tax;
//                    $data[$i]->Cod = $data1[0]->Charge;
                                    $data[$i]->Cod = $dt->cod_charge;
//                    $data[$i]->Ship = $data2[0]->Charge;
                                    $data[$i]->Ship = $dt->shipping_charge;
                                    $data[$i]->Gst = $dt->tax;
                                    $i++;
                                }
                            }

                            $tot = $cod + $ship + $total + $gst;
                            $msg = 'Coupon will valid for minimum purchase of Rs.' . $res[0]->min_limit;
                        endif;

                    else:
                        $msg = "0";
                    endif;

                else:
                    $sql = "select CEIL(mp.selling_price * mp.product_tax / 100 ) tax,mp.cod_charge,mp.shipping_charge,if(1=1,'N',1) apply,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,if(apro.p_id is NULL,mc.qty * mp.selling_price,if(CURRENT_DATE > apro.start_date and CURRENT_DATE < apro.end_date,mc.qty * mp.selling_price-(((mc.qty * mp.selling_price)*apro.discount)/100),mc.qty * mp.selling_price)) itemtotalfinal,mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,x.image as image,mp.product_name,mp.product_description,mp.payment_option,mp.sku_number,mp.list_price,mp.selling_price,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount,  mp.likes_count,mp.qty as quantity FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
                    $data = DB::Select($sql);
                    $sql1 = "SELECT * FROM mp_charges where type='COD' ORDER BY mp_charges_id desc limit 1";
                    $data1 = DB::Select($sql1);
                    $sql2 = "SELECT * FROM mp_charges where type='Shipping' ORDER BY mp_charges_id desc limit 1";
                    $data2 = DB::Select($sql2);

                    if (isset($request->ptyp) && $request->ptyp == "P") {
                        $total = 0;
                        $ship = 0;
                        $cod = 0;
                        $gst = 0;
                        $i = 0;
                        foreach ($data as $dt) {
                            $cod += 0;
//                    $ship += $data2[0]->Charge;
                            $ship += $dt->shipping_charge;
                            $total += $dt->itemtotalfinal;
                            $gst+=$dt->tax;
                            $data[$i]->Cod = 0;
//                    $data[$i]->Ship = $data2[0]->Charge;
                            $data[$i]->Ship = $dt->shipping_charge;
                            $data[$i]->Gst = $dt->tax;
                            $i++;
                        }
                    } else {
                        $total = 0;
                        $ship = 0;
                        $cod = 0;
                        $gst = 0;
                        $i = 0;
                        foreach ($data as $dt) {
                            //                    $cod += $data1[0]->Charge;
                            $cod += $dt->cod_charge;
//                    $ship += $data2[0]->Charge;
                            $ship += $dt->shipping_charge;
                            $total += $dt->itemtotalfinal;
                            $gst+=$dt->tax;
//                    $data[$i]->Cod = $data1[0]->Charge;
                            $data[$i]->Cod = $dt->cod_charge;
//                    $data[$i]->Ship = $data2[0]->Charge;
                            $data[$i]->Ship = $dt->shipping_charge;
                            $data[$i]->Gst = $dt->tax;
                            $i++;
                        }
                    }

                    $tot = $cod + $ship + $total;
                    $msg = "Coupan Already Used..!";
                endif;

            else:
                $sql = "select CEIL(mp.selling_price * mp.product_tax / 100 ) tax,mp.cod_charge,mp.shipping_charge,if(1=1,'N',1) apply,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,if(apro.p_id is NULL,mc.qty * mp.selling_price,if(CURRENT_DATE > apro.start_date and CURRENT_DATE < apro.end_date,mc.qty * mp.selling_price-(((mc.qty * mp.selling_price)*apro.discount)/100),mc.qty * mp.selling_price)) itemtotalfinal,mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.payment_option,mp.list_price,mp.selling_price,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount,  mp.likes_count,mp.qty as quantity FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
                $data = DB::Select($sql);
                $sql1 = "SELECT * FROM mp_charges where type='COD' ORDER BY mp_charges_id desc limit 1";
                $data1 = DB::Select($sql1);
                $sql2 = "SELECT * FROM mp_charges where type='Shipping' ORDER BY mp_charges_id desc limit 1";
                $data2 = DB::Select($sql2);

                if (isset($request->ptyp) && $request->ptyp == "P") {
                    $total = 0;
                    $ship = 0;
                    $cod = 0;
                    $gst = 0;
                    $i = 0;
                    foreach ($data as $dt) {

                        $cod += 0;
//                    $ship += $data2[0]->Charge;
                        $ship += $dt->shipping_charge;
                        $total += $dt->itemtotalfinal;
                        $gst += $dt->tax;
                        $data[$i]->Cod = 0;
//                    $data[$i]->Ship = $data2[0]->Charge;
                        $data[$i]->Ship = $dt->shipping_charge;
                        $data[$i]->gst = $dt->tax;
                        $i++;
                    }
                } else {
                    $total = 0;
                    $ship = 0;
                    $cod = 0;
                    $gst = 0;
                    $i = 0;
                    foreach ($data as $dt) {
//                        $cod += $data1[0]->Charge;
                        $cod += $dt->cod_charge;
//                    $ship += $data2[0]->Charge;
                        $ship += $dt->shipping_charge;
                        $gst += $dt->tax;
                        $total += $dt->itemtotalfinal;
//                    $data[$i]->Cod = $data1[0]->Charge;
                        $data[$i]->Cod = $dt->cod_charge;
//                    $data[$i]->Ship = $data2[0]->Charge;
                        $data[$i]->Ship = $dt->shipping_charge;
                        $data[$i]->Gst = $dt->tax;
                        $i++;
                    }
                }

                $tot = $cod + $ship + $total + $gst;
                $msg = "Coupan Not Avalable..!";
            endif;

        else:

            $sql = "select CEIL(mp.selling_price * mp.product_tax / 100 ) tax,mp.cod_charge,mp.shipping_charge,if(1=1,'N',1) apply,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,if(apro.p_id is NULL,mc.qty * mp.selling_price,if(CURRENT_DATE > apro.start_date and CURRENT_DATE < apro.end_date,mc.qty * mp.selling_price-(((mc.qty * mp.selling_price)*apro.discount)/100),mc.qty * mp.selling_price)) itemtotalfinal,mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.payment_option,mp.list_price,mp.selling_price,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount,  mp.likes_count,mp.qty as quantity FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->uid . " GROUP BY mp.mp_product_id";
            $data = DB::Select($sql);
//            echo $sql;
            $sql1 = "SELECT * FROM mp_charges where type='COD' ORDER BY mp_charges_id desc limit 1";
            $data1 = DB::Select($sql1);
            $sql2 = "SELECT * FROM mp_charges where type='Shipping' ORDER BY mp_charges_id desc limit 1";
            $data2 = DB::Select($sql2);

            if (isset($request->ptyp) && $request->ptyp == "P") {
                $total = 0;
                $ship = 0;
                $cod = 0;
                $gst = 0;
                $i = 0;
                foreach ($data as $dt) {
                    $cod += 0;
//                    $ship += $data2[0]->Charge;
                    $ship += $dt->shipping_charge;
                    $total += $dt->itemtotalfinal;
                    $gst += $dt->tax;
                    $data[$i]->Cod = 0;
//                    $data[$i]->Ship = $data2[0]->Charge;
                    $data[$i]->Ship = $dt->shipping_charge;
                    $data[$i]->Gst = $dt->tax;
                    $i++;
                }
            } else {
                $total = 0;
                $ship = 0;
                $cod = 0;
                $gst = 0;
                $i = 0;
                foreach ($data as $dt) {
//                    $cod += $data1[0]->Charge;
                    $cod += $dt->cod_charge;
//                    $ship += $data2[0]->Charge;
                    $ship += $dt->shipping_charge;
                    $total += $dt->itemtotalfinal;
                    $gst += $dt->tax;
//                    $data[$i]->Cod = $data1[0]->Charge;
                    $data[$i]->Cod = $dt->cod_charge;
//                    $data[$i]->Ship = $data2[0]->Charge;
                    $data[$i]->Ship = $dt->shipping_charge;
                    $data[$i]->Gst = $dt->tax;
                    $i++;
                }
            }

            $tot = $cod + $ship + $total + $gst;
            $msg = "";
        endif;

        echo json_encode(array('productdetail' => $data, 'Total' => $total, 'TotalCOD' => $cod, 'TotalShip' => $ship, 'TotalGst' => $gst, 'CartTotal' => $tot, 'cpmsg' => $msg, 'cptotal' => $cptot));
    }

    //Address Operation

    public function getUserAddress(Request $request) {
        $sql = "select * from mp_users_profile where is_trash=0 and user_id=" . $request->uid;
        $data = DB::select($sql);
        echo json_encode($data);
    }

    public function getAddress(Request $request) {
        if (isset($request->uaid) && $request->uaid != "") {
            $sql = "select * from mp_users_profile where is_trash=0 and user_address_id=" . $request->uaid;
            $data = DB::select($sql);
            echo json_encode(array('success' => '1', 'data' => $data));
        } else {
            echo json_encode(array('success' => '2', 'data' => ''));
        }
    }

    public function addUserAddress(Request $request) {
        if ($request->is_default == 1):
            DB::table('mp_users_profile')
                    ->where('user_id', $request->uid)
                    ->update(['is_default' => 0]);
        endif;

        $addaddress = [
            'user_id' => $request->uid,
            'b_firstname' => $request->b_firstname,
            'b_lastname' => $request->b_lastname,
            'b_zipcode' => $request->b_zipcode,
            'b_address' => $request->b_address,
            'b_city' => $request->b_city,
            'b_state' => $request->b_state,
            'b_country' => $request->b_country,
            's_firstname' => $request->b_firstname,
            's_lastname' => $request->b_lastname,
            's_zipcode' => $request->b_zipcode,
            's_address' => $request->b_address,
            's_city' => $request->b_city,
            's_state' => $request->b_state,
            's_country' => $request->b_country,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_trash' => 0,
            'is_default' => $request->is_default,
            'is_same' => 'Y',
            'create_date' => date('Y-m-d H:i:s')
        ];

        DB::table('mp_users_profile')->insert($addaddress);
        $sql = "select * from mp_users_profile where user_id=" . $request->uid;
        $data = DB::select($sql);
        echo json_encode($data);
    }

    public function updateUserAddress(Request $request) {
        $addaddress = [
            'b_firstname' => $request->b_firstname,
            'b_lastname' => $request->b_lastname,
            'b_zipcode' => $request->b_zipcode,
            'b_address' => $request->b_address,
            'b_city' => $request->b_city,
            'b_state' => $request->b_state,
            'b_country' => $request->b_country,
            's_firstname' => $request->b_firstname,
            's_lastname' => $request->b_lastname,
            's_zipcode' => $request->b_zipcode,
            's_address' => $request->b_address,
            's_city' => $request->b_city,
            's_state' => $request->b_state,
            's_country' => $request->b_country,
            'phone' => $request->phone,
            'email' => $request->email,
            'is_trash' => 0,
//            'is_default' => $request->is_default,
            'is_same' => 'Y',
            'create_date' => date('Y-m-d H:i:s')
        ];
        $con = [
            'user_address_id' => $request->user_address_id
        ];
        DB::table('mp_users_profile')
                ->where($con)
                ->update($addaddress);
        $sql = "select * from mp_users_profile where is_trash=0 and user_id=" . $request->uid;
        $data = DB::select($sql);
        echo json_encode($data);
    }

    public function DeleteAddress(Request $request) {
        $addaddress = [
            'is_trash' => 1,
        ];
        $con = [
            'user_address_id' => $request->user_address_id
        ];
        DB::table('mp_users_profile')
                ->where($con)
                ->update($addaddress);
        echo 'Y';
    }

    public function setDefault(Request $request) {

        DB::table('mp_users_profile')
                ->where('user_id', $request->uid)
                ->update(['is_default' => 0]);
        $addaddress = [
            'is_default' => 1,
        ];
        $con = [
            'user_address_id' => $request->user_address_id
        ];
        DB::table('mp_users_profile')
                ->where($con)
                ->update($addaddress);
        echo 'Y';
    }

    public function pincode(Request $request) {
//        $URL = "http://s.evahanexpress.com/Traking/check_service/check_pincode";
        $URL = "http://s.evahan.in/Traking/Missethnik/check_pincode";
        $data = array(
            'to_pin_code' => $request->pin,
            'payment_type' => $request->type,
            'from_pin_code' => '395004',
            'from_city' => 'surat',
            'declared_value' => '500'
        );
        $postvars = '';
        foreach ($data as $key => $value) {
            $postvars .= $key . "=" . urlencode($value) . "&";
        }
        $dt = rtrim($postvars, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dt);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        $err = curl_error($ch);
        curl_close($ch);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result[] = json_decode($response, true);
            if (isset($result[0]['sucess'])) {
                if ($result[0]['sucess'] == "yes") {
                    $dts = "yes";
                } else {
                    $dts = "no";
                }
            } else {
                $dts = $result[0]['error'];
            }
            return $dts;
        }
    }

    // Order Operation

    public function placeOrder(Request $request) {
        if ($request->userid != ""):
            if ($request->addressid != ""):
                if ($request->pt == "P"):
                    if ($request->trasctionid != ""):
                        if ($request->code != "") :
                            $con = [
                                'couponcode' => $request->code
                            ];
                            $res = DB::table('mp_manage_coupon')->where($con)->get();
                            if (count($res) > 0):
                                $checkcouponcodeused = DB::select('select * from mp_order where user_id=' . $request->userid . ' and coupon_code="' . $request->code . '"');
                                if (count($checkcouponcodeused) == 0):
                                    $sql1 = "select mp.cod_charge,mp.shipping_charge,sum(if(apro.p_id is NULL,mc.qty * mp.selling_price,if(CURRENT_DATE > apro.start_date and CURRENT_DATE < apro.end_date,mc.qty * mp.selling_price-(((mc.qty * mp.selling_price)*apro.discount)/100),mc.qty * mp.selling_price))) itemtotalfinal FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->userid;
                                    $totalamount = DB::select($sql1);
                                    if (count($totalamount) > 0) :
                                        if ($res[0]->min_limit <= $totalamount[0]->itemtotalfinal) :
                                            $this->OrderProcess($request->userid, 'C', $res, 'PPD', $request->addressid, $request->trasctionid);
                                            $msg = "Order Place Successfully";
                                            $status = 1;
                                        else:
                                            $this->OrderProcess($request->userid, 'NC', '0', 'PPD', $request->addressid, $request->trasctionid);
                                            $msg = "Order Place Successfully";
                                            $status = 1;
                                        endif;
                                    else:
                                        echo "0";
                                    endif;
                                else:
                                    $this->OrderProcess($request->userid, 'NC', '0', 'PPD', $request->addressid, $request->trasctionid);
                                    $msg = "Order Place Successfully";
                                    $status = 1;
                                endif;
                            else:
                                $this->OrderProcess($request->userid, 'NC', '0', 'PPD', $request->addressid, $request->trasctionid);
                                $msg = "Order Place Successfully";
                                $status = 1;
                            endif;
                        else:
                            $this->OrderProcess($request->userid, 'NC', '0', 'PPD', $request->addressid, $request->trasctionid);
                            $msg = "Order Place Successfully";
                            $status = 1;
                        endif;
                    else:
                        $msg = "Transaction not competed please try again..!";
                        $status = 0;
                    endif;
                else:
                    if ($request->code != "") :
                        $con = [
                            'couponcode' => $request->code
                        ];
                        $res = DB::table('mp_manage_coupon')->where($con)->get();
                        if (count($res) > 0):
                            $checkcouponcodeused = DB::select('select * from mp_order where user_id=' . $request->userid . ' and coupon_code="' . $request->code . '"');
                            if (count($checkcouponcodeused) == 0):
                                $sql1 = "select mp.cod_charge,mp.shipping_charge,sum(if(apro.p_id is NULL,mc.qty * mp.selling_price,if(CURRENT_DATE > apro.start_date and CURRENT_DATE < apro.end_date,mc.qty * mp.selling_price-(((mc.qty * mp.selling_price)*apro.discount)/100),mc.qty * mp.selling_price))) itemtotalfinal FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $request->userid;
                                $totalamount = DB::select($sql1);
                                if (count($totalamount) > 0) :
                                    if ($res[0]->min_limit <= $totalamount[0]->itemtotalfinal) :
                                        $this->OrderProcess($request->userid, 'C', $res, 'COD', $request->addressid, 0);
                                        $msg = "Order Place Successfully";
                                        $status = 1;
                                    else:
                                        $this->OrderProcess($request->userid, 'NC', '0', 'COD', $request->addressid, 0);
                                        $msg = "Order Place Successfully";
                                        $status = 1;
                                    endif;
                                else:
                                    echo "0";
                                endif;
                            else:
                                $this->OrderProcess($request->userid, 'NC', '0', 'COD', $request->addressid, 0);
                                $msg = "Order Place Successfully";
                                $status = 1;
                            endif;
                        else:
                            $this->OrderProcess($request->userid, 'NC', '0', 'COD', $request->addressid, 0);
                            $msg = "Order Place Successfully";
                            $status = 1;
                        endif;
                    else:
                        $this->OrderProcess($request->userid, 'NC', '0', 'COD', $request->addressid, 0);
                        $msg = "Order Place Successfully";
                        $status = 1;
                    endif;
                endif;
            else:
                $msg = "Address Not Set..!";
                $status = 0;
            endif;
        else:
            $msg = "Something went wrong please try again...!";
            $status = 0;
        endif;
        echo json_encode(['status' => $status, 'msg' => $msg]);
    }

    public function OrderProcess($id, $types, $res, $pt, $addid, $tid) {
        if ($types == "C"):
            if ($res[0]->flag == 3) {
                $sql = "select mp.cod_charge,mp.shipping_charge,mc.variant,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,apro.p_id,0)) pro_id,mp.selling_price*mc.qty-CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty)) promodis,CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CASE WHEN mp.mp_category_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")ELSE CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))END) coupandis,(CASE WHEN mp.mp_category_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN 'Y' ELSE 'N' END) as apply,(CASE WHEN mp.mp_category_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")ELSE CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))END) as itemtotalfinal,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,mc.mp_cart_id,mc.product_id,mc.user_id,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.likes_count,mp.qty as quantity,mp.list_price,mp.selling_price,mc.qty as cartqty,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as firstdiscount,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $id . " GROUP BY mp.mp_product_id";
                $data = DB::Select($sql);
            } else if ($res[0]->flag == 2) {
                $sql = "select mp.cod_charge,mp.shipping_charge,mc.variant,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,apro.p_id,0)) pro_id,mp.selling_price*mc.qty-CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty)) promodis,CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CASE WHEN mp.mp_product_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")ELSE CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))END) coupandis,(CASE WHEN mp.mp_product_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN 'Y' ELSE 'N' END) as apply,(CASE WHEN mp.mp_product_id in ('" . str_replace(",", "','", $res[0]->type) . "') THEN if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")ELSE CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))END) as itemtotalfinal,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,mc.mp_cart_id,mc.product_id,mc.user_id,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.likes_count,mp.qty as quantity,mp.list_price,mp.selling_price,mc.qty as cartqty,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as firstdiscount,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $id . " GROUP BY mp.mp_product_id";
                $data = DB::Select($sql);
            } else {
                $sql = "select mp.cod_charge,mp.shipping_charge,mc.variant,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,apro.p_id,0)) pro_id,mp.selling_price*mc.qty-CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty)) promodis,CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ")) coupandis,if(1=1,'Y',1) apply,if(" . $res[0]->is_percent . "=1,CEIL(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-(CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))*" . $res[0]->offer . ")/100),CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty))-" . $res[0]->offer . ") as itemtotalfinal,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,mc.mp_cart_id,mc.product_id,mc.user_id,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.likes_count,mp.qty as quantity,mp.list_price,mp.selling_price,mc.qty as cartqty,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as firstdiscount,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $id . " GROUP BY mp.mp_product_id";
                $data = DB::Select($sql);
            }
        else:
            $sql = "select mp.cod_charge,mp.shipping_charge,mc.variant,if(1=1,0,0) coupandis,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,apro.p_id,0)) pro_id,mp.selling_price*mc.qty-CEIL(if(apro.is_active is NOT NULL,if(apro.is_active=1,if(apro.start_date<=CURRENT_DATE and apro.end_date>=CURRENT_DATE,(mp.selling_price-((mp.selling_price*apro.discount)/100))*mc.qty,mp.selling_price*mc.qty),mp.selling_price*mc.qty),mp.selling_price*mc.qty)) promodis,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,apro.p_id,0)) pro_id,if(1=1,'N',1) apply,if(apro.p_id is NULL,0,if(CURRENT_DATE>apro.start_date and CURRENT_DATE < apro.end_date,1,0)) promo_status,if(apro.p_id is NULL,mc.qty * mp.selling_price,if(CURRENT_DATE > apro.start_date and CURRENT_DATE < apro.end_date,mc.qty * mp.selling_price-(((mc.qty * mp.selling_price)*apro.discount)/100),mc.qty * mp.selling_price)) itemtotalfinal,mc.mp_cart_id,mc.product_id,mc.user_id,mc.qty as cartqty,x.image as image,mp.product_name,mp.product_description,mp.sku_number,mp.list_price,mp.selling_price,(mc.qty * mp.selling_price) as itemtotal,CEIL(((mp.list_price-mp.selling_price)/mp.list_price)*100) as discount,  mp.likes_count,mp.qty as quantity FROM mp_cart mc LEFT JOIN mp_product mp ON mp.mp_product_id=mc.product_id LEFT JOIN (select GROUP_CONCAT(DISTINCT(mpi.image_name)) as image,mpi.mp_product_images_id,mpi.mp_product_id from mp_product_images mpi group by mpi.mp_product_id order by mpi.mp_product_images_id ) as x on x.mp_product_id=mp.mp_product_id LEFT JOIN mp_promotions apro ON apro.p_id=mc.promo_id WHERE mc.user_id=" . $id . " GROUP BY mp.mp_product_id";
            $data = DB::Select($sql);
        endif;

        if ($pt == "PPD"):
            $sql2 = "SELECT * FROM mp_charges where type='Shipping' ORDER BY mp_charges_id desc limit 1";
            $data2 = DB::Select($sql2);
            $this->PpdOrderPro($data, $data2, $addid, $id, $pt, $tid);
        else:
            $sql1 = "SELECT * FROM mp_charges where type='COD' ORDER BY mp_charges_id desc limit 1";
            $data1 = DB::Select($sql1);
            $sql2 = "SELECT * FROM mp_charges where type='Shipping' ORDER BY mp_charges_id desc limit 1";
            $data2 = DB::Select($sql2);
            $this->CodOrderPro($data, $data1, $data2, $addid, $id, $pt, $tid);
        endif;
        $cons = [
            'user_id' => $id
        ];
        DB::table('mp_cart')->where($cons)->delete();
    }

    public function CodOrderPro($data, $data1, $data2, $addid, $uid, $pt, $tid) {
        foreach ($data as $dt) {

            $orderdatas = [
                'product_id' => $dt->product_id,
                'user_id' => $dt->user_id,
                'mp_user_profile_id' => $addid,
                'promo_id' => $dt->pro_id,
                'order_no' => '',
                'qty' => $dt->cartqty,
                'product_amount' => $dt->selling_price,
                'product_subtotal' => $dt->itemtotalfinal,
//                'product_total' => $dt->itemtotalfinal + $data1[0]->Charge + $data2[0]->Charge,
                'product_total' => $dt->itemtotalfinal + $dt->cod_charge + $dt->shipping_charge,
//                'shipping_charge' => $data2[0]->Charge,
                'shipping_charge' => $dt->shipping_charge,
//                'cod_charge' => $data1[0]->Charge,
                'cod_charge' => $dt->cod_charge,
                'promo_discount' => $dt->promodis,
                'coupon_code' => $dt->coupandis,
                'variant_name' => $dt->variant,
                'order_placed' => 'Y',
                'lsp_status' => 'N',
                'awb_no' => '',
                'log_status' => 0,
                'status' => 'P',
                'create_date' => date('Y-m-d H:i:s')
            ];
            $id = DB::table('mp_order')->insertGetId($orderdatas);
            $data = DB::Select("select * from mp_product where mp_product_id=" . $dt->product_id);
            $qtymin = [
                'qty' => $data[0]->qty - $dt->cartqty
            ];
            $con = [
                'mp_product_id' => $dt->product_id,
            ];

            DB::table('mp_product')
                    ->where($con)
                    ->update($qtymin);
            $log = [
                'code' => 'MISS001',
                'status_log' => 'Place Order Successfully',
                'order_id' => $id,
                'location' => 'Customer Self',
                'create_date' => date('Y-m-d H:i:s')
            ];
            DB::table('mp_order_log')->insert($log);
            $ordertran = [
                'order_id' => $id,
                'user_id' => $uid,
                'transaction_id' => $tid,
                'total' => $dt->itemtotalfinal + $data1[0]->Charge + $data2[0]->Charge,
                'payment_type' => substr($pt, 0, 1),
                'status' => 1,
                'create_date' => date('Y-m-d H:i:s')
            ];
            DB::table('mp_order_transactions')->insert($ordertran);

            $userdatas = "select * from mp_users_profile where user_address_id=" . $addid;
            $userdataslog = DB::Select($userdatas);
            if (count($userdataslog) > 0):
                if ($userdataslog[0]->phone != ""):
                    $prodts = "select * from mp_product where mp_product_id=" . $dt->product_id;
                    $prodtslog = DB::Select($prodts);
                    if (count($prodtslog) > 0):
                        $smscontaint = "Your order for " . $prodtslog[0]->product_name . " with order id: " . $id . " has been successfully placed. keep Rs." . ($dt->itemtotalfinal + $data1[0]->Charge + $data2[0]->Charge) . " ready. Thank you for shopping with missethnik.";
                        $number = $userdataslog[0]->phone;
                        app('App\Http\Controllers\SMSModule')->sendSMS($number, $smscontaint);
                    endif;
                endif;
            endif;
        }
    }

    public function PpdOrderPro($data, $data2, $addid, $uid, $pt, $tid) {
        foreach ($data as $dt) {
            $orderdatas = [
                'product_id' => $dt->product_id,
                'user_id' => $dt->user_id,
                'mp_user_profile_id' => $addid,
                'promo_id' => $dt->pro_id,
                'order_no' => '',
                'qty' => $dt->cartqty,
                'product_amount' => $dt->selling_price,
                'product_subtotal' => $dt->itemtotalfinal,
//                'product_total' => $dt->itemtotalfinal + $data2[0]->Charge,
                'product_total' => $dt->itemtotalfinal + $dt->shipping_charge,
//                'shipping_charge' => $data2[0]->Charge,
                'shipping_charge' => $dt->shipping_charge,
                'cod_charge' => 0,
                'promo_discount' => $dt->promodis,
                'coupon_code' => $dt->coupandis,
                'variant_name' => $dt->variant,
                'order_placed' => 'Y',
                'lsp_status' => 'N',
                'awb_no' => '',
                'log_status' => 0,
                'status' => 'P',
                'create_date' => date('Y-m-d H:i:s')
            ];
            $id = DB::table('mp_order')->insertGetId($orderdatas);

            $data = DB::Select("select * from mp_product where mp_product_id=" . $dt->product_id);

            $qtymin = [
                'qty' => $data[0]->qty - $dt->cartqty
            ];
            $con = [
                'mp_product_id' => $dt->product_id,
            ];

            DB::table('mp_product')
                    ->where($con)
                    ->update($qtymin);
            $log = [
                'code' => 'MISS001',
                'status_log' => 'Place Order Successfully',
                'order_id' => $id,
                'location' => 'Customer Self',
                'create_date' => date('Y-m-d H:i:s')
            ];
            DB::table('mp_order_log')->insert($log);
            $ordertran = [
                'order_id' => $id,
                'user_id' => $uid,
                'transaction_id' => $tid,
                'total' => $dt->itemtotalfinal + $data2[0]->Charge,
                'payment_type' => substr($pt, 0, 1),
                'status' => 1,
                'create_date' => date('Y-m-d H:i:s')
            ];
            DB::table('mp_order_transactions')->insert($ordertran);

//            $userdatas = "select * from mp_users_profile where user_address_id=" . $addid;
//            $userdataslog = DB::Select($userdatas);
//            if (count($userdataslog) > 0):
//                if ($userdataslog[0]->phone != ""):
//                    $prodts = "select * from mp_product where mp_product_id=" . $dt->product_id;
//                    $prodtslog = DB::Select($prodts);
//                    if (count($prodtslog) > 0):
//                        $smscontaint = "Your order for " . $prodtslog[0]->product_name . " with order id: " . $id . " your prepaid order has been successfully placed. Thank you for shopping with missethnik";
//                        $number = $userdataslog[0]->phone;
//                        app('App\Http\Controllers\SMSModule')->sendSMS($number, $smscontaint);
//                    endif;
//                endif;
//            endif;
        }
    }

    public function getFilterParamiterss(Request $request) {
        if (isset($request->cid) && $request->cid == "") {
            $data = array();
        } else {
            echo '<pre>';
            print_r($request->cid);
            echo '</pre>';
            exit();
            $sql = "select GROUP_CONCAT(DISTINCT(ma.name)) name,GROUP_CONCAT(DISTINCT(mv.mp_variant_id)) id ,GROUP_CONCAT(DISTINCT(mv.title)) title
from mp_attributes ma
LEFT JOIN mp_variant mv ON ma.mp_attributes_id=mv.mp_attributes_id
WHERE find_in_set(" . $request->cid . ",ma.category_path)
GROUP BY ma.mp_attributes_id";
            $data = DB::Select($sql);
        }
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit();
        $dis = array(
            'name' => 'disocunt',
            'id' => '>=,>=,>=,>=,>=,>=,>=',
            'title' => '30,40,50,60,70,80,90'
        );
        $dt1 = array_merge($data, array($dis));
        echo json_encode($dt1);
    }

    public function getFilterParamiter(Request $request) {
        if (isset($request->cid) && $request->cid != "") {

            $sql = "select DISTINCT(UPPER(ma.name)) as name,mv.mp_variant_id as id ,UPPER(mv.title) as title
from mp_attributes ma
LEFT JOIN mp_variant mv ON ma.mp_attributes_id=mv.mp_attributes_id
WHERE find_in_set(" . $request->cid . ",ma.category_path)";
            $data = DB::Select($sql);
            $sq = "SELECT GROUP_CONCAT(DISTINCT(mp_category_id)) mpid FROM mp_category WHERE parent_id=" . $request->cid;
            $data2 = DB::Select($sq);

            if ($data2[0]->mpid != "") {
                $sql1 = "SELECT MAX(selling_price) maxprice,MIN(selling_price) minprice FROM mp_product WHERE mp_category_id in (" . $data2[0]->mpid . ")";
            } else {
                $sql1 = "SELECT MAX(selling_price) maxprice,MIN(selling_price) minprice FROM mp_product WHERE mp_category_id=" . $request->cid;
            }

            $data1 = DB::Select($sql1);
        } else {

            $sql = "select DISTINCT(UPPER(ma.name)) as name,mv.mp_variant_id as id ,UPPER(mv.title) as title
from mp_attributes ma
LEFT JOIN mp_variant mv ON ma.mp_attributes_id=mv.mp_attributes_id";
            $data = DB::Select($sql);

            $sql1 = "SELECT MAX(selling_price) maxprice,MIN(selling_price) minprice FROM mp_product ";

            $data1 = DB::Select($sql1);
        }
        echo json_encode(array('filter' => $data, 'price' => $data1));
    }

    public function getMyOrder(Request $request) {
        $con = [
            'mo.user_id' => $request->userid
        ];
        if (!array_filter($con)) {
            $data = ['rep' => "Error"];
        } else {
            //mo.*
            //mo.mp_order_id,mo.order_no,mo.product_id,
            $orderdts = DB::Select('SELECT mo.*,mls.awb_no,mp.product_name,mot.create_date,'
                            . '(SELECT image_name FROM mp_product_images WHERE mp_product_id=mo.product_id and status="A" ORDER BY mp_product_images_id limit 1)image_name '
                            . 'FROM mp_order mo '
                            . 'LEFT JOIN mp_order_transactions mot ON mot.order_id=mo.mp_order_id '
                            . 'LEFT JOIN mp_lsp_shipment mls ON mls.order_id=mo.mp_order_id '
                            . 'LEFT JOIN mp_product mp ON mp.mp_product_id=mo.product_id '
                            . 'where mo.user_id=' . $request->userid . ' and mo.status ="' . $request->status . '" ORDER BY mo.mp_order_id desc');
//                ->where('mods.status', 'P')
//                ->orderBy('mods.item_id', 'desc')
            $data = ['rep' => $orderdts];
        }
        echo json_encode([$data]);
    }

    public function getMySingleOrder($request) {
//        $sql = "SELECT if(mo.status='C','C',if(mls.awb_no is null,if(DATE_FORMAT(DATE_ADD(mot.create_date, interval 1 day),'%Y-%m-%d')<CURRENT_DATE,'NR','CB'),if(CURRENT_DATE<=DATE_FORMAT(DATE_ADD(mot.create_date, interval 20 day),'%Y-%m-%d'),if((mls.is_intransit='1' and mls.is_delivered='0') or (mls.is_intransit is NULL) and (mls.is_delivered is NULL),if(DATE_FORMAT(DATE_ADD(mot.create_date, interval 1 day),'%Y-%m-%d')>CURRENT_DATE,'NR','CB'),if(mls.return_ship=0,'ROB','RP')),'NR'))) as final_status,DATE_FORMAT(mot.create_date, '%Y-%m-%d') as Order_date,GROUP_CONCAT(mv.title) variants,DATE_FORMAT(DATE_ADD(mot.create_date, interval 7 day),'%Y-%m-%d') as Return_date,mo.mp_order_id,mot.payment_type,mup.b_firstname,mup.b_lastname,mup.b_address,mup.b_zipcode,mup.phone,mo.qty,mp.product_name,x.image_name,mo.promo_discount,
//			mo.coupon_code,
//			mo.coupon_discount,mo.product_amount,mo.shipping_charge,mo.cod_charge,mo.product_subtotal,mo.product_total,mp.system_product_code,mp.sku_number,mls.awb_no,mls.date FROM mp_order mo LEFT JOIN mp_users_profile mup ON mup.user_address_id=mo.mp_user_profile_id LEFT JOIN mp_product mp ON mp.mp_product_id=mo.product_id LEFT JOIN mp_lsp_shipment mls ON mls.order_id=mo.mp_order_id left JOIN (select mo.product_id,mpi.image_name from mp_order mo LEFT JOIN mp_product_images mpi ON mpi.mp_product_id=mo.product_id where mp_order_id=" . $request . " order by mpi.mp_product_images_id desc limit 1) x ON x.product_id=mp.mp_product_id LEFT JOIN mp_variant mv ON FIND_IN_SET(mv.mp_variant_id,mo.variant) LEFT JOIN mp_order_transactions mot ON mot.order_id=mo.mp_order_id where mo.mp_order_id=" . $request;
        $sql = "SELECT 
            IF(
    mo.status = 'C',
    'C',
    IF(
      mls.awb_no IS NULL,
      IF(
        
          DATE_ADD(
            mot.create_date,
            INTERVAL 24 HOUR
          )
          < NOW(),
        'NR',
        'CB'
      ),
      IF(
        CURRENT_DATE <= DATE_FORMAT(
          DATE_ADD(
            mot.create_date,
            INTERVAL 20 DAY
          ),
          '%Y-%m-%d'
        ),
        IF(
          (
            mls.is_intransit = '1' AND mls.is_delivered = '0'
          ) OR(mls.is_intransit IS NULL) AND(mls.is_delivered IS NULL),
          IF(
              DATE_ADD(
                mot.create_date,
                INTERVAL 24 HOUR
              )
             < NOW(),
            'NR',
            'CB'
          ),
          IF(mls.return_ship = 0,
          'ROB',
          'RP')
        ),
        'NR'
      )
    )
  ) AS final_status,
DATE_FORMAT(mot.create_date, '%Y-%m-%d') as Order_date,
mo.variant_name variants,
DATE_FORMAT(DATE_ADD(mot.create_date, interval 7 day),'%Y-%m-%d') as Return_date,
mo.mp_order_id,
mot.payment_type,
mup.b_firstname,
mup.b_lastname,
mup.b_address,
mup.b_zipcode,
mup.phone,
mo.qty,
mp.product_name,
x.image_name,
mo.promo_discount,
			mo.coupon_code,
			mo.coupon_discount,
                        mo.product_amount,
                        mo.shipping_charge,
                        mo.cod_charge,
                        mo.product_subtotal,
                        mo.product_total,
                        mp.system_product_code,
                        mp.sku_number,
                        mls.awb_no,
                        mls.date 
			FROM mp_order mo 
			LEFT JOIN mp_users_profile mup ON mup.user_address_id=mo.mp_user_profile_id 
			LEFT JOIN mp_product mp ON mp.mp_product_id=mo.product_id 
			LEFT JOIN mp_lsp_shipment mls ON mls.order_id=mo.mp_order_id 
			left JOIN (select mo.product_id,mpi.image_name 
					from mp_order mo 
					LEFT JOIN mp_product_images mpi ON mpi.mp_product_id=mo.product_id 
					where mp_order_id=" . $request . " order by mpi.mp_product_images_id asc limit 1) x ON x.product_id=mp.mp_product_id 
					LEFT JOIN mp_order_transactions mot ON mot.order_id=mo.mp_order_id 
			where mo.mp_order_id=" . $request;
        $data = DB::select($sql);
        if ($data[0]->mp_order_id != "") {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

    public function cancelProduct(Request $request) {
//        echo $request->reason;
//        dd($request->all());
        $con = [
            'mp_order_id' => $request->oid,
            'status' => 'P'
        ];
        $itemdata = DB::table('mp_order')->where($con)->get();




        if (count($itemdata) > 0) {

            // Order table Change
            $con = [
                'mp_order_id' => $request->oid
            ];
            $chnages = [
                'status' => 'C',
                'cancel_reason' => $request->reason,
                'cancel_date' => date('Y-m-d H:i:s')
            ];
//            print_r($chnages);
//            die;
            DB::table('mp_order')->where($con)->update($chnages);

            // Product Qty Set
            $con1 = [
                'mp_product_id' => $itemdata[0]->product_id
            ];
            $proqty = DB::table('mp_product')->where($con1)->select('qty', 'product_name')->get();
            if (count($proqty) > 0) {
                $changeqty = [
                    'qty' => $proqty[0]->qty + $itemdata[0]->qty
                ];
                DB::table('mp_product')->where($con1)->update($changeqty);
            }

            $statuscode = [
                'code' => 'MISS111',
                'status_log' => 'Cancel By Customer',
                'order_id' => $request->oid,
                'location' => 'Customer Self',
                'create_date' => date('Y-m-d H:i:s'),
                'sys_date' => date('Y-m-d H:i:s')
            ];
            DB::table('mp_order_log')->insert($statuscode);

            $userdatas = "select * from mp_users_profile where user_address_id=" . $itemdata[0]->mp_user_profile_id;
            $userdataslog = DB::Select($userdatas);
            if (count($userdataslog) > 0):
                if ($userdataslog[0]->phone != ""):
                    if (count($proqty) > 0):
                        $smscontaint = "Your Order for " . $proqty[0]->product_name . ", with Order Id:" . $request->oid . " has been canceled and reason is " . $request->reason . ". for any other queries , contect customercare@missethnik.com";
                        $number = $userdataslog[0]->phone;
                        app('App\Http\Controllers\SMSModule')->sendSMS($number, $smscontaint);
                    endif;
                endif;
            endif;

            $data = [
                'rep' => "Product Cancel Successfully"
            ];
        }
        else {
            $data = [
                'rep' => "Some Problem"
            ];
        }
        echo json_encode($data);
    }

    public function GetMyOrderTrack($request) {
        $con = [
            'order_id' => $request
        ];
        $itemdata = DB::table('mp_order_log')->where($con)->orderBy('code', 'desc')->get();
        echo json_encode($itemdata);
    }

    public function returnMyOrder(Request $request) {
        if ($request->order_id != ""):
            if ($request->is_img == 1):
                $base64 = $request->image;
                if ($base64 == ""):
                    echo 0;
                else:
                    $destinationPath = $_SERVER['DOCUMENT_ROOT'] . '/returnimg';
//                    echo $destinationPath;
//                    die;

                    $fileName = "Returnresonimg" . $request->order_id . ".jpg";
                    $base64 = $request->image;

                    file_put_contents($destinationPath . '/' . $fileName, base64_decode($base64));

                    $statuscode = [
                        'order_id' => $request->order_id,
                        'user_id' => $request->user_id,
                        'reasons' => $request->reasons,
                        'crate_date' => date('Y-m-d H:i:s'),
                        'copy' => $fileName,
                        'payment_type' => $request->pt,
                        'bank' => $request->bank,
                        'account_no' => $request->accno,
                        'ifsc' => $request->ifsc,
                        'status' => 'P',
                        'track_id' => '',
                        'courier_services' => ''
                    ];
                    DB::table('mp_order_return')->insert($statuscode);
                    $data = [
                        'return_ship' => 1,
                        'updated_date' => date('Y-m-d H:i:s')
                    ];
                    $con = [
                        'order_id' => $request->order_id
                    ];
                    DB::table('mp_lsp_shipment')->where($con)->update($data);


                    $statuscode = [
                        'code' => 'MISS112',
                        'status_log' => 'Return Request By Customer',
                        'order_id' => $request->order_id,
                        'location' => 'Customer Self',
                        'create_date' => date('Y-m-d H:i:s'),
                        'sys_date' => date('Y-m-d H:i:s')
                    ];
                    DB::table('mp_order_log')->insert($statuscode);
                    echo 1;
                endif;
            else:
                $statuscode = [
                    'order_id' => $request->order_id,
                    'user_id' => $request->user_id,
                    'reasons' => $request->reasons,
                    'crate_date' => date('Y-m-d H:i:s'),
                    'copy' => '',
                    'payment_type' => $request->pt,
                    'bank' => $request->bank,
                    'account_no' => $request->accno,
                    'ifsc' => $request->ifsc,
                    'status' => 'P',
                    'track_id' => '',
                    'courier_services' => ''
                ];
                DB::table('mp_order_return')->insert($statuscode);
                $data = [
                    'return_ship' => 1,
                    'updated_date' => date('Y-m-d H:i:s')
                ];
                $con = [
                    'order_id' => $request->order_id
                ];
                DB::table('mp_lsp_shipment')->where($con)->update($data);

                $statuscode = [
                    'code' => 'MISS112',
                    'status_log' => 'Return Request By Customer',
                    'order_id' => $request->order_id,
                    'location' => 'Customer Self',
                    'create_date' => date('Y-m-d H:i:s'),
                    'sys_date' => date('Y-m-d H:i:s')
                ];
                DB::table('mp_order_log')->insert($statuscode);
                echo 1;
            endif;
        else:
            echo 0;
        endif;
    }

    public function getAllReturnOrder($request) {
        $con = [
            'user_id' => $request
        ];
        $itemdata = DB::table('mp_order_return')->where($con)->orderBy('mp_order_return_id', 'desc')->get();
        $data = [
            'rep' => $itemdata
        ];
        echo json_encode($data);
    }

    public function setReturnData(Request $request) {
        if ($request->order_id != ""):
            $data = [
                'status' => 'C',
                'track_id' => $request->tid,
                'courier_services' => $request->cs,
                'modify_date' => date('Y-m-d H:i:s')
            ];
            $con = [
                'order_id' => $request->order_id
            ];
            DB::table('mp_order_return')->where($con)->update($data);

            $statuscode = [
                'code' => 'MISS113',
                'status_log' => 'Courier Services Added By Customer',
                'order_id' => $request->order_id,
                'location' => 'Customer Self',
                'create_date' => date('Y-m-d H:i:s'),
                'sys_date' => date('Y-m-d H:i:s')
            ];
            DB::table('mp_order_log')->insert($statuscode);
            echo 1;
        else:
            echo 0;
        endif;
    }

    public function getBestSalePro(Request $request) {

        // End Length
        if ($request->end == ""):
            $end = 10;
        else:
            $end = $request->end;
        endif;

        // Start Length
        if ($request->start == "" || $request->start == 0):
            $start = 0;
        else:
            $start = ($request->start * 10) + 1;
        endif;
        
        if ($request->userid == ""):
            $wish = "(CASE WHEN 1=1 THEN 0 ELSE 1 END) as wishlist,";
            $wish1 = "";
        else:
            $wish = "(CASE WHEN find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpw.user_id))) is null or find_in_set(" . $request->userid . ",GROUP_CONCAT(DISTINCT(mpw.user_id)))=0 THEN 0 ELSE 1 END) as wishlist,";
            $wish1 = " LEFT JOIN mp_wishlist mpw ON mpw.product_id=mp.mp_product_id";
        endif;


        $qr = 'select '.$wish.'mp.*,
               (select mpi.image_name from mp_product_images mpi where mpi.mp_product_id = mp.mp_product_id ORDER BY  mpi.mp_product_id LIMIT 1) as image 
               from mp_product_view_counter mpvc 
               LEFT JOIN mp_product mp ON mp.mp_product_id = mpvc.mp_product_id '.$wish1.'
			   GROUP BY mpvc.mp_product_id having image!="" LIMIT ' . $start . ',' . $end . ' ';

        $data = DB::Select($qr);
        echo json_encode($data);
    }

    public function productRating(Request $request) {

        if (
                isset($request->userid) && $request->userid != "" && isset($request->title) && $request->title != "" && isset($request->productid) && $request->productid != "" && isset($request->rating) && $request->rating != "" && isset($request->desc) && $request->desc != ""
        ) {
            DB::table('mp_product_rating')->insert(
                    [
                        'user_id' => $request->userid,
                        'product_id' => $request->productid,
                        'rating' => $request->rating,
                        'title' => $request->title,
                        'description' => $request->desc,
                        'created_date' => date('Y-m-d H:i:s')
            ]);

            echo 1;
        } else {
            echo 0;
        }
    }

    public function getData(Request $request) {

//        print_r($request->all());
//        die;
        $datasA = [];
        $datasI = [];
        //$datasI[]="fFjnFjWRYuM:APA91bGPXtkQFlncWR6H6Qtb5kDZSReZsJvnb1fmKM1MufZlsXT2HRprl0cgq9jXzsRSAJz7ITEHLstPWxJNHWlbtymvfRNLrcy2XnatxMFE_WJib-THP4xEbty58NC1Nh-hIZiPXw5W";
        $allusers = DB::table('mp_customer')->where('status', 'A')->groupBy('fcm_id')->get();
        //$notifydata = DB::table($request->tbl)->where($request->tblfiled, $request->vals)->select('title', 'discount', 'image', 'category_id', 'mp_notification_id', 'discount_type')->first();
        foreach ($allusers as $dt):
            if ($dt->fcm_id != "") {
                
//                $notifydata = DB::table($request->tbl)->where($request->tblfiled, $request->vals)->select('title', 'discount', 'image', 'category_id', 'description', 'mp_notification_id', 'discount_type')->first();
//                $this->Notification(array_slice($datasA, 0, 999), $notifydata);
                $datasA[] = $dt->fcm_id;
//                $this->Notification($datasA, $notifydata);
//                if ($dt->media == "A") {
//                $datasA[] = $dt->fcm_id;
//                } else if ($dt->media == "I") {
//                    //$datasI[] = $dt->registration_key;
//                }
//                $this->Notification($dt->registration_key, $notifydata);
            }
        endforeach;



//        $datasA[]= 'eKa9q-HKXpA:APA91bGwMFhl-Xq_61Yn6Qxdbtzghb9u3-gI5PEjFXCDvMPTARF6AauVAQf-Ll1IEKzhup8ek9HJGGs8QnRb19OvA-rzG7_0VPu-dbjKN0mkEZpNoDkAzvaxwz7RMgBbUWdsDct1tLwY';


//        echo '<pre>';
//        print_r($datasA);
//        die;


        if (!empty($datasA)) {
            
            
//            $sql = "select title,discount from,image,category_id,mp_notification_id,discount_type from ".$request->tbl." where ".$request->tblfiled."=".$request->vals." and is_delete=0";
//            echo $sql;
////            $notifydata = DB::select("select title,discount from,image,category_id,mp_notification_id,discount_type from ".$request->tbl." where ".$request->tblfiled."=".$request->vals." and is_delete=0");
            $notifydata = DB::table($request->tbl)->where($request->tblfiled, $request->vals)->select('title', 'discount', 'image', 'category_id', 'description', 'mp_notification_id', 'discount_type')->first();
//            echo "<pre>";
//            print_r($notifydata);
//            die;
            $this->Notification(array_slice($datasA, 0,999), $notifydata);
        }
    }

    public function Notification($deviceid, $msg = []) {
//        echo "<pre>";
//        print_r($deviceid);
//        die;
        
        //$url = 'https://fcm.googleapis.com/fcm/send';
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $deviceid,
            //'notification' => ['title' => 'hello', 'body' => $msg],
            'data' => array("msg" => $msg)
        );
//        echo "<pre>";
//        print_r($fields);
//        die;

        $headers = array(
            'Authorization:key=AIzaSyC7DRO1agpPZWxTwJ-DXIIsf_H0cV3PuhU',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // echo json_encode($fields);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);

        echo "<pre>";
        print_r($result);

//        echo "<br>";
//        return $result;
        die;

        //$url = 'https://android.googleapis.com/gcm/send';
        //$url = 'https://ios.googleapis.com/fcm/send';
        //$did=explode(',',$deviceid);
        //$did[] = $deviceid;
        /* $fields = array(
          'registration_ids' => $deviceid,
          ['msg' => [$msg]],
          'data' => array("msg" => $msg),
          'data' => array('alert' => "Hello"),
          'content_available' => true,
          'priority' => "high",
          ); */

        //$dts = '{"to" : "bk3RNwTe3H0:CI2k_HHwgIpoDKCIZvvDMExUdFQ3P1...","priority" : "normal","notification" : {"body" : "This weeks edition is now available.","title" :"NewsMagazine.com","icon" : "new"},"data" : {"volume" : "3.21.15","contents" : "http://www.news-magazine.com/world-week/21659772"}}';
        //print_r($fields);

        /* define("GOOGLE_API_KEY", "AIzaSyAZTkYoKbZHFLaqCn69u9mR1TfnPCjod3U");
          define("GOOGLE_API_KEY", "AIzaSyCziwNvZzEklCgcX2JzzuKrUuHpsyA4fEk");
          define("GOOGLE_API_KEY", "AAAAnYPJirk:APA91bHBtRVUCG18YA9KNDemLgUQl91AhmGpNN9nwi2WpAROZLQWmJ4YlmLe2koON7DASN0AkCJaEIijqxbljw3vPDxrRW9uUUvG2vd6zmBMZU_s7CA9BFMlsTRIxQuDBgRWr0_MQMUe");
          $headers = array(
          'Authorization: key=' . GOOGLE_API_KEY,
          'Content-Type: application/json'
          ); */

        /* $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $dts);
          $result = curl_exec($ch); */

        /* if ($result === FALSE) {
          die('Curl failed: ' . curl_error($ch));
          }
          curl_close($ch);
          print_r($result);
          return $result; */
    }

}

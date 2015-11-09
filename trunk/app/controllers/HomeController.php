<?php

class HomeController extends BaseController
{
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */


    public function login()
    {
        ob_clean();
        ob_flush();
        
        if(Request::isMethod('GET'))
        {
            return View::make('home.login');
        }
        else
        {
            $rules = array(
                'username' => array('required'),
                'passwd' => array('required'),
                'captcha' => array('required', 'captcha'));
            $messages = array(
                'username.required' => '用户名必须填写',
                'passwd.required' => '密码必须填写',
                'captcha.required' => '验证码必须填写',
                'captcha.captcha' => '验证码错误',
            );

            $validator = Validator::make(Input::all(), $rules, $messages);
            if ($validator->fails())
            {
                $mb = $validator->getMessageBag();
                return Redirect::route('login')->withErrors($mb)->withInput();
            }
            else
            {
                $username = Input::get('username');
                $passwd = Input::get('passwd');
                $remember = Input::has('remember');
                $mb = new \Illuminate\Support\MessageBag();

                $encry_pwd = md5($username . $passwd);
                $customer = Customer::where('customer_name', $username)->first();
                if (empty($customer))
                {
                    $mb->add('username', '该用户不存在');
                    return Redirect::route('login')->withErrors($mb)->withInput();
                }

                if ($customer->customer_pwd != $encry_pwd)
                {
                    $mb->add('passwd', '密码错误');
                    return Redirect::route('login')->withErrors($mb)->withInput();
                }
                
                Auth::login($customer,$remember);
                return Redirect::intended();
                
                
            }
        }
    }
    
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
    
    

}

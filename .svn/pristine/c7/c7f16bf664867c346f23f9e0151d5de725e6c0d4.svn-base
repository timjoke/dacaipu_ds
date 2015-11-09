<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
        
        protected $dealer = null;
        
        public function __construct()
        {
            if(Auth::check())
            {
                $dealer = Session::get('dealer_info', null);
                if(empty($this->dealer))
                {
                    $dealer = Dealer::getByCustomerId(Auth::user()->customer_id);
                    $this->dealer = $dealer;
                }
            }
        }

}

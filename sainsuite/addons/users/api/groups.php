<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @author	    Buddy Winangun
 * @license	    MIT License. For full terms see the file LICENSE.
 * @link        https://github.com/saintekno/sainsuite
 * @filesource
 */
class groupsApiController extends MY_Api
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        $groups = $this->aauth->list_groups();

        return response()->json($groups, JSON_PRETTY_PRINT);
	}
}
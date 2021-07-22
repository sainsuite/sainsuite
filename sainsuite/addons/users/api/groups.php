<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @copyright   Copyright (c) 2019-2020 Buddy Winangun, Eracik.
 * @copyright   Copyright (c) 2020-2021 SainTekno, SainSuite.
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
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
class usersApiController extends MY_Api
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index($group_par = false)
	{
		// Get all users / by group
		$users = ($u = $this->aauth->list_users($group_par, ['banneds'=>true])) ? $u : [];

		foreach ($users as $row => $value) :
		$users[$row]['picture'] = User::get_user_image_url($value['id']);
		endforeach;

		return response()->json($users, JSON_PRETTY_PRINT);
	}

	public function get_user($id = false)
	{
		// Get single users with param id
        if (isset($_GET['id'])) {
			$result = (array) User::get($_GET['id']);
		}
		else {
			$result = (array) User::get($id);
		}
		$array['group'] = User::get_user_group($result['id']);
		$array['picture'] = User::get_user_image_url($result['id']);

		$response = array_merge($array, $result);
		return response()->json($response, JSON_PRETTY_PRINT);
	}
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @category    Libraries
 * @author      Yoga Pratama edited by Buddy Winangun
 * @license	    MIT License. For full terms see the file LICENSE.
 * @link        https://github.com/saintekno/sainsuite
 * @filesource
 */

class Autonumber {

	/**
	 * Id semula
	 * @var string
	 */
	protected $id = '';

	/**
	 * Awalan pada Id
	 * @var string
	 */
	protected $awalan = 'ID';

	/**
	 * Jumlah digit
	 * @var integer
	 */
	protected $digit = 3;

	/**
	 * Sertakan tanggal pada Id?
	 * @var boolean
	 */
	protected $tanggal = FALSE;

	// --------------------------------------------------------------------

	/**
	 * Config Auto_number
	 * 
	 * @param  array	$params	Initialization parameters
	 * @return Autonumber
	 */
	public function config(array $params = array())
	{
		foreach ($params as $key => $val)
		{
			$this->$key = $val;
		}
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Generate id baru
	 * @return string
	 */
	public function generate_id()
	{
		//Kondisi bila id sudah di set
		if(isset($this->id))
		{
			//Kondisi bila tanggal di set TRUE
			if($this->tanggal)
			{
				//Extract tanggal dari id
				$extract_tgl = substr($this->id, 0, 6);

				//Set awalan dengan tanggal
				$this->awalan = $extract_tgl;
			}

			//Extract nomor dari id
			$extract_no = substr($this->id, -$this->digit);

			//Casting nomor ke Integer
			$no = (int) $extract_no;

			//Set id
			$this->id = ++$no;
		}
		else
		{
			//Set id
			$this->id = 1;

			//Kondisi bila tanggal di set TRUE
			if($this->tanggal)
			{
				//Set awalan dengan tanggal
				$this->awalan = date("ymd");
			}
		}

		//Kondisi bila tanggal di set TRUE dan berbeda hari
		if($this->tanggal && $this->awalan !== date("ymd"))
		{
			$id_baru = str_pad(1, $this->digit, "0", STR_PAD_LEFT);
			$this->awalan = date("ymd");
		}
		else
		{
			$id_baru = str_pad($this->id, $this->digit, "0", STR_PAD_LEFT);
		}
		
		$result = $this->awalan . $id_baru;

		return $result;
	}
}
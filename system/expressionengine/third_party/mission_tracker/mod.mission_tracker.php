<?php
/*
=====================================================
PDF Press
-----------------------------------------------------
 http://www.anecka.com/pdf_press
-----------------------------------------------------
 Copyright (c) 2013 Patrick Pohler
=====================================================
 This software is based upon and derived from
 ExpressionEngine software protected under
 copyright dated 2004 - 2012. Please see
 http://expressionengine.com/docs/license.html
=====================================================
 File: mod.pdf_press.php
-----------------------------------------------------
 Dependencies: dompdf/
-----------------------------------------------------
 Purpose: Allows an EE template to be saved as a PDF
=====================================================
*/

if (! defined('BASEPATH')) exit('No direct script access allowed');

class Mission_tracker {
	
	function __construct() {	
		$this->EE =& get_instance();
	}
	
	function missions() {
		ee()->load->model('Mission');
		
		$variables = array();
		$missions = ee()->Mission->get_all_missions(true);
		
		$tagdata = ee()->TMPL->tagdata;
		
		foreach($missions as $mission) {
			$mission['last_item'] = (array_search($mission, $missions) == (sizeof($missions) -1) ? TRUE : FALSE);
			$variables[] = $mission;
		}
		
		$str = $this->EE->TMPL->parse_variables($tagdata, $variables);
		return $str;
	}
}
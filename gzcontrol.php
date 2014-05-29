<?php
/**
 * @copyright	Copyright (c) 2014 XS_NRG. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Compression (Gzip) control over BOTS Plugin
 *
 * @package		Gzontrol.Plugin
 * By	XS_NRG, github.com/dgt41
 */
class plgSystemGzcontrol extends JPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		parent::__construct($subject, $config);
	}
	
	function onAfterRoute()
	{

		$app = JFactory::getApplication();

		if ( $app->isAdmin() )
		{
			return;
		}

		$agent = false;
		
		if (isset($_SERVER['HTTP_USER_AGENT']))
		{
		/* Facebook User Agent
		 * facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)
		 * LinkedIn User Agent
		 * LinkedInBot/1.0 (compatible; Mozilla/5.0; Jakarta Commons-HttpClient/3.1 +http://www.linkedin.com)
		 */
		 
			$pattern = strtolower('/facebookexternalhit|LinkedInBot/x');
			
			// Check if more BOTs are specified
			if ($this->params->get('custom') != NULL )
			{
			$pattern = strtolower('/facebookexternalhit|LinkedInBot|' . $this->params->get('custom') .'/x');
			}
			
			if (preg_match($pattern, strtolower($_SERVER['HTTP_USER_AGENT'])))
			{
				$agent = true;
			}
		}

		if (($app->get('gzip') == 1) && ($agent))
		{
			$app->set('gzip', 0);
		}
	}
}

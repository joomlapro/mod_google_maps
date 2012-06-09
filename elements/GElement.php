<?php
/**
 * @package		Google Maps
 * @subpackage	mod_google_maps
 * @copyright	Copyright (C) AtomTech, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.html.parameter.element');

/**
 * Renders a google element
 */
class GElement extends JElement
{
	static function getParameters($mod = 'mod_google_maps')
	{
		static $params;
		
		$file = JPATH_SITE . 'modules/' . DS . $mod . DS . $mod . '.xml';
			
		if(!is_object($params) )
		{
			// Define variables
			$app = JFactory::getApplication();
			$id = JRequest::getInt('id');
			
			if ($id) {
				// Initialiase variables.
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				
				// Prepare query.
				$query->select('a.*');
				$query->from('#__modules AS a');
				$query->where('a.id = ' . $id);
				
				// Inject the query and load the result.
				$db->setQuery($query);
				$module = $db->loadObject();
				
				// Check for errors.
				if ($error = $db->getErrorMsg()) {
					$this->setError($error);
					$module = false;
					return $module;
				}

				$params = new JParameter($module->params, $file);
			} else {
				$params = new JParameter(null, $file);
			}
		}
		
		return $params;
	}
}
<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_tag2menu
 *
 * @copyright   Copyright (C) 2015 I-SAN.de. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the helper functions only once
require_once __DIR__ . '/helper.php';

$cacheparams = $params;
$cacheparams->cachemode = 'safeuri';
$cacheparams->class = 'ModTag2menuHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = array('id' => 'array', 'Itemid' => 'int');

$list = JModuleHelper::moduleCache($module, $params, $cacheparams);

if (!empty($list))
{

	// are there any tags chosen?
	$tagids = $params->get('tags');

	if (!empty($tagids))
	{
	    // get the params of the current page
	    $app = JFactory::getApplication();
	    $router = $app->getRouter();
	    $curTypeAlias = $router->getVar('option').'.'.$router->getVar('view');
	    $curId = strval($router->getVar('id'));


	    // get the params
	    $moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
	    $beforeHeadlines = $params->get('beforeHeadlines');
	    $afterHeadlines = $params->get('afterHeadlines');
	    $useNote = $params->get('useNote');

	    // We set $multiplecols to false here in order to have a default setting in the template
	    $multipleCols = false;

	    // The bootstrap version set by the user implies some other (hidden) settings
	    $bootstrapVersion = $params->get('bootstrapVersion');

			// get the settings regarding the bootstrap container
			$addBsContainer = $params->get('addBsContainer');
			$bootstrapContainer = $params->get('bootstrapContainer'); // 'container' or 'container-fluid'

			// set bootstrap class names according to version
	    switch($bootstrapVersion) {
		case 2:
			$bootstrapRow = 'row-fluid';
			$bootstrapCol = 'span';
			break;
		case 3:
			$bootstrapRow = 'row';
			$bootstrapCol = 'col-sm-';
			break;
		default:
			$bootstrapRow = '';
			$bootstrapCol = '';
			$bootstrapSize = '';
			break;
	    }

	    // load the layout
	    require JModuleHelper::getLayoutPath('mod_tag2menu', $params->get('layout', 'default'));
	}
}

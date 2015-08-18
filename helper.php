<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_tag2menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, , Inc. Modified by Christian Baur for use in mod_tag2menu. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_tag2menu
 *
 * @package     Joomla.Site
 * @subpackage  mod_tag2menu
 * @since       3.1
 */
abstract class ModTag2menuHelper
{
	/**
	 * Get list of tags
	 *
	 * @param   JRegistry  &$params  module parameters
	 *
	 * @return mixed
	 */
	public static function getList(&$params)
	{
		$db			= JFactory::getDbo();
		$user     		= JFactory::getUser();
		$groups 		= implode(',', $user->getAuthorisedViewLevels());
		$tags			= implode(',', $params->get('tags'));
		$maximum		= 1000;//$params->get('maximum', 1000);
		$nowDate		= $db->quote(JFactory::getDate()->toSql());
		$nullDate		= $db->quote($db->getNullDate());


		$query = $db->getQuery(true)
			->select(
				array(
					'MAX(' . $db->quoteName('tag_id') . ') AS tag_id',
					' COUNT(*) AS count', 'MAX(t.title) AS title',
					/*'MAX(' . $db->quoteName('t.access') . ') AS access',
					'MAX(' . $db->quoteName('t.alias') . ') AS alias',*/
					'MAX(' . $db->quoteName('t.note') . ') AS note'
				)
			)
			->group($db->quoteName(array('tag_id', 'title', /*'access', 'alias',*/ 'note')))
			->from($db->quoteName('#__contentitem_tag_map', 'm'))
			->where($db->quoteName('t.access') . ' IN (' . $groups . ')');

		// Only return published tags
		$query->where($db->quoteName('t.published') . ' = 1 ');
		
		// Only return tags in our list
		$query->where($db->quoteName('tag_id') . ' IN (' . $tags . ')');

		// Optionally filter on language
		$language = JComponentHelper::getParams('com_tags')->get('tag_list_language_filter', 'all');

		if ($language != 'all')
		{
			if ($language == 'current_language')
			{
				$language = JHelperContent::getCurrentLanguage();
			}

			$query->where($db->quoteName('t.language') . ' IN (' . $db->quote($language) . ', ' . $db->quote('*') . ')');
		}

		
		$query->join('INNER', $db->quoteName('#__tags', 't') . ' ON ' . $db->quoteName('tag_id') . ' = t.id')
			->join('INNER', $db->quoteName('#__ucm_content', 'c') . ' ON ' . $db->quoteName('m.core_content_id') . ' = ' . $db->quoteName('c.core_content_id'));

		$query->where($db->quoteName('m.type_alias') . ' = ' . $db->quoteName('c.core_type_alias'));

		// Only return tags connected to published articles
		$query->where($db->quoteName('c.core_state') . ' = 1')
			->where('(' . $db->quoteName('c.core_publish_up') . ' = ' . $nullDate . ' OR ' . $db->quoteName('c.core_publish_up') . ' <= ' . $nowDate . ')')
			->where('(' . $db->quoteName('c.core_publish_down') . ' = ' . $nullDate . ' OR  ' . $db->quoteName('c.core_publish_down') . ' >= ' . $nowDate . ')');
		$db->setQuery($query, 0, $maximum);
		$results = $db->loadObjectList();
		
		JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
		$helper = new JHelperTags;
		
		
		
		
		
		foreach($results as $tag){
			$query = $helper->getTagItemsQuery(
							   intval($tag->tag_id),
							   $typesr = null,
							   $includeChildren = false,
							   $orderByOption = 'c.core_title',
							   $orderDir = 'ASC',
							   $anyOrAll = true,
							   $languageFilter = 'all',
							   $stateFilter = '0,1'
							   );
			$db->setQuery($query, 0, 1000);
			$items = $db->loadObjectList();
			if($params->get('bootstrapVersion') > 1) { // 1 = no bootstrap
				$numItems = count($items);
				$bootstrapSize= $params->get('bootstrapSize');
				$maxItemsPerCol = $params->get('maxItems',999);
				$numCols = intval(ceil($numItems/$maxItemsPerCol));
				$multipleCols = false;
				$colSize = 0;
				if($numCols > 1) {
					$multipleCols = true;
					$colSize = intval(ceil($numItems/$numCols));//8
					$items = array_chunk($items, $colSize);
					$bootstrapSize = min(12,$numCols*$bootstrapSize);
				}
				$tag->multipleCols = $multipleCols;
				$tag->colSize = $colSize;
				$tag->numCols = $numCols;
				$tag->bootstrapSize = $bootstrapSize;
			}
			$tag->items = $items;
		}
		
		return $results;
	}
}

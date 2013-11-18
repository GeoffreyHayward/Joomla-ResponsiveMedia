<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.database.databasequery');

/**
 * @copyright (c) 2013, Geoffrey Hayward
 * @version 1.0.0
 * @license GNU General Public License version 2 or later; see LICENSE.txt
 */

class plgContentResponsiveMediaInstallerScript {

    public function postflight($type, $parent) {
        if (($type == 'install') || ($type == 'discover_install')){
            $db = JFactory::getDbo();
           try {
                $query = $db->getQuery(true);
                $query->update("#__extensions");
                $query->set("enabled = 1");
                $query->where("element = 'ResponsiveMedia'", 'AND');
                $query->where("type = 'plugin'", 'AND');
                $query->where("folder = 'content'");
                $db->setQuery($query);
                $db->execute();
           } catch (Exception $exception) {
                throw $exception;
           }
           JFactory::getCache()->clean();
        }
    }
}
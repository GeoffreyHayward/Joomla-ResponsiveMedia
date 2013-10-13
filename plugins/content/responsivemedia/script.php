<?php
defined('_JEXEC') or die('Restricted access');
 
class plg_ResponsiveMediaInstallerScript
{
    /**
     * Enable the plugin to true on install.
     */
    function postflight($type, $parent){
        $db = JFactory::getDbo();
        try
        {
           $query = $db->getQuery(true);
           $query->update('#__extensions');
           $query->set(array('enabled = 1'));
           $query->where("element = 'ResponsiveMedia'", 'AND');
           $query->where("type = 'plugin'", 'AND');
           $query->where("folder = 'content'");
           $db->setQuery($query);
           $db->execute();
        }
        catch (Exception $exception)
        {
           throw $exception;
        }
        return true;
    }
}
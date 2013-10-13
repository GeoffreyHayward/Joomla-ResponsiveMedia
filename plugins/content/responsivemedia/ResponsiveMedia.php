<?php 
defined('_JEXEC') or die('Restricted index access');
jimport('joomla.plugin.plugin'); 
 
/**
 * This Joomla plugin 'ResponsiveMedia' helps add rich embedded third-party media into 
 * Joomla articles. All media that is added through this plugin is ready for the
 * responsive web.
 * 
 * The CSS and HTML are based on research and work by Theirry Koblentz, 
 * Anders Andersen and Niklaus Gerber. Their work was kindly documented by Jeff Hobbs 
 * at http://embedresponsively.com/.
 * 
 * @author Geoffrey Hayward - http://geoffhayward.eu
 * 
 * @copyright (c) 2013, Geoffrey Hayward
 * @version 1.0.0
   @license GNU General Public License version 2 or later; see LICENSE.txt
 */
class plgContentResponsiveMedia extends JPlugin{
    
    public function onContentPrepare($context, $row, &$params, $page = 0){    
        if(preg_match_all('/{embed:(.*?):(.*?)}/', $row->text, $matches)){
            for($index = 0; $index < sizeof($matches[1]); $index++){
                if(method_exists($this, $matches[1][$index])){
                   $row->text = preg_replace('/{embed:'.$matches[1][$index].':'.$matches[2][$index].'}/', $this->$matches[1][$index]($matches[2][$index]), $row->text); 
                }
            }
            $doc = & JFactory::getDocument();
            $doc->addStyleSheet('media/plg_content_responsivemedia/responsive-media.css');
        }
    }

    private function youtube($item){
        return $this->credit("<div class=\"youtube-container\"><iframe src=\"http://www.youtube.com/embed/".$item."\" frameborder=\"0\" allowfullscreen></iframe></div>");
    }
    
    private function vimeo($item){
        return $this->credit("<div class=\"vimeo-container\"><iframe src=\"http://player.vimeo.com/video/".$item."\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>");
    }
    
    private function instagram($item){
        return $this->credit("<div class=\"instagram-container\"><iframe src=\"http://instagram.com/p/".$item."/embed/\" frameborder=\"0\" scrolling=\"no\" allowtransparency=\"true\"></iframe></div>");
    }
    private function credit($iframe){
        if($this->params->get("credit")){
            //Load the language values for JText key.
            $lang =& JFactory::getLanguage();
            $lang->load('plg_content_responsivemedia',JPATH_ADMINISTRATOR);
            return "<div class=\"responsive-media-credit\">".$iframe."<p>".JText::_("PLG_CONTENT_RESPONSIVEMEDIA_CREDIT_TEXT")."</p></div>";
        }else{
            return $iframe;
        }
    }
}

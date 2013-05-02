<?php
/*
 * Author  : EDP Development Team 
 * Version : 1.0
 */

if (!defined('_PS_VERSION_'))
    exit; 
    
class BlockFacebookLikeBox extends Module{
    public function __construct(){
        $this->name = 'blockfacebooklikebox';
        $this->tab  = 'front_office_features';
        $this->version = 1.0;
        $this->author = 'Airlangga bayu seto';
        $this->need_instance = 0;
     
        parent::__construct();
     
        $this->displayName = $this->l('Facebook like box');
        $this->description = $this->l('Blok untuk facebook like box [http://www.iso.web.id].');
    }
    
    public function install(){
        if (parent::install() == false 
        OR !$this->registerHook('leftColumn') 
        OR !$this->registerHook('top')
        OR !Configuration::updateGlobalValue('MOD_FBLIKEBOX_URL', '')
        OR !Configuration::updateGlobalValue('MOD_FBLIKEBOX_WIDTH', '202')
        OR !Configuration::updateGlobalValue('MOD_FBLIKEBOX_HEIGHT', '')
        OR !Configuration::updateGlobalValue('MOD_FBLIKEBOX_SHOWFACE', '')
        OR !Configuration::updateGlobalValue('MOD_FBLIKEBOX_SHOWSTREAM', '')
        OR !Configuration::updateGlobalValue('MOD_FBLIKEBOX_BORDER', '')
        OR !Configuration::updateGlobalValue('MOD_FBLIKEBOX_SHOWHEADER', '')
        )
          return false;
        return true;
    }
    
    public function uninstall(){
      if (!parent::uninstall() 
      OR !Configuration::deleteByName('MOD_FBLIKEBOX_URL')
      OR !Configuration::deleteByName('MOD_FBLIKEBOX_WIDTH')
      OR !Configuration::deleteByName('MOD_FBLIKEBOX_HEGHT')
      OR !Configuration::deleteByName('MOD_FBLIKEBOX_SHOWFACE')
      OR !Configuration::deleteByName('MOD_FBLIKEBOX_SHOWSTREAM')
      OR !Configuration::deleteByName('MOD_FBLIKEBOX_BORDER')
      OR !Configuration::deleteByName('MOD_FBLIKEBOX_SHOWHEADER')
      )
        return false;
      return true;
    }
    
    /* Configure */
    public function getContent(){
        $showface = (Configuration::get('MOD_FBLIKEBOX_SHOWFACE') == '1' )?"checked=\"checked\"":"";
        $showsream = (Configuration::get('MOD_FBLIKEBOX_SHOWSTREAM') == '1' )?"checked=\"checked\"":"";
        $showheader = (Configuration::get('MOD_FBLIKEBOX_SHOWHEAEDER') == '1' )?"checked=\"checked\"":"";
        
        if(Tools::isSubmit('submitBlockFB')){
            Configuration::updateGlobalValue('MOD_FBLIKEBOX_URL', $_POST['fburl']);
            Configuration::updateGlobalValue('MOD_FBLIKEBOX_WIDTH', $_POST['fbwidth']);
            Configuration::updateGlobalValue('MOD_FBLIKEBOX_HEGHT', $_POST['fbheight']);
            Configuration::updateGlobalValue('MOD_FBLIKEBOX_SHOWFACE', $_POST['fbshowface']);
            Configuration::updateGlobalValue('MOD_FBLIKEBOX_SHOWSTREAM', $_POST['fbshowstream']);
            Configuration::updateGlobalValue('MOD_FBLIKEBOX_BORDER', $_POST['fbborder']);
            Configuration::updateGlobalValue('MOD_FBLIKEBOX_SHOWHEADER', $_POST['fbshowheader']);
            
            return $this->displayConfirmation($this->l('Settings Facebook like box updated'));
        }
        
        $this->_html = "<form action=\"".Tools::safeOutput($_SERVER['REQUEST_URI'])."\" method=\"post\" >
        <fieldset>     
            <legend>".$this->displayName."</legend>
                <label>Facebook Name : </label>
                <input type=\"input\" name=\"fburl\" id=\"fburl\" style=\"border:1px solid #333;width:200px;height:23px;\" value=\"".Configuration::get('MOD_FBLIKEBOX_URL')."\" />
                <br /> <br />
                <label>Width : </label>
                <input type=\"input\" name=\"fbwidth\" id=\"fbwidth\" style=\"border:1px solid #333;width:80px;height:23px;\" value=\"".Configuration::get('MOD_FBLIKEBOX_WIDTH')."\" />
                <br /> <br />
                <label>Height : </label>
                <input type=\"input\" name=\"fbheight\" id=\"fbheight\" style=\"border:1px solid #333;width:80px;height:23px;\" value=\"".Configuration::get('MOD_FBLIKEBOX_HEIGHT')."\" />
                <br /> <br />
                <label>Show Face : </label>
                <input type=\"checkbox\" name=\"fbshowface\" id=\"fbshowface\"  value=\"1\" ". Tools::safeOutput($showface) ." />
                <br /> <br />
                <label>Show Stream : </label>
                <input type=\"checkbox\" name=\"fbshowstream\" id=\"fbshowstream\"  value=\"1\" ". Tools::safeOutput($showstream) ." />
                <br /> <br />
                <label>Border color : </label>
                <input type=\"input\" name=\"fbborder\" id=\"fbborder\" style=\"border:1px solid #333;width:80px;height:23px;\" value=\"".Configuration::get('MOD_FBLIKEBOX_BORDER')."\" /> Contoh : #000000 (warna hitam)
                <br /> <br />
                <label>Show Header : </label>
                <input type=\"checkbox\" name=\"fbshowheader\" id=\"fbshowheader\"  value=\"1\" ". Tools::safeOutput($showheader) ." />
                <br /> <br />
                <input type=\"submit\" name=\"submitBlockFB\" value=\"".$this->l('Submit')."\" class=\"button\" />
            </fieldset>
            </form>";
        
        return $this->_html;
    }
    
    
    /* Hook */
    public function hookTop($params){
        return $this->display(__FILE__, 'fbtop.tpl');
    }
    
    public function hookLeftColumn($params){
      
      $data = array(
        "fburl"     => Configuration::get('MOD_FBLIKEBOX_URL')
        ,"fbwidth"  => Configuration::get('MOD_FBLIKEBOX_WIDTH')
        ,"fbheight" => Configuration::get('MOD_FBLIKEBOX_HEIGHT')
        ,"showface" => Configuration::get('MOD_FBLIKEBOX_SHOWFACE')
        ,"showstream"   => Configuration::get('MOD_FBLIKEBOX_SHOWSTREAM')
        ,"fbborder" => Configuration::get('MOD_FBLIKEBOX_BORDER')
        ,"showheader"   => Configuration::get('MOD_FBLIKEBOX_SHOWHEADER')
      );
      $this->smarty->assign($data);
      return $this->display(__FILE__, 'fblikebox.tpl');
    }
}
?>
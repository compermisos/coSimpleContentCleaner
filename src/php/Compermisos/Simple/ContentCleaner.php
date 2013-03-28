<?php
/*
 
coSimpleContentCleaner is a simple class to clean user imput from XSS and SQL injection atack
 
coSimpleContentCleaner is a work in progress.
a simple example
 
<?php
$clean = new coSimpleContetnCleaner();
$cleanText = $clean->cleanText($userData);
?>
 
yes is ALL
*/
class ContentCleaner{
 
    private $darkText;
    private $ligthText;
    private $BannedWords;
 
    public function __construct(){
        $this->_restart();
        $this->_setBannedWords();
    }
 

    private function addBannedWords($word){
        $this->BannedWords[] = $word;
    }


    private function _restart(){
        $this->darkText = null;
        $this->ligthText = null;
    }


    public function setText($text){
        $this->darkText = $text;
        $this->ligthText = null;
    }


    public function getText(){
        return $this->ligthText;
    }


    public function cleanText($text){
        $this->_restart();
        $this->darkText = $text;
        $this->_cleanText();
        $data = $this->getText();
        $this->_restart();
        return $data;
    }


    public function cleanURL($url){
        $this->_restart();
        $this->darkText = $url;
        $this->_cleanURL();
        $data = $this->getText();
        $this->_restart();
        return $data;
    }


    private function _cleanText(){
        $this->_removeBannedWords();
        $this->_scapeChars();
        $this->_removeChars();
        $this->_removeSQLchars();
        $this->ligthText = $this->darkText;
    }

    private function _cleanURL(){
        $this->_removeBannedWords();
        $this->_scapeURLChars();
        $this->_removeChars();
        $this->ligthText = $this->darkText;
    }
    

    private function _scapeChars(){
        $this->darkText = htmlentities($this->darkText);
    }


    private function _scapeURLChars(){
        $this->darkText = urlencode($this->darkText);
    }


    private function _removeBannedWords(){
        $text = $this->darkText;
        shuffle($this->BannedWords);
        foreach ($this->BannedWords as $BannedWord) {
            $tip = TRUE;
            while($tip){
                /* to clean <sc<scriptript> atack
                    Tanks to Enrique A. Sanchez Montellano by the feedback*/
                $textB = str_replace($BannedWord, "", $text);
                if($text == $textB){
                    $tip = FALSE;
                }
                $text = $textB;
            }
        }
        $this->$darkText = $text;
    }


    private function _removeChars(){
        $this->darkText = $this->darkText;
    }


    private function _removeSQLchars(){
        #$this->darkText = @mysql_real_escape_string($this->darkText);
        $this->darkText = addslashes($this->darkText);
    }
    

    private function _setBannedWords(){
        $this->BannedWords = array('javascript', 'vbscript', 'expression', '<applet', '<meta', '<xml', '<blink', '<link', '<style','<script', '<embed', '<object', '<iframe', '<frame', '<frameset', '<ilayer', '<layer', '<bgsound', '<title', '<base','onabort', 'onactivate', 'onafterprint','onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus',  'onbeforepaste','onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu','oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate','ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate','onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup','onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover','onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset','onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect','onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload', "<?", "?>", "1=1");
	}

}

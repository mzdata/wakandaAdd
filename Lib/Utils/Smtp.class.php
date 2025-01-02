<?php
class SimpleMail
{/*{{{*/
    var $_to;
    var $_subject;
    var $_message;
    var $_headers;

    function SimpleMail($to='', $subject='', $message='', $headers='')
    {/*{{{*/
        $this->_to = array();
        if (is_array($to))
            $this->_to = $to;
        else if ('' != $to)
            array_push($this->_to, $to);
        else $this->_to = array();
        $this->_subject = $subject;
        $this->_message = $message;
        if (is_array($headers))
            $this->_headers = $headers;
        else $this->_headers = $this->defaultHeader();
    }/*}}}*/

    function addDestAddr($to)
    {/*{{{*/
        if (is_string($to))
        {
            array_push($this->_to, $to);
            return true;
        }
        return false;
    }/*}}}*/

    function setSubjecct($subject)
    {/*{{{*/
        if (is_string($subject))
        {
            $this->_subject = $subject;
            return true;
        }
        return false;
    }/*}}}*/

    function setMessage($message)
    {/*{{{*/
        if (is_string($message))
        {
            $this->_message = $message;
            return true;
        }
        return false;
    }/*}}}*/

    function setMIMEVer($MIMEVer)
    {/*{{{*/
        if (is_string($MIMEVer))
        {
            $this->_headers['MIMEVer'] = $MIMEVer;
            return true;
        }
        return false;
    }/*}}}*/

    function setContentType($contentType)
    {/*{{{*/
        if (is_string($contentType))
        {
            $this->_headers['ContentType'] = $contentType;
            return true;
        }
        return false;
    }/*}}}*/

    function setFromMail($from)
    {/*{{{*/
        if (is_string($from))
        {
            $this->_headers['From'] = $from;
            return true;
        }
        return false;
    }/*}}}*/

    function addCCMail($CC)
    {/*{{{*/
        if (is_string($CC))
        {
            $this->_headers['CC'][] = $CC;
            return true;
        }
        return false;
    }/*}}}*/

    function addBCCMail($BCC)
    {/*{{{*/
        if (is_string($BCC))
        {
            $this->_headers['BCC'][] = $BCC;
            return true;
        }
        return false;
    }/*}}}*/

    function send()
    {/*{{{*/
        if (!is_array($this->_to) || count($this->_to) <= 0)
            return false;
        $to = implode(",", $this->_to);
        if ($to == "")
            return false;
        if (($this->_subject == "") && 
            ($this->_message == ""))
            return false;
        $header = $this->getHeader();
        if ($header == "")
            return false;
        $ret = mail($to, $this->_subject, $this->_message, $header);
        return $ret;
    }/*}}}*/

    /* ==================== private function ==================== */

    function defaultHeader()
    {/*{{{*/
        $header = array();
        $header['MIMEVer'] = "1.0";
        $header['ContentType'] = "text/html; charset=gb2312";
        $header['From'] = "Web Master <wangning@qihoo.net";
        $header['CC'] = array();
        $header['BCC'] = array();
        return $header;
    }/*}}}*/

    function getHeader()
    {/*{{{*/
        $header = "";
        if (isset($this->_headers['MIMEVer']) && 
            ("" != $this->_headers['MIMEVer']))
        {
            $header .= "MIME-Version: ".$this->_headers['MIMEVer']."\r\n";
        }
        if (isset($this->_headers['ContentType']) && 
            ("" != $this->_headers['ContentType']))
        {
            $header .= "Content-type: ".$this->_headers['ContentType']."\r\n";
        }
        if (isset($this->_headers['From']) && 
            ("" != $this->_headers['From']))
        {
            $header .= "From: ".$this->_headers['From']."\r\n";
        }
        if (isset($this->_headers['CC']) && 
            (is_array($this->_headers['CC'])))
        {
            $header .= "CC: ".implode($this->_headers['CC'])."\r\n";
        }
        if (isset($this->_headers['BCC']) && 
            (is_array($this->_headers['BCC'])))
        {
            $header .= "BCC: ".implode($this->_headers['BCC'])."\r\n";
        }
        return $header;
    }/*}}}*/

}/*}}}*/

class MailContent
{/*{{{*/
    var $_template;
    var $_content;
    var $_isSetInfo;
    function MailContent($template="")
    {/*{{{*/
        $config = getAppConfig();
        $path = $config->getEmailTplPath();

        $this->_template = $path.$template;
        $this->_content = "";
        $this->_isSetInfo = false;
    }/*}}}*/
    function loadTemplate()
    {/*{{{*/
        $nLen = filesize($this->_template);
        $fd = @fopen($this->_template,"r");
        $this->_content = @fread($fd , $nLen);
        if (strlen($this->_content) < $nLen - 1)
            return false;
        @fclose($fd);
        return true;
    }/*}}}*/
    function setInfo($info)
    {/*{{{*/
        if (!is_array($info))
            return false;
        if ($this->_content == "")
        {
            if (!$this->loadTemplate())
                return false;
        }
        foreach ($info as $key => $value)
        {
            $this->_content = str_replace("@".strtoupper($key)."@", $value, $this->_content);
        }
        $this->_isSetInfo = true;
        return true;
    }/*}}}*/
    function getContent()
    {/*{{{*/
        if ($this->_isSetInfo)
            return $this->_content;
        return false;
    }/*}}}*/
}/*}}}*/

class Smtp
{/*{{{*/
    function send($to, $subject, $message, $CC='', $BCC='',$from="badgirl@qihoo.net")
    {/*{{{*/
        $simMail = new SimpleMail($to, $subject, $message);
        $simMail->setFromMail($from);
        if ("" != $CC)
            $simMail->addCCMail($CC);
        if ("" != $BCC)
            $simMail->addBCCMail($BCC);
        return $simMail->send();
    }/*}}}*/
}/*}}}*/
?>

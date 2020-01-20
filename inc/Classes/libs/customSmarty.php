<?php

class Template
{

	private $_panel;
	private $db;
	private $smarty;

	public function template ($panel,$db,$smarty)
	{
		
		 $this->_panel = $panel;
		 $this->db	 = $db;
		 $this->smarty	= $smarty;
	}

 	public function setPanel ($panel)
 	{
       $this->_panel = $panel;
 	}


 	public function fetch ($title,$filename,$section = '')
 	{
  		if($this->db->FetchErrors())
  		{
              $this->smarty->assign(errors,$this->db->FetchErrors());
              $this->smarty->display("sqlerror.htm");
              return(false);
              exit();
    	}

        $this->smarty->assign(section,$section);
  		$this->smarty->assign(title,$title);
     	$this->smarty->display($filename);

 	}



 	public function display ($title,$filename,$theme = false)
 	{
  		if($this->db->FetchErrors())
  		{
              $this->smarty->assign(errors,$this->db->FetchErrors());
              $this->smarty->display("sqlerror.htm");
              return(false);
              exit();
    	}

	  	$this->smarty->assign('title',$title);
	  	$this->smarty->assign('filename','internal/'.$filename);
	    $this->smarty->display("layout.html");

 	}

 	public function inc ($title,$filename,$custom = "")
 	{
 		if($custom != "")
        {
        	$this->smarty->assign(custom,$custom);
        }

	  	$this->smarty->assign('title',$title);
	  	$this->smarty->assign('filename',$filename);
	    $this->smarty->display("ajax.html");

 	}


 	public function alert ($message,$exit = false,$redirect = false,$faceEmo = false)
 	{
  		if($this->db->FetchErrors())
  		{
              $this->smarty->assign(errors,$this->db->FetchErrors());
              $this->smarty->display("sqlerror.htm");
              return(false);
              exit();
    	}

    	if($faceEmo != false)
        {
        	$this->smarty->assign(not_found,1);
        }

    	$this->smarty->assign(is_module,1);

		$tm_path = $GLOBALS['template_path'];

        if($redirect != false)
        {
        	$place = 'للصفحة الرئيسية ';
        	$msg = "<p> إضغط هنا ليتم تحويلك <a href='".$redirect."'> $place</a></p>";
        }else
        {
        	$place = 'للصفحة الرئيسية ';
        	$msg = "<p> إضغط هنا ليتم تحويلك <a href='index.html'> $place</a></p>";
        }
        $title = 'رسالة إدارية';

        if(is_file($tm_path."alert.tpl"))
        {
    		$getTemplateCode = file_get_contents($tm_path."alert.tpl");
    	}

		$getTemplateCode = str_replace("[%name%]",$message,$getTemplateCode);
		$getTemplateCode = str_replace("[%content%]",$msg,$getTemplateCode);


  		$code = $this->smarty->fetch('string:'.$getTemplateCode.'');

   		$this->smarty->assign('title',$title);
	  	$this->smarty->assign('alertmsg',$code);

	    $this->smarty->display("layout.html");

	    if($exit == true)
	    {
         	exit();
	    }
 	}

 	public function message ($message)
 	{
  		if($this->db->FetchErrors())
  		{
              $this->smarty->assign(errors,$this->db->FetchErrors());
              $this->smarty->display("sqlerror.htm");
              return(false);
              exit();
    	}

  		$this->smarty->assign('title',$GLOBALS['lang']['_admin_alertmessage_title']);
  		$this->smarty->assign(alertmessage,$message);
     	$this->smarty->display("message.html");

 	}


}

?>
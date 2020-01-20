<?php
class pager
{
	private $_page;
    private $_perpage;
    private $_totalresult;
    private $_link;
    private $_pages;
    private $_analysis;
    private $_pagervar;
    private $_minpage;
    private $_maxpage;


	public function __construct ()
	{

       $this->_page 		=	null;
       $this->_perpage 		=   NULL;
       $this->_totalresult 	= 	null;
       $this->_link			= 	null;
       $this->_pages		=   null;
       $this->_analysis		=   null;
       $this->_pagervar		=   null;
       $this->_minpage		=   null;
       $this->_maxpage		=   null;

	}


    public function getPerpage()
    {
        return $this->_perpage;
    }

    public function getAnalysis (){
    	return($this->_analysis);
    }

    public function getPage()
    {
		return($this->_page);
    }

	function doAnalysisPager ($getname,$page,$perpage,$total,$link='',$dialimeter = 0)
	{
		if($total > $perpage)
		{
			$allpage = $allpage. "<div class=\"pagination\">\n<ul>\n<li class=\"no-style\"></li>\n";
		}else
		{
			$allpage = $allpage. "<div class=\"pagination\">\n<ul>\n";
		}


    	if ($page == 0)
    	{
    		$page=1;
    	}


        $this->_page		= $page;
    	$this->_perpage		= $perpage;
    	$this->_totalresult	= $total;
    	$this->_link		= $link;
    	$this->_pagervar  	= $getname;

        if((isset($this->_link))&&($this->_link!=''))
        {
        	if($dialimeter == true){$ida = "&";}else{$ida = "?";}
            $this->_link = $this->_link.$ida;
        }

        if ($this->_totalresult > $this->_perpage)
        {


        	$this->_pages = ceil($this->_totalresult/$this->_perpage);

            if ( $this->_page > 1){
            	$page_prev = $this->_page-1;
            	$allpage = $allpage. "<li><a class=\"prev\" href=\"".$this->_link."".$this->_pagervar."=".$page_prev."\" title=''> &laquo; </a></li>\n";


            }


                //get min page
	         	if ($this->_page-2 <= $this->_pages && $this->_page-2 > 1)
	         	{
    	        	$this->_minpage = $this->_page-3;
        	    }
        	    elseif ($this->_page-1 <= $this->_pages && $this->_page-1 > 1)
        	    {
            		$this->_minpage = $this->_page-2;
	            }
	            elseif ($this->_page <= $this->_pages && $this->_page > 1)
	            {
    	        	$this->_minpage = $this->_page-1;
        	    }
        	    else
        	    {
            		$this->_minpage = $this->_page;
	            }

                //get max page
	            if ($this->_page+3 <= $this->_pages)
	            {
    	        	$this->_maxpage = $this->_page+3;
            	}
            	elseif ($this->_page+2 <= $this->_pages)
            	{
	            	$this->_maxpage = $this->_page+2;
    	        }
    	        elseif ($this->_page+1 < $this->_pages)
    	        {
        	    	$this->_maxpage = $this->_page+1;
            	}
            	else
            	{
	            	$this->_maxpage = $this->_pages;
    	        }


    	        for ($i=$this->_minpage ; $i<=$this->_maxpage ; $i++)
    	        {

            	    if ($this->_page == $i && $this->_page == 1)
            	    {

	                	$allpage = $allpage. "<li><span>".$i."</span></li>\n";


    	            }
    	            elseif ($this->_page == $i && $this->_page <> 1 && $this->_page <> $this->_pages)
    	            {

            	    	$allpage = $allpage. "<li><span>".$i."</span></li>\n";
                	}
                	elseif ($this->_page == $i && $this->_page == $this->_pages)
                	{

	                	$allpage = $allpage. "<li><span>".$i."</span></li>\n";
    	            }
    	            else
    	            {
        	        	$allpage = $allpage. "<li><a href=\"".$this->_link."".$this->_pagervar."=".$i."\" class='number' title='".$i."'>".$i."</a></li> \n";
            	    }
	            }


            if ($this->_page < $this->_pages)
            {
            	$page_next = $this->_page+1;
            	$allpage = $allpage. "<li><a class=\"next\" href=\"".$this->_link."".$this->_pagervar."=".$page_next."\" title=''> &raquo; </a></li>\n";

            }

            if ($this->_page < $this->_pages)
            {
            	//$allpage = $allpage. "<li><a href=\"".$this->_link."".$this->_pagervar."=".$this->_pages."\" title='".$GLOBALS['lang']['_pager_lastpage']."'>".$GLOBALS['lang']['_pager_lastpage']." »</a></li>\n";


            }
        }
       $allpage = $allpage. "</div>\n";

       $this->_analysis = $allpage;
       return($this->_analysis);
    }



	public function __destruct ()
	{

       $this->_page 		=	NULL;
       $this->_perpage 		= 	NULL;
       $this->_totalresult 	= 	NULL;
       $this->_link			= 	NULL;
       $this->_pages		=   NULL;
       $this->_pagervar		=   NULL;
       $this->_minpage		=   NULL;
       $this->_maxpage		=   NULL;
       $this->_analysis		=   NULL;
 	}
}

?>
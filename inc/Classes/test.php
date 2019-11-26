<?php



public function client_get_gallery()
    {
        
        $start 				= ( intval($_GET['p']) == 0)? 0 : intval($_GET['p']);
        $queryLimit 		= " LIMIT ".($start * $this->getDefaults("pagination")) ." , ". $this->getDefaults("pagination");
    
        $type = intval($_GET['type']);
        if($type != "")
        {
            $addquery = "AND `gallery_type` = '".$type."' LIMIT 1";
        }else{
            $addquery = "ORDER BY `gallery_serial` DESC".$queryLimit;
        }
        
        $galleryQuery = $GLOBALS['db']->query("SELECT * FROM `gallerys`  WHERE `gallery_status` = '1'".$addquery);
        $galleryCount = $GLOBALS['db']->resultcount();
        $_galleryCredintials =[];
        if($galleryCount != 0)
        {
            $galleryCredintials = $GLOBALS['db']->fetchlist();
            
            foreach($galleryCredintials as $gId => $g)
            {
                $_galleryCredintials[$gId]['gallery_serial']        =       intval($g['gallery_serial']); 
                $_galleryCredintials[$gId]['gallery_type']          =       $g['gallery_type']; 
                $_galleryCredintials[$gId]['link']                  =       ($g['gallery_type'] == 'image')?($g["gallery_photo"] == "") ? $this->getDefaults("img_url").$this->getDefaults("gallery-default-image") : $this->getDefaults("img_url").$g["gallery_link"] : $g['gallery_link'];	 
            }
            
            $this->terminate('success',$_galleryCredintials,200);
           
        }else
        {
            $this->terminate('success',$_galleryCredintials,200);
        }
    }
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cozy Room HTML template</title>
<meta name="description" content="interneto svetainių kūrimas" />
<meta name="keywords" content="dizainas" />
<meta name="author" content="Romano studija | http://www.roman.lt/ | Copyright (C) 2007. All rights reserved." />
<meta name="robots" content="index, follow" />
<link href="css/listall.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/lightface.css" />
<script src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools.js"></script>
<script src="js/LightFace.js"></script>
<script src="js/LightFace.IFrame.js"></script>
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="0" class="table-corners">
  <tr>
    <td class="corner1">&nbsp;</td>
    <td class="bg-white">&nbsp;</td>
    <td class="corner2">&nbsp;</td>
  </tr>
  <tr>
    <td class="bg-white">&nbsp;</td>
    <td><table border="0" align="center" cellpadding="0" cellspacing="0" class="main-table">
      <tr>
        <td colspan="2" class="top-img"><p><br />
              <br />
              <span class="website-title">Activity Pool  </span><br />
              <br />
          - A fresh template with rounded corners<br />
          - 900px width, that can be easily changed</p>
          </td>
      </tr>
      <tr>
		<td colspan="2" class="menu"><a class="menu-link" href="http://www.roman.lt/">Design</a> <a class="menu-link" href="http://www.roman.lt/svetaines.htm">Portfolio</a> <a class="menu-link" href="http://www.mediafire.com/?b2zltsyez82">Present</a> <a class="menu-link" href="http://www.keiskis.lt/refer.php?8407">Links</a> <a class="menu-link" href="index.html">Contact information </a> 
</td>
      </tr>
			<?php foreach($list as $v):?>
				<a name="content_<?php echo $v['timestamp'];?>"></a>
      <tr>
				<td class="content"><h1>Date</h1>
				<p><?php echo $v['row'];?></p>
			  <h1>Place</h1>
			  <p><?php echo $v['place'];?></p>
			  <h1>Content</h1>
			  <p><?php echo $v['content'];?></p>
<a href="#content_<?php echo $v['timestamp'];?>" id="content_<?php echo $v['timestamp'];?>">read more</a>
<script>window.addEvent('domready',function(){document.id('content_<?php echo $v['timestamp']?>').addEvent('click',function() {light = new LightFace.IFrame({ height:400, width:800, content: unescape(decodeURI('<?php echo $v['fulltxt'];?>')), title: 'Read more' }).addButton('Close', function() { light.close(); },true).open();});});</script>
			  <p><em>From .
			<a href="<?php echo $v['link']?>" target="_blank">here</a>
			</em></p>
			</td>
				<?php endforeach;?>
      <tr>
<td>
<form action="<?php echo $url;?>" method="post" id="page" >
<table><tr><td><input type="submit" class="submit-link" name="pre" id="pre" value="pre"></td><td><input type="submit" class="submit-link" name="next" id="next" value="next"><input type="hidden" name="now" value="<?php echo $page;?>"></td></tr></table>
</form></td>
</tr><tr>
        <td width="200" class="content-right"><a class="menu-right" href="#">Activity Pool</a>
            <a class="menu-right" href="#">Friendly pets</a>
            <a class="menu-right" href="#">Friendly friends :-) </a>
          <a class="menu-right" href="#">Funny guests</a>
		  <a class="menu-right" href="#">That's  perfect</a></td>
      </tr>
      <tr>
        <td colspan="2"><span class="made-in_text">Design by <!-- You can use this template for any purpose you want, but you have to leave this link --><a class="made-in" title="Interneto svetainių kūrimas" href="http://www.roman.lt/">Svetainių kūrimas</a></span></td>
      </tr>
    </table></td>
    <td class="bg-white">&nbsp;</td>
  </tr>
  <tr>
    <td class="corner3">&nbsp;</td>
    <td class="bg-white">&nbsp;</td>
    <td class="corner4">&nbsp;</td>
  </tr>
</table>
<p class="style1">&nbsp;</p>
</body>
</html>

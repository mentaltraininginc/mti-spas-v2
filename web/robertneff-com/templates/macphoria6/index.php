<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// needed to seperate the ISO number from the language file constant _ISO
$iso = split( '=', _ISO );
// xml prolog
echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php mosShowHead(); ?>
<?php
if ( $my->id ) {
	initEditor();
}

if (mosCountModules('user1') + mosCountModules('user2') < 2) {
  $greybox = 'large';
} else {
  $greybox = 'small';
}
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/template_css.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo $mosConfig_live_site;?>/images/favicon.ico" />
</head>
<body id="page_bg">
<a name="up" id="up"></a>

<div class="center" align="center">
  <table cellpadding="0" cellspacing="0" width="795" id="main">
    <tr valign="top">
      <td class="left_shadow"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/mp_shadow_l_t.png" alt="" title="" height="37" width="11" /><br /></td>
      <td class="wrapper">
      	<div id="header"></div>
      	<div id="mainbody">
      		<table cellpadding="0" cellspacing="0" width="100%" class="menu">
      			<tr valign="top">
      				<td class="menu_l">&nbsp;</td>
      				<td class="menu_m">
      				  <table cellpadding="0" cellspacing="0" class="pill">
      				    <tr>
      				      <td class="pill_l">&nbsp;</td>
      				      <td class="pill_m">
      				        <div id="pillmenu">
      				          <?php mosLoadModules('top', -1); ?>
      				        </div>
      				      </td>
      				      <td class="pill_r">&nbsp;</td>
      				    </tr>
      				  </table>
      				</td>
      				<td class="menu_r">&nbsp;</td>
      			</tr>
      		</table>
      		<?php mosPathWay(); ?>
      		<div id="roundbox">
      		  <div class="top"></div>
            <div class="middle">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr valign="top">
                  <td class="maincol"> 
                    <?php if (mosCountModules('user1') || mosCountModules('user2')) { ?>
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr valign="top">
                        <?php if (mosCountModules('user1')) { ?>
                        <td width="50%">
                          <?php mosLoadModules('user1',-2); ?>
                        </td>
                        <?php } ?>
                        <?php if (mosCountModules('user1') && mosCountModules('user2')) { ?>
                        <td class="greyline"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/spacer.png" alt="spacer.png, 0 kB" title="spacer" class="" height="50" width="11" /></td>
                        <?php } ?>
                        <?php if (mosCountModules('user2')) { ?>
                        <td width="50%">
                          <?php mosLoadModules('user2',-2); ?>
                        </td>
                        <?php } ?>
                      </tr>
                    </table>
         						<?php } ?>
				            <?php if (mosCountModules('user1') && mosCountModules('user2')) { ?>
                    <div id="maindivider"></div>
                    <?php } ?>
                    <?php mosMainBody(); ?>
                  </td>
                  <td class="rightcol">
                    <?php mosLoadModules('right', -3); ?>
                  </td>
                </tr>
              </table>
              
            </div>
      		  <div class="bottom"></div>
      		</div>
      	</div>
      	<div id="footer_divider"></div>
      </td>
      <td class="right_shadow"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/mp_shadow_r_t.png" alt="" title="" height="55" width="11" /><br /></td>
    </tr>
    <tr>
      <td class="left_bot_shadow"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/spacer.png" alt="spacer.png, 0 kB" title="spacer" class="" height="55" width="11" /><br /></td>
      <td class="bottom">
				<?php mosLoadModules('footer', -1); ?>
			</td>  
      <td class="right_bot_shadow"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/spacer.png" alt="spacer.png, 0 kB" title="spacer" class="" height="55" width="11" /><br /></td>
    </tr>
  </table>
  <div class="bottomspacer"></div>
</div>
<?php mosLoadModules( 'debug', -1 );?>
</body>
</html>

<?php  
	$logo = $entry[13];
	$color = $entry[12];
	
	foreach (unserialize($entry[9]) as $link) {
		$email_links .= '<a href="'.$link['review_button_url'].'" style="display:block; width: 300px; margin-bottom:10px; background-color:'.$color.'; color: #FFF; padding: 15px; text-decoration: none; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">' .$link['review_button_link_text']. '</a>';
	}

	$email ='<div style="font-family:arial; background:#EEE; text-align: center; padding:45px 10px">
		<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="background:#EEE; margin: 0 auto;">
		<tr>
			<td align="center">
			<table cellpadding="0" cellspacing="0" border="0" align="center" style="background:#FFF; border-radius: 5px;">
				<tr>
					<td width="600" valign="top" align="center" style="padding:30px;">
						<img src="'.$logo.'" alt="" style="margin:30px auto; display: block; max-width: 300px;" />
						<h1 style="color:'.$color.'">'.$entry[6].'</h1>
						<p>'.$entry[8].'</p>
						'.$email_links.'
						<p style="margin-top:50px;">If your experience wasn\'t great, let us know.</p>
						<a href="'.$entry[14].'" style="display:block; width: 300px; background-color:#000; color: #FFF; padding: 15px; text-decoration: none; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Contact us directly</a>
					</td>
				</tr>
			</table>
			</td>
		</tr>
		</table>
	</div>
	';

	$email = trim(preg_replace('/\s\s+/', ' ', $email));
	

?>






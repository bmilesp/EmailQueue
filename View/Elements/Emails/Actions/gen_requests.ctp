<br />
<br />
<table width="630" border="0" cellspacing="0" cellpadding="0">
	<?php
		foreach($data['EmailQueue'] as $key => $value){
			if($data['EmailQueue'] != "QuickSearch"){
		?>
					<tr>
						<td width="50%" style="text-align:right; font-weight:bold;">
							<?php echo Inflector::humanize($key); ?>: &nbsp; 
						</td>						
						<td width="50%" style="text-align:left;">
							<?php 
								if($key == "job_number" && $key == "invoice_request" && $key == "EmailQueueQuickSearch"){
									?>
										<a href="<?php echo "PutJobsURL/".$value; ?>"><?php echo Inflector::humanize($key);?></a>
									<?php							
								}
								else{
									echo $value; 
								}
							?>					
						</td>	
					</tr>
		<?php
				}
			}
		?>
</table>
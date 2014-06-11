<br />
<br />
<table width="630" border="0" cellspacing="0" cellpadding="0">
	<?php
		$comments = "";
		foreach($data as $key => $value){
				if($key != "file_and_advise" && $key != "suggest_print_colors" && $key != "final_artwork_design_file_in_eps_format" && $key != "final_artwork_design_file_in_pdf_format" && $key != "indivdual_high_res_jpeg_image_files_of_each_location" && $key != "files"){
		?>
					<tr>
						<td width="50%" style="text-align:right; font-weight:bold;">
							<?php echo Inflector::humanize($key); ?>: &nbsp; 
						</td>						
						<td width="50%" style="text-align:left;">
							<?php 
								if($key == "job_number"){
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
				else{
					if($key != "files"){
						$comments  .=  $value."<br />";
					}
				}
			}
			if(!empty($data['files'])){
			?>
				<tr><td align="left" colspan="2"><h4>Files: </h4></td></tr>
				<?php
				$count = count($data['files']);
				$count--;
				for($i = 1; $i <= $count; $i++) {
				?>				
				<tr>
					<td align="left" style="font-weight:bold;" colspan="2">
						<a href="/media/media/download/<?php echo $data['files'][$i]['id']; ?>"><?php echo $data['files'][$i]['filename'];  ?></a>
					</td>
				</tr>
				<?php
					}
				?>
				
		<?php
			}		
			if(!empty($comments)){
			?>
				<tr><td align="left" colspan="2">&nbsp;</td></tr>
				<tr><td align="left" colspan="2">&nbsp;</td></tr>				
				<tr><td align="left" colspan="2"><h4>Comments: </h4></td></tr>
				<tr>
					<td align="left" style="font-weight:bold;" colspan="2">
						<?php echo $comments; ?> 
					</td>
				</tr>
		<?php
			}
	?>
</table>
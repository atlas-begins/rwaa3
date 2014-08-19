<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
		    <div class="left ObjectTable">
		    	<ul class="tabs" data-persist="true">
		            <li><a href="#viewtab1">Description</a></li>
		            <li><a href="#viewtab2">Image</a></li>
		            <li><a href="#viewtab3">Winners</a></li>
		        </ul>
		        <div class="tabcontents">
					<div id="viewtab1">
		        		<p>This item is currently held by </p>
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab2">
		        		<% loop Result %>
		        			$TrophyImage.SetRatioSize(600,600)
		        		<% end_loop %>
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab3">
		        		
		    			<div class="clear"></div>
		    		</div>
		    	</div>
		</div>
	</article>
	$Form
	$PageComments
</div>
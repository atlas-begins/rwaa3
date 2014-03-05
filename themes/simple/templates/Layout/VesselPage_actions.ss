<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<% if Content %><div class="opaque">$Content</div><% end_if %>
			<div class="left ObjectTable">
				<% if ObjectAction == 'edit' %>
					edit stuff here
				
				<% end_if %>
				
				<% if ObjectAction == 'add' %>
					add stuff here
				<% end_if %>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>
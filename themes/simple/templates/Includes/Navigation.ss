<nav class="primary">
	<span class="nav-open-button">²</span>
	<ul>
		<% loop $Menu(1) %>
			<li class="$LinkingMode"><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
		<% end_loop %>
		<% if CurrentMember %>
			<li class="link"><a href="/Security/logout?BackURL=$thisURL" title="$Title.XML">Log out</a></li>
		<% else %>
			<li class="link"><a href="/Security/login?BackURL=$thisURL" title="$Title.XML">Log in</a></li>
		<% end_if %>
	</ul>
</nav>

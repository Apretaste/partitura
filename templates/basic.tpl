<h1>{$Song|capitalize}</h1>

{for $i = 0 to 9}
	{if isset($titles[$i]) }
		<h3>{$titles[$i]}</h3>
		<p>
		{* {link href="partitura detalle {$urls[$i]} {$pages[$i]} {$titles[$i]|replace:' ':'-'}" caption= "{$titles[$i]}, {$pages[$i]}, {$instruments[$i]}"} *}
		{foreach item=item from=$newurls[$i] key=key}
			{link href="NAVEGAR {$item}" caption="P&aacute;g. {$key}"} |
		{/foreach}
		</p>
	{/if}
{/for}

{space10}
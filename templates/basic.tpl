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

{* <p>{$var_one|capitalize} {$var_two|capitalize} {$var_three|capitalize}</p> *}

{space15}

<center>
	<p><small>Mejore tu pasion de tocar tu instrumento favorito.</small></p>
	{space15}
</center>

{space30}

<p>Adjunto archivo tiene tu musica</p>
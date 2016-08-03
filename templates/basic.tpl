<h1>{$Song|capitalize}</h1>

<p>Estas son las canciones encontradas para <b>{$Song}</b>. Cada canci&oacute;n 
tiene una partitura y cada partitura puede tener varias p&aacute;ginas que se obtienen en formato 
de imagen PNG con un tama&ntilde;o promedio de 80KB. Para cada canci&oacute;n se muestran 
los enlaces de cada p&aacute;gina de su partitura para que puedas descargarlas una a una y as&iacute;
puedas ahorrar cr&eacute;dito de tu celular si solo deseas una p&aacute;gina.</p>

{for $i = 0 to 9}
	{if isset($titles[$i]) }
		{if isset($newurls[$i][0])}
			<h3>{$titles[$i]}</h3>
			{button href="LETRA {$Song}" caption="Ver Letra"}<br/>
			<p>
			{* {link href="partitura detalle {$urls[$i]} {$pages[$i]} {$titles[$i]|replace:' ':'-'}" caption= "{$titles[$i]}, {$pages[$i]}, {$instruments[$i]}"} *}
			{foreach item=item from=$newurls[$i] key=key}
				{link href="NAVEGAR {$item}" caption="P&aacute;g. {$key+1}"} 
				{if not $item@last}{separator}{/if}
			{/foreach}
			</p>
		{/if}
	{/if}
{/for}

{space10}
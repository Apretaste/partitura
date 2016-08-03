<h1>{$Song|capitalize}</h1>

<p>Estas son las canciones encontradas para <b>{$Song}</b>. Cada canci&oacute;n 
tiene una partitura y cada partitura puede tener varias p&aacute;ginas que se obtienen en formato 
de imagen PNG con un tama&ntilde;o promedio de 80KB. Para cada canci&oacute;n se muestran 
los enlaces de cada p&aacute;gina de su partitura para que puedas descargarlas una a una y as&iacute;
puedas ahorrar cr&eacute;dito de tu celular si solo deseas una p&aacute;gina.</p>

<table width="100%">
{for $i = 0 to 9}
	{if isset($titles[$i]) }
		{if isset($newurls[$i][0])}
			<tr>
				<td><b>{$titles[$i]}</b></td>
				<td>
				{foreach item=item from=$newurls[$i] key=key}
					{button href="NAVEGAR {$item}" caption="P&aacute;g. {$key+1}" size="samall" color="green"} 
					{if not $item@last}{separator}{/if}
				{/foreach}
				</td>
				<td align="right">
				{button href="LETRA {$Song}" caption="Ver Letra" color="grey" size="small"}
				</td>
			</tr>
		{/if}
	{/if}
{/for}
</table>
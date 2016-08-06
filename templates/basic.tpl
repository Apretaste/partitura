<h1>{$Song|capitalize}</h1>

<p align="justify" >Estas son las canciones encontradas para <b>{$Song}</b>. Cada canci&oacute;n 
tiene varias partituras que se obtienen en formato de imagen PNG con un tama&ntilde;o promedio de 80KB. Para cada canci&oacute;n se muestran 
los enlaces a cada partitura para que puedas descargarlas una a una y as&iacute;
puedas ahorrar cr&eacute;dito de tu celular si solo deseas una.</p>

<table width="100%" cellpadding="2">
{for $i = 0 to 9}
	{if isset($titles[$i]) }
		{if isset($newurls[$i][0])}
			<tr>
				<td valign="top">{$titles[$i]}</td>
				<td width="20%" valign="top">
				{foreach item=item from=$newurls[$i] key=key}
					{link href="NAVEGAR {$item}" caption="Partitura #{$key+1}"} <br/>
				{/foreach}
				</td>
				<td width="20%" align="right" valign="top">
				{link href="LETRA {$Song}" caption="Ver Letra"}
				</td>
			</tr>
			<tr><td colspan="3"><hr/></td></tr>
		{/if}
	{/if}
{/for}
</table>
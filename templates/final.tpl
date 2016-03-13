<h1>La partitura de su cancion</h1>

{space10}

{foreach from=$images item=image}
	{img src="{$image}" alt="Partitura" width="300"}
	{space10}
{/foreach}

<center>
	{button href="LETRA {$song}" caption="Ver Letra"}
</center>
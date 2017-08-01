<?php

use Goutte\Client;

class Partitura extends Service
{
	/**
	 * Function executed when the service is called
	 *
	 * @param Request
	 * @return Response
	 */
	public function _main (Request $request)
	{
		// do not allow blank searches
		if(empty($request->query))
		{
			$response = new Response();
			$response->setResponseSubject("Que desea buscar en Wikipedia?");
			$response->createFromTemplate("home.tpl", array());
			return $response;
		}

	/**
	 * Function executed when the service is called
	 *
	 * @param
	 *        	Request
	 * @return Response
	 */
	public function _main(Request $request)
	{
		try
		{
			// create a new client
			$client = new Client();
			$guzzle = $client->getClient();
			$guzzle->setDefaultOption('verify', false);
			$client->setClient($guzzle);

			// create a crawler
			$crawler = $client->request('GET', "https://musescore.com/sheetmusic?text=" . $request->query);

			$titles = $crawler->filter('.views-field-title .field-content a')->each(function ($node, $i)
			{
				return $node->text();
			});

			$pages = $crawler->filter('.score-pages')->each(function ($node, $i)
			{
				return $node->text();
			});

			$instruments = $crawler->filter('.views-field-field-score-part-programs-value .field-content')->each(function ($node, $i)
			{
				return $node->text();
			});

			$urls = $crawler->filter('.picture img')->each(function ($node, $i)
			{
				return $node->attr("src");
			});

			$newurls = $crawler->filter('.views-field-title .field-content a')->each(function ($node, $i)
			{
				return $node->attr('href');
			});

			$new = array();
			foreach ($newurls as $k => $v)
			{
				if (trim($v) == '')
				{
					$newurls[$k] = array();
					continue;
				}

				$arr = array();
				$v = $this->getScoreImageUrl($v);

				if (isset($pages[$k]))
					for ($i = 1; $i <= $pages[$k] * 1; $i ++)
					{
						$arr[] = str_replace('score_0', 'score_' . ($i - 1), $v);
					}

				$new[] = $arr;
			}

			// Not found
			if (count($new) < 1)
			{
				// create the response
				$response = new Response();
				$response->setResponseSubject("No se encontraron resultados de partituras para " . ucwords($request->query));
				$response->createFromText("No se encontraron resultados de partituras para " . ucwords($request->query). ". Por favor verifica que hayas escrito bien el nombre de la canci&oacute;n. En caso de persistir el problema contacta cone el soporte t&eacute;cnico. Disculpa los inconvenientes causados.");
				return $response;
			}

			// create a json object to send to the template
			$responseContent = array(
				"titles" => $titles,
				"Song" => $request->query,
				"pages" => $pages,
				"instruments" => $instruments,
				"urls" => $urls,
				"newurls" => $new
			);

			// create the response
			$response = new Response();
			$response->setResponseSubject("Resultados para " . ucwords($request->query));
			$response->createFromTemplate("basic.tpl", $responseContent);
			return $response;
		}
		catch (Exception $e)
		{
			$response = new Response();
			$response->setResponseSubject("No se pudo obtener las partituras");
			$response->createFromText("En estos momentos no se pudo obtener las partituras. Int&eacute;ntelo m&aacute;s tarde. Si el problema persiste, por favor, contacte al soporte t&eacute;nico. Disculpe las molestias ocasionadas.");
			return $response;
		}
	}

	/**
	 * Return the URL of score image based on an URL page
	 *
	 * @param string $url
	 */
	private function getScoreImageUrl($url)
	{
		$client = new Client();
		$guzzle = $client->getClient();
		$guzzle->setDefaultOption('verify', false);
		$client->setClient($guzzle);

		// create a crawler
		$crawler = $client->request('GET', "https://musescore.com{$url}");

		$url = $crawler->filter('.share42init')->each(function ($node, $i)
		{
			return $node->attr('data-image');
		});

		if (isset($url[0])) return $url[0];

		return '';
	}
}

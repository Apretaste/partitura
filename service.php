<?php

use Goutte\Client; // UNCOMMENT TO USE THE CRAWLER OR DELETE

class Partitura extends Service
{
	/**
	 * Function executed when the service is called
	 * 
	 * @param Request
	 * @return Response
	 * */
	public function _main(Request $request)
	{
		// create a new client
		$client = new Client();
		$guzzle = $client->getClient();
		$guzzle->setDefaultOption('verify', false);
		$client->setClient($guzzle);

		// create a crawler
		$crawler = $client->request('GET', "https://musescore.com/sheetmusic?text=" . $request->query);

		$titles = $crawler->filter('.views-field-title .field-content a')->each(function ($node, $i){
		    return $node->text(); 
		});

		$pages = $crawler->filter('.score-pages')->each(function ($node, $i){
		    return $node->text(); 
		});

		$instruments = $crawler->filter('.views-field-field-score-part-programs-value .field-content')->each(function ($node, $i){
		    return $node->text(); 
		});

		$urls = $crawler->filter('.picture img')->each(function ($node, $i){
		    return $node->attr("src"); 
		});

		// create a json object to send to the template
		$responseContent = array(
			"titles" => $titles,
			"Song" => $request->query,
			"pages" => $pages,
			"instruments" => $instruments,
			"urls" => $urls
		);

		// create the response
		$response = new Response();
		$response->setResponseSubject("Resultados para " . ucwords($request->query));
		$response->createFromTemplate("basic.tpl", $responseContent);
		return $response;
	}

	public function _detalle (Request $request)
	{
		$chopped = explode(" ", $request->query);
		$url = $chopped[0];
		$page = $chopped[1];
		$title = str_replace("-"," ",$chopped[2]);

		$pos = strpos($url, "thumb");
		$chopped = str_split($request->query, $pos);

		// get path to the temp folder 
		$di = \Phalcon\DI\FactoryDefault::getDefault();
		$temp = $di->get('path')['root'] . "/temp/";

		$images = array();
		for ($i = 0; $i < $page; $i++)
		{
			$image = $chopped[0] . "score_$i.png";
			$file_headers = @get_headers($image);
			if(strpos($file_headers[0], '200') !== false)
			{
				$savePath = $temp.$this->utils->generateRandomHash().".jpg";
				file_put_contents($savePath, file_get_contents($image));
//				imagejpeg($savePath, $savePath); // @TODO convert to jpg
				$this->utils->optimizeImage($savePath, 300);
				$images[] = $savePath;
			}
		}

		$responseContent = array(
			"song" => $title,
			"images" => $images
		);

		$response = new Response();
		$response->setResponseSubject("Su partitura de " . ucwords($title));
		$response->createFromTemplate("final.tpl", $responseContent, $images);
		return $response;
	}
}
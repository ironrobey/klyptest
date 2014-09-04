<?php

class process{

	public function _request( $q, $p ){

		// request api 
		$request = 'http://api.rottentomatoes.com/api/public/v1.0/movies.json?apikey=mkvuufq76732zh8v96s8su5u&q='.$q.'&page_limit=15&page='.$p;
		$session = curl_init($request);

		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($session);

		curl_close($session);

		return json_decode( $data ); //return requested result

	}

	public function computeRuntime( $minutes ){

		if( $minutes ){
			$hours = floor( $minutes / 60 );
			$mins = $minutes % 60;					

			$return = $hours.' hr. '.$mins.' min.';
		} else {

			$return = 'No Data';

		}

		return $return; //compute for H:i based on minutes

	}

	public function qMatch( $q, $title ){

		$return = array();

		$replace = preg_replace( '/\b('.$q.'?)(\.|\b)/i', '', $title ); //check if query matches a word in the title, replace with space

		if( $replace != $title ){
			$return['movie_title'] = $this->formatTitle( $replace );
			$return['bg_color'] = $q;
		} else {
			$return['movie_title'] = $this->formatTitle( $title);
			$return['bg_color'] = null;
		}

		return $return;

	}

	public function formatTitle( $title ){
		//format title 
		//if more 40 chars cut down char to 40 only 
		//add ... at the end
		//else return as is
		if( strlen($title) > 40 ){
			$return = substr($title, 0, 40).'...';
		} else {
			$return = $title;
		}

		return $return;

	}

}
<?php namespace Xethron;

class L4ToString extends ToString
{

	public static function queryLog( $queryLog = null )
	{
		if ( is_null( $queryLog ) )
			$queryLog = \DB::getQueryLog();
		$queryString = "";
		foreach ( $queryLog as $i => $query )
		{
			$queryString .= "#$i ". L4ToString::query( $query['query'], $query['bindings'], $query['time'] ) ."\n";
		}
		return $queryString;
	}

	public static function query( $query, $bindings, $time )
	{
		$data = compact( 'bindings', 'time' );

		// Format binding data for sql insertion
		foreach ($bindings as $i => $binding)
		{
			if ($binding instanceof \DateTime)
			{
				$bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
			}
			else if (is_string($binding))
			{
				$bindings[$i] = "'$binding'";
			}
		}

		// Insert bindings into query
		$query = str_replace(array('%', '?'), array('%%', '%s'), $query);
		$query = vsprintf($query, $bindings);

		return $query .";\n    ". json_encode( $data );
	}

}
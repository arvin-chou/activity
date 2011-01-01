<?php  
//https://svn.apache.org/repos/asf/hbase/trunk/src/examples/thrift/DemoClient.php
class hbase_model extends Model {  
	private $client = "";
	private $transport= "";
	private $tablename= "";
    function hbase_model()  
    {  
        // Call the Model constructor  
        parent::Model();  
		//$this->getnextmin();
		//$this->hbaseini();
	}  
	function hbaseinsert($row,$coldes,$col,$v)
	{
		$mutations = array(
			new Mutation( array(
				'column' => $coldes.':'.$col,
				'value' => $v
			) ),
		);
		$this->client->mutateRow( $this->tablename, $row, $mutations );
	}
	function hbaseget($coldes,$col,$num)
	{
		$scanner = $this->client->scannerOpen( 
			$this->tablename, "", array( $coldes . ":" . $col ) );
		$values = array();
		while($num > 0)
		{
			$values[] = ( ($this->client->scannerGet( $scanner )));
			$num-- ;
		}
		//print_r($values);
		//print_r($this->client->getRow( $this->tablename, '1260057600'));
		return $values;
		//$a = ( ($this->client->scannerGet( $scanner )));
		//echo $a[0]['columns']['place:content']['value'];
		//print_r(urldecode($a[0]->columns['place:content']->value));
		//中文
	}
	function hbasegetrange($coldes,$start,$end,$num)
	{
		$scanner = $this->client->scannerOpenWithStop( 
			$this->tablename, $start, $end, $coldes );
		//print_r($this->client->scannerGetList( $scanner ,$num));
		//$values = array();
		//try {
		//	//while (true) 
		//	$num = 20;
		//	while ($num > 0) 
		//	{
		//		$values[] = $this->client->scannerGet( $scanner );
		//		$num--;
		//	}
		//} catch ( NotFound $nf ) {
		//	  $this->client->scannerClose( $scanner );
		//	    echo( "Scanner finished\n" );
		//}
		//print_r($values);
		return $this->client->scannerGetList( $scanner ,$num);

	}
	function hbaseclose()
	{
		$this->transport->close();
	}
	function hbaseini()
	{
		$GLOBALS['THRIFT_ROOT'] = '/var/www/activity/system/application/models/hbase/thrift';
		//require_once( $GLOBALS['THRIFT_ROOT'].'/packages/hive_service/ThriftHive.php' );
		require_once( $GLOBALS['THRIFT_ROOT'].'/Thrift.php' );
		require_once( $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php' );
		require_once( $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php' );
		require_once( $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php' );
		require_once( $GLOBALS['THRIFT_ROOT'].'/packages/Hbase/Hbase.php' );

		$socket = new TSocket( 'aeiltest64', 9090);
		$socket->setSendTimeout( 100000 ); // Ten seconds (too long for production, but this is just a demo ;)
		$socket->setRecvTimeout( 200000 ); // Twenty seconds
		$transport = new TBufferedTransport( $socket );
		$protocol = new TBinaryProtocol( $transport );
		$client = new HbaseClient( $protocol );
		//$client = new ThriftHiveClient($protocol);
		//$client->recv_execute('SELECT * FROM pokes');
		//var_dump($client->fetchAll());
		$transport->open();
		$tables = $client->getTableNames();
		sort( $tables );
		$this->tablename = "list";
		if(!in_array($this->tablename,$tables))
		{
			$columns = array(
				new ColumnDescriptor( array(
					'name' => 'place:'
				) ),
				new ColumnDescriptor( array(
					'name' => 'content:'
				) )
			);
			try {
				$client->createTable( $this->tablename, $columns );
			} catch ( AlreadyExists $ae ) {
				echo( "WARN: {$ae->message}\n" );
			}
		}
		/*
		$descriptors = $client->getColumnDescriptors( $tablename );
		asort( $descriptors );
		foreach ( $descriptors as $col )
		{
			//echo( " column: {$col->name}, maxVer: {$col->maxVersions}\n" );
			print_r($col);
		}

		$row = "201012281749";//row name
		$mutations = array(
			new Mutation( array(
				'column' => 'place:',
				'value' => 'taipei'
			) ),
			//new Mutation( array(
			//	'column' => 'content:',
			//	'value' => '306'
			//) )
		);
			$client->mutateRow( $tablename, $row, $mutations );
		$mutations = array(
			new Mutation( array(
				'column' => 'place:content',
				'value' => '306'
			) )
		);
			$client->mutateRow( $tablename, $row,$mutations );
		//try {
		//	$client->mutateRow( $tablename, "test", $mutations );
		//	throw new Exception( "shouldn't get here!" );
		//} catch ( IOError $e ) {
		//	echo( "expected error: {$e->message}\n" );
		//}
		echo( "Starting scanner...\n" );
		$scanner = $client->scannerOpen( $this->tablename, "", array( "place:" ) );
		$x = 0;
		while($x < 20 )
		{
			print_r( $client->scannerGet( $scanner ));
			$x++;
		}
		//while (true) print_r( $client->scannerGet( $scanner ) );
		//try {
		//	  while (true) print_r( $client->scannerGet( $scanner ) );
		//} catch ( NotFound $nf ) {
		//	  $client->scannerClose( $scanner );
		//	    echo( "Scanner finished\n" );
		//}



		//include "ThriftLib.php";
		$fam_col_name = 'place:math';//column name
		$arr = $client->get($this->tablename, $row, $fam_col_name);

		foreach ( $arr as $k=>$v )
		{
			echo "value = {$v->value} , <br> ";
			echo "timestamp = {$v->timestamp} <br>";
		}
		 */
												//
		/*
		foreach ( $tables as $name ) {
			echo( " found: {$name}\n" );
		}*/
		//$transport->close();
		$this->client = $client;
		$this->transport = $transport;
	}
}  
?>  


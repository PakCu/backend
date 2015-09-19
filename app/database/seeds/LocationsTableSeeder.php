<?php

class LocationsTableSeeder extends Seeder {

	public function run()
	{

        Location::truncate();

		$datas = [
            [
                'name' => 'PiMasjid Test Device 001',
                'device_hash' => '5d8511dc4e4345440d266dabf74e98e2'
            ]
        ];

		foreach($datas as $data)
		{
			Location::create($data);
		}
	}

}
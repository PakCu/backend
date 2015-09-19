<?php

class TalksTableSeeder extends Seeder {

	public function run()
	{

    Talk::truncate();

		$datas = [
            [
                'name' => 'example'
            ]
        ];

		foreach($datas as $data)
		{
			Talk::create($data);
		}
	}

}
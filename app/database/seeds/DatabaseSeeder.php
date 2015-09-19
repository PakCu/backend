<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        Eloquent::unguard();
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } catch (Exception $e) {}
        
        // $this->call('LaravelBaseSeeder');
        $this->call('LocationsTableSeeder');

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } catch (Exception $e) {}

    }

}

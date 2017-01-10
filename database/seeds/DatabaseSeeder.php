<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		// 
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		 //call uses table seeder class
  		$this->call('MaterialTypeSeeder');
        $this->command->info("materialType table seeded :)");

        $this->call('CompanyTypeSeeder');
        $this->command->info("Company Type table seeded :)");

        $this->call('CompanyStatusSeeder');
        $this->command->info("Company Status table seeded :)");

        $this->call('CompanyLocationSeeder');
        $this->command->info("Company Location table seeded :)");

        $this->call('MaterialMasterSeeder');
        $this->command->info("Company Master table seeded :)");

        $this->call('CompanyMasterSeeder');
        $this->command->info("Company table seeded :)");

        $this->call('StockMasterSeeder');
        $this->command->info("Stock table seeded :)");

        $this->call('BCTypeSeeder');
        $this->command->info("BC Type table seeded :)");

        $this->call('UnitTypeSeeder');
        $this->command->info("Unit Type table seeded :)");

        $this->call('CurrTypeSeeder');
        $this->command->info("Curr Type table seeded :)");

        $this->call('StockTypeSeeder');
        $this->command->info("Stock Type table seeded :)");

        $this->call('StockToSeeder');
        $this->command->info("Stock Type table seeded :)");

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');



	}

}

class MaterialTypeSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('material_type')->delete();
		DB::table('material_type')->truncate();

        DB::table('material_type')->insert(
	        array(
	                array('name' => 'Accesories', 'desc'=>'detail description material type'),
	                array('name' => 'Fabric', 'desc'=>'detail description material type'),
	                array('name' => 'Machine', 'desc'=>'detail description material type'),
	                array('name' => 'Scrap', 'desc'=>'detail description material type'),
	                array('name' => 'Finish Good', 'desc'=>'detail description material type'),                               
	        ));
	}

}

class CompanyTypeSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('company_type')->delete();
		DB::table('company_type')->truncate();

        DB::table('company_type')->insert(
	        array(
	                array('name' => 'Supplier', 'desc'=>'detail description material type'),
	                array('name' => 'CMT', 'desc'=>'detail description material type'),
	                array('name' => 'Buyer', 'desc'=>'detail description material type'),
	                array('name' => 'Forwarder', 'desc'=>'detail description material type'),
	        ));
	}

}

class CompanyStatusSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('company_status')->delete();
		DB::table('company_status')->truncate();

        DB::table('company_status')->insert(
	        array(
	                array('name' => 'KB', 'desc'=>'detail description material type'),
	                array('name' => 'NON KB', 'desc'=>'detail description material type'),                       
	        ));
	}

}

class CompanyLocationSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('company_location')->delete();
		DB::table('company_location')->truncate();

        DB::table('company_location')->insert(
	        array(
	                array('name' => 'Local', 'desc'=>'detail description material type'),
	                array('name' => 'Import', 'desc'=>'detail description material type'),                            
	        ));
	}

}

class MaterialMasterSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('material_master')->delete();
		DB::table('material_master')->truncate();

		$arr_data = array();

		$name = array('Baju','benang','jarum','celana','jaket');

		$color = array('abu-abu','putih','bulawo','hitam','merah','jingga');



		for ($i=0; $i < 10; $i++) {

			$arr_data[] = array(
				'code'=> 'SAMPLE-MAT-'.str_pad($i+1, 3, '0', STR_PAD_LEFT),
				'name'=> $name[rand(0,4)],
				'color' => $color[rand(0,5)],
				'size' => rand(10,500),
				'type' => rand(1,5),
				'created_by' => 'admin',
				'created_at' => date("Y-m-d H:i:s")
				);
		}

        DB::table('material_master')->insert($arr_data);
	}

}

class CompanyMasterSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('company_master')->delete();
		DB::table('company_master')->truncate();

		$arr_data = array();

		$start_date = strtotime("2015-01-01");
		$end_date = strtotime("2016-12-31");

		$name = array('jaya teknik','teknik perkasa','garment international','sepatu lokal','sabang merauke');

		$address = array('Jln manis Tangerang Banten', 'Jln Siliwangi no 188','jln separo karawaci tangerang banten');



		for ($i=0; $i < 10; $i++) { 
			$rand_date = mt_rand($start_date,$end_date);
			$rand_date_bc = mt_rand($start_date,$end_date);

			$arr_data[] = array(
				'code'=> 'SAMPLE-COMP-'.str_pad($i+1, 3, '0', STR_PAD_LEFT),
				'name'=> 'PT. '.$name[rand(0,4)],
				'type' => rand(1,4),
				'address' => $address[rand(0,2)],
				'npwp' => 'SAMPLE-NPWP-'.str_pad(rand(1,10), 3, '0', STR_PAD_LEFT).'.'.str_pad(rand(500,1000), 5, '0', STR_PAD_LEFT),
				'status' => rand(1,2),
				'location' => rand(1,2),
				'created_by' => 'admin',
				'created_at' => date("Y-m-d H:i:s")
				);
		}

        DB::table('company_master')->insert($arr_data);
	}

}

class StockMasterSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('stock_master')->delete();
		DB::table('stock_master')->truncate();

		$arr_data = array();

		$start_date = strtotime("2015-01-01");
		$end_date = strtotime("2016-12-31");



		for ($i=0; $i < 100; $i++) { 
			# code...
			$rand_date = mt_rand($start_date,$end_date);
			$rand_date_bc = mt_rand($start_date,$end_date);

			$arr_data[] = array(
				'date'=>date("Y-m-d H:i:s",$rand_date),
				'no'=> str_pad(rand(50,200), 4, '0', STR_PAD_LEFT).'-SAMPLE-'.rand(100,150),
				'date_bc' => date("Y-m-d H:i:s",$rand_date_bc),
				'no_bc' => 'SAMPLE-BC-'.str_pad(rand(1000,1500), 5, '0', STR_PAD_LEFT),
				'type_bc' => rand(1,7),
				'code_mat' => 'SAMPLE-MAT-'.str_pad(rand(1,10), 3, '0', STR_PAD_LEFT),
				'code_company' => 'SAMPLE-COMP-'.str_pad(rand(1,10), 3, '0', STR_PAD_LEFT),
				'qty' => rand(10,200),
				'unit' => rand(1,3),
				'price' => rand(1000,3000),
				'curr' => rand(1,3),
				'no_inv' => 'SAMPLE-INV-'.str_pad(rand(1000,3000), 5, '0', STR_PAD_LEFT),
				'no_po' => 'SAMPLE-PO-'.str_pad(rand(1000,15000), 5, '0', STR_PAD_LEFT),
				'no_so' => 'SAMPLE-SO-'.str_pad(rand(1000,2500), 5, '0', STR_PAD_LEFT),
				'to' => rand(1,3),
				'type' => rand(1,3),
				'created_by' => 'admin',
				'created_at' => new datetime
				);
		}

        DB::table('stock_master')->insert($arr_data);
	}

}


class BCTypeSeeder extends Seeder {

	/**
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('bc_type')->delete();
		DB::table('bc_type')->truncate();

        DB::table('bc_type')->insert(
	        array(
	                array('name' => 'BC 2.3', 'desc'=>'Barang masuk berasal dari supplier import'),
	                array('name' => 'BC 4.0', 'desc'=>'Barang masuk berasal dari supplier lokal'),
	                array('name' => 'BC 2.7 Keluar', 'desc'=>'Barang keluar untuk CM KB'),
	                array('name' => 'BC 2.7 Masuk', 'desc'=>'Pengembalian barang keluar untuk CM KB'),
	                array('name' => 'BC 2.6.1', 'desc'=>'Barang keluar untuk CM non KB'),                               
	                array('name' => 'BC 2.6.2', 'desc'=>'Pengembalian barang keluar untuk CM non KB'),                               
	                array('name' => 'BC 4.1', 'desc'=>'Pengembalian barang ke supplier')                            
	        ));
	}

}


class UnitTypeSeeder extends Seeder {

	/**
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('unit_type')->delete();
		DB::table('unit_type')->truncate();

        DB::table('unit_type')->insert(
	        array(
	                array('name' => 'Unit', 'desc'=>'Details descriptions'),
	                array('name' => 'Buah', 'desc'=>'Details descriptions'),
	                array('name' => 'Pasang', 'desc'=>'Details descriptions'),
	                array('name' => 'Lembar', 'desc'=>'Details descriptions'),
	                array('name' => 'Potong', 'desc'=>'Details descriptions'),                               
	                array('name' => 'Bungkus', 'desc'=>'Details descriptions'),                               
	                array('name' => 'Rim', 'desc'=>'Details descriptions'),                            
	                array('name' => 'Karung', 'desc'=>'Details descriptions'),                            
	                array('name' => 'Dus', 'desc'=>'Details descriptions'),                            
	                array('name' => 'Gulung', 'desc'=>'Details descriptions'),                            
	        ));
	}

}

class CurrTypeSeeder extends Seeder {

	/**
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('curr_type')->delete();
		DB::table('curr_type')->truncate();

        DB::table('curr_type')->insert(
	        array(
	                array('name' => 'IDR', 'desc'=>'Details descriptions'),
	                array('name' => 'JPY', 'desc'=>'Details descriptions'),
	                array('name' => 'USD', 'desc'=>'Details descriptions'),
	                array('name' => 'EUR', 'desc'=>'Details descriptions'),
	                array('name' => 'CNY', 'desc'=>'Details descriptions'),                               
	                array('name' => 'HKD', 'desc'=>'Details descriptions'),                               
	                array('name' => 'AUD', 'desc'=>'Details descriptions'),                            
	                array('name' => 'SGD', 'desc'=>'Details descriptions')                          
	        ));
	}

}

class StockTypeSeeder extends Seeder {

	/**
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('stock_type')->delete();
		DB::table('stock_type')->truncate();

        DB::table('stock_type')->insert(
	        array(
	                array('name' => 'IN', 'desc'=>'Details descriptions'),
	                array('name' => 'OUT', 'desc'=>'Details descriptions'),
	                array('name' => 'BALANCE', 'desc'=>'Details descriptions')                        
	        ));
	}

}

class StockToSeeder extends Seeder {

	/**
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('stock_to')->delete();
		DB::table('stock_to')->truncate();

        DB::table('stock_to')->insert(
	        array(
	                array('name' => 'Ekspor', 'desc'=>'Details descriptions'),
	                array('name' => 'CM', 'desc'=>'Details descriptions'),
	                array('name' => 'Inhouse', 'desc'=>'Details descriptions')                        
	        ));
	}

}